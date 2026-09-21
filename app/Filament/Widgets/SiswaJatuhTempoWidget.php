<?php

namespace App\Filament\Widgets;

use App\Models\Siswa;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class SiswaJatuhTempoWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    /**
     * Otorisasi: Hanya role ADMIN yang dapat melihat daftar siswa jatuh tempo & finansial.
     */
    public static function canView(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? true;
    }

    public function table(Table $table): Table
    {
        $hariIni = Carbon::now()->day;
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        return $table
            ->heading('Daftar Siswa Jatuh Tempo / Menunggak Bulan Ini')
            ->searchPlaceholder('Cari nama siswa...')
            ->query(
                Siswa::query()
                    ->where('status_siswa', 'AKTIF')
                    // 1. Filter Dinamis: Siswa yang belum memiliki record Pembayaran LUNAS di bulan & tahun berjalan
                    ->whereDoesntHave('pembayarans', function (Builder $query) use ($bulanSekarang, $tahunSekarang) {
                        $query->where('status_bayar', 'LUNAS')
                            ->where('untuk_bulan', $bulanSekarang)
                            ->where('untuk_tahun', $tahunSekarang);
                    })
                    // 2. Filter Dinamis: Hanya ambil yang tanggal jatuh temponya sudah lewat
                    ->where(function (Builder $query) use ($hariIni) {
                        // AWAL_BULAN jatuh tempo setiap tanggal 10
                        if ($hariIni >= 10) {
                            $query->orWhere('tipe_jatuh_tempo', 'AWAL_BULAN');
                        }

                        // AKHIR_BULAN jatuh tempo setiap tanggal 25
                        if ($hariIni >= 25) {
                            $query->orWhere('tipe_jatuh_tempo', 'AKHIR_BULAN');
                        }

                        // Jika belum tanggal 10, tampilkan kosong (belum ada yang jatuh tempo bulan ini)
                        if ($hariIni < 10) {
                            $query->whereRaw('1 = 0');
                        }
                    })
            )
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->color('gray'),

                TextColumn::make('kategori_kelas')
                    ->label('Jenjang / Kelas')
                    ->badge()
                    ->color('info'),

                TextColumn::make('tipe_jatuh_tempo')
                    ->label('Batas Jatuh Tempo')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'AWAL_BULAN' => 'Tgl 10 (Awal Bulan)',
                        'AKHIR_BULAN' => 'Tgl 25 (Akhir Bulan)',
                        default => $state,
                    })
                    ->badge()
                    ->color('danger'),

                TextColumn::make('biaya_bulanan')
                    ->label('Tagihan SPP')
                    ->money('IDR', locale: 'id')
                    ->weight('semibold'),

                TextColumn::make('nama_ortu')
                    ->label('Nama Orang Tua')
                    ->description(fn (Siswa $record): string => $record->no_telp_ortu),
            ])
            ->actions([
                Action::make('hubungi_wa')
                    ->label('Ingatkan WA')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Siswa $record): string {
                        $phone = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', $record->no_telp_ortu));
                        $nama = urlencode($record->nama_lengkap);
                        $pesan = urlencode("Halo Bapak/Ibu {$record->nama_ortu}, kami dari Bimbel Pelita Ilmu ingin mengonfirmasi terkait administrasi SPP ananda {$record->nama_lengkap} untuk periode bulan ini. Terima kasih.");
                        return "https://wa.me/{$phone}?text={$pesan}";
                    })
                    ->openUrlInNewTab(),
            ])
            ->emptyStateHeading('Tidak Ada Siswa Menunggak')
            ->emptyStateDescription('Seluruh siswa aktif telah melunasi pembayaran SPP atau belum memasuki tanggal jatuh tempo.')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->paginated([5, 10, 25]);
    }
}
