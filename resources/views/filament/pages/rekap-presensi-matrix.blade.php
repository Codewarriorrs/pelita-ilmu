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
        /* Scoped styles for Matrix Presensi */
        .matrix-container {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            width: 100%;
        }
        /* Strict sizing for all SVGs in this component */
        .matrix-container svg {
            max-width: 100%;
            flex-shrink: 0;
            display: inline-block;
            vertical-align: middle;
        }
        .matrix-hero-header {
            background: linear-gradient(135deg, #0d5f58 0%, #193836 100%);
            color: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .matrix-badge-stat {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            text-align: center;
            min-width: 90px;
        }
        .matrix-filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            background: #ffffff;
            padding: 1rem;
            border-radius: 0.85rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .matrix-filter-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }
        .matrix-input-field, .matrix-select-field {
            border: 1.5px solid #cbd5e1;
            background-color: #ffffff;
            color: #1e293b;
            font-size: 0.825rem;
            font-weight: 600;
            border-radius: 0.6rem;
            padding: 0.5rem 0.75rem;
            outline: none;
            transition: all 0.2s;
        }
        .matrix-input-field:focus, .matrix-select-field:focus {
            border-color: #009688;
            box-shadow: 0 0 0 3px rgba(0, 150, 136, 0.15);
        }
        .matrix-btn-export {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-size: 0.825rem;
            font-weight: 700;
            padding: 0.55rem 1.15rem;
            border-radius: 0.6rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
            transition: all 0.2s;
        }
        .matrix-btn-export:hover {
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
        }
        .matrix-legend-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.65rem;
            border-radius: 0.4rem;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            color: #ffffff;
        }
        .matrix-table-container {
            border-radius: 0.85rem;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            overflow: auto;
            max-height: 65vh;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .matrix-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
            text-align: center;
        }
        .matrix-table th, .matrix-table td {
            border: 1px solid #cbd5e1;
            padding: 0.45rem 0.3rem;
            vertical-align: middle;
        }
        .matrix-sticky-header {
            position: sticky;
            top: 0;
            z-index: 20;
        }
        .matrix-sticky-col-1 {
            position: sticky;
            left: 0;
            z-index: 10;
            min-width: 40px;
            max-width: 40px;
            width: 40px;
        }
        .matrix-sticky-col-2 {
            position: sticky;
            left: 40px;
            z-index: 10;
            min-width: 175px;
            max-width: 210px;
            text-align: left !important;
            padding-left: 0.75rem !important;
            box-shadow: 2px 0 5px -2px rgba(0, 0, 0, 0.12);
        }
        .matrix-header-sticky-1 {
            position: sticky;
            left: 0;
            z-index: 30;
            background: #193836 !important;
            color: #ffffff !important;
            min-width: 40px;
            max-width: 40px;
        }
        .matrix-header-sticky-2 {
            position: sticky;
            left: 40px;
            z-index: 30;
            background: #193836 !important;
            color: #ffffff !important;
            min-width: 175px;
            max-width: 210px;
            text-align: left !important;
            padding-left: 0.75rem !important;
            box-shadow: 2px 0 5px -2px rgba(0, 0, 0, 0.18);
        }
        .matrix-header-mapel {
            background: #0f766e !important;
            color: #f0fdfa !important;
            font-weight: 800 !important;
            font-size: 0.8rem !important;
            padding: 0.5rem 0.35rem !important;
            border-right: 2px solid #042f2e !important;
            letter-spacing: 0.02em;
        }
        .matrix-header-rekap {
            background: #fef08a !important;
            color: #713f12 !important;
            font-weight: 900 !important;
            font-size: 0.8rem !important;
            padding: 0.5rem 0.35rem !important;
            letter-spacing: 0.03em;
            border-left: 2px solid #ca8a04 !important;
        }
        .session-subhead {
            font-size: 0.62rem;
            font-weight: 600;
            color: #64748b;
            margin-top: 0.15rem;
            display: block;
        }
        .badge-hadir { background: #16a34a; color: #ffffff; font-weight: 800; border-radius: 0.3rem; padding: 0.2rem 0.25rem; display: block; font-size: 0.67rem; }
        .badge-sakit { background: #d97706; color: #ffffff; font-weight: 800; border-radius: 0.3rem; padding: 0.2rem 0.25rem; display: block; font-size: 0.67rem; }
        .badge-izin  { background: #2563eb; color: #ffffff; font-weight: 800; border-radius: 0.3rem; padding: 0.2rem 0.25rem; display: block; font-size: 0.67rem; }
        .badge-alpa  { background: #dc2626; color: #ffffff; font-weight: 800; border-radius: 0.3rem; padding: 0.2rem 0.25rem; display: block; font-size: 0.67rem; }
        .badge-none  { background: #f1f5f9; color: #94a3b8; font-weight: 600; border-radius: 0.3rem; padding: 0.2rem 0.25rem; display: block; font-size: 0.67rem; }
        .matrix-class-pill {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            font-size: 0.72rem;
            padding: 0.15rem 0.45rem;
            border-radius: 0.35rem;
            border: 1px solid #cbd5e1;
        }
        .rekap-cell-h { background: #f0fdf4; color: #15803d; font-weight: 900; font-size: 0.825rem; }
        .rekap-cell-i { background: #eff6ff; color: #1d4ed8; font-weight: 900; font-size: 0.825rem; }
        .rekap-cell-s { background: #fffbeb; color: #b45309; font-weight: 900; font-size: 0.825rem; }
        .rekap-cell-a { background: #fef2f2; color: #b91c1c; font-weight: 900; font-size: 0.825rem; }
    </style>

    <div class="matrix-container">
        
        <!-- 1. HERO HEADER CONTAINER -->
        <div class="matrix-hero-header">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.2rem 0.65rem; border-radius: 9999px; background: rgba(0, 150, 136, 0.25); border: 1px solid rgba(0, 200, 180, 0.4); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #b3e0dc; margin-bottom: 0.5rem;">
                        <svg style="width: 14px; height: 14px; min-width: 14px; max-width: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Format Buku Presensi Excel
                    </div>
                    <h2 style="font-size: 1.45rem; font-weight: 900; margin: 0; color: #ffffff; letter-spacing: -0.02em;">
                        Rekap Presensi Bulanan
                        <span style="font-size: 1.1rem; font-weight: 500; color: #80ccc5;">({{ $bulanNamaArray[$this->bulan] ?? '' }} {{ $this->tahun }})</span>
                    </h2>
                    <p style="font-size: 0.8rem; color: #cbd5e1; margin: 0.35rem 0 0 0;">
                        Matriks terstruktur per mata pelajaran (Pertemuan 1–4) & rekapitulasi kehadiran (H, I, S, A).
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="matrix-badge-stat">
                        <span style="display: block; font-size: 1.35rem; font-weight: 900; color: #fde047; line-height: 1.2;">{{ $totalSiswaCount }}</span>
                        <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #e2e8f0;">Total Siswa</span>
                    </div>
                    <div class="matrix-badge-stat">
                        <span style="display: block; font-size: 1.35rem; font-weight: 900; color: #80ccc5; line-height: 1.2;">{{ $totalMapelCount }}</span>
                        <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #e2e8f0;">Mata Pelajaran</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. FILTER & ACTION TOOLBAR -->
        <div class="matrix-filter-bar">
            <div class="matrix-filter-group">
                <!-- Search Input -->
                <div style="position: relative; min-width: 180px; flex: 1; max-width: 240px;">
                    <input type="text" wire:model.live.debounce.300ms="searchSiswa" placeholder="Cari nama siswa..." 
                           class="matrix-input-field" style="width: 100%; padding-left: 2rem;"/>
                    <svg style="position: absolute; left: 0.65rem; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; min-width: 15px; max-width: 15px; color: #94a3b8; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Filter Jenjang (Dependent Parent) -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Jenjang:</label>
                    <select wire:model.live="jenjang" class="matrix-select-field" style="max-width: 170px;">
                        @foreach($this->jenjangOptions as $val => $lbl)
                            <option value="{{ $val }}">{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Kelompok (Dependent Child) -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Kelompok:</label>
                    <select wire:model.live="kelompokId" class="matrix-select-field" style="max-width: 190px;">
                        <option value="">Semua Kelompok</option>
                        @foreach($data['allKelompoks'] as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelompok }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bulan -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Bulan:</label>
                    <select wire:model.live="bulan" class="matrix-select-field">
                        @foreach($bulanNamaArray as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Tahun:</label>
                    <select wire:model.live="tahun" class="matrix-select-field">
                        @foreach([2024, 2025, 2026, 2027] as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Export Excel Button -->
            <div>
                <button wire:click="exportExcel" type="button" class="matrix-btn-export">
                    <svg style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6zm10.5-5.5l-2.1-2.1 2.1-2.1-1.4-1.4-2.1 2.1-2.1-2.1-1.4 1.4 2.1 2.1-2.1 2.1 1.4 1.4 2.1-2.1 2.1 2.1 1.4-1.4z"/>
                    </svg>
                    Download Excel (.xls)
                </button>
            </div>
        </div>

        <!-- 3. STATUS COLOR LEGEND BAR -->
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; background: #f8fafc; padding: 0.65rem 1rem; border-radius: 0.65rem; border: 1px solid #e2e8f0;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;">
                <span style="font-size: 0.75rem; font-weight: 800; color: #334155; margin-right: 0.25rem;">Status Kehadiran:</span>
                <span class="matrix-legend-badge" style="background: #16a34a;">HADIR (H)</span>
                <span class="matrix-legend-badge" style="background: #d97706;">SAKIT (S)</span>
                <span class="matrix-legend-badge" style="background: #2563eb;">IZIN (I)</span>
                <span class="matrix-legend-badge" style="background: #dc2626;">ALPA (A)</span>
                <span class="matrix-legend-badge" style="background: #e2e8f0; color: #64748b;">- (Belum Ada Sesi)</span>
            </div>
            <span style="font-size: 0.7rem; color: #64748b; font-weight: 600;">
                *Format 4 pertemuan (P1–P4) setiap mata pelajaran + Rekapitulasi Hadir/Izin/Sakit/Alpa
            </span>
        </div>

        <!-- 4. MATRIX TABLE CONTAINER -->
        <div class="matrix-table-container">
            <table class="matrix-table">
                <!-- HEADER BAR -->
                <thead class="matrix-sticky-header">
                    <!-- Row 1: Title Header -->
                    <tr style="background: #193836; color: #ffffff;">
                        <th rowspan="2" class="matrix-header-sticky-1">
                            NO
                        </th>
                        <th rowspan="2" class="matrix-header-sticky-2">
                            NAMA SISWA
                        </th>
                        <th rowspan="2" style="background: #193836; color: #ffffff; min-width: 80px; font-weight: 800; font-size: 0.75rem;">
                            KELAS
                        </th>
                        @foreach($data['mapelList'] as $m)
                            <th colspan="4" class="matrix-header-mapel">
                                {{ strtoupper($m['nama']) }}
                            </th>
                        @endforeach
                        <th colspan="4" class="matrix-header-rekap">
                            REKAPITULASI ({{ strtoupper($bulanNamaArray[$this->bulan] ?? '') }})
                        </th>
                    </tr>

                    <!-- Row 2: Pertemuan 1 - 4 & Rekap Subheaders -->
                    <tr style="background: #f1f5f9; color: #334155; font-weight: 800; font-size: 0.72rem;">
                        @foreach($data['mapelList'] as $mId => $m)
                            @php
                                $sessions = $data['sessionsByMapel'][$mId] ?? [];
                            @endphp
                            @for($p = 0; $p < 4; $p++)
                                @php
                                    $jadwal = $sessions[$p] ?? null;
                                    $tglLabel = $jadwal ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_sesi)->format('d/m') : '';
                                @endphp
                                <th style="width: 48px; background: #f8fafc; {{ $p === 3 ? 'border-right: 2px solid #042f2e;' : '' }}">
                                    <span>P{{ $p + 1 }}</span>
                                    @if($tglLabel)
                                        <span class="session-subhead">{{ $tglLabel }}</span>
                                    @endif
                                </th>
                            @endfor
                        @endforeach

                        <!-- Rekapitulasi H, I, S, A -->
                        <th style="width: 38px; background: #dcfce7; color: #15803d; font-weight: 900; border-left: 2px solid #ca8a04;">H</th>
                        <th style="width: 38px; background: #dbeafe; color: #1d4ed8; font-weight: 900;">I</th>
                        <th style="width: 38px; background: #fef3c7; color: #b45309; font-weight: 900;">S</th>
                        <th style="width: 38px; background: #fee2e2; color: #b91c1c; font-weight: 900;">A</th>
                    </tr>
                </thead>

                <!-- BODY ROWS -->
                <tbody>
                    @forelse($data['siswas'] as $index => $s)
                        @php
                            $countH = 0;
                            $countI = 0;
                            $countS = 0;
                            $countA = 0;
                        @endphp
                        <tr style="background: {{ $index % 2 === 0 ? '#ffffff' : '#f8fafc' }};">
                            
                            <!-- Index -->
                            <td class="matrix-sticky-col-1" style="font-weight: 700; color: #64748b; background: {{ $index % 2 === 0 ? '#ffffff' : '#f8fafc' }};">
                                {{ $index + 1 }}
                            </td>

                            <!-- Nama Siswa -->
                            <td class="matrix-sticky-col-2" style="font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background: {{ $index % 2 === 0 ? '#ffffff' : '#f8fafc' }};" title="{{ $s->nama_lengkap }}">
                                {{ $s->nama_lengkap }}
                            </td>

                            <!-- Kelas / Jenjang -->
                            <td style="background: {{ $index % 2 === 0 ? '#ffffff' : '#f8fafc' }};">
                                <span class="matrix-class-pill">
                                    {{ $s->kelas ?: ($s->kategori_kelas ?: '-') }}
                                </span>
                            </td>

                            <!-- Presensi Pertemuan -->
                            @foreach($data['mapelList'] as $mId => $m)
                                @php
                                    $sessions = $data['sessionsByMapel'][$mId] ?? [];
                                @endphp

                                @for($p = 0; $p < 4; $p++)
                                    @php
                                        $jadwal = $sessions[$p] ?? null;
                                        $status = '-';
                                        $badgeClass = 'badge-none';

                                        if ($jadwal) {
                                            $st = strtolower($data['presensis'][$s->id][$jadwal->id] ?? '');
                                            if ($st === 'hadir') {
                                                $status = 'HADIR';
                                                $badgeClass = 'badge-hadir';
                                                $countH++;
                                            } elseif ($st === 'sakit') {
                                                $status = 'SAKIT';
                                                $badgeClass = 'badge-sakit';
                                                $countS++;
                                            } elseif ($st === 'izin') {
                                                $status = 'IZIN';
                                                $badgeClass = 'badge-izin';
                                                $countI++;
                                            } elseif ($st === 'alpa') {
                                                $status = 'ALPA';
                                                $badgeClass = 'badge-alpa';
                                                $countA++;
                                            }
                                        }
                                    @endphp
                                    <td style="padding: 0.25rem 0.15rem; {{ $p === 3 ? 'border-right: 2px solid #042f2e;' : '' }}">
                                        <span class="{{ $badgeClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                @endfor
                            @endforeach

                            <!-- Rekapitulasi Cells -->
                            <td class="rekap-cell-h" style="border-left: 2px solid #ca8a04;">
                                {{ $countH }}
                            </td>
                            <td class="rekap-cell-i">
                                {{ $countI }}
                            </td>
                            <td class="rekap-cell-s">
                                {{ $countS }}
                            </td>
                            <td class="rekap-cell-a">
                                {{ $countA }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $totalCols }}" style="padding: 3rem 1rem; text-align: center; color: #64748b;">
                                <div style="max-width: 320px; margin: 0 auto; text-align: center;">
                                    <svg style="width: 48px; height: 48px; min-width: 48px; max-width: 48px; margin: 0 auto 0.75rem auto; color: #cbd5e1; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p style="font-size: 0.95rem; font-weight: 700; color: #334155; margin: 0;">Tidak ada data siswa / presensi</p>
                                    <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.35rem 0 0 0;">Coba sesuaikan kata kunci pencarian, filter jenjang, atau kelompok di atas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-filament-panels::page>
