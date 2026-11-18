<?php

namespace App\Filament\GlobalSearch;

use App\Models\Kelompok;
use App\Models\MataPelajaran;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Ruangan;
use App\Models\Siswa;
use Filament\GlobalSearch\GlobalSearchResult;
use Filament\GlobalSearch\GlobalSearchResults;
use Filament\GlobalSearch\Providers\Contracts\GlobalSearchProvider;
use Illuminate\Support\Str;

class ComprehensiveGlobalSearchProvider implements GlobalSearchProvider
{
    public function getResults(string $query): ?GlobalSearchResults
    {
        $query = trim($query);
        if ($query === '' || strlen($query) < 2) {
            return null;
        }

        $builder = GlobalSearchResults::make();
        $lowerQuery = mb_strtolower($query);

        // ==========================================
        // 1. FITUR, HALAMAN & MENU NAVIGASI (DINAMIS)
        // ==========================================
        $features = [
            [
                'title' => 'Dashboard Utama',
                'description' => 'Ringkasan statistik bimbel, murid aktif, keuangan, dan grafik jadwal.',
                'keywords' => 'dashboard beranda home statistik murid siswa keuangan grafik ringkasan',
                'url' => route('filament.admin.pages.dashboard'),
            ],
            [
                'title' => 'Data Siswa',
                'description' => 'Daftar murid aktif, belum mulai, nonaktif, serta riwayat kelompok yang diikuti.',
                'keywords' => 'siswa murid anak peserta didik data siswa direktori status aktif nonaktif',
                'url' => route('filament.admin.resources.siswas.index'),
            ],
            [
                'title' => 'Tambah Siswa Baru',
                'description' => 'Formulir input data siswa baru secara manual.',
                'keywords' => 'tambah siswa buat siswa murid baru registrasi manual tambah murid',
                'url' => route('filament.admin.resources.siswas.create'),
            ],
            [
                'title' => 'Pendaftaran Online',
                'description' => 'Verifikasi calon siswa baru, nota ringkasan pendaftaran kaos/reguler, dan penempatan kelompok.',
                'keywords' => 'pendaftaran online pendaftar baru calon siswa registrasi formulir masuk tinjau verifikasi',
                'url' => route('filament.admin.resources.pendaftarans.index'),
            ],
            [
                'title' => 'Jadwal & Presensi Belajar',
                'description' => 'Manajemen sesi pertemuan kelas, jadwal mengajar tentor, dan pencatatan absensi siswa.',
                'keywords' => 'jadwal presensi sesi pertemuan absensi absen kelas mengajar hari jam tanggal',
                'url' => route('filament.admin.resources.jadwal-kelompoks.index'),
            ],
            [
                'title' => 'Tambah Jadwal Sesi Baru',
                'description' => 'Buat jadwal pertemuan atau sesi bimbingan baru dengan pemilihan ruang kelas.',
                'keywords' => 'tambah jadwal buat sesi baru buat jadwal sesi pertemuan buat pertemuan',
                'url' => route('filament.admin.resources.jadwal-kelompoks.create'),
            ],
            [
                'title' => 'Kelompok Belajar (Rombel)',
                'description' => 'Kelola rombel kelompok belajar siswa, pembagian tentor pengampu, dan kuota murid.',
                'keywords' => 'kelompok belajar rombel kelas grup rombongan belajar tentor pengampu kuota',
                'url' => route('filament.admin.resources.kelompoks.index'),
            ],
            [
                'title' => 'Tambah Kelompok Belajar',
                'description' => 'Buat rombongan belajar / kelompok siswa baru.',
                'keywords' => 'tambah kelompok buat kelompok rombel baru buat rombel',
                'url' => route('filament.admin.resources.kelompoks.create'),
            ],
            [
                'title' => 'Mata Pelajaran',
                'description' => 'Master mata pelajaran standar per jenjang (TK, SD, SMP, SMA) dan relasi kelompok belajarnya.',
                'keywords' => 'mata pelajaran mapel kurikulum bidang studi fisika kimia biologi matematika inggris',
                'url' => route('filament.admin.resources.mata-pelajarans.index'),
            ],
            [
                'title' => 'Rekap Pembayaran & SPP',
                'description' => 'Laporan keuangan pemasukan bimbel per metode (Tunai, Transfer, QRIS), tagihan siswa, dan cetak kuitansi.',
                'keywords' => 'pembayaran spp keuangan uang kas pemasukan transfer tunai qris tagihan tunggakan lunas rekap pendapatan',
                'url' => route('filament.admin.resources.pembayarans.index'),
            ],
            [
                'title' => 'Catat Pembayaran Baru',
                'description' => 'Input pelunasan SPP atau transaksi pembayaran siswa baru.',
                'keywords' => 'catat pembayaran bayar spp bayar tagihan kuitansi input pembayaran transaksi',
                'url' => route('filament.admin.resources.pembayarans.create'),
            ],
            [
                'title' => 'Ruang Kelas',
                'description' => 'Daftar fasilitas ruangan bimbel (AC, Proyektor, Meja Privat) dan kapasitas daya tampung.',
                'keywords' => 'ruangan ruang kelas fasilitas kapasitas ac meja whiteboard',
                'url' => route('filament.admin.resources.ruangans.index'),
            ],
            [
                'title' => 'Rekap Presensi Matrix',
                'description' => 'Tabel matriks absensi kehadiran siswa per jenjang dan kelompok belajar.',
                'keywords' => 'rekap presensi matrix laporan absensi kehadiran murid rekap absen export excel',
                'url' => route('filament.admin.pages.rekap-presensi-matrix'),
            ],
        ];

        $matchedFeatures = [];
        foreach ($features as $f) {
            $searchableText = mb_strtolower("{$f['title']} {$f['description']} {$f['keywords']}");
            if (Str::contains($searchableText, $lowerQuery) || Str::is("*{$lowerQuery}*", $searchableText)) {
                $matchedFeatures[] = new GlobalSearchResult(
                    title: $f['title'],
                    url: $f['url'],
                    details: [
                        'Keterangan' => $f['description'],
                    ]
                );
            }
        }

        if (!empty($matchedFeatures)) {
            $builder->category('Menu, Halaman & Fitur', collect($matchedFeatures));
        }

        // ==========================================
        // 2. DATA SISWA AKTIF & TERDAFTAR
        // ==========================================
        $siswas = Siswa::query()
            ->where(function ($q) use ($lowerQuery) {
                $q->whereRaw('LOWER(nama_lengkap) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhereRaw('LOWER(asal_sekolah) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhereRaw('LOWER(kelas) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhere('no_telp_siswa', 'LIKE', "%{$lowerQuery}%")
                  ->orWhere('no_telp_ortu', 'LIKE', "%{$lowerQuery}%");
            })
            ->limit(5)
            ->get();

        if ($siswas->isNotEmpty()) {
            $siswaResults = $siswas->map(fn (Siswa $s) => new GlobalSearchResult(
                title: "{$s->nama_lengkap} ({$s->kelas})",
                url: route('filament.admin.resources.siswas.edit', ['record' => $s->id]),
                details: [
                    'Status' => $s->status_siswa ?? 'AKTIF',
                    'Sekolah' => $s->asal_sekolah ?: '-',
                    'Kontak' => $s->no_telp_siswa ?: $s->no_telp_ortu ?: '-',
                ]
            ));
            $builder->category('Data Siswa', $siswaResults);
        }

        // ==========================================
        // 3. KELOMPOK BELAJAR (ROMBEL)
        // ==========================================
        $kelompoks = Kelompok::query()
            ->with(['mapel', 'tentor'])
            ->where(function ($q) use ($lowerQuery) {
                $q->whereRaw('LOWER(nama_kelompok) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhereRaw('LOWER(jadwal_hari) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhereHas('mapel', fn ($mq) => $mq->whereRaw('LOWER(nama_mapel) LIKE ?', ["%{$lowerQuery}%"]))
                  ->orWhereHas('tentor', fn ($tq) => $tq->whereRaw('LOWER(name) LIKE ?', ["%{$lowerQuery}%"]));
            })
            ->limit(5)
            ->get();

        if ($kelompoks->isNotEmpty()) {
            $kelompokResults = $kelompoks->map(fn (Kelompok $k) => new GlobalSearchResult(
                title: "{$k->nama_kelompok} [{$k->mapel?->nama_mapel}]",
                url: route('filament.admin.resources.kelompoks.edit', ['record' => $k->id]),
                details: [
                    'Jenjang' => $k->jenjang ?? '-',
                    'Tentor' => $k->tentor?->name ?? 'Belum ada',
                    'Jadwal' => $k->jadwal_hari ?: '-',
                ]
            ));
            $builder->category('Kelompok Belajar', $kelompokResults);
        }

        // ==========================================
        // 4. PENDAFTARAN ONLINE (CALON SISWA)
        // ==========================================
        $pendaftarans = Pendaftaran::query()
            ->where(function ($q) use ($lowerQuery) {
                $q->whereRaw('LOWER(nama_lengkap) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhereRaw('LOWER(asal_sekolah) LIKE ?', ["%{$lowerQuery}%"])
                  ->orWhere('nomor_wa', 'LIKE', "%{$lowerQuery}%")
                  ->orWhere('no_telp_ortu', 'LIKE', "%{$lowerQuery}%");
            })
            ->limit(4)
            ->get();

        if ($pendaftarans->isNotEmpty()) {
            $pendaftaranResults = $pendaftarans->map(fn (Pendaftaran $p) => new GlobalSearchResult(
                title: "Calon: {$p->nama_lengkap} ({$p->kelas})",
                url: route('filament.admin.resources.pendaftarans.index'),
                details: [
                    'Status' => $p->status_tindak_lanjut ?? 'BARU',
                    'Paket' => $p->paket_pendaftaran ?: 'Pendaftaran',
                    'WhatsApp' => $p->nomor_wa ?: '-',
                ]
            ));
            $builder->category('Calon Siswa / Pendaftar', $pendaftaranResults);
        }

        return $builder;
    }
}
