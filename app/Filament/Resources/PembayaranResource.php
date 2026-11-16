<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static \UnitEnum|string|null $navigationGroup = 'Keuangan';
    protected static ?string $navigationLabel = 'Rekap Pembayaran';
    protected static ?string $modelLabel = 'Rekap Pembayaran';
    protected static ?string $pluralModelLabel = 'Rekap Pembayaran';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? true;
    }

    public static function getBulanOptions(): array
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    public static function getTahunOptions(): array
    {
        return [
            2024 => '2024',
            2025 => '2025',
            2026 => '2026',
            2027 => '2027',
        ];
    }

    public static function resolveActivePeriod(mixed $livewire = null): array
    {
        $periodeWaktu = 'BULAN';
        $bulanRaw = (string) (int) now()->month;
        $tahun = (int) now()->year;
        $statusBayar = null;
        $metodeBayar = null;

        if ($livewire && method_exists($livewire, 'getTableFilterState')) {
            $periodeVal = $livewire->getTableFilterState('periode_waktu')['value'] ?? null;
            $bulanVal = $livewire->getTableFilterState('untuk_bulan')['value'] ?? null;
            $tahunVal = $livewire->getTableFilterState('untuk_tahun')['value'] ?? null;
            $statusVal = $livewire->getTableFilterState('status_bayar')['value'] ?? null;
            $metodeVal = $livewire->getTableFilterState('metode_bayar')['value'] ?? null;

            if (filled($periodeVal) && in_array((string) $periodeVal, ['BULAN', 'HARI_INI', 'MINGGU_INI', 'SEMUA'], true)) {
                $periodeWaktu = (string) $periodeVal;
            }
            if (filled($bulanVal)) {
                $bulanRaw = (string) $bulanVal;
            }
            if (filled($tahunVal) && is_numeric($tahunVal)) {
                $tahunInt = (int) $tahunVal;
                if ($tahunInt >= 2000 && $tahunInt <= 2100) {
                    $tahun = $tahunInt;
                }
            }
            if (filled($statusVal)) {
                $statusBayar = (string) $statusVal;
            }
            if (filled($metodeVal)) {
                $metodeBayar = (string) $metodeVal;
            }
        }

        $bulan = null;
        if ($periodeWaktu === 'BULAN' && $bulanRaw !== 'ALL' && is_numeric($bulanRaw)) {
            $bulanInt = (int) $bulanRaw;
            if ($bulanInt >= 1 && $bulanInt <= 12) {
                $bulan = $bulanInt;
            }
        }

        $isSingleMonth = ($periodeWaktu === 'BULAN' && $bulan !== null);

        $awalPeriode = match ($periodeWaktu) {
            'HARI_INI' => Carbon::today()->startOfDay(),
            'MINGGU_INI' => Carbon::now()->startOfWeek()->startOfDay(),
            'SEMUA' => null,
            default => $bulan !== null
                ? Carbon::createFromDate($tahun, $bulan, 1)->startOfDay()
                : Carbon::createFromDate($tahun, 1, 1)->startOfDay(),
        };

        $akhirPeriode = match ($periodeWaktu) {
            'HARI_INI' => Carbon::today()->endOfDay(),
            'MINGGU_INI' => Carbon::now()->endOfWeek()->endOfDay(),
            'SEMUA' => null,
            default => $bulan !== null
                ? Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->endOfDay()
                : Carbon::createFromDate($tahun, 12, 31)->endOfDay(),
        };

        $fallbackLabel = match ($periodeWaktu) {
            'HARI_INI' => 'Hari Ini',
            'MINGGU_INI' => 'Minggu Ini',
            'SEMUA' => 'Semua Periode',
            default => $bulan !== null
                ? Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->translatedFormat('F Y')
                : "Tahun {$tahun}",
        };

        return [
            'periode_waktu' => $periodeWaktu,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'is_single_month' => $isSingleMonth,
            'status_bayar' => $statusBayar,
            'metode_bayar' => $metodeBayar,
            'awal_periode' => $awalPeriode,
            'akhir_periode' => $akhirPeriode,
            'fallback_label' => $fallbackLabel,
        ];
    }

    public static function resolveRowPayment(Siswa $record): ?Pembayaran
    {
        if ($record->pembayarans->isEmpty()) {
            return null;
        }

        return $record->pembayarans
            ->sortByDesc(fn (Pembayaran $p): int => ($p->status_bayar === 'LUNAS' ? 1000000 : 0) + ($p->untuk_tahun * 100) + $p->untuk_bulan)
            ->first();
    }

    public static function formatPeriodeLabel(int $bulan, int $tahun): string
    {
        $safeBulan = max(1, min(12, $bulan));
        $safeTahun = max(2000, min(2100, $tahun));

        return Carbon::createFromDate($safeTahun, $safeBulan, 1)->locale('id')->translatedFormat('F Y');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->label('Pilih Siswa')
                    ->relationship('siswa', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set): void {
                        if ($state) {
                            $siswa = Siswa::find($state);
                            if ($siswa) {
                                $set('biaya_dibayar', $siswa->biaya_bulanan);
                            }
                        }
                    }),

                Hidden::make('admin_pencatat_id')
                    ->default(fn () => auth()->id()),

                TextInput::make('biaya_dibayar')
                    ->label('Jumlah SPP Dibayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0),

                Select::make('metode_bayar')
                    ->label('Metode Pembayaran')
                    ->options([
                        'TUNAI' => 'Tunai',
                        'TRANSFER' => 'Transfer Bank',
                        'QRIS' => 'QRIS',
                    ])
                    ->default('TUNAI')
                    ->required(),

                Select::make('status_bayar')
                    ->label('Status Pembayaran')
                    ->options([
                        'LUNAS' => 'Lunas',
                        'BELUM' => 'Belum Lunas',
                    ])
                    ->default('LUNAS')
                    ->required(),

                DatePicker::make('tanggal_bayar')
                    ->label('Tanggal Pembayaran')
                    ->default(now())
                    ->required(),

                Select::make('untuk_bulan')
                    ->label('Untuk Bulan')
                    ->options(self::getBulanOptions())
                    ->default((int) date('m'))
                    ->required(),

                TextInput::make('untuk_tahun')
                    ->label('Untuk Tahun')
                    ->numeric()
                    ->default((int) date('Y'))
                    ->required()
                    ->rule(fn (Get $get, ?Pembayaran $record): \Closure => function (string $attribute, mixed $value, \Closure $fail) use ($get, $record): void {
                        $siswaId = (int) $get('siswa_id');
                        $bulan = (int) $get('untuk_bulan');
                        $tahun = (int) $value;

                        if (! $siswaId || $bulan < 1 || $bulan > 12 || $tahun < 2000) {
                            return;
                        }

                        $duplicate = Pembayaran::query()
                            ->where('siswa_id', $siswaId)
                            ->where('untuk_bulan', $bulan)
                            ->where('untuk_tahun', $tahun)
                            ->when($record, fn (Builder $q) => $q->where('id', '!=', $record->id))
                            ->first();

                        if ($duplicate) {
                            $periodeLabel = self::formatPeriodeLabel($bulan, $tahun);
                            $fail($duplicate->status_bayar === 'LUNAS'
                                ? "Pembayaran SPP siswa untuk periode {$periodeLabel} sudah tercatat LUNAS."
                                : "Catatan pembayaran siswa untuk periode {$periodeLabel} sudah ada. Silakan edit data yang sudah ada.");
                        }
                    }),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('Catatan atau keterangan pembayaran')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () use ($table): Builder {
                $livewire = $table->getLivewire();
                $period = self::resolveActivePeriod($livewire);

                if ($period['is_single_month']) {
                    return Siswa::query()->where('status_siswa', '!=', 'CALON');
                }

                return Pembayaran::query()->whereHas('siswa', fn ($q) => $q->where('status_siswa', '!=', 'CALON'));
            })
            ->recordUrl(null)
            ->modifyQueryUsing(function (Builder $query, mixed $livewire = null): Builder {
                $period = self::resolveActivePeriod($livewire);
                $periodeWaktu = $period['periode_waktu'];
                $bulan = $period['bulan'];
                $tahun = $period['tahun'];
                $awalPeriode = $period['awal_periode'];
                $akhirPeriode = $period['akhir_periode'];
                $statusBayar = $period['status_bayar'];
                $metodeBayar = $period['metode_bayar'];

                if ($period['is_single_month']) {
                    // Mode Siswa (Monitoring Tagihan 1 Bulan Spesifik)
                    if ($akhirPeriode !== null) {
                        $query->where(function (Builder $q) use ($akhirPeriode): void {
                            $q->whereNull('tanggal_daftar')
                                ->orWhere('tanggal_daftar', '<=', $akhirPeriode->toDateTimeString());
                        });
                    }

                    if ($awalPeriode !== null) {
                        $query->where(function (Builder $q) use ($awalPeriode): void {
                            $q->whereNull('tanggal_keluar')
                                ->orWhere('tanggal_keluar', '>=', $awalPeriode->toDateString());
                        });
                    }

                    $applyPeriodToPayment = function (BuilderContract $q) use ($bulan, $tahun): void {
                        $q->where('untuk_bulan', $bulan)->where('untuk_tahun', $tahun);
                    };

                    $query->with([
                        'pembayarans' => function (BuilderContract $q) use ($applyPeriodToPayment, $metodeBayar): void {
                            $q->with('adminPencatat');
                            $applyPeriodToPayment($q);
                            if ($metodeBayar) {
                                $q->where('metode_bayar', $metodeBayar);
                            }
                        },
                    ]);

                    if ($statusBayar === 'LUNAS') {
                        $query->whereHas('pembayarans', function (Builder $q) use ($applyPeriodToPayment): void {
                            $q->where('status_bayar', 'LUNAS');
                            $applyPeriodToPayment($q);
                        });
                    } elseif ($statusBayar === 'BELUM') {
                        $query->whereDoesntHave('pembayarans', function (Builder $q) use ($applyPeriodToPayment): void {
                            $q->where('status_bayar', 'LUNAS');
                            $applyPeriodToPayment($q);
                        });
                    }

                    if ($metodeBayar) {
                        $query->whereHas('pembayarans', function (Builder $q) use ($metodeBayar, $applyPeriodToPayment): void {
                            $q->where('status_bayar', 'LUNAS')->where('metode_bayar', $metodeBayar);
                            $applyPeriodToPayment($q);
                        });
                    }

                    if (empty($query->getQuery()->orders)) {
                        $query->orderBy('nama_lengkap', 'asc');
                    }

                    return $query;
                }

                // Mode Multi-Periode (1 Baris per Transaksi Pembayaran)
                $query->with(['siswa', 'adminPencatat']);

                match ($periodeWaktu) {
                    'HARI_INI' => $query->whereDate('tanggal_bayar', Carbon::today()->toDateString()),
                    'MINGGU_INI' => $query->whereBetween('tanggal_bayar', [
                        Carbon::now()->startOfWeek()->startOfDay()->toDateTimeString(),
                        Carbon::now()->endOfWeek()->endOfDay()->toDateTimeString(),
                    ]),
                    'SEMUA' => $query,
                    default => $query->where('untuk_tahun', $tahun), // BULAN dengan untuk_bulan === 'ALL'
                };

                if ($statusBayar) {
                    $query->where('status_bayar', $statusBayar);
                }

                if ($metodeBayar) {
                    $query->where('metode_bayar', $metodeBayar);
                }

                if (empty($query->getQuery()->orders)) {
                    $query->orderByDesc('tanggal_bayar')
                        ->orderByDesc('untuk_tahun')
                        ->orderByDesc('untuk_bulan')
                        ->orderByDesc('id');
                }

                return $query;
            })
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->state(fn ($record) => $record instanceof Siswa ? $record->nama_lengkap : ($record->siswa?->nama_lengkap ?? '-'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        if ($query->getModel() instanceof Siswa) {
                            return $query->where('nama_lengkap', 'ILIKE', "%{$search}%");
                        }

                        return $query->whereHas('siswa', fn ($q) => $q->where('nama_lengkap', 'ILIKE', "%{$search}%"));
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        if ($query->getModel() instanceof Siswa) {
                            return $query->orderBy('nama_lengkap', $direction);
                        }

                        return $query->join('siswa', 'pembayaran.siswa_id', '=', 'siswa.id')
                            ->orderBy('siswa.nama_lengkap', $direction)
                            ->select('pembayaran.*');
                    })
                    ->weight('bold'),

                TextColumn::make('periode_spp')
                    ->label('Periode SPP')
                    ->state(function ($record, mixed $livewire): string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);
                            $period = self::resolveActivePeriod($livewire);
                            $bulan = $payment?->untuk_bulan ?? $period['bulan'];
                            $tahun = $payment?->untuk_tahun ?? $period['tahun'];

                            return self::formatPeriodeLabel((int) $bulan, (int) $tahun);
                        }

                        return self::formatPeriodeLabel((int) $record->untuk_bulan, (int) $record->untuk_tahun);
                    })
                    ->badge()
                    ->color('primary'),

                TextColumn::make('biaya_dibayar')
                    ->label('Jumlah SPP')
                    ->state(function ($record): string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return ($payment && $payment->status_bayar === 'LUNAS')
                                ? 'Rp ' . number_format((float) $payment->biaya_dibayar, 0, ',', '.')
                                : '-';
                        }

                        return 'Rp ' . number_format((float) $record->biaya_dibayar, 0, ',', '.');
                    })
                    ->description(function ($record): ?string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);
                            if ((! $payment || $payment->status_bayar !== 'LUNAS') && (float) $record->biaya_bulanan > 0) {
                                return 'Tagihan: Rp ' . number_format((float) $record->biaya_bulanan, 0, ',', '.');
                            }
                        }

                        return null;
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        if ($query->getModel() instanceof Siswa) {
                            return $query->orderBy('biaya_bulanan', $direction);
                        }

                        return $query->orderBy('biaya_dibayar', $direction);
                    })
                    ->weight('semibold'),

                TextColumn::make('tipe_jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->state(fn ($record) => $record instanceof Siswa ? $record->tipe_jatuh_tempo : ($record->siswa?->tipe_jatuh_tempo ?? '-'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'AWAL BULAN' => 'Jatuh Tempo Awal Bulan',
                        'AKHIR BULAN' => 'Jatuh Tempo Akhir Bulan',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'AWAL BULAN' => 'warning',
                        'AKHIR BULAN' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('metode_bayar')
                    ->label('Metode Bayar')
                    ->state(function ($record): string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return ($payment && $payment->status_bayar === 'LUNAS') ? $payment->metode_bayar : '-';
                        }

                        return $record->metode_bayar ?? '-';
                    })
                    ->badge()
                    ->color(function ($record): string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return ($payment && $payment->status_bayar === 'LUNAS') ? 'info' : 'gray';
                        }

                        return 'info';
                    })
                    ->toggleable(),

                TextColumn::make('status_bayar')
                    ->label('Status')
                    ->state(function ($record): string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return ($payment && $payment->status_bayar === 'LUNAS') ? 'LUNAS' : 'BELUM';
                        }

                        return $record->status_bayar ?? 'LUNAS';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'LUNAS' => 'success',
                        'BELUM' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'LUNAS' => 'LUNAS',
                        'BELUM' => 'BELUM LUNAS',
                        default => $state,
                    }),

                TextColumn::make('tanggal_bayar')
                    ->label('Tgl Bayar')
                    ->state(function ($record): string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return ($payment && $payment->status_bayar === 'LUNAS' && $payment->tanggal_bayar)
                                ? Carbon::parse($payment->tanggal_bayar)->locale('id')->translatedFormat('d M Y')
                                : '-';
                        }

                        return $record->tanggal_bayar
                            ? Carbon::parse($record->tanggal_bayar)->locale('id')->translatedFormat('d M Y')
                            : '-';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        if ($query->getModel() instanceof Siswa) {
                            return $query;
                        }

                        return $query->orderBy('tanggal_bayar', $direction);
                    }),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->state(function ($record): ?string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return $payment?->keterangan ?: ($record->keterangan ?: null);
                        }

                        return $record->keterangan ?: ($record->siswa?->keterangan ?: null);
                    })
                    ->limit(25)
                    ->tooltip(function ($record): ?string {
                        if ($record instanceof Siswa) {
                            $payment = self::resolveRowPayment($record);

                            return $payment?->keterangan ?: ($record->keterangan ?: null);
                        }

                        return $record->keterangan ?: ($record->siswa?->keterangan ?: null);
                    })
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->placeholder('-'),

                TextColumn::make('admin_pencatat')
                    ->label('Pencatat Admin')
                    ->state(function ($record): string {
                        if ($record instanceof Siswa) {
                            return self::resolveRowPayment($record)?->adminPencatat?->name ?? '-';
                        }

                        return $record->adminPencatat?->name ?? '-';
                    })
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('periode_waktu')
                    ->label('Periode Waktu')
                    ->options([
                        'BULAN' => 'Bulan',
                        'HARI_INI' => 'Hari Ini',
                        'MINGGU_INI' => 'Minggu Ini',
                        'SEMUA' => 'Semua',
                    ])
                    ->default('BULAN')
                    ->selectablePlaceholder(false)
                    ->indicateUsing(function (array $state): array {
                        $val = $state['value'] ?? null;
                        if (blank($val) || $val === 'BULAN') {
                            return [];
                        }

                        $labels = [
                            'HARI_INI' => 'Hari Ini',
                            'MINGGU_INI' => 'Minggu Ini',
                            'SEMUA' => 'Semua Periode',
                        ];

                        return ['Periode: ' . ($labels[$val] ?? $val)];
                    })
                    ->query(fn (Builder $query): Builder => $query),

                SelectFilter::make('untuk_bulan')
                    ->label('Bulan')
                    ->options(['ALL' => 'Semua'] + self::getBulanOptions())
                    ->default((int) date('m'))
                    ->selectablePlaceholder(false)
                    ->indicateUsing(function (array $state, SelectFilter $filter): array {
                        $livewire = $filter->getTable()->getLivewire();
                        $periodeVal = null;
                        if ($livewire && method_exists($livewire, 'getTableFilterState')) {
                            $periodeVal = $livewire->getTableFilterState('periode_waktu')['value'] ?? null;
                        }

                        // Hilangkan bentrok: sembunyikan pill bulan jika periode_waktu selain BULAN
                        if (filled($periodeVal) && $periodeVal !== 'BULAN') {
                            return [];
                        }

                        $val = $state['value'] ?? null;
                        if (blank($val) || (string) $val === 'ALL') {
                            return [];
                        }

                        return ['Bulan: ' . (self::getBulanOptions()[(int) $val] ?? $val)];
                    })
                    ->query(fn (Builder $query): Builder => $query),

                SelectFilter::make('untuk_tahun')
                    ->label('Tahun')
                    ->options(self::getTahunOptions())
                    ->default((int) date('Y'))
                    ->selectablePlaceholder(false)
                    ->indicateUsing(function (array $state, SelectFilter $filter): array {
                        $livewire = $filter->getTable()->getLivewire();
                        $periodeVal = null;
                        if ($livewire && method_exists($livewire, 'getTableFilterState')) {
                            $periodeVal = $livewire->getTableFilterState('periode_waktu')['value'] ?? null;
                        }

                        if (in_array($periodeVal, ['HARI_INI', 'MINGGU_INI', 'SEMUA'], true)) {
                            return [];
                        }

                        $val = $state['value'] ?? null;

                        return filled($val) ? ['Tahun: ' . $val] : [];
                    })
                    ->query(fn (Builder $query): Builder => $query),

                SelectFilter::make('status_bayar')
                    ->label('Status Pembayaran')
                    ->options([
                        'LUNAS' => 'Lunas',
                        'BELUM' => 'Belum Lunas',
                    ])
                    ->query(fn (Builder $query): Builder => $query),

                SelectFilter::make('metode_bayar')
                    ->label('Metode Bayar')
                    ->options([
                        'TUNAI' => 'Tunai',
                        'TRANSFER' => 'Transfer',
                        'QRIS' => 'QRIS',
                    ])
                    ->query(fn (Builder $query): Builder => $query),
            ])
            ->recordActions([
                Action::make('bayar_lunas')
                    ->label('Bayar / Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(function ($record, mixed $livewire): bool {
                        if (! $record instanceof Siswa) {
                            return false;
                        }

                        $period = self::resolveActivePeriod($livewire);
                        if ($period['is_single_month']) {
                            return self::resolveRowPayment($record)?->status_bayar !== 'LUNAS';
                        }

                        return true;
                    })
                    ->modalHeading(fn (Siswa $record): string => 'Konfirmasi Pembayaran: ' . $record->nama_lengkap)
                    ->modalDescription('Pilih periode bulan/tahun, nominal SPP, dan metode pembayaran untuk menandai tagihan lunas.')
                    ->schema(fn (Siswa $record, mixed $livewire): array => [
                        Grid::make(['default' => 1, 'sm' => 2])
                            ->schema([
                                Select::make('untuk_bulan')
                                    ->label('Untuk Bulan')
                                    ->options(self::getBulanOptions())
                                    ->default(self::resolveActivePeriod($livewire)['bulan'] ?? (int) now()->month)
                                    ->required(),

                                Select::make('untuk_tahun')
                                    ->label('Untuk Tahun')
                                    ->options(self::getTahunOptions())
                                    ->default(self::resolveActivePeriod($livewire)['tahun'])
                                    ->required(),

                                TextInput::make('biaya_dibayar')
                                    ->label('Jumlah SPP Dibayar')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->default((float) $record->biaya_bulanan > 0 ? (int) $record->biaya_bulanan : 0)
                                    ->required(),

                                Select::make('metode_bayar')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'TUNAI' => 'Tunai',
                                        'TRANSFER' => 'Transfer Bank',
                                        'QRIS' => 'QRIS',
                                    ])
                                    ->default('TUNAI')
                                    ->required(),
                            ]),

                        DatePicker::make('tanggal_bayar')
                            ->label('Tanggal Pembayaran')
                            ->default(now())
                            ->required(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Catatan pembayaran (opsional)')
                            ->rows(2),
                    ])
                    ->action(function (array $data, Siswa $record, Action $action): void {
                        $bulan = (int) $data['untuk_bulan'];
                        $tahun = (int) $data['untuk_tahun'];
                        $adminId = auth()->id() ?? User::where('role', 'ADMIN')->value('id') ?? 1;

                        $saved = DB::transaction(function () use ($record, $bulan, $tahun, $data, $adminId): bool {
                            $existing = Pembayaran::query()
                                ->where('siswa_id', $record->id)
                                ->where('untuk_bulan', $bulan)
                                ->where('untuk_tahun', $tahun)
                                ->lockForUpdate()
                                ->first();

                            if ($existing && $existing->status_bayar === 'LUNAS') {
                                return false;
                            }

                            Pembayaran::updateOrCreate(
                                [
                                    'siswa_id' => $record->id,
                                    'untuk_bulan' => $bulan,
                                    'untuk_tahun' => $tahun,
                                ],
                                [
                                    'admin_pencatat_id' => $adminId,
                                    'status_bayar' => 'LUNAS',
                                    'biaya_dibayar' => $data['biaya_dibayar'],
                                    'metode_bayar' => $data['metode_bayar'],
                                    'tanggal_bayar' => $data['tanggal_bayar'],
                                    'keterangan' => $data['keterangan'] ?? null,
                                ]
                            );

                            return true;
                        });

                        if (! $saved) {
                            $periodeLabel = self::formatPeriodeLabel($bulan, $tahun);

                            Notification::make()
                                ->title('Pembayaran Duplikat Ditolak')
                                ->body("SPP {$record->nama_lengkap} untuk periode {$periodeLabel} sudah tercatat LUNAS.")
                                ->danger()
                                ->send();

                            $action->halt();

                            return;
                        }

                        Notification::make()
                            ->title('Pembayaran berhasil dikonfirmasi LUNAS')
                            ->success()
                            ->send();
                    }),

                Action::make('edit_pembayaran')
                    ->iconButton()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->tooltip('Edit Pembayaran')
                    ->visible(fn ($record): bool => ($record instanceof Siswa && self::resolveRowPayment($record) !== null) || ($record instanceof Pembayaran))
                    ->modalHeading(fn ($record): string => 'Edit Pembayaran: ' . ($record instanceof Siswa ? $record->nama_lengkap : ($record->siswa?->nama_lengkap ?? '-')))
                    ->fillForm(function ($record): array {
                        $payment = $record instanceof Siswa ? self::resolveRowPayment($record) : $record;

                        return [
                            'untuk_bulan' => $payment?->untuk_bulan ?? (int) now()->month,
                            'untuk_tahun' => $payment?->untuk_tahun ?? (int) now()->year,
                            'biaya_dibayar' => (int) ($payment?->biaya_dibayar ?? ($record instanceof Siswa ? $record->biaya_bulanan : 0)),
                            'metode_bayar' => $payment?->metode_bayar ?? 'TUNAI',
                            'status_bayar' => $payment?->status_bayar ?? 'LUNAS',
                            'tanggal_bayar' => $payment?->tanggal_bayar ?? now(),
                            'keterangan' => $payment?->keterangan,
                        ];
                    })
                    ->schema([
                        Grid::make(['default' => 1, 'sm' => 2])
                            ->schema([
                                Select::make('untuk_bulan')
                                    ->label('Untuk Bulan')
                                    ->options(self::getBulanOptions())
                                    ->required(),

                                Select::make('untuk_tahun')
                                    ->label('Untuk Tahun')
                                    ->options(self::getTahunOptions())
                                    ->required(),

                                TextInput::make('biaya_dibayar')
                                    ->label('Jumlah SPP Dibayar')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                Select::make('metode_bayar')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'TUNAI' => 'Tunai',
                                        'TRANSFER' => 'Transfer Bank',
                                        'QRIS' => 'QRIS',
                                    ])
                                    ->required(),

                                Select::make('status_bayar')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'LUNAS' => 'Lunas',
                                        'BELUM' => 'Belum Lunas',
                                    ])
                                    ->required(),

                                DatePicker::make('tanggal_bayar')
                                    ->label('Tanggal Pembayaran')
                                    ->required(),
                            ]),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Catatan pembayaran (opsional)')
                            ->rows(2),
                    ])
                    ->action(function (array $data, $record, Action $action): void {
                        $payment = $record instanceof Siswa ? self::resolveRowPayment($record) : $record;

                        if (! $payment) {
                            return;
                        }

                        $bulan = (int) $data['untuk_bulan'];
                        $tahun = (int) $data['untuk_tahun'];

                        $conflict = Pembayaran::query()
                            ->where('siswa_id', $payment->siswa_id)
                            ->where('untuk_bulan', $bulan)
                            ->where('untuk_tahun', $tahun)
                            ->where('id', '!=', $payment->id)
                            ->exists();

                        if ($conflict) {
                            $periodeLabel = self::formatPeriodeLabel($bulan, $tahun);
                            $namaSiswa = $record instanceof Siswa ? $record->nama_lengkap : ($record->siswa?->nama_lengkap ?? '');

                            Notification::make()
                                ->title('Periode Pembayaran Sudah Ada')
                                ->body("Transaksi {$namaSiswa} untuk periode {$periodeLabel} sudah terdaftar.")
                                ->danger()
                                ->send();

                            $action->halt();

                            return;
                        }

                        $adminId = auth()->id() ?? User::where('role', 'ADMIN')->value('id') ?? 1;

                        $payment->update([
                            'untuk_bulan' => $bulan,
                            'untuk_tahun' => $tahun,
                            'biaya_dibayar' => $data['biaya_dibayar'],
                            'metode_bayar' => $data['metode_bayar'],
                            'status_bayar' => $data['status_bayar'],
                            'tanggal_bayar' => $data['status_bayar'] === 'LUNAS' ? $data['tanggal_bayar'] : null,
                            'keterangan' => $data['keterangan'] ?? null,
                            'admin_pencatat_id' => $adminId,
                        ]);

                        Notification::make()
                            ->title('Data pembayaran berhasil diperbarui')
                            ->success()
                            ->send();
                    }),

                Action::make('hapus_pembayaran')
                    ->iconButton()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->tooltip('Hapus Transaksi')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Transaksi Pembayaran')
                    ->modalDescription(fn ($record): string => 'Hapus catatan pembayaran ini untuk ' . ($record instanceof Siswa ? $record->nama_lengkap : ($record->siswa?->nama_lengkap ?? 'siswa')) . '?')
                    ->visible(fn ($record): bool => ($record instanceof Siswa && self::resolveRowPayment($record) !== null) || ($record instanceof Pembayaran))
                    ->action(function ($record): void {
                        $payment = $record instanceof Siswa ? self::resolveRowPayment($record) : $record;
                        $payment?->delete();

                        Notification::make()
                            ->title('Transaksi pembayaran dihapus')
                            ->success()
                            ->send();
                    }),
            ])
            ->emptyStateHeading(fn (mixed $livewire): string => self::resolveActivePeriod($livewire)['is_single_month']
                ? 'Belum Ada Data Siswa'
                : 'Belum Ada Transaksi Pembayaran'
            )
            ->emptyStateDescription(fn (mixed $livewire): string => self::resolveActivePeriod($livewire)['is_single_month']
                ? 'Tidak ada siswa non-calon yang terdaftar aktif pada periode ini.'
                : 'Tidak ada transaksi pembayaran pada rentang periode yang dipilih.'
            )
            ->emptyStateIcon('heroicon-o-banknotes');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
