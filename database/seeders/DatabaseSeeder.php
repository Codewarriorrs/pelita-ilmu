<?php

namespace Database\Seeders;

use App\Models\Kelompok;
use App\Models\MataPelajaran;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use ZipArchive;

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

        // 2. Baca file Pendataan Siswa
        $studentsByClass = $this->parseMasterStudents();

        // 3. Baca Rombel Kelompok dari Data Kelompok Siswa All Pelita Ilmu 19092026.xlsx
        $rombelList = $this->parseRombels();

        $admin = User::where('role', 'ADMIN')->first() ?? User::first();
        $tentors = User::where('role', 'TENTOR')->get();
        $tentor1 = $tentors->get(0) ?? $admin;
        $tentor2 = $tentors->get(1) ?? $tentor1;

        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $createdSiswaIds = [];

        foreach ($rombelList as $idx => $rombel) {
            $rombelName = $rombel['nama'];
            $mapelName = $rombel['mapel'];
            $jenjang = $rombel['jenjang'];
            $kelas = $rombel['kelas'];
            $biaya = $rombel['biaya'];

            // Mata Pelajaran
            $mapel = MataPelajaran::firstOrCreate(['nama_mapel' => $mapelName]);

            // Tentor bergantian
            $tentorId = ($idx % 2 === 0) ? ($tentor1?->id ?? 1) : ($tentor2?->id ?? 1);

            // Buat Kelompok
            $kelompok = Kelompok::create([
                'nama_kelompok' => $rombelName,
                'mapel_id' => $mapel->id,
                'tentor_id' => $tentorId,
                'jadwal_hari' => $rombel['hari'],
                'jam_mulai' => $rombel['jam_mulai'],
                'jam_selesai' => $rombel['jam_selesai'],
            ]);

            // Ambil maksimal 2 siswa untuk kelompok ini dari data murid asli
            $candidates = $studentsByClass[$kelas] ?? ($studentsByClass[$jenjang] ?? []);
            $assignedCount = 0;

            foreach ($candidates as $candidate) {
                if ($assignedCount >= 2) break;

                // Ambil atau buat siswa
                $siswa = Siswa::firstOrCreate(
                    ['nama_lengkap' => $candidate['nama']],
                    [
                        'asal_sekolah' => $candidate['asal_sekolah'],
                        'kelas' => $candidate['kelas_display'],
                        'kategori_kelas' => $candidate['kategori'] ?? 'Reguler',
                        'pilihan_mapel' => [$mapelName],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => '2026-10-10',
                        'alamat_rumah' => $candidate['alamat'] ?: 'Jl. Pelita Ilmu No. 1',
                        'no_telp_siswa' => $candidate['hp_siswa'] ?: '081200000000',
                        'nama_ortu' => $candidate['ortu'] ?: 'Orang Tua Siswa',
                        'no_telp_ortu' => $candidate['hp_ortu'] ?: '081200000000',
                        'biaya_bulanan' => $biaya,
                    ]
                );

                // Petakan ke kelompok
                DB::table('pemetaan_kelompok')->updateOrInsert(
                    ['siswa_id' => $siswa->id, 'kelompok_id' => $kelompok->id],
                    ['created_at' => $now, 'updated_at' => $now]
                );

                // Sesuaikan tagihan SPP
                Pembayaran::firstOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'untuk_bulan' => $currentMonth,
                        'untuk_tahun' => $currentYear,
                    ],
                    [
                        'admin_pencatat_id' => $admin?->id ?? 1,
                        'biaya_dibayar' => $biaya,
                        'metode_bayar' => 'QRIS',
                        'status_bayar' => 'LUNAS',
                        'tanggal_bayar' => $now->toDateString(),
                        'keterangan' => 'Pelunasan SPP awal bulan (QRIS)',
                    ]
                );

                $assignedCount++;
            }
        }
    }

    protected function parseMasterStudents(): array
    {
        $file = database_path('data/PENDATAAN ULANG MURID PELITA ILMU BIMBEL 2026 (Jawaban) (1).xlsx');
        if (!file_exists($file)) {
            $file = 'C:/Users/DELL/Downloads/Kuliah/Projek Bimbel/PENDATAAN ULANG MURID PELITA ILMU BIMBEL 2026 (Jawaban) (1).xlsx';
        }
        if (!file_exists($file)) {
            $file = 'C:/Users/DELL/Downloads/PENDATAAN ULANG MURID PELITA ILMU BIMBEL 2026 (Jawaban).xlsx';
        }

        $zip = new ZipArchive();
        if ($zip->open($file) !== true) return [];

        $ss = [];
        $ssContent = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssContent) {
            $ssXml = simplexml_load_string($ssContent);
            foreach ($ssXml->si as $si) {
                if (isset($si->t)) $ss[] = (string)$si->t;
                elseif (isset($si->r)) {
                    $t = '';
                    foreach ($si->r as $r) $t .= (string)$r->t;
                    $ss[] = $t;
                } else $ss[] = '';
            }
        }

        $wsXml = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
        $zip->close();

        $studentsByClass = [];
        foreach ($wsXml->sheetData->row as $idx => $row) {
            if ($idx == 0) continue;
            $r = [];
            foreach ($row->c as $c) {
                $col = preg_replace('/\d+/', '', (string)$c['r']);
                $val = (string)$c->v;
                $t = (string)$c['t'];
                $text = ($t === 's' && isset($ss[(int)$val])) ? $ss[(int)$val] : $val;
                $r[$col] = $text;
            }

            $nama = trim($r['C'] ?? '');
            if (!$nama || $nama === 'Nama Lengkap Murid') continue;

            $rawKelas = str_replace('.0', '', trim($r['H'] ?? ''));
            $jenjang = trim($r['G'] ?? '');
            $kategori = trim($r['I'] ?? 'Reguler');

            $classKey = $rawKelas;
            if (stripos($jenjang, 'TK') !== false || stripos($rawKelas, 'TK') !== false) {
                $classKey = 'TK';
                $kelasDisplay = 'TK';
            } elseif (stripos($jenjang, 'SD') !== false || is_numeric($rawKelas) && (int)$rawKelas <= 6) {
                $classKey = "{$rawKelas} SD";
                $kelasDisplay = "{$rawKelas} SD";
            } elseif (stripos($jenjang, 'SMP') !== false || is_numeric($rawKelas) && (int)$rawKelas <= 9) {
                $classKey = "{$rawKelas} SMP";
                $kelasDisplay = "{$rawKelas} SMP";
            } else {
                $classKey = "{$rawKelas} SMA";
                $kelasDisplay = "{$rawKelas} SMA";
            }

            $studentsByClass[$classKey][] = [
                'nama' => $nama,
                'panggilan' => trim($r['D'] ?? ''),
                'asal_sekolah' => trim($r['F'] ?? ''),
                'kelas_display' => $kelasDisplay,
                'kategori' => $kategori,
                'hp_siswa' => trim($r['J'] ?? ''),
                'ortu' => trim($r['K'] ?? ''),
                'hp_ortu' => trim($r['L'] ?? ''),
                'alamat' => trim($r['M'] ?? ''),
            ];
        }

        return $studentsByClass;
    }

    protected function parseRombels(): array
    {
        $file = database_path('data/Data Kelompok Siswa All Pelita Ilmu 19092026.xlsx');
        if (!file_exists($file)) {
            $file = 'C:/Users/DELL/Downloads/Kuliah/Projek Bimbel/Data Kelompok Siswa All Pelita Ilmu 19092026.xlsx';
        }
        $zip = new ZipArchive();
        if ($zip->open($file) !== true) return [];

        $ss = [];
        $ssContent = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssContent) {
            $ssXml = simplexml_load_string($ssContent);
            foreach ($ssXml->si as $si) {
                if (isset($si->t)) $ss[] = (string)$si->t;
                elseif (isset($si->r)) {
                    $t = '';
                    foreach ($si->r as $r) $t .= (string)$r->t;
                    $ss[] = $t;
                } else $ss[] = '';
            }
        }

        $wsXml = simplexml_load_string($zip->getFromName('xl/worksheets/sheet2.xml'));
        $zip->close();

        $rombelList = [];
        $hariPool = ['Senin & Rabu', 'Selasa & Kamis', 'Rabu & Jumat', 'Senin & Kamis', 'Selasa & Jumat'];
        $jamPool = [
            ['15:30:00', '17:00:00'],
            ['16:00:00', '17:30:00'],
            ['17:00:00', '18:30:00'],
        ];

        $i = 0;
        foreach ($wsXml->sheetData->row as $row) {
            $r = [];
            foreach ($row->c as $c) {
                $col = preg_replace('/\d+/', '', (string)$c['r']);
                $val = (string)$c->v;
                $t = (string)$c['t'];
                $text = ($t === 's' && isset($ss[(int)$val])) ? $ss[(int)$val] : $val;
                $r[$col] = $text;
            }

            $rombel = trim($r['B'] ?? '');
            if (!$rombel || $rombel === 'ROMBEL') continue;

            // Tentukan jenjang, kelas, dan mapel dari nama rombel
            $jenjang = 'SD';
            $kelas = '1 SD';
            $mapel = 'Tematik SD';
            $biaya = 150000;

            if (stripos($rombel, 'TK') !== false) {
                $jenjang = 'TK';
                $kelas = 'TK';
                $mapel = 'Calistung & Tematik TK';
                $biaya = 150000;
            } elseif (preg_match('/KELAS\s*(\d)/i', $rombel, $m)) {
                $num = (int)$m[1];
                if ($num <= 6) {
                    $jenjang = 'SD';
                    $kelas = "{$num} SD";
                    $mapel = ($num >= 4) ? 'Matematika SD' : 'Tematik SD';
                    $biaya = 150000;
                } elseif ($num <= 9) {
                    $jenjang = 'SMP';
                    $kelas = "{$num} SMP";
                    $biaya = 190000;
                    if (stripos($rombel, 'IPA') !== false) $mapel = 'IPA SMP';
                    elseif (stripos($rombel, 'ING') !== false) $mapel = 'Bahasa Inggris SMP';
                    elseif (stripos($rombel, 'IPS') !== false) $mapel = 'IPS SMP';
                    else $mapel = 'Matematika SMP';
                } else {
                    $jenjang = 'SMA';
                    $kelas = "{$num} SMA";
                    $biaya = 230000;
                    if (stripos($rombel, 'FISIKA') !== false) $mapel = 'Fisika SMA';
                    elseif (stripos($rombel, 'KIM') !== false) $mapel = 'Kimia SMA';
                    elseif (stripos($rombel, 'BIO') !== false) $mapel = 'Biologi SMA';
                    elseif (stripos($rombel, 'EKO') !== false) $mapel = 'Ekonomi & Soshum SMA';
                    elseif (stripos($rombel, 'UTBK') !== false) {
                        $mapel = 'SNBT / UTBK Intensif';
                        $biaya = 290000;
                    } else $mapel = 'Matematika SMA';
                }
            } elseif (stripos($rombel, 'SMK') !== false) {
                $jenjang = 'SMA';
                $kelas = '11 SMA';
                $mapel = 'Bahasa Inggris SMA';
                $biaya = 230000;
            } elseif (stripos($rombel, 'UTBK') !== false || stripos($rombel, 'TKA') !== false) {
                $jenjang = 'SMA';
                $kelas = '12 SMA';
                $mapel = 'SNBT / UTBK Intensif';
                $biaya = 290000;
            }

            $slotHari = $hariPool[$i % count($hariPool)];
            $slotJam = $jamPool[$i % count($jamPool)];

            $rombelList[] = [
                'nama' => $rombel,
                'jenjang' => $jenjang,
                'kelas' => $kelas,
                'mapel' => $mapel,
                'biaya' => $biaya,
                'hari' => $slotHari,
                'jam_mulai' => $slotJam[0],
                'jam_selesai' => $slotJam[1],
            ];
            $i++;
        }

        return $rombelList;
    }
}
