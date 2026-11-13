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
        $tentorRole->syncPermissions(['dashboard.view', 'siswa.view', 'kelompok.view', 'pendaftaran.view']);
    }

    protected function seedUsers(): void
    {
        $users = [
            ['email' => 'admin@pelitailmu.id', 'name' => 'Administrator Pelita Ilmu', 'password' => 'password', 'role' => 'ADMIN'],
            ['email' => 'admin@admin.com', 'name' => 'Admin Utama', 'password' => 'admin123', 'role' => 'ADMIN'],
            ['email' => 'tentor@pelitailmu.id', 'name' => 'Tentor Pelita Ilmu', 'password' => 'tentor123', 'role' => 'TENTOR'],
            ['email' => 'guru@pelitailmu.id', 'name' => 'Guru Pengajar Pelita Ilmu', 'password' => 'guru123', 'role' => 'TENTOR'],
            ['email' => 'test@example.com', 'name' => 'Test User', 'password' => 'password', 'role' => 'TENTOR'],
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
            [
                'nama_lengkap' => 'Alya Putri',
                'nama_panggilan' => 'Alya',
                'asal_sekolah' => 'SDN 1 Semarang',
                'kelas' => '5 SD',
                'kategori_kelas' => 'Reguler',
                'program_belajar' => 'SD Kelas 1-5',
                'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Indonesia'],
                'tanggal_lahir' => '2016-03-12',
                'nama_ortu' => 'Siti Aminah',
                'no_telp_ortu' => '081234567801',
                'no_telp_siswa' => '081200000001',
                'alamat_rumah' => 'Jl. Taman Sari No. 12',
                'minat_program' => '[5 SD] Reguler - SD Kelas 1-5',
                'paket_pendaftaran' => 'Dengan Kaos (+Rp70.000)',
                'ukuran_kaos' => 'M',
                'nomor_wa' => '081234567801',
                'status_tindak_lanjut' => 'DITERIMA',
                'tanggal_masuk' => Carbon::create(2026, 8, 5, 10, 0),
            ],
            [
                'nama_lengkap' => 'Dimas Pratama',
                'nama_panggilan' => 'Dimas',
                'asal_sekolah' => 'SMPN 3 Semarang',
                'kelas' => '8 SMP',
                'kategori_kelas' => 'Privat',
                'program_belajar' => 'SMP 2 Mapel',
                'pilihan_mapel' => ['Matematika', 'IPA Fisika'],
                'tanggal_lahir' => '2014-08-17',
                'nama_ortu' => 'Budi Pratama',
                'no_telp_ortu' => '081234567802',
                'no_telp_siswa' => '081200000002',
                'alamat_rumah' => 'Jl. Kusumanegara 8',
                'minat_program' => '[8 SMP] Privat - SMP 2 Mapel (Mapel: Matematika, IPA Fisika)',
                'paket_pendaftaran' => 'Hanya Pendaftaran',
                'ukuran_kaos' => null,
                'nomor_wa' => '081234567802',
                'status_tindak_lanjut' => 'DIHUBUNGI',
                'tanggal_masuk' => Carbon::create(2026, 9, 4, 14, 30),
            ],
            [
                'nama_lengkap' => 'Nadia Zahra',
                'nama_panggilan' => 'Nadia',
                'asal_sekolah' => 'SMA 7 Semarang',
                'kelas' => '11 SMA',
                'kategori_kelas' => 'Reguler',
                'program_belajar' => 'SMA 2 Mapel',
                'pilihan_mapel' => ['Matematika Wajib / Lanjut', 'Bahasa Inggris'],
                'tanggal_lahir' => '2007-12-05',
                'nama_ortu' => 'Rahmat Zahra',
                'no_telp_ortu' => '081234567803',
                'no_telp_siswa' => '081200000003',
                'alamat_rumah' => 'Jl. Gajahmungkur 15',
                'minat_program' => '[11 SMA] Reguler - SMA 2 Mapel (Mapel: Matematika Wajib / Lanjut, Bahasa Inggris)',
                'paket_pendaftaran' => 'Dengan Kaos (+Rp70.000)',
                'ukuran_kaos' => 'L',
                'nomor_wa' => '081234567803',
                'status_tindak_lanjut' => 'BARU',
                'tanggal_masuk' => Carbon::create(2026, 11, 8, 9, 15),
            ],
            [
                'nama_lengkap' => 'Rizky Fadillah',
                'nama_panggilan' => 'Rizky',
                'asal_sekolah' => 'SMPN 2 Semarang',
                'kelas' => '8 SMP',
                'kategori_kelas' => 'Reguler',
                'program_belajar' => 'SMP 3 Mapel',
                'pilihan_mapel' => ['Matematika', 'Bahasa Inggris', 'IPA Fisika'],
                'tanggal_lahir' => '2013-11-20',
                'nama_ortu' => 'Fadillah Ahmad',
                'no_telp_ortu' => '081234567807',
                'no_telp_siswa' => '081200000011',
                'alamat_rumah' => 'Jl. Pamularsih 19',
                'minat_program' => '[8 SMP] Reguler - SMP 3 Mapel (Mapel: Matematika, Bahasa Inggris, IPA Fisika)',
                'paket_pendaftaran' => 'Hanya Pendaftaran',
                'ukuran_kaos' => null,
                'nomor_wa' => '081234567807',
                'status_tindak_lanjut' => 'BARU',
                'tanggal_masuk' => now()->subHours(5),
            ],
        ];

        foreach ($data as $item) {
            Pendaftaran::updateOrCreate(
                ['nomor_wa' => $item['nomor_wa']],
                $item
            );
        }
    }

    protected function seedSiswa(): void
    {
        $siswa = [
            // Masuk Agustus 2026
            [
                'nama_lengkap' => 'Alya Putri',
                'asal_sekolah' => 'SDN 1 Semarang',
                'kelas' => '5 SD',
                'kategori_kelas' => 'SD',
                'pilihan_mapel' => ['Matematika', 'IPA', 'Bahasa Indonesia'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-08-05 09:00:00',
                'tanggal_lahir' => '2016-03-12',
                'alamat_rumah' => 'Jl. Taman Sari No. 12',
                'no_telp_siswa' => '081200000001',
                'nama_ortu' => 'Siti Aminah',
                'no_telp_ortu' => '081300000001',
                'biaya_bulanan' => 250000,
                'keterangan' => 'Siswa angkatan Agustus, jadwal rutin Senin & Rabu.',
            ],
            [
                'nama_lengkap' => 'Zahra Nabila',
                'asal_sekolah' => 'SDN 5 Semarang',
                'kelas' => '4 SD',
                'kategori_kelas' => 'SD',
                'pilihan_mapel' => ['Matematika', 'Bahasa Indonesia'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-08-18 10:30:00',
                'tanggal_lahir' => '2017-01-15',
                'alamat_rumah' => 'Jl. Kramat Raya 22',
                'no_telp_siswa' => '081200000007',
                'nama_ortu' => 'Yusuf Nabil',
                'no_telp_ortu' => '081300000007',
                'biaya_bulanan' => 240000,
                'keterangan' => 'Fokus pendampingan berhitung dasar.',
            ],

            // Masuk September 2026
            [
                'nama_lengkap' => 'Dimas Pratama',
                'asal_sekolah' => 'SMPN 3 Semarang',
                'kelas' => '8 SMP',
                'kategori_kelas' => 'SMP',
                'pilihan_mapel' => ['Matematika', 'IPA Fisika'],
                'tipe_belajar' => 'PRIVAT',
                'tipe_jatuh_tempo' => 'AKHIR BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-09-04 14:00:00',
                'tanggal_lahir' => '2014-08-17',
                'alamat_rumah' => 'Jl. Kusumanegara 8',
                'no_telp_siswa' => '081200000002',
                'nama_ortu' => 'Budi Pratama',
                'no_telp_ortu' => '081300000002',
                'biaya_bulanan' => 350000,
                'keterangan' => 'Privat sore, jatuh tempo akhir bulan.',
            ],
            [
                'nama_lengkap' => 'Ibrahim Hadi',
                'asal_sekolah' => 'SMPN 2 Semarang',
                'kelas' => '7 SMP',
                'kategori_kelas' => 'SMP',
                'pilihan_mapel' => ['Matematika', 'IPA Fisika'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AKHIR BULAN',
                'status_siswa' => 'NONAKTIF',
                'tanggal_daftar' => '2026-09-19 11:00:00',
                'tanggal_keluar' => '2026-10-15',
                'tanggal_lahir' => '2012-11-08',
                'alamat_rumah' => 'Jl. Tambakaji 7',
                'no_telp_siswa' => '081200000008',
                'nama_ortu' => 'Hadi Santoso',
                'no_telp_ortu' => '081300000008',
                'biaya_bulanan' => 330000,
                'keterangan' => 'Siswa nonaktif/berhenti pada 15 Oktober 2026.',
            ],

            // Masuk Oktober 2026
            [
                'nama_lengkap' => 'Rafi Ramadhan',
                'asal_sekolah' => 'SDN 2 Semarang',
                'kelas' => '6 SD',
                'kategori_kelas' => 'SD',
                'pilihan_mapel' => ['Matematika', 'IPA'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-10-03 08:45:00',
                'tanggal_lahir' => '2015-05-03',
                'alamat_rumah' => 'Jl. Pandanaran 45',
                'no_telp_siswa' => '081200000004',
                'nama_ortu' => 'Ari Ramadhan',
                'no_telp_ortu' => '081300000004',
                'biaya_bulanan' => 260000,
                'keterangan' => 'Persiapan ujian sekolah kelas 6.',
            ],
            [
                'nama_lengkap' => 'Salsa Anjani',
                'asal_sekolah' => 'SMPN 1 Semarang',
                'kelas' => '9 SMP',
                'kategori_kelas' => 'SMP',
                'pilihan_mapel' => ['Matematika', 'Bahasa Inggris', 'IPA Biologi'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AKHIR BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-10-12 13:15:00',
                'tanggal_lahir' => '2013-09-21',
                'alamat_rumah' => 'Jl. Diponegoro 9',
                'no_telp_siswa' => '081200000005',
                'nama_ortu' => 'Aminah',
                'no_telp_ortu' => '081300000005',
                'biaya_bulanan' => 380000,
                'keterangan' => 'Lunas Oktober, tagihan November menunggu konfirmasi ortu.',
            ],
            [
                'nama_lengkap' => 'Farhan Agung',
                'asal_sekolah' => 'SMAN 9 Semarang',
                'kelas' => '12 SMA',
                'kategori_kelas' => 'SMA',
                'pilihan_mapel' => ['Fisika / Ekonomi', 'Kimia / Geografi'],
                'tipe_belajar' => 'PRIVAT',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-10-21 16:00:00',
                'tanggal_lahir' => '2006-06-27',
                'alamat_rumah' => 'Jl. Merdeka 82',
                'no_telp_siswa' => '081200000006',
                'nama_ortu' => 'Harun Agung',
                'no_telp_ortu' => '081300000006',
                'biaya_bulanan' => 480000,
                'keterangan' => 'Program intensif UTBK/SNBT.',
            ],

            // Masuk November 2026 (siswa baru — tidak boleh tampil di filter Oktober 2026 ke bawah)
            [
                'nama_lengkap' => 'Maya Sari',
                'asal_sekolah' => 'SMA 3 Semarang',
                'kelas' => '10 SMA',
                'kategori_kelas' => 'SMA',
                'pilihan_mapel' => ['Matematika Wajib / Lanjut', 'Bahasa Inggris', 'Biologi / Sosiologi'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'AKTIF',
                'tanggal_daftar' => '2026-11-02 09:30:00',
                'tanggal_lahir' => '2008-02-02',
                'alamat_rumah' => 'Jl. Pahlawan 18',
                'no_telp_siswa' => '081200000009',
                'nama_ortu' => 'Deden Sari',
                'no_telp_ortu' => '081300000009',
                'biaya_bulanan' => 450000,
                'keterangan' => 'Siswa baru masuk November 2026.',
            ],
            [
                'nama_lengkap' => 'Bintang Pratama',
                'asal_sekolah' => 'SMPN 4 Semarang',
                'kelas' => '8 SMP',
                'kategori_kelas' => 'SMP',
                'pilihan_mapel' => ['Matematika', 'Bahasa Inggris'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'BELUM_MULAI',
                'tanggal_daftar' => '2026-11-10 15:00:00',
                'tanggal_lahir' => '2013-05-19',
                'alamat_rumah' => 'Jl. Pamularsih 33',
                'no_telp_siswa' => '081200000010',
                'nama_ortu' => 'Agus Pratama',
                'no_telp_ortu' => '081300000010',
                'biaya_bulanan' => 320000,
                'keterangan' => 'Sudah daftar November, mulai sesi minggu depan.',
            ],
            [
                'nama_lengkap' => 'Nadia Zahra',
                'asal_sekolah' => 'SMA 7 Semarang',
                'kelas' => '11 SMA',
                'kategori_kelas' => 'SMA',
                'pilihan_mapel' => ['Matematika Wajib / Lanjut', 'Bahasa Inggris'],
                'tipe_belajar' => 'KELOMPOK',
                'tipe_jatuh_tempo' => 'AWAL BULAN',
                'status_siswa' => 'CALON',
                'tanggal_daftar' => '2026-11-08 09:15:00',
                'tanggal_lahir' => '2007-12-05',
                'alamat_rumah' => 'Jl. Gajahmungkur 15',
                'no_telp_siswa' => '081200000003',
                'nama_ortu' => 'Rahmat Zahra',
                'no_telp_ortu' => '081300000003',
                'biaya_bulanan' => 420000,
                'keterangan' => 'Masih calon siswa, menunggu konfirmasi jadwal.',
            ],
        ];

        foreach ($siswa as $item) {
            Siswa::updateOrCreate(
                ['nama_lengkap' => $item['nama_lengkap'], 'no_telp_siswa' => $item['no_telp_siswa']],
                $item
            );
        }
    }

    protected function seedKelompok(): void
    {
        $mapelIds = MataPelajaran::pluck('id', 'nama_mapel');
        $tentorIds = User::where('role', 'TENTOR')->orderBy('id')->pluck('id');

        $kelompokData = [
            ['nama_kelompok' => 'Kelompok Matematika SD A', 'mapel_id' => $mapelIds['Matematika'] ?? 1, 'tentor_id' => $tentorIds[0] ?? 1, 'jadwal_hari' => 'Senin & Rabu', 'jam_mulai' => '16:00:00', 'jam_selesai' => '17:30:00'],
            ['nama_kelompok' => 'Kelompok IPA SMP', 'mapel_id' => $mapelIds['IPA'] ?? 2, 'tentor_id' => $tentorIds[1] ?? ($tentorIds[0] ?? 1), 'jadwal_hari' => 'Selasa & Kamis', 'jam_mulai' => '15:30:00', 'jam_selesai' => '17:00:00'],
            ['nama_kelompok' => 'Kelompok Bahasa Inggris SMA', 'mapel_id' => $mapelIds['Bahasa Inggris'] ?? 3, 'tentor_id' => $tentorIds[0] ?? 1, 'jadwal_hari' => 'Senin & Jumat', 'jam_mulai' => '17:00:00', 'jam_selesai' => '18:30:00'],
            ['nama_kelompok' => 'Kelompok TPA Intensif', 'mapel_id' => $mapelIds['TPA'] ?? 7, 'tentor_id' => $tentorIds[1] ?? ($tentorIds[0] ?? 1), 'jadwal_hari' => 'Sabtu', 'jam_mulai' => '09:00:00', 'jam_selesai' => '11:00:00'],
        ];

        foreach ($kelompokData as $item) {
            Kelompok::updateOrCreate(
                ['nama_kelompok' => $item['nama_kelompok']],
                $item
            );
        }

        $siswaList = Siswa::where('status_siswa', '!=', 'CALON')->pluck('id');
        $kelompokList = Kelompok::all();

        foreach ($kelompokList as $idx => $kelompok) {
            $slice = $siswaList->slice($idx * 2, 3);
            if ($slice->isEmpty()) {
                $slice = $siswaList->take(2);
            }
            foreach ($slice as $siswaId) {
                DB::table('pemetaan_kelompok')->updateOrInsert(
                    ['siswa_id' => $siswaId, 'kelompok_id' => $kelompok->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    protected function seedJadwal(): void
    {
        $ruangOptions = ['Ruang 1 (Utama)', 'Ruang 2 (AC)', 'Ruang 3', 'Ruang Privat'];
        $kelompokList = Kelompok::all();

        foreach ($kelompokList as $idx => $kelompok) {
            JadwalKelompok::updateOrCreate(
                [
                    'kelompok_id' => $kelompok->id,
                    'tanggal_sesi' => now()->toDateString(),
                ],
                [
                    'ruang_kelas' => $ruangOptions[$idx % count($ruangOptions)],
                    'status_sesi' => 'TERJADWAL',
                    'materi_pembahasan' => 'Latihan Soal & Pendalaman Konsep Pertemuan Hari Ini',
                    'catatan_tentor' => 'Persiapkan modul latihan bagian B.',
                ]
            );

            for ($i = 1; $i <= 2; $i++) {
                JadwalKelompok::updateOrCreate(
                    [
                        'kelompok_id' => $kelompok->id,
                        'tanggal_sesi' => now()->subDays($i * 4)->toDateString(),
                    ],
                    [
                        'ruang_kelas' => $ruangOptions[($idx + $i) % count($ruangOptions)],
                        'status_sesi' => 'SELESAI',
                        'materi_pembahasan' => "Review Materi Sesi #{$i}",
                        'catatan_tentor' => 'Evaluasi berjalan lancar.',
                    ]
                );
            }
        }
    }

    protected function seedPresensi(): void
    {
        $jadwals = JadwalKelompok::where('status_sesi', 'SELESAI')->get();
        $statuses = ['HADIR', 'HADIR', 'HADIR', 'IZIN', 'SAKIT', 'ALPA'];

        foreach ($jadwals as $jadwal) {
            $siswaIds = DB::table('pemetaan_kelompok')
                ->where('kelompok_id', $jadwal->kelompok_id)
                ->pluck('siswa_id');

            foreach ($siswaIds as $idx => $siswaId) {
                DetailPresensi::firstOrCreate(
                    ['jadwal_id' => $jadwal->id, 'siswa_id' => $siswaId],
                    ['status_kehadiran' => $statuses[($siswaId + $idx) % count($statuses)]]
                );
            }
        }
    }

    protected function seedPembayaran(): void
    {
        $adminId = User::where('role', 'ADMIN')->value('id') ?? 1;
        $siswaByName = Siswa::all()->keyBy('nama_lengkap');
        $today = now()->toDateString();

        $records = [
            // Alya Putri (masuk Agu 2026): lunas Agu, Sep, Okt, dan Nov (bayar hari ini TUNAI)
            ['nama' => 'Alya Putri', 'bulan' => 8, 'tahun' => 2026, 'metode' => 'TUNAI', 'tgl' => '2026-08-06', 'ket' => 'Pembayaran SPP Agustus lunas'],
            ['nama' => 'Alya Putri', 'bulan' => 9, 'tahun' => 2026, 'metode' => 'TRANSFER', 'tgl' => '2026-09-05', 'ket' => 'Transfer BCA bulan September'],
            ['nama' => 'Alya Putri', 'bulan' => 10, 'tahun' => 2026, 'metode' => 'QRIS', 'tgl' => '2026-10-06', 'ket' => 'Scan QRIS kasir'],
            ['nama' => 'Alya Putri', 'bulan' => 11, 'tahun' => 2026, 'metode' => 'TUNAI', 'tgl' => $today, 'ket' => 'Pelunasan tunai hari ini di meja admin'],

            // Zahra Nabila (masuk Agu 2026): lunas Agu, Sep, Okt — BELUM lunas November 2026
            ['nama' => 'Zahra Nabila', 'bulan' => 8, 'tahun' => 2026, 'metode' => 'TUNAI', 'tgl' => '2026-08-19', 'ket' => 'SPP awal Agustus'],
            ['nama' => 'Zahra Nabila', 'bulan' => 9, 'tahun' => 2026, 'metode' => 'TUNAI', 'tgl' => '2026-09-07', 'ket' => 'Lunas September'],
            ['nama' => 'Zahra Nabila', 'bulan' => 10, 'tahun' => 2026, 'metode' => 'TRANSFER', 'tgl' => '2026-10-07', 'ket' => 'Lunas Oktober via transfer Mandiri'],

            // Dimas Pratama (masuk Sep 2026): lunas Sep, Okt, dan Nov (TRANSFER hari ini)
            ['nama' => 'Dimas Pratama', 'bulan' => 9, 'tahun' => 2026, 'metode' => 'TRANSFER', 'tgl' => '2026-09-25', 'ket' => 'Transfer privat September'],
            ['nama' => 'Dimas Pratama', 'bulan' => 10, 'tahun' => 2026, 'metode' => 'TRANSFER', 'tgl' => '2026-10-25', 'ket' => 'Transfer privat Oktober'],
            ['nama' => 'Dimas Pratama', 'bulan' => 11, 'tahun' => 2026, 'metode' => 'TRANSFER', 'tgl' => $today, 'ket' => 'Transfer konfirmasi WA hari ini'],

            // Rafi Ramadhan (masuk Okt 2026): lunas Okt — BELUM lunas November 2026
            ['nama' => 'Rafi Ramadhan', 'bulan' => 10, 'tahun' => 2026, 'metode' => 'QRIS', 'tgl' => '2026-10-05', 'ket' => 'Lunas bulan pertama Oktober'],

            // Salsa Anjani (masuk Okt 2026): lunas Okt — BELUM lunas November 2026
            ['nama' => 'Salsa Anjani', 'bulan' => 10, 'tahun' => 2026, 'metode' => 'TUNAI', 'tgl' => '2026-10-26', 'ket' => 'Lunas Oktober akhir bulan'],

            // Farhan Agung (masuk Okt 2026): lunas Okt dan Nov (QRIS)
            ['nama' => 'Farhan Agung', 'bulan' => 10, 'tahun' => 2026, 'metode' => 'QRIS', 'tgl' => '2026-10-22', 'ket' => 'Pembayaran perdana Oktober'],
            ['nama' => 'Farhan Agung', 'bulan' => 11, 'tahun' => 2026, 'metode' => 'QRIS', 'tgl' => now()->startOfWeek()->toDateString(), 'ket' => 'Lunas November via QRIS'],

            // Maya Sari (siswa baru Nov 2026): lunas Nov (TRANSFER)
            ['nama' => 'Maya Sari', 'bulan' => 11, 'tahun' => 2026, 'metode' => 'TRANSFER', 'tgl' => '2026-11-04', 'ket' => 'Pelunasan SPP perdana November'],
        ];

        foreach ($records as $item) {
            $siswa = $siswaByName->get($item['nama']);
            if (! $siswa) {
                continue;
            }

            Pembayaran::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'untuk_bulan' => $item['bulan'],
                    'untuk_tahun' => $item['tahun'],
                ],
                [
                    'admin_pencatat_id' => $adminId,
                    'biaya_dibayar' => $siswa->biaya_bulanan,
                    'metode_bayar' => $item['metode'],
                    'status_bayar' => 'LUNAS',
                    'tanggal_bayar' => $item['tgl'],
                    'keterangan' => $item['ket'],
                ]
            );
        }
    }
}
