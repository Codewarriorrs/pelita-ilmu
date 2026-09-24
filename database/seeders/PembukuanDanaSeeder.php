<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class PembukuanDanaSeeder extends Seeder
{
    public function run(): void
    {
        // Seed demo pembukuan only for existing seeded students
        $adminId = User::where('role', 'ADMIN')->first()?->id ?? 1;
        $siswaList = Siswa::all();
        foreach ($siswaList as $siswa) {
            for ($bulan = 1; $bulan <= 3; $bulan++) {
                Pembayaran::firstOrCreate(
                    [
                        'siswa_id'    => $siswa->id,
                        'untuk_bulan' => $bulan,
                        'untuk_tahun' => 2026,
                    ],
                    [
                        'biaya_dibayar'     => $siswa->biaya_bulanan > 0 ? $siswa->biaya_bulanan : 200000,
                        'metode_bayar'      => 'TRANSFER',
                        'status_bayar'      => 'LUNAS',
                        'tanggal_bayar'     => now()->subMonths(3 - $bulan),
                        'admin_pencatat_id' => $adminId,
                    ]
                );
            }
        }
    }
}
