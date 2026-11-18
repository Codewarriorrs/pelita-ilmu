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

        $filename = 'Rekap_Presensi_' . str_replace(' ', '_', $bulanNama) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Transfer-Encoding' => 'binary',
        ];

        $callback = function () use ($matrix, $bulanNama): void {
            // Clean output buffers to prevent corrupt files or hung downloads
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $output = fopen('php://output', 'w');

            // Write UTF-8 BOM so Microsoft Excel on Windows opens non-ASCII characters & Indonesian accents correctly
            fputs($output, "\xEF\xBB\xBF");

            // Header 1: Basic info
            fputcsv($output, ['REKAPITULASI PRESENSI SISWA - PELITA ILMU']);
            fputcsv($output, ['PERIODE: ' . strtoupper($bulanNama)]);
            fputcsv($output, []);

            // Build dynamic headers
            $headers1 = ['NO', 'NAMA SISWA', 'KELAS'];
            foreach ($matrix['mapelList'] as $mId => $m) {
                $sessions = $matrix['sessionsByMapel'][$mId] ?? [];
                $count = count($sessions);
                if ($count === 0) {
                    $headers1[] = strtoupper($m['nama']);
                } else {
                    foreach ($sessions as $pIdx => $jadwal) {
                        $tglLabel = Carbon::parse($jadwal->tanggal_sesi)->format('d/m');
                        $headers1[] = strtoupper($m['nama']) . ' - P' . ($pIdx + 1) . ' (' . $tglLabel . ')';
                    }
                }
            }
            $headers1[] = 'TOTAL HADIR (H)';
            $headers1[] = 'TOTAL IZIN (I)';
            $headers1[] = 'TOTAL SAKIT (S)';
            $headers1[] = 'TOTAL ALPA (A)';

            fputcsv($output, $headers1);

            $no = 1;
            foreach ($matrix['siswas'] as $s) {
                $countH = 0;
                $countI = 0;
                $countS = 0;
                $countA = 0;

                $row = [
                    $no++,
                    $s->nama_lengkap,
                    $s->kelas ?: ($s->kategori_kelas ?: '-'),
                ];

                foreach ($matrix['mapelList'] as $mId => $m) {
                    $sessions = $matrix['sessionsByMapel'][$mId] ?? [];
                    if (count($sessions) === 0) {
                        $row[] = '-';
                    } else {
                        foreach ($sessions as $jadwal) {
                            $st = strtolower($matrix['presensis'][$s->id][$jadwal->id] ?? '');
                            if ($st === 'hadir') {
                                $row[] = 'H';
                                $countH++;
                            } elseif ($st === 'sakit') {
                                $row[] = 'S';
                                $countS++;
                            } elseif ($st === 'izin') {
                                $row[] = 'I';
                                $countI++;
                            } elseif ($st === 'alpa') {
                                $row[] = 'A';
                                $countA++;
                            } else {
                                $row[] = '-';
                            }
                        }
                    }
                }

                $row[] = $countH;
                $row[] = $countI;
                $row[] = $countS;
                $row[] = $countA;

                fputcsv($output, $row);
            }

            fclose($output);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
