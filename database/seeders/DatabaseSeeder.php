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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRolesAndPermissions();
        $this->seedUsers();
        $this->resetSimulasiData();
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
        $tentorRole->syncPermissions(['dashboard.view', 'siswa.view', 'kelompok.view', 'pendaftaran.view']);
    }

    protected function seedUsers(): void
    {
        $users = [
            ['email' => 'admin@pelitailmu.id', 'name' => 'Administrator Pelita Ilmu', 'password' => 'password', 'role' => 'ADMIN'],
            ['email' => 'admin@admin.com', 'name' => 'Admin Utama', 'password' => 'admin123', 'role' => 'ADMIN'],
            ['email' => 'tentor@pelitailmu.id', 'name' => 'Tentor Pelita Ilmu', 'password' => 'tentor123', 'role' => 'TENTOR'],
            ['email' => 'guru@pelitailmu.id', 'name' => 'Guru Pengajar Pelita Ilmu', 'password' => 'guru123', 'role' => 'TENTOR'],
        ];

        foreach ($users as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make($item['password']),
                    'role' => $item['role'],
                    'tanggal_daftar' => now(),
                ]
            );
            $user->syncRoles([$item['role']]);
        }
    }

    protected function resetSimulasiData(): void
    {
        // 1. Reset data pendaftar online & sesi jadwal ke 0
        DB::table('detail_presensi')->delete();
        DB::table('jadwal_kelompok')->delete();
        DB::table('pembayaran')->delete();
        DB::table('pemetaan_kelompok')->delete();
        DB::table('siswa')->delete();
        DB::table('kelompok')->delete();
        DB::table('pendaftaran')->delete();

        // 2. Mata Pelajaran resmi dari spreadsheet
        $mapels = [
            'Calistung & Tematik TK',
            'Tematik SD',
            'Matematika SD',
            'IPA SD',
            'Bahasa Indonesia SD',
            'Matematika SMP',
            'IPA SMP',
            'Bahasa Inggris SMP',
            'Matematika SMA',
            'Fisika SMA',
            'Kimia SMA',
            'Biologi SMA',
            'Bahasa Inggris SMA',
            'Ekonomi & Soshum SMA',
            'SNBT / UTBK Intensif',
        ];

        $mapelMap = [];
        foreach ($mapels as $m) {
            $record = MataPelajaran::firstOrCreate(['nama_mapel' => $m]);
            $mapelMap[$m] = $record->id;
        }

        $admin = User::where('role', 'ADMIN')->first() ?? User::first();
        $tentors = User::where('role', 'TENTOR')->get();
        $tentor1 = $tentors->get(0) ?? $admin;
        $tentor2 = $tentors->get(1) ?? $tentor1;

        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        // 3. Kelompok Belajar & Maksimal 2 Siswa per Kelompok (Data Asli Spreadsheet Pelita Ilmu)
        $groups = [
            [
                'nama_kelompok' => 'Kelompok TK - Calistung & Motorik',
                'mapel_name' => 'Calistung & Tematik TK',
                'jadwal_hari' => 'Senin & Rabu',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:00:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Adiba Fardina Adha',
                        'asal_sekolah' => 'RA Permata Belia',
                        'kelas' => 'TK',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Calistung', 'Membaca', 'Berhitung'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2020-07-31',
                        'alamat_rumah' => 'Jl. Penataran RT 6 RW 3, Kalipancur,Ngaliyan',
                        'no_telp_siswa' => '085712051029',
                        'nama_ortu' => 'Anngy audina',
                        'no_telp_ortu' => '085712051029',
                        'biaya_bulanan' => 150000,
                    ],
                    [
                        'nama_lengkap' => 'Rafanizan Mehrdad Chala',
                        'asal_sekolah' => 'TK ABA 54',
                        'kelas' => 'TK',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Calistung', 'Membaca', 'Berhitung'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2022-01-23',
                        'alamat_rumah' => 'Candi penataran 1 no 16',
                        'no_telp_siswa' => '-',
                        'nama_ortu' => 'Dwi Astuti',
                        'no_telp_ortu' => '08970077547',
                        'biaya_bulanan' => 150000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 1 SD - Tematik Terpadu',
                'mapel_name' => 'Tematik SD',
                'jadwal_hari' => 'Senin & Rabu',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:00:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Kenizia Sekar Raudhisya Susilo',
                        'asal_sekolah' => 'SDI AL MADINA',
                        'kelas' => '1 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2020-01-23',
                        'alamat_rumah' => 'Jalan Candi Berlian IV no 25 (Perum Pasadena)',
                        'no_telp_siswa' => '081901215656',
                        'nama_ortu' => 'Kartikasari Kusuma Putri',
                        'no_telp_ortu' => '081901215656',
                        'biaya_bulanan' => 150000,
                    ],
                    [
                        'nama_lengkap' => 'Muhammad Falih Aqmar Saputra',
                        'asal_sekolah' => 'SD Islam Bintang Juara',
                        'kelas' => '1 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2019-08-05',
                        'alamat_rumah' => 'Bukit Panembahan Senopati blok A 18',
                        'no_telp_siswa' => '0895392576189',
                        'nama_ortu' => 'Agus Priyanto',
                        'no_telp_ortu' => '0895392576189',
                        'biaya_bulanan' => 150000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 2 SD - Tematik Terpadu',
                'mapel_name' => 'Tematik SD',
                'jadwal_hari' => 'Selasa & Kamis',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:00:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Rana Azkadina Khalfani',
                        'asal_sekolah' => 'SD Islam Bintang Juara',
                        'kelas' => '2 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2018-09-02',
                        'alamat_rumah' => 'Bukit Panembahan Senopati blok A 18',
                        'no_telp_siswa' => '0895392576189',
                        'nama_ortu' => 'Agus Priyanto',
                        'no_telp_ortu' => '0895392576189',
                        'biaya_bulanan' => 150000,
                    ],
                    [
                        'nama_lengkap' => 'Aluna sagita zivanna',
                        'asal_sekolah' => 'SD Hj ISRIATI BAITURRAHMAN 2',
                        'kelas' => '2 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2018-05-18',
                        'alamat_rumah' => 'Griya Sekar Gading Blok R no 7 Kalisegoro',
                        'no_telp_siswa' => '081329241680',
                        'nama_ortu' => 'Ferry dwi arianto',
                        'no_telp_ortu' => '081329241680',
                        'biaya_bulanan' => 150000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 3 SD - Matematika & Tematik',
                'mapel_name' => 'Tematik SD',
                'jadwal_hari' => 'Senin & Rabu',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Muhammad Azlan Arsalan Al-Fatih',
                        'asal_sekolah' => 'SDIT Mutiara Hati',
                        'kelas' => '3 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2017-06-05',
                        'alamat_rumah' => 'Jalan Candi Penataran Selatan RT 2 RW 2',
                        'no_telp_siswa' => '085641777271',
                        'nama_ortu' => 'Eny Nur Khasanah',
                        'no_telp_ortu' => '085641777271',
                        'biaya_bulanan' => 150000,
                    ],
                    [
                        'nama_lengkap' => 'Muhammad Rizqi Pradana',
                        'asal_sekolah' => 'SD Negeri Kalipancur 01',
                        'kelas' => '3 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2017-08-16',
                        'alamat_rumah' => 'Jl. Kalicari IV No. 12',
                        'no_telp_siswa' => '081228884910',
                        'nama_ortu' => 'Danang Pradana',
                        'no_telp_ortu' => '081228884910',
                        'biaya_bulanan' => 150000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 4 SD - Matematika & IPA',
                'mapel_name' => 'Matematika SD',
                'jadwal_hari' => 'Selasa & Kamis',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Kinan Radithya Alfarizqy Susilo',
                        'asal_sekolah' => 'SDI AL MADINA',
                        'kelas' => '4 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2016-04-12',
                        'alamat_rumah' => 'Jalan Candi Berlian IV no 25 (Perum Pasadena)',
                        'no_telp_siswa' => '081901215656',
                        'nama_ortu' => 'Kartikasari Kusuma Putri',
                        'no_telp_ortu' => '081901215656',
                        'biaya_bulanan' => 150000,
                    ],
                    [
                        'nama_lengkap' => 'Alvaro Gavriel Alfarizqi',
                        'asal_sekolah' => 'SD Islam Al Azhar 29 BSB',
                        'kelas' => '4 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2016-07-28',
                        'alamat_rumah' => 'Cluster Pasadena Spring No. 8',
                        'no_telp_siswa' => '081390444821',
                        'nama_ortu' => 'Rina Kurniawati',
                        'no_telp_ortu' => '081390444821',
                        'biaya_bulanan' => 150000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 5 SD - Matematika & IPA',
                'mapel_name' => 'Matematika SD',
                'jadwal_hari' => 'Rabu & Jumat',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Rayanza Al Khalifi',
                        'asal_sekolah' => 'SDIT Bina Amal',
                        'kelas' => '5 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2015-03-10',
                        'alamat_rumah' => 'Jl. Bukit Manyaran Permai Blok C No. 5',
                        'no_telp_siswa' => '081225567781',
                        'nama_ortu' => 'Bambang Irawan',
                        'no_telp_ortu' => '081225567781',
                        'biaya_bulanan' => 150000,
                    ],
                    [
                        'nama_lengkap' => 'Naura Khadijah Azzahra',
                        'asal_sekolah' => 'SD Negeri Ngaliyan 01',
                        'kelas' => '5 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2015-09-19',
                        'alamat_rumah' => 'Permata Puri Blok D No. 14',
                        'no_telp_siswa' => '081326778901',
                        'nama_ortu' => 'Sri Wahyuni',
                        'no_telp_ortu' => '081326778901',
                        'biaya_bulanan' => 150000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 6 SD - Sukses Ujian Sekolah',
                'mapel_name' => 'Matematika SD',
                'jadwal_hari' => 'Senin & Kamis',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Fathir Ahmad Pratama',
                        'asal_sekolah' => 'SD Hj Isriati Baiturrahman 1',
                        'kelas' => '6 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Indonesia'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2014-02-14',
                        'alamat_rumah' => 'Jl. Pamularsih Raya No. 45',
                        'no_telp_siswa' => '081229988712',
                        'nama_ortu' => 'Ahmad Fauzi',
                        'no_telp_ortu' => '081229988712',
                        'biaya_bulanan' => 195000,
                    ],
                    [
                        'nama_lengkap' => 'Aisyah Putri Rahmadani',
                        'asal_sekolah' => 'SD Negeri Kalipancur 02',
                        'kelas' => '6 SD',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Indonesia'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2014-06-22',
                        'alamat_rumah' => 'Jl. Candi Kalasan No. 8',
                        'no_telp_siswa' => '085740112233',
                        'nama_ortu' => 'Rahmat Hidayat',
                        'no_telp_ortu' => '085740112233',
                        'biaya_bulanan' => 195000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 7 SMP - Matematika & IPA',
                'mapel_name' => 'Matematika SMP',
                'jadwal_hari' => 'Selasa & Jumat',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Zalfa Kayla Nadhifa',
                        'asal_sekolah' => 'SMP Negeri 1 Semarang',
                        'kelas' => '7 SMP',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA Fisika', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2013-04-18',
                        'alamat_rumah' => 'Jl. Veteran No. 15',
                        'no_telp_siswa' => '081228899001',
                        'nama_ortu' => 'Dwi Handayani',
                        'no_telp_ortu' => '081228899001',
                        'biaya_bulanan' => 140000,
                    ],
                    [
                        'nama_lengkap' => 'Galih Bintang Pamungkas',
                        'asal_sekolah' => 'SMP Negeri 3 Semarang',
                        'kelas' => '7 SMP',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA Fisika', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2013-11-09',
                        'alamat_rumah' => 'Jl. Dr. Sutomo No. 30',
                        'no_telp_siswa' => '081390112234',
                        'nama_ortu' => 'Tri Pamungkas',
                        'no_telp_ortu' => '081390112234',
                        'biaya_bulanan' => 140000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 8 SMP - Matematika & IPA',
                'mapel_name' => 'Matematika SMP',
                'jadwal_hari' => 'Senin & Rabu',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Devan Raditya Pratama',
                        'asal_sekolah' => 'SMP Negeri 2 Semarang',
                        'kelas' => '8 SMP',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA Fisika', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2012-05-15',
                        'alamat_rumah' => 'Jl. Gajahmungkur Selatan No. 19',
                        'no_telp_siswa' => '085876543210',
                        'nama_ortu' => 'Heru Pratama',
                        'no_telp_ortu' => '085876543210',
                        'biaya_bulanan' => 190000,
                    ],
                    [
                        'nama_lengkap' => 'Syifa Aulia Rahman',
                        'asal_sekolah' => 'SMP Islam Al Azhar 14',
                        'kelas' => '8 SMP',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA Fisika', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2012-08-30',
                        'alamat_rumah' => 'Bukit Silayur No. 27',
                        'no_telp_siswa' => '081226789123',
                        'nama_ortu' => 'Arief Rahman',
                        'no_telp_ortu' => '081226789123',
                        'biaya_bulanan' => 190000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 9 SMP - Sukses ASPD & Ujian Akhir',
                'mapel_name' => 'IPA SMP',
                'jadwal_hari' => 'Selasa & Kamis',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Muhammad Zidan Arfiansyah',
                        'asal_sekolah' => 'SMP Negeri 7 Semarang',
                        'kelas' => '9 SMP',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA Biologi/Fisika', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2011-01-20',
                        'alamat_rumah' => 'Jl. Kaligarang No. 6',
                        'no_telp_siswa' => '081225678901',
                        'nama_ortu' => 'Arfian S.',
                        'no_telp_ortu' => '081225678901',
                        'biaya_bulanan' => 190000,
                    ],
                    [
                        'nama_lengkap' => 'Amanda Putri Maharani',
                        'asal_sekolah' => 'SMP Negeri 4 Semarang',
                        'kelas' => '9 SMP',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika', 'IPA Biologi/Fisika', 'Bahasa Inggris'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2011-07-14',
                        'alamat_rumah' => 'Jl. Simongan Raya No. 50',
                        'no_telp_siswa' => '085728899112',
                        'nama_ortu' => 'Maharani Dewi',
                        'no_telp_ortu' => '085728899112',
                        'biaya_bulanan' => 190000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 10 SMA - Matematika & Sains',
                'mapel_name' => 'Matematika SMA',
                'jadwal_hari' => 'Senin & Rabu',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Rangga Aditya Nugraha',
                        'asal_sekolah' => 'SMA Negeri 3 Semarang',
                        'kelas' => '10 SMA',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika Wajib', 'Fisika', 'Kimia'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2010-03-25',
                        'alamat_rumah' => 'Jl. Pandanaran II No. 11',
                        'no_telp_siswa' => '081391234567',
                        'nama_ortu' => 'Nugraha Sanjaya',
                        'no_telp_ortu' => '081391234567',
                        'biaya_bulanan' => 200000,
                    ],
                    [
                        'nama_lengkap' => 'Clarissa Aurelia Putri',
                        'asal_sekolah' => 'SMA Negeri 1 Semarang',
                        'kelas' => '10 SMA',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika Wajib', 'Fisika', 'Kimia'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2010-10-11',
                        'alamat_rumah' => 'Jl. Kyai Saleh No. 4',
                        'no_telp_siswa' => '081228123456',
                        'nama_ortu' => 'Iwan Susanto',
                        'no_telp_ortu' => '081228123456',
                        'biaya_bulanan' => 200000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 11 SMA - MIPA Unggulan',
                'mapel_name' => 'Kimia SMA',
                'jadwal_hari' => 'Selasa & Jumat',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Bagas Arya Wicaksana',
                        'asal_sekolah' => 'SMA Negeri 5 Semarang',
                        'kelas' => '11 SMA',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika Tingkat Lanjut', 'Kimia', 'Fisika'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2009-02-18',
                        'alamat_rumah' => 'Jl. Pemuda No. 88',
                        'no_telp_siswa' => '085712349876',
                        'nama_ortu' => 'Wicaksana E.',
                        'no_telp_ortu' => '085712349876',
                        'biaya_bulanan' => 230000,
                    ],
                    [
                        'nama_lengkap' => 'Salma Nabilla Ramadhani',
                        'asal_sekolah' => 'SMA Negeri 2 Semarang',
                        'kelas' => '11 SMA',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Matematika Tingkat Lanjut', 'Kimia', 'Fisika'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2009-08-04',
                        'alamat_rumah' => 'Jl. Mugas Barat No. 12',
                        'no_telp_siswa' => '081229001122',
                        'nama_ortu' => 'Ramadhani K.',
                        'no_telp_ortu' => '081229001122',
                        'biaya_bulanan' => 230000,
                    ],
                ],
            ],
            [
                'nama_kelompok' => 'Kelompok Kelas 12 SMA - Sukses SNBT & UTBK',
                'mapel_name' => 'SNBT / UTBK Intensif',
                'jadwal_hari' => 'Senin & Kamis',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
                'siswa' => [
                    [
                        'nama_lengkap' => 'Satria Bayu Aji',
                        'asal_sekolah' => 'SMA Negeri 1 Semarang',
                        'kelas' => '12 SMA',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Penalaran Matematika', 'Literasi B. Indonesia', 'Pengetahuan Kuantitatif'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2008-04-27',
                        'alamat_rumah' => 'Jalan Tambakharjo Rt 1 Rw 7',
                        'no_telp_siswa' => '085875299217',
                        'nama_ortu' => 'Miati',
                        'no_telp_ortu' => '085701137072',
                        'biaya_bulanan' => 290000,
                    ],
                    [
                        'nama_lengkap' => 'Tiara Anindita Putri',
                        'asal_sekolah' => 'SMA Negeri 3 Semarang',
                        'kelas' => '12 SMA',
                        'kategori_kelas' => 'Reguler',
                        'pilihan_mapel' => ['Penalaran Matematika', 'Literasi B. Indonesia', 'Pengetahuan Kuantitatif'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'tanggal_lahir' => '2008-09-15',
                        'alamat_rumah' => 'Jl. Erlangga Tengah No. 3',
                        'no_telp_siswa' => '081229334455',
                        'nama_ortu' => 'Bambang Soetrisno',
                        'no_telp_ortu' => '081229334455',
                        'biaya_bulanan' => 290000,
                    ],
                ],
            ],
        ];

        foreach ($groups as $idx => $g) {
            $tentorId = ($idx % 2 === 0) ? ($tentor1?->id ?? 1) : ($tentor2?->id ?? 1);
            $kelompok = Kelompok::create([
                'nama_kelompok' => $g['nama_kelompok'],
                'mapel_id' => $mapelMap[$g['mapel_name']] ?? 1,
                'tentor_id' => $tentorId,
                'jadwal_hari' => $g['jadwal_hari'],
                'jam_mulai' => $g['jam_mulai'],
                'jam_selesai' => $g['jam_selesai'],
            ]);

            foreach ($g['siswa'] as $sData) {
                $siswa = Siswa::create([
                    'nama_lengkap' => $sData['nama_lengkap'],
                    'asal_sekolah' => $sData['asal_sekolah'],
                    'kelas' => $sData['kelas'],
                    'kategori_kelas' => $sData['kategori_kelas'],
                    'pilihan_mapel' => $sData['pilihan_mapel'],
                    'tipe_belajar' => $sData['tipe_belajar'],
                    'tipe_jatuh_tempo' => $sData['tipe_jatuh_tempo'],
                    'status_siswa' => $sData['status_siswa'],
                    'tanggal_daftar' => $sData['tanggal_daftar'],
                    'tanggal_lahir' => $sData['tanggal_lahir'],
                    'alamat_rumah' => $sData['alamat_rumah'],
                    'no_telp_siswa' => $sData['no_telp_siswa'],
                    'nama_ortu' => $sData['nama_ortu'],
                    'no_telp_ortu' => $sData['no_telp_ortu'],
                    'biaya_bulanan' => $sData['biaya_bulanan'],
                ]);

                DB::table('pemetaan_kelompok')->insert([
                    'siswa_id' => $siswa->id,
                    'kelompok_id' => $kelompok->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Buat 1 tagihan lunas dan 1 tagihan berjalan untuk testing modul pembayaran
                Pembayaran::create([
                    'siswa_id' => $siswa->id,
                    'admin_pencatat_id' => $admin?->id ?? 1,
                    'untuk_bulan' => $currentMonth,
                    'untuk_tahun' => $currentYear,
                    'biaya_dibayar' => $sData['biaya_bulanan'],
                    'metode_bayar' => 'QRIS',
                    'status_bayar' => 'LUNAS',
                    'tanggal_bayar' => $now->toDateString(),
                    'keterangan' => 'Pelunasan SPP awal bulan (QRIS)',
                ]);
            }
        }
    }
}
