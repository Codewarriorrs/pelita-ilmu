<?php

namespace Database\Seeders;

use App\Models\DetailPresensi;
use App\Models\JadwalKelompok;
use App\Models\Kelompok;
use App\Models\MataPelajaran;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedRolesAndPermissions();
        $this->seedUsers();
        $this->seedMasterData();
        $this->seedPendaftaran();
        $this->seedSiswa();
        $this->seedKelompok();
        $this->seedJadwal();
        $this->seedPresensi();
        $this->seedPembayaran();
    }

    protected function seedRolesAndPermissions(): void
    {
        $permissions = [
            'dashboard.view',
            'siswa.view',
            'siswa.create',
            'siswa.update',
            'kelompok.view',
            'pembayaran.view',
            'pendaftaran.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'web']);
        $tentorRole = Role::firstOrCreate(['name' => 'TENTOR', 'guard_name' => 'web']);

        $adminRole->syncPermissions($permissions);
        $tentorRole->givePermissionTo(['dashboard.view', 'siswa.view', 'kelompok.view', 'pendaftaran.view']);
    }

    protected function seedUsers(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@pelitailmu.id'],
            [
                'name' => 'Administrator Pelita Ilmu',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'tanggal_daftar' => now(),
            ]
        );
        $admin->assignRole('ADMIN');

        $admin2 = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('admin123'),
                'role' => 'ADMIN',
                'tanggal_daftar' => now(),
            ]
        );
        $admin2->assignRole('ADMIN');

        $tentor1 = User::updateOrCreate(
            ['email' => 'tentor@pelitailmu.id'],
            [
                'name' => 'Tentor Pelita Ilmu',
                'password' => Hash::make('tentor123'),
                'role' => 'TENTOR',
                'tanggal_daftar' => now(),
            ]
        );
        $tentor1->assignRole('TENTOR');

        $tentor2 = User::updateOrCreate(
            ['email' => 'guru@pelitailmu.id'],
            [
                'name' => 'Guru Pengajar Pelita Ilmu',
                'password' => Hash::make('guru123'),
                'role' => 'TENTOR',
                'tanggal_daftar' => now(),
            ]
        );
        $tentor2->assignRole('TENTOR');

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'TENTOR',
                'tanggal_daftar' => now(),
            ]
        );
    }

    protected function seedMasterData(): void
    {
        $mapels = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'IPA',
            'Ekonomi',
            'Computer',
            'TPA',
        ];

        foreach ($mapels as $namaMapel) {
            MataPelajaran::firstOrCreate(['nama_mapel' => $namaMapel]);
        }
    }

    protected function seedPendaftaran(): void
    {
        $data = [
            ['nama_lengkap' => 'Alya Putri', 'asal_sekolah' => 'SDN 1 Semarang', 'minat_program' => 'Reguler', 'nomor_wa' => '081234567801', 'status_tindak_lanjut' => 'DITERIMA', 'tanggal_masuk' => now()->subDays(12)],
            ['nama_lengkap' => 'Dimas Pratama', 'asal_sekolah' => 'SMPN 3 Semarang', 'minat_program' => 'Intensif', 'nomor_wa' => '081234567802', 'status_tindak_lanjut' => 'DIHUBUNGI', 'tanggal_masuk' => now()->subDays(7)],
            ['nama_lengkap' => 'Nadia Zahra', 'asal_sekolah' => 'SMA 7 Semarang', 'minat_program' => 'Konsultasi', 'nomor_wa' => '081234567803', 'status_tindak_lanjut' => 'BARU', 'tanggal_masuk' => now()->subDays(2)],
            ['nama_lengkap' => 'Rafi Ramadhan', 'asal_sekolah' => 'SDN 2 Semarang', 'minat_program' => 'Reguler', 'nomor_wa' => '081234567804', 'status_tindak_lanjut' => 'DITERIMA', 'tanggal_masuk' => now()->subDays(20)],
            ['nama_lengkap' => 'Salsa Anjani', 'asal_sekolah' => 'SMPN 1 Semarang', 'minat_program' => 'Intensif', 'nomor_wa' => '081234567805', 'status_tindak_lanjut' => 'DIHUBUNGI', 'tanggal_masuk' => now()->subDays(4)],
            ['nama_lengkap' => 'Farhan Agung', 'asal_sekolah' => 'SMAN 9 Semarang', 'minat_program' => 'Reguler', 'nomor_wa' => '081234567806', 'status_tindak_lanjut' => 'BARU', 'tanggal_masuk' => now()->subDays(1)],
        ];

        foreach ($data as $item) {
            Pendaftaran::firstOrCreate(
                ['nomor_wa' => $item['nomor_wa']],
                $item
            );
        }
    }

    protected function seedSiswa(): void
    {
        $siswa = [
            ['nama_lengkap' => 'Alya Putri', 'asal_sekolah' => 'SDN 1 Semarang', 'kategori_kelas' => 'SD', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AWAL BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(25), 'tanggal_lahir' => '2016-03-12', 'alamat_rumah' => 'Jl. Taman Sari No. 12', 'no_telp_siswa' => '081200000001', 'nama_ortu' => 'Siti Aminah', 'no_telp_ortu' => '081300000001', 'biaya_bulanan' => 250000],
            ['nama_lengkap' => 'Dimas Pratama', 'asal_sekolah' => 'SMPN 3 Semarang', 'kategori_kelas' => 'SMP', 'tipe_belajar' => 'PRIVAT', 'tipe_jatuh_tempo' => 'AKHIR BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(22), 'tanggal_lahir' => '2014-08-17', 'alamat_rumah' => 'Jl. Kusumanegara 8', 'no_telp_siswa' => '081200000002', 'nama_ortu' => 'Budi Pratama', 'no_telp_ortu' => '081300000002', 'biaya_bulanan' => 350000],
            ['nama_lengkap' => 'Nadia Zahra', 'asal_sekolah' => 'SMA 7 Semarang', 'kategori_kelas' => 'SMA', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AWAL BULAN', 'status_siswa' => 'CALON', 'tanggal_daftar' => now()->subDays(10), 'tanggal_lahir' => '2007-12-05', 'alamat_rumah' => 'Jl. Gajahmungkur 15', 'no_telp_siswa' => '081200000003', 'nama_ortu' => 'Rahmat Zahra', 'no_telp_ortu' => '081300000003', 'biaya_bulanan' => 420000],
            ['nama_lengkap' => 'Rafi Ramadhan', 'asal_sekolah' => 'SDN 2 Semarang', 'kategori_kelas' => 'SD', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AWAL BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(18), 'tanggal_lahir' => '2015-05-03', 'alamat_rumah' => 'Jl. Pandanaran 45', 'no_telp_siswa' => '081200000004', 'nama_ortu' => 'Ari Ramadhan', 'no_telp_ortu' => '081300000004', 'biaya_bulanan' => 260000],
            ['nama_lengkap' => 'Salsa Anjani', 'asal_sekolah' => 'SMPN 1 Semarang', 'kategori_kelas' => 'SMP', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AKHIR BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(9), 'tanggal_lahir' => '2013-09-21', 'alamat_rumah' => 'Jl. Diponegoro 9', 'no_telp_siswa' => '081200000005', 'nama_ortu' => 'Aminah', 'no_telp_ortu' => '081300000005', 'biaya_bulanan' => 380000],
            ['nama_lengkap' => 'Farhan Agung', 'asal_sekolah' => 'SMAN 9 Semarang', 'kategori_kelas' => 'SMA', 'tipe_belajar' => 'PRIVAT', 'tipe_jatuh_tempo' => 'AWAL BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(11), 'tanggal_lahir' => '2006-06-27', 'alamat_rumah' => 'Jl. Merdeka 82', 'no_telp_siswa' => '081200000006', 'nama_ortu' => 'Harun Agung', 'no_telp_ortu' => '081300000006', 'biaya_bulanan' => 480000],
            ['nama_lengkap' => 'Zahra Nabila', 'asal_sekolah' => 'SDN 5 Semarang', 'kategori_kelas' => 'SD', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AWAL BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(30), 'tanggal_lahir' => '2017-01-15', 'alamat_rumah' => 'Jl. Kramat Raya 22', 'no_telp_siswa' => '081200000007', 'nama_ortu' => 'Yusuf Nabil', 'no_telp_ortu' => '081300000007', 'biaya_bulanan' => 240000],
            ['nama_lengkap' => 'Ibrahim Hadi', 'asal_sekolah' => 'SMPN 2 Semarang', 'kategori_kelas' => 'SMP', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AKHIR BULAN', 'status_siswa' => 'NONAKTIF', 'tanggal_daftar' => now()->subDays(45), 'tanggal_lahir' => '2012-11-08', 'alamat_rumah' => 'Jl. Tambakaji 7', 'no_telp_siswa' => '081200000008', 'nama_ortu' => 'Hadi Santoso', 'no_telp_ortu' => '081300000008', 'biaya_bulanan' => 330000],
            ['nama_lengkap' => 'Maya Sari', 'asal_sekolah' => 'SMA 3 Semarang', 'kategori_kelas' => 'SMA', 'tipe_belajar' => 'KELOMPOK', 'tipe_jatuh_tempo' => 'AWAL BULAN', 'status_siswa' => 'AKTIF', 'tanggal_daftar' => now()->subDays(14), 'tanggal_lahir' => '2008-02-02', 'alamat_rumah' => 'Jl. Pahlawan 18', 'no_telp_siswa' => '081200000009', 'nama_ortu' => 'Deden Sari', 'no_telp_ortu' => '081300000009', 'biaya_bulanan' => 450000],
        ];

        foreach ($siswa as $item) {
            Siswa::firstOrCreate(
                ['nama_lengkap' => $item['nama_lengkap'], 'no_telp_siswa' => $item['no_telp_siswa']],
                $item
            );
        }
    }

    protected function seedKelompok(): void
    {
        $mapelIds = MataPelajaran::pluck('id', 'nama_mapel');
        $tentorIds = User::where('role', 'TENTOR')->pluck('id');

        $kelompokData = [
            ['nama_kelompok' => 'Kelompok Matematika SD A', 'mapel_id' => $mapelIds['Matematika'] ?? 1, 'tentor_id' => $tentorIds[0] ?? 1, 'jadwal_hari' => 'Senin & Rabu', 'jam_mulai' => '16:00:00', 'jam_selesai' => '17:30:00'],
            ['nama_kelompok' => 'Kelompok IPA SMP', 'mapel_id' => $mapelIds['IPA'] ?? 2, 'tentor_id' => $tentorIds[1] ?? 2, 'jadwal_hari' => 'Selasa & Kamis', 'jam_mulai' => '15:30:00', 'jam_selesai' => '17:00:00'],
            ['nama_kelompok' => 'Kelompok Bahasa Inggris SMA', 'mapel_id' => $mapelIds['Bahasa Inggris'] ?? 3, 'tentor_id' => $tentorIds[0] ?? 1, 'jadwal_hari' => 'Senin & Jumat', 'jam_mulai' => '17:00:00', 'jam_selesai' => '18:30:00'],
            ['nama_kelompok' => 'Kelompok TPA Intensif', 'mapel_id' => $mapelIds['TPA'] ?? 7, 'tentor_id' => $tentorIds[1] ?? 2, 'jadwal_hari' => 'Sabtu', 'jam_mulai' => '09:00:00', 'jam_selesai' => '11:00:00'],
        ];

        foreach ($kelompokData as $item) {
            Kelompok::firstOrCreate(
                ['nama_kelompok' => $item['nama_kelompok']],
                $item
            );
        }

        $siswaList = Siswa::pluck('id');
        $kelompokList = Kelompok::all();

        foreach ($kelompokList as $kelompok) {
            $selected = $siswaList->shuffle()->take(rand(3, 5));
            foreach ($selected as $siswaId) {
                DB::table('pemetaan_kelompok')->updateOrInsert(
                    ['siswa_id' => $siswaId, 'kelompok_id' => $kelompok->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    protected function seedJadwal(): void
    {
        $kelompokId = Kelompok::pluck('id');

        foreach ($kelompokId as $id) {
            for ($i = 1; $i <= 3; $i++) {
                JadwalKelompok::firstOrCreate(
                    ['kelompok_id' => $id, 'tanggal_sesi' => now()->subDays($i * 4)->toDateString()],
                    ['kelompok_id' => $id, 'tanggal_sesi' => now()->subDays($i * 4)->toDateString()]
                );
            }
        }
    }

    protected function seedPresensi(): void
    {
        $jadwals = JadwalKelompok::with('kelompok')->get();
        foreach ($jadwals as $jadwal) {
            $siswaIds = DB::table('pemetaan_kelompok')->where('kelompok_id', $jadwal->kelompok_id)->pluck('siswa_id');
            foreach ($siswaIds as $siswaId) {
                DetailPresensi::firstOrCreate(
                    ['jadwal_id' => $jadwal->id, 'siswa_id' => $siswaId],
                    [
                        'jadwal_id' => $jadwal->id,
                        'siswa_id' => $siswaId,
                        'status_kehadiran' => ['HADIR', 'IZIN', 'SAKIT', 'ALPA'][array_rand(['HADIR', 'IZIN', 'SAKIT', 'ALPA'])],
                    ]
                );
            }
        }
    }

    protected function seedPembayaran(): void
    {
        $admins = User::where('role', 'ADMIN')->pluck('id');
        $siswaList = Siswa::all();

        foreach ($siswaList as $siswa) {
            $status = ['LUNAS', 'BELUM'][rand(0, 1)];
            $bulan = rand(1, 12);
            $tahun = now()->year;

            Pembayaran::firstOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'untuk_bulan' => $bulan,
                    'untuk_tahun' => $tahun,
                ],
                [
                    'siswa_id' => $siswa->id,
                    'admin_pencatat_id' => $admins->isNotEmpty() ? $admins->random() : 1,
                    'biaya_dibayar' => $siswa->biaya_bulanan,
                    'metode_bayar' => ['TUNAI', 'TRANSFER', 'QRIS'][rand(0, 2)],
                    'status_bayar' => $status,
                    'tanggal_bayar' => $status === 'LUNAS' ? now()->subDays(rand(1, 21)) : null,
                    'untuk_bulan' => $bulan,
                    'untuk_tahun' => $tahun,
                ]
            );
        }
    }
}
