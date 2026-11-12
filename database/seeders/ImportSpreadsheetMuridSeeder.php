<?php

namespace Database\Seeders;

use App\Models\Kelompok;
use App\Models\MataPelajaran;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class ImportSpreadsheetMuridSeeder extends Seeder
{
    public function run(): void
    {
        $xlsxPath = base_path('data_murid.xlsx');
        if (!file_exists($xlsxPath)) {
            $downloadPath = 'C:/Users/DELL/Downloads/PENDATAAN ULANG MURID PELITA ILMU BIMBEL 2026 (Jawaban).xlsx';
            $storagePath = storage_path('app/data_murid.xlsx');
            if (file_exists($storagePath)) {
                $xlsxPath = $storagePath;
            } elseif (file_exists($downloadPath)) {
                copy($downloadPath, $xlsxPath);
            } else {
                $this->command->error("File data_murid.xlsx tidak ditemukan!");
                return;
            }
        }

        // 1. Ekstrak data dari file XLSX
        $students = $this->parseXlsx($xlsxPath);

        // 2. Siapkan Mata Pelajaran
        $mapelMap = $this->seedMataPelajaran();

        // 3. Siapkan Tentor
        $tentor1 = User::where('role', 'TENTOR')->first() ?? User::first();
        $tentor2 = User::where('role', 'TENTOR')->skip(1)->first() ?? $tentor1;
        $admin = User::where('role', 'ADMIN')->first() ?? User::first();

        // 4. Definisi Kelompok & Tarif per Program
        $groupDefinitions = [
            'TK' => [
                'nama' => 'Kelompok TK - Calistung & Motorik',
                'mapel' => 'Calistung & Tematik TK',
                'jenjang_mapel' => 'TK',
                'kelas_label' => 'TK',
                'kategori' => 'Reguler',
                'biaya' => 150000,
                'mapels' => ['Calistung', 'Membaca', 'Berhitung'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Senin & Rabu',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:00:00',
            ],
            'Kelas 1 SD' => [
                'nama' => 'Kelompok Kelas 1 SD - Tematik Terpadu',
                'mapel' => 'Tematik SD',
                'jenjang_mapel' => 'SD',
                'kelas_label' => '1 SD',
                'kategori' => 'Reguler',
                'biaya' => 150000,
                'mapels' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Senin & Rabu',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:00:00',
            ],
            'Kelas 2 SD' => [
                'nama' => 'Kelompok Kelas 2 SD - Tematik Terpadu',
                'mapel' => 'Tematik SD',
                'jenjang_mapel' => 'SD',
                'kelas_label' => '2 SD',
                'kategori' => 'Reguler',
                'biaya' => 150000,
                'mapels' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                'tentor_id' => $tentor2?->id,
                'hari' => 'Selasa & Kamis',
                'jam_mulai' => '15:30:00',
                'jam_selesai' => '17:00:00',
            ],
            'Kelas 3 SD' => [
                'nama' => 'Kelompok Kelas 3 SD - Matematika & Tematik',
                'mapel' => 'Tematik SD',
                'jenjang_mapel' => 'SD',
                'kelas_label' => '3 SD',
                'kategori' => 'Reguler',
                'biaya' => 150000,
                'mapels' => ['Matematika', 'Bahasa Indonesia', 'IPA'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Senin & Rabu',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
            ],
            'Kelas 4 SD' => [
                'nama' => 'Kelompok Kelas 4 SD - Matematika & IPA',
                'mapel' => 'Matematika SD',
                'jenjang_mapel' => 'SD',
                'kelas_label' => '4 SD',
                'kategori' => 'Reguler',
                'biaya' => 150000,
                'mapels' => ['Matematika', 'IPA', 'Bahasa Inggris'],
                'tentor_id' => $tentor2?->id,
                'hari' => 'Selasa & Kamis',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
            ],
            'Kelas 5 SD' => [
                'nama' => 'Kelompok Kelas 5 SD - Matematika & IPA',
                'mapel' => 'Matematika SD',
                'jenjang_mapel' => 'SD',
                'kelas_label' => '5 SD',
                'kategori' => 'Reguler',
                'biaya' => 150000,
                'mapels' => ['Matematika', 'IPA', 'Bahasa Inggris'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Rabu & Jumat',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
            ],
            'Kelas 6 SD' => [
                'nama' => 'Kelompok Kelas 6 SD - Sukses Ujian Sekolah',
                'mapel' => 'Matematika SD',
                'jenjang_mapel' => 'SD',
                'kelas_label' => '6 SD',
                'kategori' => 'Reguler',
                'biaya' => 195000,
                'mapels' => ['Matematika', 'IPA', 'Bahasa Indonesia'],
                'tentor_id' => $tentor2?->id,
                'hari' => 'Senin & Kamis',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
            ],
            'Kelas 7 SMP' => [
                'nama' => 'Kelompok Kelas 7 SMP - Matematika & IPA',
                'mapel' => 'Matematika SMP',
                'jenjang_mapel' => 'SMP',
                'kelas_label' => '7 SMP',
                'kategori' => 'Reguler',
                'biaya' => 140000,
                'mapels' => ['Matematika', 'IPA Fisika', 'Bahasa Inggris'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Selasa & Jumat',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '17:30:00',
            ],
            'Kelas 8 SMP' => [
                'nama' => 'Kelompok Kelas 8 SMP - Matematika & IPA',
                'mapel' => 'Matematika SMP',
                'jenjang_mapel' => 'SMP',
                'kelas_label' => '8 SMP',
                'kategori' => 'Reguler',
                'biaya' => 190000,
                'mapels' => ['Matematika', 'IPA Fisika', 'Bahasa Inggris'],
                'tentor_id' => $tentor2?->id,
                'hari' => 'Senin & Rabu',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
            ],
            'Kelas 9 SMP' => [
                'nama' => 'Kelompok Kelas 9 SMP - Sukses ASPD & Ujian Akhir',
                'mapel' => 'IPA SMP',
                'jenjang_mapel' => 'SMP',
                'kelas_label' => '9 SMP',
                'kategori' => 'Reguler',
                'biaya' => 190000,
                'mapels' => ['Matematika', 'IPA Biologi/Fisika', 'Bahasa Inggris'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Selasa & Kamis',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
            ],
            'Kelas 10 SMA' => [
                'nama' => 'Kelompok Kelas 10 SMA - Matematika & Sains',
                'mapel' => 'Matematika SMA',
                'jenjang_mapel' => 'SMA',
                'kelas_label' => '10 SMA',
                'kategori' => 'Reguler',
                'biaya' => 200000,
                'mapels' => ['Matematika Wajib', 'Fisika', 'Kimia'],
                'tentor_id' => $tentor2?->id,
                'hari' => 'Senin & Rabu',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
            ],
            'Kelas 11 SMA' => [
                'nama' => 'Kelompok Kelas 11 SMA - MIPA Unggulan',
                'mapel' => 'Kimia SMA',
                'jenjang_mapel' => 'SMA',
                'kelas_label' => '11 SMA',
                'kategori' => 'Reguler',
                'biaya' => 230000,
                'mapels' => ['Matematika Tingkat Lanjut', 'Kimia', 'Fisika'],
                'tentor_id' => $tentor1?->id,
                'hari' => 'Selasa & Jumat',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '18:30:00',
            ],
            'Kelas 12 SMA' => [
                'nama' => 'Kelompok Kelas 12 SMA - Sukses SNBT & UTBK',
                'mapel' => 'SNBT / UTBK Intensif',
                'jenjang_mapel' => 'SMA',
                'kelas_label' => '12 SMA',
                'kategori' => 'Reguler',
                'biaya' => 290000,
                'mapels' => ['Penalaran Matematika', 'Literasi B. Indonesia', 'Pengetahuan Kuantitatif'],
                'tentor_id' => $tentor2?->id,
                'hari' => 'Senin & Kamis',
                'jam_mulai' => '18:30:00',
                'jam_selesai' => '20:00:00',
            ],
        ];

        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        foreach ($groupDefinitions as $groupKey => $def) {
            // A. Buat atau perbarui Kelompok
            $mapelId = $mapelMap[$def['mapel']] ?? 1;
            $kelompok = Kelompok::updateOrCreate(
                ['nama_kelompok' => $def['nama']],
                [
                    'mapel_id' => $mapelId,
                    'tentor_id' => $def['tentor_id'],
                    'jadwal_hari' => $def['hari'],
                    'jam_mulai' => $def['jam_mulai'],
                    'jam_selesai' => $def['jam_selesai'],
                ]
            );

            // B. Ambil 2 siswa dari spreadsheet untuk kelompok ini
            $candidates = $students[$groupKey] ?? [];
            $selected = array_slice($candidates, 0, 2);

            foreach ($selected as $sData) {
                // Buat atau perbarui record Siswa
                $siswa = Siswa::updateOrCreate(
                    [
                        'nama_lengkap' => $sData['nama'],
                    ],
                    [
                        'asal_sekolah' => $sData['sekolah'] ?: 'Pelita Ilmu',
                        'kelas' => $def['kelas_label'],
                        'kategori_kelas' => $def['kategori'],
                        'pilihan_mapel' => $def['mapels'],
                        'tipe_belajar' => 'KELOMPOK',
                        'tipe_jatuh_tempo' => 'AWAL BULAN',
                        'status_siswa' => 'AKTIF',
                        'tanggal_daftar' => $sData['tgl_daftar'] ?? $now->toDateString(),
                        'tanggal_lahir' => $sData['tgl_lahir'],
                        'alamat_rumah' => $sData['alamat'],
                        'no_telp_siswa' => $sData['hp_siswa'],
                        'nama_ortu' => $sData['ortu'],
                        'no_telp_ortu' => $sData['hp_ortu'],
                        'biaya_bulanan' => $def['biaya'],
                    ]
                );

                // Hubungkan Siswa ke Kelompok (pemetaan_kelompok)
                DB::table('pemetaan_kelompok')->updateOrInsert(
                    [
                        'siswa_id' => $siswa->id,
                        'kelompok_id' => $kelompok->id,
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Sesuaikan Tagihan / Pembayaran berdasarkan program & biaya
                Pembayaran::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'untuk_bulan' => $currentMonth,
                        'untuk_tahun' => $currentYear,
                    ],
                    [
                        'admin_pencatat_id' => $admin?->id ?? 1,
                        'biaya_dibayar' => $def['biaya'],
                        'metode_bayar' => 'QRIS',
                        'status_bayar' => 'LUNAS',
                        'tanggal_bayar' => $now->toDateString(),
                    ]
                );
            }
        }
    }

    protected function seedMataPelajaran(): array
    {
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

        $mapelIds = [];
        foreach ($mapels as $nama) {
            $m = MataPelajaran::firstOrCreate(
                ['nama_mapel' => $nama]
            );
            $mapelIds[$nama] = $m->id;
        }

        return $mapelIds;
    }

    protected function parseXlsx(string $filePath): array
    {
        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return [];
        }

        $ss = [];
        $ssContent = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssContent) {
            $ssXml = simplexml_load_string($ssContent);
            foreach ($ssXml->si as $si) {
                if (isset($si->t)) {
                    $ss[] = (string) $si->t;
                } elseif (isset($si->r)) {
                    $t = '';
                    foreach ($si->r as $r) {
                        $t .= (string) $r->t;
                    }
                    $ss[] = $t;
                } else {
                    $ss[] = '';
                }
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
                $t = (string) $c['t'];
                $v = (string) $c->v;
                $val = ($t === 's' && isset($ss[(int)$v])) ? $ss[(int)$v] : $v;
                $r[$col] = $val;
            }

            $jenjang = trim($r['G'] ?? '');
            $rawKelas = trim($r['H'] ?? '');
            $nama = trim($r['C'] ?? '');
            if (!$nama || $nama === 'Nama Lengkap Murid') continue;

            $cleanKelas = str_replace('.0', '', $rawKelas);

            // Klasifikasi group
            if (stripos($jenjang, 'TK') !== false || stripos($cleanKelas, 'TK') !== false) {
                $groupKey = 'TK';
            } elseif (stripos($jenjang, 'SD') !== false || $cleanKelas === '6' && stripos($r['F'] ?? '', 'MI') !== false) {
                $groupKey = "Kelas {$cleanKelas} SD";
            } elseif (stripos($jenjang, 'SMP') !== false) {
                $groupKey = "Kelas {$cleanKelas} SMP";
            } elseif (stripos($jenjang, 'SMA') !== false) {
                $groupKey = "Kelas {$cleanKelas} SMA";
            } else {
                $groupKey = "Kelas {$cleanKelas} SD";
            }

            $tglLahir = null;
            if (!empty($r['E']) && is_numeric($r['E'])) {
                $tglLahir = gmdate('Y-m-d', (int)(($r['E'] - 25569) * 86400));
            }

            $tglDaftar = null;
            if (!empty($r['A']) && is_numeric($r['A'])) {
                $tglDaftar = gmdate('Y-m-d', (int)(($r['A'] - 25569) * 86400));
            }

            $studentsByClass[$groupKey][] = [
                'uid' => $r['B'] ?? '',
                'nama' => $nama,
                'panggilan' => $r['D'] ?? '',
                'tgl_lahir' => $tglLahir,
                'tgl_daftar' => $tglDaftar,
                'sekolah' => $r['F'] ?? '',
                'jenjang' => $jenjang,
                'kategori' => $r['I'] ?? 'Regular',
                'hp_siswa' => $r['J'] ?? '',
                'ortu' => $r['K'] ?? '',
                'hp_ortu' => $r['L'] ?? '',
                'alamat' => $r['M'] ?? '',
            ];
        }

        return $studentsByClass;
    }
}
