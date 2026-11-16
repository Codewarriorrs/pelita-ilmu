<?php

namespace App\Filament\Pages;

use App\Models\DetailPresensi;
use App\Models\JadwalKelompok;
use App\Models\Kelompok;
use App\Models\Siswa;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapPresensiMatrix extends Page
{
    use WithPagination;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-table-cells';
    protected static \UnitEnum|string|null $navigationGroup = 'Presensi';
    protected static ?string $title = 'Rekap Presensi Bulanan (Matrix Format)';
    protected static ?string $navigationLabel = 'Rekap Presensi';
    protected string $view = 'filament.pages.rekap-presensi-matrix';

    public int $bulan;
    public int $tahun;
    public ?string $jenjang = 'ALL';
    public ?int $kelompokId = null;
    public ?string $jenjangKelas = null;
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
        $this->resetPage();
    }

    public function updatedKelompokId(): void
    {
        $this->resetPage();
    }

    public function updatedBulan(): void
    {
        $this->bulan = max(1, min(12, (int) $this->bulan));
        $this->resetPage();
    }

    public function updatedTahun(): void
    {
        $this->tahun = max(2020, min(2035, (int) $this->tahun));
        $this->resetPage();
    }

    public function updatedSearchSiswa(): void
    {
        $this->resetPage();
    }

    public function updatedJenjangKelas(): void
    {
        $this->resetPage();
    }

    protected function getSafePeriod(): array
    {
        $bulan = ($this->bulan >= 1 && $this->bulan <= 12) ? $this->bulan : (int) now()->month;
        $tahun = ($this->tahun >= 2020 && $this->tahun <= 2035) ? $this->tahun : (int) now()->year;

        return [$bulan, $tahun];
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
        if ($jenjang === 'TK') {
            $query->where(function ($q) {
                $q->where('kelas', 'ILIKE', '%TK%')
                    ->orWhere('kelas', 'ILIKE', '%PAUD%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%TK%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%PAUD%');
            })->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('kelas')
                        ->orWhere(function ($s) {
                            $s->where('kelas', 'NOT ILIKE', '%SD%')
                                ->where('kelas', 'NOT ILIKE', '%SMP%')
                                ->where('kelas', 'NOT ILIKE', '%SMA%')
                                ->where('kelas', 'NOT ILIKE', '%SMK%');
                        });
                });
            });
        } elseif ($jenjang === 'SD') {
            $query->where(function ($q) {
                $q->where('kelas', 'ILIKE', '%SD%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%SD%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 1%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 2%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 3%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 4%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 5%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 6%')
                    ->orWhere('kelas', 'ILIKE', '1 %')
                    ->orWhere('kelas', 'ILIKE', '2 %')
                    ->orWhere('kelas', 'ILIKE', '3 %')
                    ->orWhere('kelas', 'ILIKE', '4 %')
                    ->orWhere('kelas', 'ILIKE', '5 %')
                    ->orWhere('kelas', 'ILIKE', '6 %');
            })->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('kelas')
                        ->orWhere(function ($s) {
                            $s->where('kelas', 'NOT ILIKE', '%SMP%')
                                ->where('kelas', 'NOT ILIKE', '%SMA%')
                                ->where('kelas', 'NOT ILIKE', '%SMK%')
                                ->where('kelas', 'NOT ILIKE', '%TK%')
                                ->where('kelas', 'NOT ILIKE', '%PAUD%');
                        });
                })->where(function ($sub) {
                    $sub->whereNull('kategori_kelas')
                        ->orWhere(function ($s) {
                            $s->where('kategori_kelas', 'NOT ILIKE', '%SMP%')
                                ->where('kategori_kelas', 'NOT ILIKE', '%SMA%')
                                ->where('kategori_kelas', 'NOT ILIKE', '%SMK%');
                        });
                });
            });
        } elseif ($jenjang === 'SMP') {
            $query->where(function ($q) {
                $q->where('kelas', 'ILIKE', '%SMP%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%SMP%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 7%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 8%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 9%')
                    ->orWhere('kelas', 'ILIKE', '7 %')
                    ->orWhere('kelas', 'ILIKE', '8 %')
                    ->orWhere('kelas', 'ILIKE', '9 %');
            })->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('kelas')
                        ->orWhere(function ($s) {
                            $s->where('kelas', 'NOT ILIKE', '%SMA%')
                                ->where('kelas', 'NOT ILIKE', '%SMK%')
                                ->where('kelas', 'NOT ILIKE', '%SD%')
                                ->where('kelas', 'NOT ILIKE', '%TK%');
                        });
                })->where(function ($sub) {
                    $sub->whereNull('kategori_kelas')
                        ->orWhere(function ($s) {
                            $s->where('kategori_kelas', 'NOT ILIKE', '%SMA%')
                                ->where('kategori_kelas', 'NOT ILIKE', '%SMK%')
                                ->where('kategori_kelas', 'NOT ILIKE', '%SD%');
                        });
                });
            });
        } elseif ($jenjang === 'SMA') {
            $query->where(function ($q) {
                $q->where('kelas', 'ILIKE', '%SMA%')
                    ->orWhere('kelas', 'ILIKE', '%SMK%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%SMA%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%SMK%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 10%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 11%')
                    ->orWhere('kelas', 'ILIKE', 'Kelas 12%')
                    ->orWhere('kelas', 'ILIKE', '10 %')
                    ->orWhere('kelas', 'ILIKE', '11 %')
                    ->orWhere('kelas', 'ILIKE', '12 %');
            })->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('kelas')
                        ->orWhere(function ($s) {
                            $s->where('kelas', 'NOT ILIKE', '%SMP%')
                                ->where('kelas', 'NOT ILIKE', '%SD%')
                                ->where('kelas', 'NOT ILIKE', '%TK%');
                        });
                })->where(function ($sub) {
                    $sub->whereNull('kategori_kelas')
                        ->orWhere(function ($s) {
                            $s->where('kategori_kelas', 'NOT ILIKE', '%SMP%')
                                ->where('kategori_kelas', 'NOT ILIKE', '%SD%');
                        });
                });
            });
        } elseif ($jenjang === 'UTBK') {
            $query->where(function ($q) {
                $q->where('kelas', 'ILIKE', '%UTBK%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%UTBK%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%SNBT%')
                    ->orWhere('kategori_kelas', 'ILIKE', '%TPA%')
                    ->orWhere('kelas', 'ILIKE', '%Alumni%')
                    ->orWhere('kelas', 'ILIKE', '%Gap Year%');
            });
        }
    }

    public function getMatrixData(bool $paginate = true): array
    {
        [$bulan, $tahun] = $this->getSafePeriod();

        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $isTentor = $user && $user->isTentor();

        $allKelompoksQuery = Kelompok::query()->with(['mapel', 'tentor']);
        if ($isTentor) {
            $allKelompoksQuery->where('tentor_id', $user->id);
        }
        if ($this->jenjang && $this->jenjang !== 'ALL') {
            $this->filterKelompokByJenjang($allKelompoksQuery, $this->jenjang);
        }
        $allKelompoks = $allKelompoksQuery->orderBy('nama_kelompok')->get();

        if ($this->kelompokId && ! $allKelompoks->pluck('id')->contains($this->kelompokId)) {
            $this->kelompokId = null;
        }

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();

        $jadwalQuery = JadwalKelompok::with(['kelompok.mapel', 'kelompok.tentor'])
            ->whereBetween('tanggal_sesi', [$startDate, $endDate]);

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

        $jadwals = $jadwalQuery->orderBy('tanggal_sesi', 'asc')->orderBy('id', 'asc')->get();

        $mapelList = [];
        $sessionsByMapel = [];

        foreach ($jadwals as $jadwal) {
            $colKey = $jadwal->kelompok?->mapel_id ?? ('kelompok_' . $jadwal->kelompok_id);
            if (! isset($mapelList[$colKey])) {
                $colName = $this->kelompokId
                    ? ($jadwal->kelompok?->mapel?->nama_mapel ?? $jadwal->kelompok?->nama_kelompok ?? 'Kelompok')
                    : ($jadwal->kelompok?->mapel?->nama_mapel ?? $jadwal->kelompok?->nama_kelompok ?? 'Mapel');

                $mapelList[$colKey] = [
                    'id' => $colKey,
                    'nama' => $colName,
                    'kelompok_id' => $jadwal->kelompok_id,
                ];
                $sessionsByMapel[$colKey] = [];
            }

            $sessionsByMapel[$colKey][] = $jadwal;
        }

        $siswaQuery = Siswa::query()->with('kelompok');

        if ($isTentor) {
            $siswaQuery->whereHas('kelompok', function ($q) use ($user) {
                $q->where('tentor_id', $user->id);
            });
        }

        if ($this->jenjang && $this->jenjang !== 'ALL') {
            $this->filterSiswaByJenjang($siswaQuery, $this->jenjang);
        }

        if ($this->kelompokId) {
            $siswaQuery->whereHas('kelompok', function ($q) {
                $q->where('kelompok.id', $this->kelompokId);
            });
        }

        if (! empty($this->jenjangKelas)) {
            $val = trim($this->jenjangKelas);
            $siswaQuery->where(function ($q) use ($val) {
                $q->where('kelas', 'ILIKE', "%{$val}%")
                    ->orWhere('kategori_kelas', 'ILIKE', "%{$val}%");
            });
        }

        if (! empty(trim($this->searchSiswa))) {
            $siswaQuery->where('nama_lengkap', 'ILIKE', '%' . trim($this->searchSiswa) . '%');
        }

        $siswaQuery->where(function (Builder $q) use ($endDate): void {
            $q->whereNull('tanggal_daftar')
                ->orWhere('tanggal_daftar', '<=', $endDate);
        })->where(function (Builder $q) use ($startDate): void {
            $q->whereNull('tanggal_keluar')
                ->orWhere('tanggal_keluar', '>=', $startDate);
        });

        $siswaQuery->orderBy('nama_lengkap', 'asc');

        $siswas = $paginate
            ? $siswaQuery->paginate(25)
            : $siswaQuery->get();

        $visibleSiswaIds = $paginate
            ? $siswas->getCollection()->pluck('id')->all()
            : $siswas->pluck('id')->all();

        $allJadwalIds = $jadwals->pluck('id')->all();
        $presensis = [];

        if (! empty($allJadwalIds) && ! empty($visibleSiswaIds)) {
            $dpRecords = DetailPresensi::query()
                ->whereIn('jadwal_id', $allJadwalIds)
                ->whereIn('siswa_id', $visibleSiswaIds)
                ->get(['siswa_id', 'jadwal_id', 'status_kehadiran']);

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
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
    }

    public function exportExcel(): StreamedResponse
    {
        $matrix = $this->getMatrixData(paginate: false);
        $bulanNama = Carbon::createFromDate($matrix['tahun'], $matrix['bulan'], 1)->locale('id')->translatedFormat('F Y');

        $filename = 'Rekap_Presensi_' . str_replace(' ', '_', $bulanNama) . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($matrix, $bulanNama): void {
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

            echo '<tr>';
            echo '<th rowspan="2" style="width: 35px;">NO</th>';
            echo '<th rowspan="2" style="width: 180px; text-align:left;">NAMA SISWA</th>';
            echo '<th rowspan="2" style="width: 85px;">KELAS</th>';

            foreach ($matrix['mapelList'] as $mId => $m) {
                $colspan = max(1, count($matrix['sessionsByMapel'][$mId] ?? []));
                echo '<th colspan="' . $colspan . '" class="th-sub">' . htmlspecialchars(strtoupper($m['nama'])) . '</th>';
            }

            echo '<th colspan="4" class="th-rekap">REKAPITULASI (' . strtoupper($bulanNama) . ')</th>';
            echo '</tr>';

            echo '<tr>';
            foreach ($matrix['mapelList'] as $mId => $m) {
                $sessions = $matrix['sessionsByMapel'][$mId] ?? [];
                foreach ($sessions as $pIdx => $jadwal) {
                    $tglLabel = Carbon::parse($jadwal->tanggal_sesi)->format('d/m');
                    echo '<th style="background:#f1f5f9; color:#334155; font-size:10px; width:55px;">P' . ($pIdx + 1) . '<br><span style="font-weight:normal; font-size:9px;">' . $tglLabel . '</span></th>';
                }
            }

            echo '<th style="background:#dcfce7; color:#15803d; width:40px;">H</th>';
            echo '<th style="background:#dbeafe; color:#1d4ed8; width:40px;">I</th>';
            echo '<th style="background:#fef3c7; color:#b45309; width:40px;">S</th>';
            echo '<th style="background:#fee2e2; color:#b91c1c; width:40px;">A</th>';
            echo '</tr>';

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
                    foreach ($sessions as $jadwal) {
                        $statusText = '-';
                        $cssClass = '';

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

                        echo '<td ' . $cssClass . '>' . $statusText . '</td>';
                    }
                }

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
