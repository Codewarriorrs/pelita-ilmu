<?php

namespace App\Filament\Pages;

use App\Models\DetailPresensi;
use App\Models\JadwalKelompok;
use App\Models\Kelompok;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapPresensiMatrix extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-table-cells';
    protected static \UnitEnum|string|null $navigationGroup = 'Presensi';
    protected static ?string $title = 'Rekap Presensi Bulanan (Matrix Format)';
    protected static ?string $navigationLabel = 'Rekap Presensi';
    protected string $view = 'filament.pages.rekap-presensi-matrix';

    public int $bulan;
    public int $tahun;
    public ?string $jenjang = 'ALL';
    public ?int $kelompokId = null;
    public string $searchSiswa = '';

    public array $jenjangOptions = [
        'ALL'  => 'Semua Jenjang',
        'TK'   => 'TK / PAUD',
        'SD'   => 'SD (Kelas 1–6)',
        'SMP'  => 'SMP (Kelas 7–9)',
        'SMA'  => 'SMA / SMK (Kelas 10–12)',
        'UTBK' => 'Intensif UTBK / SNBT',
    ];

    public static function canAccess(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return $user && ($user->isAdmin() || $user->isTentor());
    }

    public function mount(): void
    {
        $this->bulan = (int) date('m');
        $this->tahun = (int) date('Y');
    }

    public function updatedJenjang(): void
    {
        $this->kelompokId = null;
    }

    protected function filterKelompokByJenjang(Builder $query, string $jenjang): void
    {
        if ($jenjang === 'TK') {
            $query->where(function ($q) {
                $q->where('nama_kelompok', 'ILIKE', '%TK%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%PAUD%');
            });
        } elseif ($jenjang === 'SD') {
            $query->where('nama_kelompok', 'ILIKE', '%SD%');
        } elseif ($jenjang === 'SMP') {
            $query->where('nama_kelompok', 'ILIKE', '%SMP%');
        } elseif ($jenjang === 'SMA') {
            $query->where(function ($q) {
                $q->where('nama_kelompok', 'ILIKE', '%SMA%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%SMK%');
            });
        } elseif ($jenjang === 'UTBK') {
            $query->where(function ($q) {
                $q->where('nama_kelompok', 'ILIKE', '%UTBK%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%SNBT%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%TPA%');
            });
        }
    }

    protected function filterSiswaByJenjang(Builder $query, string $jenjang): void
    {
        $query->where(function ($q) use ($jenjang) {
            if ($jenjang === 'TK') {
                $q->where('kelas', 'ILIKE', '%TK%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%TK%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%PAUD%');
            } elseif ($jenjang === 'SD') {
                $q->where('kelas', 'ILIKE', '%SD%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%SD%');
            } elseif ($jenjang === 'SMP') {
                $q->where('kelas', 'ILIKE', '%SMP%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%SMP%');
            } elseif ($jenjang === 'SMA') {
                $q->where('kelas', 'ILIKE', '%SMA%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%SMA%')
                  ->orWhere('kelas', 'ILIKE', '%SMK%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%SMK%');
            } elseif ($jenjang === 'UTBK') {
                $q->where('kelas', 'ILIKE', '%UTBK%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%UTBK%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%SNBT%')
                  ->orWhere('kategori_kelas', 'ILIKE', '%TPA%');
            }

            $q->orWhereHas('kelompok', function ($kq) use ($jenjang) {
                $this->filterKelompokByJenjang($kq, $jenjang);
            });
        });
    }

    public function getMatrixData(): array
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;

        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $isTentor = $user && $user->isTentor();

        // 1. Dropdown kelompoks (dependent pada Jenjang dan hak akses Tentor)
        $allKelompoksQuery = Kelompok::query();
        if ($isTentor) {
            $allKelompoksQuery->where('tentor_id', $user->id);
        }
        if ($this->jenjang && $this->jenjang !== 'ALL') {
            $this->filterKelompokByJenjang($allKelompoksQuery, $this->jenjang);
        }
        $allKelompoks = $allKelompoksQuery->orderBy('nama_kelompok')->get();

        // Validasi jika kelompokId terpilih bukan anggota kelompok yang tersedia
        if ($this->kelompokId && !$allKelompoks->pluck('id')->contains($this->kelompokId)) {
            $this->kelompokId = null;
        }

        // 2. Fetch kelompoks untuk matriks kolom
        $kelompokQuery = Kelompok::with('mapel');
        if ($isTentor) {
            $kelompokQuery->where('tentor_id', $user->id);
        }
        if ($this->kelompokId) {
            $kelompokQuery->where('id', $this->kelompokId);
        } elseif ($this->jenjang && $this->jenjang !== 'ALL') {
            $this->filterKelompokByJenjang($kelompokQuery, $this->jenjang);
        }
        $kelompoks = $kelompokQuery->get();

        // Unique mapels or kelompoks to form the matrix columns
        $mapelList = [];
        foreach ($kelompoks as $k) {
            $mapelName = $k->mapel->nama_mapel ?? $k->nama_kelompok;
            if (!isset($mapelList[$k->mapel_id])) {
                $mapelList[$k->mapel_id] = [
                    'id' => $k->mapel_id,
                    'nama' => $mapelName,
                    'kelompok_id' => $k->id,
                ];
            }
        }

        // Fallback: if no mapels in kelompoks (hanya untuk Admin bila belum ada filter)
        if (empty($mapelList) && !$isTentor && ($this->jenjang === 'ALL' || empty($this->jenjang))) {
            $allMapels = MataPelajaran::all();
            foreach ($allMapels as $m) {
                $mapelList[$m->id] = [
                    'id' => $m->id,
                    'nama' => $m->nama_mapel,
                    'kelompok_id' => null,
                ];
            }
        }

        // 3. Fetch sessions (JadwalKelompok) in selected month & year
        $jadwalQuery = JadwalKelompok::with('kelompok')
            ->whereRaw('EXTRACT(MONTH FROM tanggal_sesi) = ?', [$bulan])
            ->whereRaw('EXTRACT(YEAR FROM tanggal_sesi) = ?', [$tahun]);

        if ($isTentor) {
            $jadwalQuery->whereHas('kelompok', function ($q) use ($user) {
                $q->where('tentor_id', $user->id);
            });
        }

        if ($this->kelompokId) {
            $jadwalQuery->where('kelompok_id', $this->kelompokId);
        } elseif ($this->jenjang && $this->jenjang !== 'ALL') {
            $jadwalQuery->whereHas('kelompok', function ($q) {
                $this->filterKelompokByJenjang($q, $this->jenjang);
            });
        }

        $jadwals = $jadwalQuery->orderBy('tanggal_sesi', 'asc')->get();

        // Group sessions by mapel_id (up to 4 sessions per mapel)
        $sessionsByMapel = [];
        foreach ($mapelList as $mapelId => $mInfo) {
            $sessionsByMapel[$mapelId] = [];
        }

        foreach ($jadwals as $j) {
            $mapelId = $j->kelompok->mapel_id ?? null;
            if ($mapelId && isset($sessionsByMapel[$mapelId])) {
                if (count($sessionsByMapel[$mapelId]) < 4) {
                    $sessionsByMapel[$mapelId][] = $j;
                }
            }
        }

        // 4. Fetch active students only
        $siswaQuery = Siswa::query()->where('status_siswa', 'AKTIF');

        if ($isTentor) {
            $siswaQuery->whereHas('kelompok', function ($q) use ($user) {
                $q->where('tentor_id', $user->id);
            });
        }

        if ($this->kelompokId) {
            $siswaQuery->whereHas('kelompok', function ($q) {
                $q->where('kelompok.id', $this->kelompokId);
            });
        } elseif ($this->jenjang && $this->jenjang !== 'ALL') {
            $this->filterSiswaByJenjang($siswaQuery, $this->jenjang);
        }

        if (!empty(trim($this->searchSiswa))) {
            $siswaQuery->where('nama_lengkap', 'ILIKE', '%' . trim($this->searchSiswa) . '%');
        }
        $siswas = $siswaQuery->orderBy('nama_lengkap', 'asc')->get();

        // 5. Get all DetailPresensi for fetched jadwals
        $allJadwalIds = $jadwals->pluck('id')->toArray();
        $presensis = [];
        if (!empty($allJadwalIds)) {
            $dpRecords = DetailPresensi::whereIn('jadwal_id', $allJadwalIds)->get();
            foreach ($dpRecords as $dp) {
                $presensis[$dp->siswa_id][$dp->jadwal_id] = $dp->status_kehadiran;
            }
        }

        return [
            'mapelList' => $mapelList,
            'sessionsByMapel' => $sessionsByMapel,
            'siswas' => $siswas,
            'presensis' => $presensis,
            'allKelompoks' => $allKelompoks,
        ];
    }

    public function exportExcel(): StreamedResponse
    {
        $matrix = $this->getMatrixData();
        $bulanNama = Carbon::createFromDate($this->tahun, $this->bulan, 1)->translatedFormat('F Y');

        $filename = "Rekap_Presensi_" . str_replace(' ', '_', $bulanNama) . ".xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($matrix, $bulanNama) {
            echo '<html><head><meta charset="UTF-8"><style>';
            echo 'table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 11px; }';
            echo 'th, td { border: 1px solid #cbd5e1; padding: 6px; text-align: center; }';
            echo 'th { background: #193836; color: #ffffff; }';
            echo '.th-sub { background: #0f766e; color: #ffffff; font-size: 10px; }';
            echo '.th-rekap { background: #fef08a; color: #713f12; font-weight: bold; }';
            echo '.text-left { text-align: left; }';
            echo '.hadir { background: #16a34a; color: #ffffff; font-weight: bold; }';
            echo '.sakit { background: #d97706; color: #ffffff; font-weight: bold; }';
            echo '.izin  { background: #2563eb; color: #ffffff; font-weight: bold; }';
            echo '.alpa  { background: #dc2626; color: #ffffff; font-weight: bold; }';
            echo '.rekap-cell { font-weight: bold; font-size: 12px; }';
            echo '</style></head><body>';
            
            echo '<table border="1">';
            
            // Header Row 1: Title, Mapels, and Rekapitulasi
            echo '<tr>';
            echo '<th rowspan="2" style="width: 35px;">NO</th>';
            echo '<th rowspan="2" style="width: 180px; text-align:left;">NAMA SISWA</th>';
            echo '<th rowspan="2" style="width: 85px;">KELAS</th>';
            
            foreach ($matrix['mapelList'] as $m) {
                echo '<th colspan="4" class="th-sub">' . htmlspecialchars(strtoupper($m['nama'])) . '</th>';
            }
            
            echo '<th colspan="4" class="th-rekap">REKAPITULASI (' . strtoupper($bulanNama) . ')</th>';
            echo '</tr>';

            // Header Row 2: Pertemuan 1..4 per Mapel, and H/I/S/A
            echo '<tr>';
            foreach ($matrix['mapelList'] as $mId => $m) {
                $sessions = $matrix['sessionsByMapel'][$mId] ?? [];
                for ($p = 0; $p < 4; $p++) {
                    $jadwal = $sessions[$p] ?? null;
                    $tglLabel = $jadwal ? Carbon::parse($jadwal->tanggal_sesi)->format('d/m') : '';
                    echo '<th style="background:#f1f5f9; color:#334155; font-size:10px; width:55px;">P' . ($p + 1) . ($tglLabel ? '<br><span style="font-weight:normal; font-size:9px;">' . $tglLabel . '</span>' : '') . '</th>';
                }
            }
            
            echo '<th style="background:#dcfce7; color:#15803d; width:40px;">H</th>';
            echo '<th style="background:#dbeafe; color:#1d4ed8; width:40px;">I</th>';
            echo '<th style="background:#fef3c7; color:#b45309; width:40px;">S</th>';
            echo '<th style="background:#fee2e2; color:#b91c1c; width:40px;">A</th>';
            echo '</tr>';

            // Rows: Siswa Data
            $no = 1;
            foreach ($matrix['siswas'] as $s) {
                $countH = 0;
                $countI = 0;
                $countS = 0;
                $countA = 0;

                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td class="text-left">' . htmlspecialchars($s->nama_lengkap) . '</td>';
                echo '<td>' . htmlspecialchars($s->kelas ?: ($s->kategori_kelas ?: '-')) . '</td>';

                foreach ($matrix['mapelList'] as $mId => $m) {
                    $sessions = $matrix['sessionsByMapel'][$mId] ?? [];
                    for ($p = 0; $p < 4; $p++) {
                        $jadwal = $sessions[$p] ?? null;
                        $statusText = '-';
                        $cssClass = '';

                        if ($jadwal) {
                            $st = strtolower($matrix['presensis'][$s->id][$jadwal->id] ?? '');
                            if ($st === 'hadir') {
                                $statusText = 'H';
                                $cssClass = 'class="hadir"';
                                $countH++;
                            } elseif ($st === 'sakit') {
                                $statusText = 'S';
                                $cssClass = 'class="sakit"';
                                $countS++;
                            } elseif ($st === 'izin') {
                                $statusText = 'I';
                                $cssClass = 'class="izin"';
                                $countI++;
                            } elseif ($st === 'alpa') {
                                $statusText = 'A';
                                $cssClass = 'class="alpa"';
                                $countA++;
                            }
                        }

                        echo '<td ' . $cssClass . '>' . $statusText . '</td>';
                    }
                }

                // Rekapitulasi cells (H, I, S, A)
                echo '<td class="rekap-cell" style="color:#15803d;">' . $countH . '</td>';
                echo '<td class="rekap-cell" style="color:#1d4ed8;">' . $countI . '</td>';
                echo '<td class="rekap-cell" style="color:#b45309;">' . $countS . '</td>';
                echo '<td class="rekap-cell" style="color:#b91c1c;">' . $countA . '</td>';
                echo '</tr>';
            }

            echo '</table></body></html>';
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
