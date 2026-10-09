<?php

namespace App\Filament\Pages;

use App\Models\DetailPresensi;
use App\Models\JadwalKelompok;
use App\Models\Kelompok;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
    public ?int $kelompokId = null;
    public ?string $jenjangKelas = null;
    public string $searchSiswa = '';

    public function mount(): void
    {
        $this->bulan = (int) date('m');
        $this->tahun = (int) date('Y');
    }

    public function getMatrixData(): array
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        $user = auth()->user();
        $isTentor = $user?->isTentor();

        // Fetch subjects
        $kelompokQuery = Kelompok::with('mapel');
        if ($isTentor) {
            $kelompokQuery->where('tentor_id', $user->id);
        }
        if ($this->kelompokId) {
            $kelompokQuery->where('id', $this->kelompokId);
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

        // Fallback: if no mapels in kelompoks, get all mapels (only for admin or if empty)
        if (empty($mapelList)) {
            $allMapels = MataPelajaran::all();
            foreach ($allMapels as $m) {
                $mapelList[$m->id] = [
                    'id' => $m->id,
                    'nama' => $m->nama_mapel,
                    'kelompok_id' => null,
                ];
            }
        }

        // Fetch sessions (JadwalKelompok) in selected month & year (index-friendly query)
        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();

        $jadwalQuery = JadwalKelompok::with('kelompok')
            ->whereBetween('tanggal_sesi', [$startDate, $endDate]);

        if ($isTentor) {
            $jadwalQuery->whereHas('kelompok', fn ($q) => $q->where('tentor_id', $user->id));
        }

        if ($this->kelompokId) {
            $jadwalQuery->where('kelompok_id', $this->kelompokId);
        }

        $jadwals = $jadwalQuery->orderBy('tanggal_sesi', 'asc')->get();

        // Group sessions by mapel_id (or kelompok_id)
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

        // Fetch active students only
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
        }

        if (!empty($this->jenjangKelas)) {
            $val = trim($this->jenjangKelas);
            $siswaQuery->where(function ($q) use ($val) {
                $q->where('kelas', 'ILIKE', "%{$val}%")
                  ->orWhere('kategori_kelas', 'ILIKE', "%{$val}%");
            });
        }

        if (!empty(trim($this->searchSiswa))) {
            $siswaQuery->where('nama_lengkap', 'ILIKE', '%' . trim($this->searchSiswa) . '%');
        }
        $siswas = $siswaQuery->orderBy('nama_lengkap', 'asc')->get();

        // Get all DetailPresensi for fetched jadwals
        $allJadwalIds = $jadwals->pluck('id')->toArray();
        $presensis = [];
        if (!empty($allJadwalIds)) {
            $dpRecords = DetailPresensi::whereIn('jadwal_id', $allJadwalIds)->get();
            foreach ($dpRecords as $dp) {
                $presensis[$dp->siswa_id][$dp->jadwal_id] = $dp->status_kehadiran;
            }
        }

        $allKelompoksQuery = Kelompok::query();
        if ($isTentor) {
            $allKelompoksQuery->where('tentor_id', $user->id);
        }
        $allKelompoks = $allKelompoksQuery->orderBy('nama_kelompok')->get();

        return [
            'mapelList' => $mapelList,
            'sessionsByMapel' => $sessionsByMapel,
            'siswas' => $siswas,
            'presensis' => $presensis,
            'allKelompoks' => $allKelompoks,
        ];
    }

    public function exportExcel()
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
            echo '<html><head><meta charset="UTF-8"></head><body>';
            echo '<table border="1" style="border-collapse:collapse; text-align:center;">';
            
            // Row 1: Title & Month
            echo '<tr>';
            echo '<th style="background:#f3f4f6;">NO</th>';
            echo '<th style="background:#f3f4f6; text-align:left;">NAMA</th>';
            echo '<th colspan="' . (count($matrix['mapelList']) * 4) . '" style="background:#dbeafe;">DROPDOWN BULAN: ' . strtoupper($bulanNama) . '</th>';
            echo '</tr>';

            // Row 2: Mapels (spanning 4 columns each)
            echo '<tr>';
            echo '<th style="background:#f3f4f6;"></th>';
            echo '<th style="background:#f3f4f6;"></th>';
            foreach ($matrix['mapelList'] as $m) {
                echo '<th colspan="4" style="background:#e0e7ff;">' . strtoupper($m['nama']) . '</th>';
            }
            echo '</tr>';

            // Row 3: Pertemuan 1, 2, 3, 4
            echo '<tr>';
            echo '<th style="background:#f3f4f6;"></th>';
            echo '<th style="background:#f3f4f6;"></th>';
            foreach ($matrix['mapelList'] as $m) {
                for ($p = 1; $p <= 4; $p++) {
                    echo '<th style="background:#f1f5f9; width:60px;">' . $p . '</th>';
                }
            }
            echo '</tr>';

            // Rows: Siswa data
            $no = 1;
            foreach ($matrix['siswas'] as $s) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td style="text-align:left; padding:0 8px;">' . htmlspecialchars($s->nama_lengkap) . '</td>';

                foreach ($matrix['mapelList'] as $mId => $m) {
                    $sessions = $matrix['sessionsByMapel'][$mId] ?? [];
                    for ($p = 0; $p < 4; $p++) {
                        $jadwal = $sessions[$p] ?? null;
                        $status = '-';
                        $bgColor = '#ffffff';
                        $textColor = '#374151';

                        if ($jadwal) {
                            $st = strtolower($matrix['presensis'][$s->id][$jadwal->id] ?? '');
                            if ($st === 'hadir') {
                                $status = 'Hadir';
                                $bgColor = '#16a34a'; // Green solid
                                $textColor = '#ffffff';
                            } elseif ($st === 'sakit') {
                                $status = 'Sakit';
                                $bgColor = '#d97706'; // Orange solid
                                $textColor = '#ffffff';
                            } elseif ($st === 'izin') {
                                $status = 'Izin';
                                $bgColor = '#2563eb'; // Blue solid
                                $textColor = '#ffffff';
                            } elseif ($st === 'alpa') {
                                $status = 'Alpa';
                                $bgColor = '#dc2626'; // Red solid
                                $textColor = '#ffffff';
                            }
                        }

                        echo '<td style="background:' . $bgColor . '; color:' . $textColor . '; font-weight:bold;">' . $status . '</td>';
                    }
                }
                echo '</tr>';
            }

            echo '</table></body></html>';
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
