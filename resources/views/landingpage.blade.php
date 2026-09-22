@extends('layouts.app')

@section('title', 'Pelita Ilmu Bimbel - Raih Prestasimu')

@section('content')
    <!-- HERO SECTION -->
    <section id="beranda" class="relative bg-primary py-16 lg:py-24 border-b-2 border-black overflow-hidden bubble-bg">
        <!-- Decorative Background Circles & Floating Dots -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -left-16 h-72 w-72 rounded-full border-4 border-white/20 animate-pulse"></div>
            <div class="absolute top-8 left-8 h-40 w-40 rounded-full border-2 border-dashed border-white/30 animate-spin-slow"></div>
            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full border-4 border-highlight/30"></div>
            <div class="absolute bottom-10 right-10 h-56 w-56 rounded-full border-2 border-dashed border-highlight/35"></div>
            <div class="absolute top-6 left-1/2 -translate-x-1/2 flex gap-3">
                <span class="h-2.5 w-2.5 rounded-full bg-white/40 animate-ping"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-white/60"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-white/40"></span>
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            

            <h1 class="font-headline text-3xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-white uppercase tracking-tight drop-shadow-md">
                DAFTAR SEKARANG 
            </h1>

            <div class="my-6 flex justify-center hover:scale-105 transition-transform duration-300">
                <img
                    src="{{ asset('images/logo-bimbel-removebg.png') }}"
                    alt="Logo Bimbel Pelita Ilmu"
                    class="h-44 w-44 sm:h-60 sm:w-60 object-contain drop-shadow-2xl animate-float"
                    onerror="this.src='{{ asset('images/logo-bimbel.png') }}'"
                >
            </div>

            <h2 class="font-headline text-2xl sm:text-4xl font-extrabold text-highlight uppercase tracking-wide drop-shadow-md">
                DAN RAIH PRESTASIMU!
            </h2>

            <p class="mt-4 font-body text-white/90 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Bimbingan belajar intensif  dengan tentor terbaik di Semarang.
            </p>

            <!-- Anti-Metal Hero CTA Button -->
            <div class="mt-8 flex justify-center">
                <a id="hero-cta" href="{{ route('pendaftaran') }}" class="group/btn relative inline-flex h-14 min-w-[290px] items-center justify-center overflow-hidden rounded-2xl bg-highlight shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all border-2 border-black">
                    <span class="relative z-20 font-headline font-black text-base text-void group-hover/btn:text-highlight pl-14 pr-6 transition-colors duration-300 uppercase tracking-wider">DAFTAR BIMBEL SEKARANG</span>
                    <span aria-hidden="true" class="absolute bottom-1 left-1 top-1 z-10 flex w-10 items-center justify-center overflow-hidden rounded-xl bg-[#193836] transition-[width] duration-300 ease-[cubic-bezier(0.65,0,0.35,1)] group-hover/btn:w-[calc(100%-0.5rem)]">
                        <svg width="14" height="16" viewBox="0 0 14 16" class="shrink-0 overflow-visible">
                            <g fill="#FFE500">
                                <circle cx="2" cy="2" r="1" />
                                <circle cx="5" cy="5" r="1" />
                                <circle cx="8" cy="8" r="1" />
                                <circle cx="5" cy="11" r="1" />
                                <circle cx="2" cy="14" r="1" />
                                <circle cx="6" cy="2" r="1" />
                                <circle cx="9" cy="5" r="1" />
                                <circle cx="12" cy="8" r="1" />
                                <circle cx="9" cy="11" r="1" />
                                <circle cx="6" cy="14" r="1" />
                            </g>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION FASILITAS & KEUNGGULAN (Termasuk Relokasi Cards Ruangan & Lokasi) -->
    <section id="keunggulan" class="relative bg-[#193836] text-white py-16 lg:py-20 border-b-2 border-black">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto">
                <span class="font-headline text-xs sm:text-sm font-extrabold uppercase text-highlight tracking-widest block mb-1">
                    FASILITAS & KEUNGGULAN
                </span>
                <h2 class="font-headline text-3xl sm:text-4xl font-extrabold text-white mt-2">
                    Suasana Belajar Kondusif & Berkelanjutan
                </h2>
            </div>

            <!-- RELOCATED CARDS GRID (Ruang Kelas & Lokasi Strategis) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Ruang Kelas Card -->
                <div class="bg-canvas rounded-3xl p-6 border-2 border-black shadow-[4px_4px_0px_0px_rgba(255,229,0,1)] text-void hover:-translate-y-1 transition-transform">
                    <div class="flex items-center gap-4 border-b border-black/10 pb-4">
                        <div class="h-12 w-12 rounded-2xl bg-highlight flex items-center justify-center border-2 border-black shrink-0 shadow-sm">
                            <img src="{{ asset('images/kursi.png') }}" alt="Kursi" class="h-7 w-7 object-contain" onerror="this.src='';this.alt='🏫';">
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-[#193836]">Ruang Kelas Nyaman & Ber-AC</h3>
                            <p class="font-subtitle text-xs text-primary font-bold">Max 4–6 Siswa / Kelompok</p>
                        </div>
                    </div>
                    <div class="mt-4 rounded-2xl overflow-hidden border-2 border-black shadow-inner">
                        <img
                            src="{{ asset('images/ruang.jpg') }}"
                            alt="Suasana Belajar Pelita Ilmu"
                            class="h-64 w-full object-cover hover:scale-105 transition-transform duration-500"
                            onerror="this.src='{{ asset('images/WhatsApp_Image_2026-08-27_at_7.08.24_PM.jpeg') }}'"
                        >
                    </div>
                    <p class="mt-4 font-body text-xs text-void/80 leading-relaxed">
                        Fasilitas ruang belajar ber-AC dengan meja & kursi ergonomis untuk fokus belajar maksimal tanpa kebisingan.
                    </p>
                </div>

                <!-- Lokasi Card -->
                <div class="bg-canvas rounded-3xl p-6 border-2 border-black shadow-[4px_4px_0px_0px_rgba(255,229,0,1)] text-void hover:-translate-y-1 transition-transform">
                    <div class="flex items-center gap-4 border-b border-black/10 pb-4">
                        <a href="https://maps.app.goo.gl/4mZR8LgBXbN69YL4A" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 group">
                            <div class="h-12 w-12 rounded-2xl bg-primary flex items-center justify-center border-2 border-black shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                                <img src="{{ asset('images/gps.png') }}" alt="GPS Pin" class="h-7 w-7 object-contain" onerror="this.src='';this.alt='📍';">
                            </div>
                            <div>
                                <h3 class="font-headline text-lg font-bold text-[#193836] group-hover:text-primary transition-colors">Lokasi Strategis & Mudah Ditempuh</h3>
                                <p class="font-subtitle text-xs text-primary font-bold">Manyaran, Semarang Barat ➔</p>
                            </div>
                        </a>
                    </div>
                    <div class="mt-4 rounded-2xl overflow-hidden border-2 border-black shadow-inner">
                        <img
                            src="{{ asset('images/lokasi.jpg') }}"
                            alt="Lokasi Bimbel Pelita Ilmu"
                            class="h-64 w-full object-cover hover:scale-105 transition-transform duration-500"
                            onerror="this.src='{{ asset('images/WhatsApp_Image_2026-08-27_at_7.08.25_PM.jpeg') }}'"
                        >
                    </div>
                    <p class="mt-4 font-body text-xs text-void/80 leading-relaxed">
                        Terletak di lokasi strategis kawasan Manyaran yang aman, nyaman, dan mudah dijangkau dari sekolah-sekolah utama Semarang Barat.
                    </p>
                </div>
            </div>

            <!-- Feature Icons Grid (6 Keunggulan Utama) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border-2 border-black bg-highlight text-void font-bold">🎓</div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-white">Pengajar Berpengalaman</h3>
                        <p class="font-body text-xs text-white/80 mt-1">Lulusan S1 & S2 PTN ternama berdedikasi tinggi.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border-2 border-black bg-highlight text-void font-bold">💡</div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-white">Active & Fun Learning</h3>
                        <p class="font-body text-xs text-white/80 mt-1">Metode interaktif dua arah tanpa rasa jenuh.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border-2 border-black bg-highlight text-void font-bold">⭐</div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-white">Pendidikan Berkarakter</h3>
                        <p class="font-body text-xs text-white/80 mt-1">Menanamkan kedisiplinan dan moral baik.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border-2 border-black bg-highlight text-void font-bold">💬</div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-white">Komunikatif & Terbuka</h3>
                        <p class="font-body text-xs text-white/80 mt-1">Laporan perkembangan rutin kepada orang tua.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border-2 border-black bg-highlight text-void font-bold">📶</div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-white">Fasilitas Lengkap & Wi-Fi</h3>
                        <p class="font-body text-xs text-white/80 mt-1">Ruang ber-AC & akses internet cepat untuk tugas.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border-2 border-black bg-highlight text-void font-bold">🏷️</div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-white">Harga Terjangkau</h3>
                        <p class="font-body text-xs text-white/80 mt-1">Mulai Rp 195.000/bulan dengan kualitas terjamin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION PROGRAM & HARGA -->
    <section id="program" class="bg-canvas py-16 lg:py-24 border-b-2 border-black">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-bold text-[#193836]">
                        Program Lengkap Bimbel Pelita Ilmu
                    </h2>
                    <p class="mt-2 font-body text-sm sm:text-base text-void/70">
                        Kelompok mini 4–6 siswa per kelas agar perhatian tentor merata.
                    </p>
                </div>
                <span class="font-subtitle text-xs sm:text-sm font-bold text-[#193836] shrink-0 self-start md:self-auto flex items-center gap-1.5">
                    ⏱️ Durasi 90 Menit Tiap Sesi
                </span>
            </div>

            <!-- Grid 4 Card Program -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                
                <!-- CARD TK -->
                <div class="flex flex-col rounded-[32px] overflow-hidden border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] bg-white hover:-translate-y-1 transition-transform">
                    <div class="bg-[#193836] p-6 text-white flex items-center justify-between min-h-[108px] border-b-2 border-black">
                        <div>
                            <span class="text-[10px] font-subtitle font-bold text-highlight uppercase tracking-wider block mb-1">PRASEKOLAH</span>
                            <h3 class="font-headline text-2xl font-bold text-white">Jenjang TK</h3>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center border-2 border-black shrink-0">
                            TK
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="pb-3 border-b border-stone-200">
                                <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Fokus Pembelajaran:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">Calistung (Baca, Tulis, Hitung), Mengaji, B. Inggris Dasar</p>
                            </div>
                            <ul class="space-y-2 font-body text-xs text-void/85">
                                <li class="flex items-center gap-2"><span class="text-primary font-bold">✓</span> 3x Seminggu @90 menit</li>
                                <li class="flex items-center gap-2"><span class="text-primary font-bold">✓</span> Flashcard & Game Edukasi</li>
                                <li class="flex items-center gap-2"><span class="text-primary font-bold">✓</span> Metode Fun & Friendly</li>
                            </ul>
                        </div>
                        <div class="pt-6">
                            <p class="font-headline text-2xl font-extrabold text-void mb-3">Rp 195.000 <span class="text-xs font-normal font-body text-void/60">/bln</span></p>
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center py-3 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">PILIH PAKET TK ➔</a>
                        </div>
                    </div>
                </div>

                <!-- CARD SD -->
                <div class="flex flex-col rounded-[32px] overflow-hidden border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] bg-white hover:-translate-y-1 transition-transform">
                    <div class="bg-primary p-6 text-white flex items-center justify-between min-h-[108px] border-b-2 border-black">
                        <div>
                            <span class="text-[10px] font-subtitle font-bold text-highlight uppercase tracking-wider block mb-1">SEKOLAH DASAR</span>
                            <h3 class="font-headline text-2xl font-bold text-white">Jenjang SD</h3>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center border-2 border-black shrink-0">
                            SD
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="pb-3 border-b border-stone-200">
                                <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Fokus Pembelajaran:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">Semua Mapel Pokok (Tematik, MTK, IPA, B. Indo, B. Ing)</p>
                            </div>
                            <ul class="space-y-2 font-body text-xs text-void/85">
                                <li class="flex items-center gap-2"><span class="text-primary font-bold">✓</span> 3x Seminggu @90 menit</li>
                                <li class="flex items-center gap-2"><span class="text-primary font-bold">✓</span> Bimbingan PR Sekolah</li>
                                <li class="flex items-center gap-2"><span class="text-primary font-bold">✓</span> Persiapan PTS / PAS</li>
                            </ul>
                        </div>
                        <div class="pt-6">
                            <p class="font-headline text-2xl font-extrabold text-void mb-3">Rp 195.000 <span class="text-xs font-normal font-body text-void/60">/bln</span></p>
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center py-3 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">PILIH PAKET SD ➔</a>
                        </div>
                    </div>
                </div>

                <!-- CARD SMP -->
                <div class="flex flex-col rounded-[32px] overflow-hidden border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] bg-white hover:-translate-y-1 transition-transform">
                    <div class="bg-[#193836] p-6 text-white flex items-center justify-between min-h-[108px] border-b-2 border-black">
                        <div>
                            <span class="text-[10px] font-subtitle font-bold text-highlight uppercase tracking-wider block mb-1">MENENGAH PERTAMA</span>
                            <h3 class="font-headline text-2xl font-bold text-white">Jenjang SMP</h3>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center border-2 border-black shrink-0">
                            SMP
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="pb-3 border-b border-stone-200">
                                <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Mapel Pilihan:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">Matematika, IPA, B. Inggris, B. Indo, IPS</p>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs"><span class="font-subtitle font-bold">Paket 3 Mapel</span><span class="font-headline font-bold bg-highlight px-2 py-0.5 rounded border border-black">Rp 240k/bln</span></div>
                                <div class="flex items-center justify-between text-xs"><span class="font-subtitle font-bold">Paket 4 Mapel</span><span class="font-headline font-bold bg-highlight px-2 py-0.5 rounded border border-black">Rp 290k/bln</span></div>
                                <div class="flex items-center justify-between text-xs"><span class="font-subtitle font-bold">Paket 5 Mapel</span><span class="font-headline font-bold bg-highlight px-2 py-0.5 rounded border border-black">Rp 340k/bln</span></div>
                            </div>
                        </div>
                        <div class="pt-6">
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center py-3 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">PILIH PAKET SMP ➔</a>
                        </div>
                    </div>
                </div>

                <!-- CARD SMA -->
                <div class="flex flex-col rounded-[32px] overflow-hidden border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] bg-white hover:-translate-y-1 transition-transform">
                    <div class="bg-primary p-6 text-white flex items-center justify-between min-h-[108px] border-b-2 border-black">
                        <div>
                            <span class="text-[10px] font-subtitle font-bold text-highlight uppercase tracking-wider block mb-1">MENENGAH ATAS</span>
                            <h3 class="font-headline text-2xl font-bold text-white">SMA & UTBK</h3>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center border-2 border-black shrink-0">
                            SMA
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="pb-3 border-b border-stone-200">
                                <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Mapel Pilihan:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">Matematika Wajib/Lanjut, Fisika, Kimia, Biologi, B. Indo, B. Ing, Ekonomi</p>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs"><span class="font-subtitle font-bold">Paket 4 Mapel</span><span class="font-headline font-bold bg-highlight px-2 py-0.5 rounded border border-black">Rp 350k/bln</span></div>
                                <div class="flex items-center justify-between text-xs"><span class="font-subtitle font-bold">Paket 5 Mapel</span><span class="font-headline font-bold bg-highlight px-2 py-0.5 rounded border border-black">Rp 400k/bln</span></div>
                            </div>
                        </div>
                        <div class="pt-6">
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center py-3 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">PILIH PAKET SMA ➔</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA & DAFTAR SECTION -->
    <section id="daftar" class="bg-canvas py-16 lg:py-24 border-b-2 border-black">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-[#193836] via-[#122A28] to-[#0D1F1D] text-white rounded-[32px] p-8 sm:p-12 lg:p-16 overflow-hidden border-2 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                <!-- Decorative Glow Circles & Ambient Aura -->
                <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-primary/40 pointer-events-none blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-highlight/25 pointer-events-none blur-3xl"></div>
                <div class="absolute top-1/2 right-10 -translate-y-1/2 w-64 h-64 rounded-full border-8 border-white/10 pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl space-y-6">
                    <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                        Siap Antarkan Putra-Putri Anda Meraih Prestasi Terbaik?
                    </h2>
                    <p class="font-body text-white/90 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Daftarkan putra-putri Anda hari ini di Bimbel Pelita Ilmu. Dapatkan bimbingan intensif 4-6 siswa per kelompok dengan pengajar S1/S2 berdedikasi tinggi!
                    </p>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4">
                        <a href="{{ route('pendaftaran') }}" class="inline-flex h-14 items-center justify-center rounded-2xl bg-highlight text-void font-headline font-black text-sm uppercase tracking-wider px-8 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                            DAFTAR SEKARANG SECARA ONLINE ➔
                        </a>
                        <a href="https://wa.me/6289624601717?text=Halo%20Admin%20Pelita%20Ilmu,%20saya%20ingin%20bertanya%20mengenai%20bimbingan%20belajar" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-white text-primary font-headline font-black text-sm rounded-2xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                            💬 Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
