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
        $jsonPath = __DIR__ . '/students_data.json';
        if (!file_exists($jsonPath)) {
            return;
        }

        $students = json_decode(file_get_contents($jsonPath), true);
        if (!is_array($students)) {
            return;
        }

        $adminId = User::where('role', 'ADMIN')->first()?->id ?? 1;

        foreach ($students as $data) {
            // Check if student already exists
            $siswa = Siswa::updateOrCreate(
                ['nama_lengkap' => $data['nama_lengkap']],
                [
                    'status_siswa'     => $data['status_siswa'] ?? 'AKTIF',
                    'kategori_kelas'   => $data['kategori_kelas'] ?? 'SD',
                    'tipe_belajar'     => $data['tipe_belajar'] ?? 'KELOMPOK',
                    'asal_sekolah'     => $data['asal_sekolah'] ?? '',
                    'tipe_jatuh_tempo' => $data['tipe_jatuh_tempo'] ?? 'AWAL BULAN',
                    'biaya_bulanan'    => $data['biaya_bulanan'] ?? 195000,
                    'tanggal_daftar'   => now(),
                ]
            );

            // Seed payments
            if (isset($data['payments']) && is_array($data['payments'])) {
                foreach ($data['payments'] as $p) {
                    Pembayaran::updateOrCreate(
                        [
                            'siswa_id'    => $siswa->id,
                            'untuk_bulan' => $p['bulan'],
                            'untuk_tahun' => 2026,
                        ],
                        [
                            'biaya_dibayar'     => $p['nominal'],
                            'metode_bayar'      => $p['metode'] ?? 'TUNAI',
                            'status_bayar'      => 'LUNAS',
                            'tanggal_bayar'     => now(),
                            'admin_pencatat_id' => $adminId,
                        ]
                    );
                }
            }
        }
    }
}
