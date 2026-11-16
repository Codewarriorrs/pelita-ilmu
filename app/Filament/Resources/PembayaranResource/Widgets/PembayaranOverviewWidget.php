<?php

namespace App\Filament\Resources\PembayaranResource\Widgets;

use App\Filament\Resources\PembayaranResource\Pages\ListPembayarans;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class PembayaranOverviewWidget extends BaseWidget
{
    use InteractsWithPageTable;

    protected static bool $isLazy = false;

    public const SESSION_KEY = 'pembayaran_overview_visible_cards';

    public const CARD_OPTIONS = [
        'total' => 'Total Pemasukan',
        'tunai' => 'Pemasukan Tunai',
        'transfer' => 'Pemasukan Transfer',
        'qris' => 'Pemasukan QRIS',
        'tagihan' => 'Status Tagihan',
    ];

    protected ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.resources.pembayaran-resource.widgets.pembayaran-overview-widget';

    protected function getTablePage(): string
    {
        return ListPembayarans::class;
    }

    public function getVisibleCards(): array
    {
        $saved = session(self::SESSION_KEY);

        if (! is_array($saved)) {
            return array_keys(self::CARD_OPTIONS);
        }

        return array_values(array_intersect(array_keys(self::CARD_OPTIONS), $saved));
    }

    public function toggleCard(string $cardKey): void
    {
        if (! array_key_exists($cardKey, self::CARD_OPTIONS)) {
            return;
        }

        $visible = $this->getVisibleCards();

        if (in_array($cardKey, $visible, true)) {
            $visible = array_values(array_diff($visible, [$cardKey]));
        } else {
            $visible[] = $cardKey;
            $visible = array_values(array_intersect(array_keys(self::CARD_OPTIONS), $visible));
        }

        session()->put(self::SESSION_KEY, $visible);
        $this->cachedStats = null;
        unset($this->cachedSchemas['content']);
    }

    public function showAllCards(): void
    {
        session()->put(self::SESSION_KEY, array_keys(self::CARD_OPTIONS));
        $this->cachedStats = null;
        unset($this->cachedSchemas['content']);
    }

    protected function getColumns(): int | array | null
    {
        $count = count($this->getVisibleCards());

        return match ($count) {
            0, 1 => 1,
            2 => ['@xl' => 2, '!@lg' => 2],
            3 => ['@xl' => 3, '!@lg' => 3],
            4 => ['@xl' => 4, '!@lg' => 4],
            default => ['@xl' => 5, '!@lg' => 5],
        };
    }

    protected function resolveFilterContext(): array
    {
        $periodeRaw = $this->tableFilters['periode_waktu']['value'] ?? null;
        $periodeWaktu = (filled($periodeRaw) && in_array((string) $periodeRaw, ['BULAN', 'HARI_INI', 'MINGGU_INI', 'SEMUA'], true))
            ? (string) $periodeRaw
            : 'BULAN';

        $bulanRaw = $this->tableFilters['untuk_bulan']['value'] ?? (string) (int) now()->month;
        $bulan = null;
        if ($periodeWaktu === 'BULAN' && (string) $bulanRaw !== 'ALL' && is_numeric($bulanRaw)) {
            $bulanInt = (int) $bulanRaw;
            if ($bulanInt >= 1 && $bulanInt <= 12) {
                $bulan = $bulanInt;
            }
        }

        $tahunRaw = $this->tableFilters['untuk_tahun']['value'] ?? null;
        $tahun = (filled($tahunRaw) && is_numeric($tahunRaw) && (int) $tahunRaw >= 2000 && (int) $tahunRaw <= 2100)
            ? (int) $tahunRaw
            : (int) now()->year;

        $metodeFilter = filled($this->tableFilters['metode_bayar']['value'] ?? null)
            ? (string) $this->tableFilters['metode_bayar']['value']
            : null;

        $cutoffStart = match ($periodeWaktu) {
            'HARI_INI' => Carbon::today()->startOfDay(),
            'MINGGU_INI' => Carbon::now()->startOfWeek()->startOfDay(),
            'SEMUA' => null,
            default => $bulan !== null
                ? Carbon::createFromDate($tahun, $bulan, 1)->startOfDay()
                : Carbon::createFromDate($tahun, 1, 1)->startOfDay(),
        };

        $cutoffEnd = match ($periodeWaktu) {
            'HARI_INI' => Carbon::today()->endOfDay(),
            'MINGGU_INI' => Carbon::now()->endOfWeek()->endOfDay(),
            'SEMUA' => null,
            default => $bulan !== null
                ? Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->endOfDay()
                : Carbon::createFromDate($tahun, 12, 31)->endOfDay(),
        };

        $labelPeriode = match ($periodeWaktu) {
            'HARI_INI' => 'Hari Ini (' . Carbon::today()->locale('id')->translatedFormat('d M Y') . ')',
            'MINGGU_INI' => 'Minggu Ini (' . Carbon::now()->startOfWeek()->locale('id')->translatedFormat('d M') . ' - ' . Carbon::now()->endOfWeek()->locale('id')->translatedFormat('d M Y') . ')',
            'SEMUA' => 'Semua Periode',
            default => $bulan !== null
                ? Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->translatedFormat('F Y')
                : "Tahun {$tahun} (Semua Bulan)",
        };

        return [
            'periode_waktu' => $periodeWaktu,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'metode_filter' => $metodeFilter,
            'cutoff_start' => $cutoffStart,
            'cutoff_end' => $cutoffEnd,
            'label_periode' => $labelPeriode,
        ];
    }

    protected function getStats(): array
    {
        $ctx = $this->resolveFilterContext();
        $periodeWaktu = $ctx['periode_waktu'];
        $bulan = $ctx['bulan'];
        $tahun = $ctx['tahun'];
        $metodeFilter = $ctx['metode_filter'];
        $cutoffStart = $ctx['cutoff_start'];
        $cutoffEnd = $ctx['cutoff_end'];
        $labelPeriode = $ctx['label_periode'];

        $applyPeriod = function (Builder $query) use ($periodeWaktu, $bulan, $tahun): void {
            match ($periodeWaktu) {
                'HARI_INI' => $query->whereDate('tanggal_bayar', Carbon::today()->toDateString()),
                'MINGGU_INI' => $query->whereBetween('tanggal_bayar', [
                    Carbon::now()->startOfWeek()->startOfDay()->toDateTimeString(),
                    Carbon::now()->endOfWeek()->endOfDay()->toDateTimeString(),
                ]),
                'SEMUA' => $query,
                default => $bulan !== null
                    ? $query->where('untuk_bulan', $bulan)->where('untuk_tahun', $tahun)
                    : $query->where('untuk_tahun', $tahun),
            };
        };

        $pembayaranQuery = Pembayaran::query()
            ->where('status_bayar', 'LUNAS')
            ->whereHas('siswa', fn (Builder $sq) => $sq->where('status_siswa', '!=', 'CALON'));

        $applyPeriod($pembayaranQuery);

        if ($metodeFilter) {
            $pembayaranQuery->where('metode_bayar', $metodeFilter);
        }

        $rekapMetode = $pembayaranQuery
            ->selectRaw('metode_bayar, COALESCE(SUM(biaya_dibayar), 0) as total')
            ->groupBy('metode_bayar')
            ->pluck('total', 'metode_bayar')
            ->toArray();

        $tunai = (float) ($rekapMetode['TUNAI'] ?? 0);
        $transfer = (float) ($rekapMetode['TRANSFER'] ?? 0);
        $qris = (float) ($rekapMetode['QRIS'] ?? 0);
        $totalPeriode = $tunai + $transfer + $qris;

        $eligibleSiswaQuery = Siswa::query()->where('status_siswa', '!=', 'CALON');
        if ($cutoffEnd !== null) {
            $eligibleSiswaQuery->where(function (Builder $q) use ($cutoffEnd): void {
                $q->whereNull('tanggal_daftar')
                    ->orWhere('tanggal_daftar', '<=', $cutoffEnd->toDateTimeString());
            });
        }
        if ($cutoffStart !== null) {
            $eligibleSiswaQuery->where(function (Builder $q) use ($cutoffStart): void {
                $q->whereNull('tanggal_keluar')
                    ->orWhere('tanggal_keluar', '>=', $cutoffStart->toDateString());
            });
        }

        $totalEligible = (clone $eligibleSiswaQuery)->count();
        $jumlahLunas = (clone $eligibleSiswaQuery)
            ->whereHas('pembayarans', function (Builder $q) use ($applyPeriod): void {
                $q->where('status_bayar', 'LUNAS');
                $applyPeriod($q);
            })
            ->count();
        $jumlahBelum = max(0, $totalEligible - $jumlahLunas);

        $formatRupiah = fn (float $amount): string => 'Rp ' . number_format($amount, 0, ',', '.');

        $allCards = [
            'total' => Stat::make('Total Pemasukan Periode Ini', $formatRupiah($totalPeriode))
                ->description($labelPeriode)
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            'tunai' => Stat::make('Pemasukan Tunai', $formatRupiah($tunai))
                ->description('Pembayaran Cash / Tunai')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            'transfer' => Stat::make('Pemasukan Transfer', $formatRupiah($transfer))
                ->description('Transfer Rekening Bank')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('info'),

            'qris' => Stat::make('Pemasukan QRIS', $formatRupiah($qris))
                ->description('Pembayaran QRIS')
                ->descriptionIcon('heroicon-m-qr-code')
                ->color('warning'),

            'tagihan' => Stat::make('Status Tagihan', "{$jumlahLunas} Lunas / {$jumlahBelum} Belum")
                ->description($cutoffEnd ? "Dari {$totalEligible} siswa terdaftar s.d. periode" : "Dari {$totalEligible} siswa terdaftar (semua periode)")
                ->descriptionIcon('heroicon-m-user-group')
                ->color($jumlahBelum > 0 ? 'warning' : 'success'),
        ];

        $visibleKeys = $this->getVisibleCards();

        return array_values(array_intersect_key($allCards, array_flip($visibleKeys)));
    }

    protected function getViewData(): array
    {
        return [
            ...parent::getViewData(),
            'cardOptions' => self::CARD_OPTIONS,
            'visibleCards' => $this->getVisibleCards(),
            'labelPeriode' => $this->resolveFilterContext()['label_periode'],
        ];
    }
}
