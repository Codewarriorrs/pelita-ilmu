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

    <div class="flex flex-col gap-5 w-full font-sans">
        
        <!-- 1. TOOLBAR & FILTER CARD (Sesuai Gaya Filament Header) -->
        <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm ring-1 ring-gray-950/5 border border-gray-200/80">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                
                <!-- Left: Title & Live Summary -->
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-teal-50 border border-teal-200/60 flex items-center justify-center text-teal-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-extrabold text-gray-900 tracking-tight">Rekap Presensi Bulanan</h2>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                {{ $bulanNamaArray[$this->bulan] ?? '' }} {{ $this->tahun }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Menampilkan <span class="font-bold text-gray-900">{{ $totalSiswaCount }}</span> siswa terdaftar &bull; <span class="font-bold text-teal-700">{{ $totalMapelCount }}</span> mata pelajaran
                        </p>
                    </div>
                </div>

                <!-- Right: Action Export -->
                <div class="flex items-center gap-2 self-start lg:self-auto">
                    <button wire:click="exportExcel" type="button" 
                            class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel (.xls)
                    </button>
                </div>
            </div>

            <!-- Filter Controls Bar -->
            <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 items-end">
                <!-- Search Input -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Cari Siswa</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="searchSiswa" placeholder="Ketik nama siswa..." 
                               class="w-full text-xs font-semibold rounded-lg border-gray-300 bg-white py-2 pl-8 pr-3 text-gray-800 placeholder-gray-400 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 shadow-sm transition-all"/>
                        <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Select Jenjang -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Jenjang</label>
                    <select wire:model.live="jenjang" 
                            class="w-full text-xs font-semibold rounded-lg border-gray-300 bg-white py-2 px-3 text-gray-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 shadow-sm">
                        @foreach($this->jenjangOptions as $val => $lbl)
                            <option value="{{ $val }}">{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Kelompok -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Kelompok Belajar</label>
                    <select wire:model.live="kelompokId" 
                            class="w-full text-xs font-semibold rounded-lg border-gray-300 bg-white py-2 px-3 text-gray-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 shadow-sm">
                        <option value="">Semua Kelompok</option>
                        @foreach($data['allKelompoks'] as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelompok }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Bulan -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Bulan</label>
                    <select wire:model.live="bulan" 
                            class="w-full text-xs font-semibold rounded-lg border-gray-300 bg-white py-2 px-3 text-gray-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 shadow-sm">
                        @foreach($bulanNamaArray as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Tahun -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1">Tahun</label>
                    <select wire:model.live="tahun" 
                            class="w-full text-xs font-semibold rounded-lg border-gray-300 bg-white py-2 px-3 text-gray-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 shadow-sm">
                        @foreach([2024, 2025, 2026, 2027] as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- 2. STATUS LEGEND BAR (Clean Minimalist White) -->
        <div class="bg-white rounded-xl px-4 py-3 shadow-sm ring-1 ring-gray-950/5 border border-gray-200/80 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex flex-wrap items-center gap-2">
                <span class="font-bold text-gray-600 mr-1 text-[11px] uppercase tracking-wider">Status:</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> HADIR (H)
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-sky-50 text-sky-700 ring-1 ring-sky-600/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span> IZIN (I)
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 ring-1 ring-amber-600/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> SAKIT (S)
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-rose-50 text-rose-700 ring-1 ring-rose-600/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> ALPA (A)
                </span>
                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] font-medium text-gray-400 bg-gray-50 border border-gray-200">
                    - Belum Ada Sesi
                </span>
            </div>
            <span class="text-[11px] font-medium text-gray-400">
                *Matriks 4 pertemuan (P1–P4) per mapel + rekapitulasi otomatis
            </span>
        </div>

        <!-- 3. MATRIX DATA TABLE (Dominan Putih Sesuai Standar Filament) -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto max-h-[68vh]">
                <table class="w-full border-collapse text-center text-xs">
                    
                    <!-- THEAD -->
                    <thead class="sticky top-0 z-20 bg-gray-50/95 backdrop-blur-sm border-b border-gray-200">
                        
                        <!-- Row 1: Header Kelompok & Mapel -->
                        <tr class="divide-x divide-gray-200">
                            <!-- No -->
                            <th rowspan="2" class="sticky left-0 z-30 bg-gray-50 px-2.5 py-3 w-10 text-[11px] font-bold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                NO
                            </th>
                            <!-- Nama Siswa -->
                            <th rowspan="2" class="sticky left-10 z-30 bg-gray-50 px-4 py-3 min-w-[200px] text-left text-[11px] font-extrabold text-gray-900 uppercase tracking-wider border-b border-gray-200 shadow-[2px_0_4px_-2px_rgba(0,0,0,0.06)]">
                                NAMA SISWA
                            </th>
                            <!-- Kelas -->
                            <th rowspan="2" class="bg-gray-50 px-3 py-3 min-w-[100px] text-[11px] font-bold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                KELAS
                            </th>

                            <!-- Dynamic Mapels Header -->
                            @foreach($data['mapelList'] as $m)
                                <th colspan="4" class="px-3 py-2.5 bg-teal-50/80 text-teal-900 font-extrabold text-xs uppercase tracking-wide border-b border-teal-200/80">
                                    {{ strtoupper($m['nama']) }}
                                </th>
                            @endforeach

                            <!-- Rekapitulasi Header -->
                            <th colspan="4" class="px-3 py-2.5 bg-amber-50/90 text-amber-900 font-black text-xs uppercase tracking-wider border-b border-amber-200">
                                REKAPITULASI
                            </th>
                        </tr>

                        <!-- Row 2: Pertemuan 1-4 & Subheader Rekapitulasi -->
                        <tr class="divide-x divide-gray-200 text-[11px]">
                            @foreach($data['mapelList'] as $mId => $m)
                                @php
                                    $sessions = $data['sessionsByMapel'][$mId] ?? [];
                                @endphp
                                @for($p = 0; $p < 4; $p++)
                                    @php
                                        $jadwal = $sessions[$p] ?? null;
                                        $tglLabel = $jadwal ? \Illuminate\Support\Carbon::parse($jadwal->tanggal_sesi)->format('d/m') : '';
                                    @endphp
                                    <th class="w-12 px-1 py-2 font-bold text-gray-600 bg-white">
                                        <span>P{{ $p + 1 }}</span>
                                        @if($tglLabel)
                                            <span class="block text-[9px] font-normal text-gray-400 mt-0.5">{{ $tglLabel }}</span>
                                        @endif
                                    </th>
                                @endfor
                            @endforeach

                            <!-- Subhead Rekap (H, I, S, A) -->
                            <th class="w-10 px-1 py-2 font-black text-emerald-700 bg-emerald-50/50">H</th>
                            <th class="w-10 px-1 py-2 font-black text-sky-700 bg-sky-50/50">I</th>
                            <th class="w-10 px-1 py-2 font-black text-amber-700 bg-amber-50/50">S</th>
                            <th class="w-10 px-1 py-2 font-black text-rose-700 bg-rose-50/50">A</th>
                        </tr>
                    </thead>

                    <!-- TBODY -->
                    <tbody class="divide-y divide-gray-100 bg-white text-gray-800">
                        @forelse($data['siswas'] as $index => $s)
                            @php
                                $countH = 0;
                                $countI = 0;
                                $countS = 0;
                                $countA = 0;
                            @endphp
                            <tr class="hover:bg-teal-50/20 transition-colors divide-x divide-gray-100">
                                
                                <!-- No -->
                                <td class="sticky left-0 z-10 bg-white px-2.5 py-2.5 text-[11px] font-medium text-gray-400">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Nama Siswa -->
                                <td class="sticky left-10 z-10 bg-white px-4 py-2.5 text-left font-bold text-gray-900 whitespace-nowrap shadow-[2px_0_4px_-2px_rgba(0,0,0,0.06)]">
                                    <span>{{ $s->nama_lengkap }}</span>
                                </td>

                                <!-- Kelas -->
                                <td class="px-3 py-2.5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700">
                                        {{ $s->kelas ?: ($s->kategori_kelas ?: '-') }}
                                    </span>
                                </td>

                                <!-- Sesi Pertemuan Mapel -->
                                @foreach($data['mapelList'] as $mId => $m)
                                    @php
                                        $sessions = $data['sessionsByMapel'][$mId] ?? [];
                                    @endphp

                                    @for($p = 0; $p < 4; $p++)
                                        @php
                                            $jadwal = $sessions[$p] ?? null;
                                            $status = null;

                                            if ($jadwal) {
                                                $st = strtolower($data['presensis'][$s->id][$jadwal->id] ?? '');
                                                if ($st === 'hadir') {
                                                    $status = 'H';
                                                    $countH++;
                                                } elseif ($st === 'izin') {
                                                    $status = 'I';
                                                    $countI++;
                                                } elseif ($st === 'sakit') {
                                                    $status = 'S';
                                                    $countS++;
                                                } elseif ($st === 'alpa') {
                                                    $status = 'A';
                                                    $countA++;
                                                }
                                            }
                                        @endphp
                                        <td class="px-1 py-1.5 whitespace-nowrap">
                                            @if($status === 'H')
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-emerald-50 text-emerald-700 font-extrabold text-[11px] ring-1 ring-emerald-600/20">H</span>
                                            @elseif($status === 'I')
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-sky-50 text-sky-700 font-extrabold text-[11px] ring-1 ring-sky-600/20">I</span>
                                            @elseif($status === 'S')
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-amber-50 text-amber-700 font-extrabold text-[11px] ring-1 ring-amber-600/20">S</span>
                                            @elseif($status === 'A')
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-rose-50 text-rose-700 font-extrabold text-[11px] ring-1 ring-rose-600/20">A</span>
                                            @else
                                                <span class="text-gray-300 font-bold text-xs select-none">&bull;</span>
                                            @endif
                                        </td>
                                    @endfor
                                @endforeach

                                <!-- Rekapitulasi Cell -->
                                <td class="px-2 py-2 font-black text-emerald-700 bg-emerald-50/30 text-xs">
                                    {{ $countH }}
                                </td>
                                <td class="px-2 py-2 font-black text-sky-700 bg-sky-50/30 text-xs">
                                    {{ $countI }}
                                </td>
                                <td class="px-2 py-2 font-black text-amber-700 bg-amber-50/30 text-xs">
                                    {{ $countS }}
                                </td>
                                <td class="px-2 py-2 font-black text-rose-700 bg-rose-50/30 text-xs">
                                    {{ $countA }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $totalCols }}" class="py-12 px-4 text-center">
                                    <div class="max-w-xs mx-auto flex flex-col items-center justify-center">
                                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-900">Tidak ada siswa ditemukan</h4>
                                        <p class="text-xs text-gray-500 mt-1">Coba ubah kata kunci pencarian, jenjang, atau filter kelompok di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-panels::page>
