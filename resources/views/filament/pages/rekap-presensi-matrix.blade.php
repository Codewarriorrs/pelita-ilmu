<x-filament-panels::page>
    @php
        $data = $this->getMatrixData();
        $bulanNamaArray = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $totalSiswaCount = count($data['siswas']);
        $totalMapelCount = count($data['mapelList']);
        $totalCols = 3 + ($totalMapelCount * 4) + 4;
    @endphp

    <style>
        .rp-container {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            width: 100%;
        }
        .rp-container svg {
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
        }
        .rp-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
        }
        .rp-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .rp-title-group h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
            line-height: 1.3;
        }
        .rp-title-group p {
            font-size: 0.8125rem;
            color: #6b7280;
            margin: 0.25rem 0 0 0;
        }
        .rp-btn-export {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #10b981;
            color: #ffffff;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #059669;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .rp-btn-export:hover {
            background: #059669;
        }
        .rp-filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 0.75rem;
            align-items: flex-end;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }
        .rp-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .rp-form-group label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #4b5563;
        }
        .rp-input, .rp-select {
            width: 100%;
            height: 2.35rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
            color: #1f2937;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .rp-input:focus, .rp-select:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 2px rgba(15, 118, 110, 0.15);
        }
        .rp-table-wrapper {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            overflow: auto;
            max-height: 68vh;
        }
        .rp-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.775rem;
            color: #1f2937;
            text-align: center;
        }
        .rp-table th, .rp-table td {
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.45rem 0.35rem;
            vertical-align: middle;
            box-sizing: border-box;
        }
        .rp-table thead tr:first-child th {
            border-top: none;
        }
        .rp-th-sticky {
            position: sticky;
            top: 0;
            z-index: 20;
            background: #f9fafb;
            color: #374151;
            font-weight: 700;
            font-size: 0.725rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .rp-th-sub {
            position: sticky;
            top: 33px;
            z-index: 19;
            background: #f3f4f6;
            color: #4b5563;
            font-weight: 600;
            font-size: 0.7rem;
        }
        .rp-col-no {
            position: sticky;
            left: 0;
            z-index: 10;
            width: 42px;
            min-width: 42px;
            max-width: 42px;
            background: #ffffff;
            font-weight: 600;
            color: #6b7280;
        }
        .rp-col-nama {
            position: sticky;
            left: 42px;
            z-index: 10;
            min-width: 180px;
            max-width: 220px;
            text-align: left !important;
            padding-left: 0.75rem !important;
            padding-right: 0.5rem !important;
            background: #ffffff;
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            box-shadow: 2px 0 4px -2px rgba(0, 0, 0, 0.08);
        }
        .rp-th-col-no {
            position: sticky;
            top: 0;
            left: 0;
            z-index: 30;
            width: 42px;
            min-width: 42px;
            max-width: 42px;
            background: #f9fafb;
            color: #374151;
        }
        .rp-th-col-nama {
            position: sticky;
            top: 0;
            left: 42px;
            z-index: 30;
            min-width: 180px;
            max-width: 220px;
            text-align: left !important;
            padding-left: 0.75rem !important;
            background: #f9fafb;
            color: #374151;
            box-shadow: 2px 0 4px -2px rgba(0, 0, 0, 0.08);
        }
        .rp-col-kelas {
            min-width: 100px;
            color: #4b5563;
            font-size: 0.775rem;
            white-space: nowrap;
            text-align: center;
        }
        .rp-th-mapel {
            background: #f9fafb;
            color: #1f2937;
            font-weight: 700;
            font-size: 0.725rem;
        }
        .rp-th-rekap {
            background: #f9fafb;
            color: #1f2937;
            font-weight: 700;
            font-size: 0.725rem;
            border-left: 2px solid #cbd5e1;
        }
        .rp-row:nth-child(even) td {
            background-color: #fafafa;
        }
        .rp-row:nth-child(even) .rp-col-no,
        .rp-row:nth-child(even) .rp-col-nama {
            background-color: #fafafa;
        }
        .rp-row:hover td {
            background-color: #f3f4f6;
        }
        .rp-row:hover .rp-col-no,
        .rp-row:hover .rp-col-nama {
            background-color: #f3f4f6;
        }
        .rp-status-hadir {
            display: inline-block;
            color: #15803d;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 0.25rem;
            padding: 0.1rem 0.35rem;
            font-size: 0.675rem;
            font-weight: 700;
        }
        .rp-status-izin {
            display: inline-block;
            color: #1d4ed8;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.25rem;
            padding: 0.1rem 0.35rem;
            font-size: 0.675rem;
            font-weight: 700;
        }
        .rp-status-sakit {
            display: inline-block;
            color: #b45309;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.25rem;
            padding: 0.1rem 0.35rem;
            font-size: 0.675rem;
            font-weight: 700;
        }
        .rp-status-alpa {
            display: inline-block;
            color: #b91c1c;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 0.25rem;
            padding: 0.1rem 0.35rem;
            font-size: 0.675rem;
            font-weight: 700;
        }
        .rp-status-none {
            color: #9ca3af;
            font-size: 0.75rem;
        }
        .rp-total-h { color: #15803d; font-weight: 700; background: #f0fdf4; }
        .rp-total-i { color: #1d4ed8; font-weight: 700; background: #eff6ff; }
        .rp-total-s { color: #b45309; font-weight: 700; background: #fffbeb; }
        .rp-total-a { color: #b91c1c; font-weight: 700; background: #fef2f2; }
    </style>

    <div class="rp-container">

        <!-- 1. HEADER & FILTER CARD (White, Clean Filament Style) -->
        <div class="rp-card">
            <div class="rp-toolbar">
                <div class="rp-title-group">
                    <h2>Rekap Presensi Bulanan</h2>
                    <p>
                        Periode {{ $bulanNamaArray[$this->bulan] ?? '' }} {{ $this->tahun }} &bull; 
                        <strong>{{ $totalSiswaCount }}</strong> Siswa terdaftar &bull; 
                        <strong>{{ $totalMapelCount }}</strong> Mata Pelajaran
                    </p>
                </div>

                <div>
                    <button wire:click="exportExcel" type="button" class="rp-btn-export">
                        <svg style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Export Excel (.xls)</span>
                    </button>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="rp-filter-grid">
                <!-- Search -->
                <div class="rp-form-group">
                    <label>Cari Siswa</label>
                    <input type="text" wire:model.live.debounce.300ms="searchSiswa" placeholder="Ketik nama siswa..." class="rp-input" />
                </div>

                <!-- Jenjang -->
                <div class="rp-form-group">
                    <label>Jenjang</label>
                    <select wire:model.live="jenjang" class="rp-select">
                        @foreach($this->jenjangOptions as $val => $lbl)
                            <option value="{{ $val }}">{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelompok -->
                <div class="rp-form-group">
                    <label>Kelompok Belajar</label>
                    <select wire:model.live="kelompokId" class="rp-select">
                        <option value="">Semua Kelompok</option>
                        @foreach($data['allKelompoks'] as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelompok }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bulan -->
                <div class="rp-form-group">
                    <label>Bulan</label>
                    <select wire:model.live="bulan" class="rp-select">
                        @foreach($bulanNamaArray as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun -->
                <div class="rp-form-group">
                    <label>Tahun</label>
                    <input type="number" wire:model.live="tahun" min="2020" max="2035" class="rp-input" />
                </div>
            </div>
        </div>

        <!-- 2. TABLE WRAPPER -->
        <div class="rp-table-wrapper">
            <table class="rp-table">
                <thead>
                    <!-- Row 1: Main Headers -->
                    <tr>
                        <th rowspan="2" class="rp-th-col-no">#</th>
                        <th rowspan="2" class="rp-th-col-nama">NAMA SISWA</th>
                        <th rowspan="2" class="rp-th-sticky" style="min-width: 90px;">KELAS</th>
                        @foreach($data['mapelList'] as $m)
                            <th colspan="4" class="rp-th-sticky rp-th-mapel">
                                {{ strtoupper($m['nama']) }}
                            </th>
                        @endforeach
                        <th colspan="4" class="rp-th-sticky rp-th-rekap">
                            REKAP ({{ strtoupper(substr($bulanNamaArray[$this->bulan] ?? '', 0, 3)) }})
                        </th>
                    </tr>

                    <!-- Row 2: Pertemuan 1 - 4 & Rekap H, I, S, A -->
                    <tr>
                        @foreach($data['mapelList'] as $mId => $m)
                            @php
                                $sessions = $data['sessionsByMapel'][$mId] ?? [];
                            @endphp
                            @for($p = 0; $p < 4; $p++)
                                @php
                                    $jadwal = $sessions[$p] ?? null;
                                    $tglLabel = $jadwal ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_sesi)->format('d/m') : '';
                                @endphp
                                <th class="rp-th-sub" style="width: 48px; {{ $p === 3 ? 'border-right: 2px solid #cbd5e1;' : '' }}">
                                    <span>P{{ $p + 1 }}</span>
                                    @if($tglLabel)
                                        <div style="font-size: 0.625rem; color: #9ca3af; font-weight: normal; margin-top: 1px;">{{ $tglLabel }}</div>
                                    @endif
                                </th>
                            @endfor
                        @endforeach

                        <th class="rp-th-sub" style="width: 38px; color: #15803d; border-left: 2px solid #cbd5e1;">H</th>
                        <th class="rp-th-sub" style="width: 38px; color: #1d4ed8;">I</th>
                        <th class="rp-th-sub" style="width: 38px; color: #b45309;">S</th>
                        <th class="rp-th-sub" style="width: 38px; color: #b91c1c;">A</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data['siswas'] as $index => $s)
                        @php
                            $countH = 0;
                            $countI = 0;
                            $countS = 0;
                            $countA = 0;
                        @endphp
                        <tr class="rp-row">
                            <!-- Index -->
                            <td class="rp-col-no">
                                {{ $index + 1 }}
                            </td>

                            <!-- Nama Siswa -->
                            <td class="rp-col-nama" title="{{ $s->nama_lengkap }}">
                                {{ $s->nama_lengkap }}
                            </td>

                            <!-- Kelas (Plain text, NO nested rectangle pill) -->
                            <td class="rp-col-kelas">
                                {{ $s->kelas ?: ($s->kategori_kelas ?: '-') }}
                            </td>

                            <!-- Presensi Pertemuan -->
                            @foreach($data['mapelList'] as $mId => $m)
                                @php
                                    $sessions = $data['sessionsByMapel'][$mId] ?? [];
                                @endphp

                                @for($p = 0; $p < 4; $p++)
                                    @php
                                        $jadwal = $sessions[$p] ?? null;
                                        $statusHtml = '<span class="rp-status-none">-</span>';

                                        if ($jadwal) {
                                            $st = strtolower($data['presensis'][$s->id][$jadwal->id] ?? '');
                                            if ($st === 'hadir') {
                                                $statusHtml = '<span class="rp-status-hadir">HADIR</span>';
                                                $countH++;
                                            } elseif ($st === 'sakit') {
                                                $statusHtml = '<span class="rp-status-sakit">SAKIT</span>';
                                                $countS++;
                                            } elseif ($st === 'izin') {
                                                $statusHtml = '<span class="rp-status-izin">IZIN</span>';
                                                $countI++;
                                            } elseif ($st === 'alpa') {
                                                $statusHtml = '<span class="rp-status-alpa">ALPA</span>';
                                                $countA++;
                                            }
                                        }
                                    @endphp
                                    <td style="padding: 0.25rem 0.15rem; {{ $p === 3 ? 'border-right: 2px solid #cbd5e1;' : '' }}">
                                        {!! $statusHtml !!}
                                    </td>
                                @endfor
                            @endforeach

                            <!-- Rekapitulasi Totals -->
                            <td class="rp-total-h" style="border-left: 2px solid #cbd5e1;">
                                {{ $countH }}
                            </td>
                            <td class="rp-total-i">
                                {{ $countI }}
                            </td>
                            <td class="rp-total-s">
                                {{ $countS }}
                            </td>
                            <td class="rp-total-a">
                                {{ $countA }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $totalCols }}" style="padding: 3rem 1rem; text-align: center; color: #6b7280;">
                                <div style="max-width: 320px; margin: 0 auto; text-align: center;">
                                    <svg style="width: 36px; height: 36px; min-width: 36px; max-width: 36px; margin: 0 auto 0.5rem auto; color: #9ca3af; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p style="font-size: 0.875rem; font-weight: 600; color: #374151; margin: 0;">Tidak ada data siswa / presensi</p>
                                    <p style="font-size: 0.75rem; color: #9ca3af; margin: 0.25rem 0 0 0;">Sesuaikan pencarian atau filter di atas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-filament-panels::page>
