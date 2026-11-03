<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    // Matikan auto-polling — hemat round-trip ke database Neon
    protected ?string $pollingInterval = null;

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
        $namaBulan     = Carbon::now()->locale('id')->translatedFormat('F Y');

        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $role = $user?->role ?? 'ADMIN';
        $userId = $user?->id ?? 0;

        // Cache jangka pendek (60 detik) dengan scope peran & user id agar terisolasi per role
        $totalSiswaAktif = Cache::remember("stats.{$role}.{$userId}.siswa_aktif", 60, function () {
            return Siswa::query()->where('status_siswa', 'AKTIF')->count();
        });

        $rekapMetode = Cache::remember("stats.{$role}.{$userId}.metode_bayar.{$bulanSekarang}.{$tahunSekarang}", 60, function () use ($bulanSekarang, $tahunSekarang) {
            return Pembayaran::query()
                ->selectRaw("metode_bayar, SUM(biaya_dibayar) as total")
                ->where('status_bayar', 'LUNAS')
                ->where('untuk_bulan', $bulanSekarang)
                ->where('untuk_tahun', $tahunSekarang)
                ->groupBy('metode_bayar')
                ->pluck('total', 'metode_bayar')
                ->toArray();
        });

        $tunai = (float) ($rekapMetode['TUNAI'] ?? 0);
        $transfer = (float) ($rekapMetode['TRANSFER'] ?? 0);
        $qris = (float) ($rekapMetode['QRIS'] ?? 0);
        $totalPemasukan = $tunai + $transfer + $qris;

        $formattedPemasukan = 'Rp ' . number_format($totalPemasukan, 0, ',', '.');
        $formattedTunai = 'Rp ' . number_format($tunai, 0, ',', '.');
        $formattedTransfer = 'Rp ' . number_format($transfer, 0, ',', '.');
        $formattedQris = 'Rp ' . number_format($qris, 0, ',', '.');

        return [
            Stat::make('Total Siswa Aktif', $totalSiswaAktif . ' Siswa')
                ->description('Siswa terdaftar aktif belajar')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Pemasukan ' . $namaBulan, $formattedPemasukan)
                ->description("Tunai: {$formattedTunai} | Transfer: {$formattedTransfer} | QRIS: {$formattedQris}")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Pemasukan Tunai', $formattedTunai)
                ->description('Metode Tunai / Cash')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pemasukan Transfer', $formattedTransfer)
                ->description('Transfer Rekening Bank')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('info'),

            Stat::make('Pemasukan QRIS', $formattedQris)
                ->description('Pembayaran via QRIS')
                ->descriptionIcon('heroicon-m-qr-code')
                ->color('warning'),
        ];
    }
}
