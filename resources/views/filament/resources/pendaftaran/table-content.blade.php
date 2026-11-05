<div class="w-full">
    @if($records->count() > 0)
        <!-- 1. DESKTOP VIEW (md ke atas: 4 Kolom Ramping) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 text-left text-xs">
                <thead class="bg-gray-50/80 text-gray-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4 w-[28%]">Calon Siswa</th>
                        <th class="py-3 px-4 w-[34%]">Program Belajar</th>
                        <th class="py-3 px-4 w-[18%]">Status & Tanggal</th>
                        <th class="py-3 px-4 w-[20%] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($records as $record)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <!-- Kolom 1: Calon Siswa -->
                            <td class="py-3 px-4 align-top">
                                <div class="font-bold text-gray-900 text-sm">
                                    {{ $record->nama_lengkap }}
                                </div>
                                @if($record->nama_panggilan)
                                    <div class="text-[11px] text-gray-400 font-medium">
                                        Panggilan: {{ $record->nama_panggilan }}
                                    </div>
                                @endif
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $record->asal_sekolah ?: '-' }}
                                </div>
                            </td>

                            <!-- Kolom 2: Program -->
                            <td class="py-3 px-4 align-top">
                                <div class="font-semibold text-gray-800 text-xs">
                                    {{ $record->program_clean }}
                                </div>
                                <x-mapel-badges :mapels="$record->mapel_list" />
                                
                                @if($record->paket_pendaftaran)
                                    <div class="text-[11px] text-gray-500 mt-1">
                                        {{ $record->paket_pendaftaran }}
                                        @if($record->ukuran_kaos)
                                            <span class="font-semibold text-gray-700">(Size: {{ $record->ukuran_kaos }})</span>
                                        @endif
                                    </div>
                                @endif
                            </td>

                            <!-- Kolom 3: Status & Tgl Masuk -->
                            <td class="py-3 px-4 align-top">
                                <div>
                                    <x-status-badge :status="$record->status_tindak_lanjut" />
                                </div>
                                <div class="text-[11px] text-gray-400 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $record->tanggal_masuk ? $record->tanggal_masuk->format('d M Y H:i') : '-' }}</span>
                                </div>
                            </td>

                            <!-- Kolom 4: Aksi -->
                            <td class="py-3 px-4 align-top text-right">
                                <div class="inline-flex justify-end">
                                    <x-aksi-pendaftar :record="$record" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 2. MOBILE VIEW (di bawah md: Cards Tanpa Scroll Horizontal) -->
        <div class="md:hidden flex flex-col gap-3 p-3 bg-gray-50/50">
            @foreach($records as $record)
                <div class="bg-white rounded-xl border border-gray-200/90 p-4 shadow-sm flex flex-col gap-2.5 max-w-full overflow-hidden">
                    
                    <!-- Baris Atas: Nama & Status Badge -->
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <h3 class="font-bold text-gray-900 text-sm truncate">
                                {{ $record->nama_lengkap }}
                            </h3>
                            @if($record->nama_panggilan)
                                <div class="text-[11px] text-gray-400 font-medium">
                                    Panggilan: {{ $record->nama_panggilan }}
                                </div>
                            @endif
                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                {{ $record->asal_sekolah ?: '-' }}
                            </div>
                        </div>

                        <div class="shrink-0">
                            <x-status-badge :status="$record->status_tindak_lanjut" />
                        </div>
                    </div>

                    <!-- Baris Tengah: Program & Mapel -->
                    <div class="pt-2 border-t border-gray-100 flex flex-col gap-1">
                        <div class="text-xs font-semibold text-gray-800 leading-snug">
                            {{ $record->program_clean }}
                        </div>
                        <x-mapel-badges :mapels="$record->mapel_list" />

                        @if($record->paket_pendaftaran)
                            <div class="text-[11px] text-gray-500 mt-1">
                                {{ $record->paket_pendaftaran }}
                                @if($record->ukuran_kaos)
                                    <span class="font-semibold text-gray-700">(Size: {{ $record->ukuran_kaos }})</span>
                                @endif
                            </div>
                        @endif

                        <div class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Daftar: {{ $record->tanggal_masuk ? $record->tanggal_masuk->format('d M Y H:i') : '-' }}</span>
                        </div>
                    </div>

                    <!-- Baris Bawah: Aksi -->
                    <div class="pt-2 border-t border-gray-100 flex items-center justify-between gap-2">
                        <x-aksi-pendaftar :record="$record" />
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="py-12 px-4 text-center">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <div class="text-sm font-semibold text-gray-600">Belum ada calon siswa yang terdaftar</div>
            <div class="text-xs text-gray-400 mt-1">Data pendaftaran dari formulir publik akan tampil otomatis di sini.</div>
        </div>
    @endif
</div>

