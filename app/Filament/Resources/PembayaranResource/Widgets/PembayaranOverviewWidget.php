<?php

namespace App\Filament\Resources\PembayaranResource\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class PembayaranOverviewWidget extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $bulanIni = (int) date('m');
        $tahunIni = (int) date('Y');
        $namaBulan = Carbon::now()->locale('id')->translatedFormat('F Y');

        // Total Pendapatan Bulan Ini
        $totalBulanIni = (float) Pembayaran::query()
            ->where('status_bayar', 'LUNAS')
            ->where('untuk_bulan', $bulanIni)
            ->where('untuk_tahun', $tahunIni)
            ->sum('biaya_dibayar');

        // Total Pendapatan Keseluruhan
        $totalKeseluruhan = (float) Pembayaran::query()
            ->where('status_bayar', 'LUNAS')
            ->sum('biaya_dibayar');

        // Jumlah Siswa Lunas vs Belum Lunas Bulan Ini
        $jumlahLunasBulanIni = Pembayaran::query()
            ->where('status_bayar', 'LUNAS')
            ->where('untuk_bulan', $bulanIni)
            ->where('untuk_tahun', $tahunIni)
            ->count();

        $jumlahBelumLunasBulanIni = Pembayaran::query()
            ->where('status_bayar', 'BELUM')
            ->where('untuk_bulan', $bulanIni)
            ->where('untuk_tahun', $tahunIni)
            ->count();

        return [
            Stat::make("Pendapatan {$namaBulan}", 'Rp ' . number_format($totalBulanIni, 0, ',', '.'))
                ->description("{$jumlahLunasBulanIni} transaksi lunas bulan ini")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Pendapatan Keseluruhan', 'Rp ' . number_format($totalKeseluruhan, 0, ',', '.'))
                ->description('Akumulasi seluruh pemasukan bimbel')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make('Status Tagihan Bulan Ini', "{$jumlahLunasBulanIni} Lunas / {$jumlahBelumLunasBulanIni} Belum")
                ->description('Monitoring pembayaran SPP')
                ->descriptionIcon('heroicon-m-user-group')
                ->color($jumlahBelumLunasBulanIni > 0 ? 'warning' : 'success'),
        ];
    }
}
