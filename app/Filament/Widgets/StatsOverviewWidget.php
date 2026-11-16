<?php

namespace App\Filament\Widgets;

use App\Models\JadwalKelompok;
use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    public static function canView(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? true;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();
        $hariIni = $now->day;
        $bulanSekarang = $now->month;
        $tahunSekarang = $now->year;
        $tanggalHariIni = $now->toDateString();

        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $role = $user?->role ?? 'ADMIN';
        $userId = $user?->id ?? 0;

        $totalSiswaAktif = Cache::remember("stats.{$role}.{$userId}.siswa_aktif", 60, function () use ($tanggalHariIni) {
            return Siswa::query()
                ->where('status_siswa', 'AKTIF')
                ->where(function (Builder $query) use ($tanggalHariIni): void {
                    $query->whereNull('tanggal_keluar')
                        ->orWhere('tanggal_keluar', '>=', $tanggalHariIni);
                })
                ->count();
        });

        $totalJatuhTempo = Cache::remember("stats.{$role}.{$userId}.jatuh_tempo.{$tanggalHariIni}", 60, function () use ($hariIni, $bulanSekarang, $tahunSekarang) {
            if ($hariIni < 7) {
                return 0;
            }

            $startOfMonth = Carbon::createFromDate($tahunSekarang, $bulanSekarang, 1)->startOfMonth()->toDateString();
            $endOfMonth = Carbon::createFromDate($tahunSekarang, $bulanSekarang, 1)->endOfMonth()->toDateTimeString();

            return Siswa::query()
                ->where('status_siswa', 'AKTIF')
                ->where(function (Builder $query) use ($endOfMonth, $startOfMonth) {
                    $query->where(function (Builder $q) use ($endOfMonth): void {
                        $q->whereNull('tanggal_daftar')
                            ->orWhere('tanggal_daftar', '<=', $endOfMonth);
                    })->where(function (Builder $q) use ($startOfMonth): void {
                        $q->whereNull('tanggal_keluar')
                            ->orWhere('tanggal_keluar', '>=', $startOfMonth);
                    });
                })
                ->whereDoesntHave('pembayarans', function (Builder $query) use ($bulanSekarang, $tahunSekarang) {
                    $query->where('status_bayar', 'LUNAS')
                        ->where('untuk_bulan', $bulanSekarang)
                        ->where('untuk_tahun', $tahunSekarang);
                })
                ->where(function (Builder $query) use ($hariIni) {
                    if ($hariIni >= 7) {
                        $query->orWhere('tipe_jatuh_tempo', 'AWAL BULAN');
                    }

                    if ($hariIni >= 25) {
                        $query->orWhere('tipe_jatuh_tempo', 'AKHIR BULAN');
                    }
                })
                ->count();
        });

        $jadwalHariIni = Cache::remember("stats.{$role}.{$userId}.jadwal_hari_ini.{$tanggalHariIni}", 60, function () use ($tanggalHariIni) {
            return JadwalKelompok::query()
                ->whereDate('tanggal_sesi', $tanggalHariIni)
                ->count();
        });

        return [
            Stat::make('Total Siswa Aktif', $totalSiswaAktif . ' Siswa')
                ->description('Siswa terdaftar aktif belajar')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Siswa Jatuh Tempo / Menunggak Bulan Ini', $totalJatuhTempo . ' Siswa')
                ->description('Belum lunas & melewati jatuh tempo')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($totalJatuhTempo > 0 ? 'danger' : 'success'),

            Stat::make('Jadwal Bimbingan Hari Ini', $jadwalHariIni . ' Sesi')
                ->description('Pertemuan terjadwal ' . $now->locale('id')->translatedFormat('d M Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
        ];
    }
}
