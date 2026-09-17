<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    /**
     * Otorisasi: Hanya role ADMIN yang diizinkan melihat widget finansial & statistik ringkasan.
     */
    public static function canView(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        // Pastikan hanya role ADMIN yang bisa melihat data keuangan
        return $user?->isAdmin() ?? true;
    }

    protected function getStats(): array
    {
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;
        $namaBulan = Carbon::now()->locale('id')->translatedFormat('F Y');

        // 1. Query Total Siswa Aktif (Efisien via index status_siswa)
        $totalSiswaAktif = Siswa::query()
            ->where('status_siswa', 'AKTIF')
            ->count();

        // 2. Query Total Pemasukan Bulan Berjalan (Menggunakan sum tipe data decimal konsisten)
        $totalPemasukan = Pembayaran::query()
            ->where('status_bayar', 'LUNAS')
            ->where('untuk_bulan', $bulanSekarang)
            ->where('untuk_tahun', $tahunSekarang)
            ->sum('biaya_dibayar');

        // Format mata uang Rupiah tanpa resiko floating point issue
        $formattedPemasukan = 'Rp ' . number_format((float) $totalPemasukan, 0, ',', '.');

        return [
            Stat::make('Total Siswa Aktif', $totalSiswaAktif . ' Siswa')
                ->description('Siswa terdaftar aktif belajar')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Pemasukan ' . $namaBulan, $formattedPemasukan)
                ->description('Total pembayaran SPP terkonfirmasi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
