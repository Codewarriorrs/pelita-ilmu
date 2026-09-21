@extends('layouts.app')

@section('title', 'Pelita Ilmu Bimbel - Raih Prestasimu')

@section('content')
        <!-- HERO SECTION -->
        <section id="beranda" class="relative bg-primary py-16 lg:py-20 border-b border-[#193836]/10 overflow-hidden bubble-bg">

            <!-- Decorative Background -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-16 -left-16 h-72 w-72 rounded-full border-4 border-white/30"></div>
                <div class="absolute top-8 left-8 h-40 w-40 rounded-full border-2 border-dashed border-white/35"></div>
                <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full border-4 border-highlight/30"></div>
                <div class="absolute bottom-10 right-10 h-56 w-56 rounded-full border-2 border-dashed border-highlight/35"></div>
                <svg class="absolute bottom-8 left-1/4 h-24 w-36 text-white/30 hidden lg:block" fill="none" viewBox="0 0 140 80" stroke="currentColor" stroke-width="2">
                    <line x1="0" y1="15" x2="140" y2="15" stroke-dasharray="6 6" />
                    <line x1="0" y1="35" x2="140" y2="35" stroke-dasharray="6 6" />
                    <line x1="0" y1="55" x2="140" y2="55" stroke-dasharray="6 6" />
                    <line x1="0" y1="75" x2="140" y2="75" stroke-dasharray="6 6" />
                </svg>
                <svg class="absolute top-8 right-1/4 h-28 w-28 text-highlight/30 hidden lg:block" fill="none" viewBox="0 0 100 100" stroke="currentColor" stroke-width="2">
                    <line x1="0" y1="20" x2="80" y2="100" stroke-dasharray="4 4" />
                    <line x1="20" y1="0" x2="100" y2="80" stroke-dasharray="4 4" />
                    <line x1="40" y1="0" x2="100" y2="60" stroke-dasharray="4 4" />
                </svg>
                <div class="absolute top-6 left-1/2 -translate-x-1/2 flex gap-3">
                    <span class="h-2.5 w-2.5 rounded-full bg-white/40"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-white/40"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-white/40"></span>
                </div>
            </div>

            <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                    <!-- LEFT COLUMN CARD: Ruang Kelas -->
                    <div class="order-2 lg:order-1 lg:col-span-3">
                        <div class="bg-white rounded-3xl p-5 shadow-xl text-void border-2 border-black">
                            <div class="flex items-center gap-3 border-b border-[#193836]/10 pb-4">
                                <img src="{{ asset('images/kursi.png') }}" alt="Kursi" class="h-10 w-10 shrink-0 object-contain hover:scale-110 transition-transform" onerror="this.src='';this.alt='🏫';this.className='text-2xl'">
                                <div>
                                    <h3 class="font-headline text-base font-bold text-[#193836]">Ruang Kelas</h3>
                                    <p class="font-subtitle text-xs text-primary">Nyaman & Terang</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-2xl bg-primary/5 p-2 border border-primary/20 shadow-sm">
                                <img
                                    src="{{ asset('images/ruang.jpg') }}"
                                    alt="Suasana Belajar Pelita Ilmu"
                                    class="h-72 w-full object-cover rounded-xl"
                                    onerror="this.src='{{ asset('images/WhatsApp_Image_2026-08-27_at_7.08.24_PM.jpeg') }}'"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- CENTER COLUMN: Main Hero -->
                    <div class="order-1 lg:order-2 text-center lg:col-span-6 px-2">
                        <h1 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-white uppercase">
                            DAFTAR SEKARANG KE
                        </h1>
                        <div class="my-4 flex justify-center">
                            <img
                                src="{{ asset('images/logo-bimbel-removebg.png') }}"
                                alt="Logo Bimbel Pelita Ilmu"
                                class="h-44 w-44 sm:h-52 sm:w-52 object-contain"
                                onerror="this.src='{{ asset('images/logo-bimbel.png') }}'"
                            >
                        </div>
                        <h2 class="font-headline text-xl sm:text-3xl font-bold text-highlight uppercase mt-2">
                            DAN RAIH PRESTASIMU!
                        </h2>

                        <!-- Anti-Metal Hero CTA Button -->
                        <div class="mt-8 flex justify-center">
                            <a id="hero-cta" href="{{ route('pendaftaran') }}" class="group/btn relative inline-flex h-14 min-w-[280px] items-center justify-center overflow-hidden rounded-2xl bg-highlight shadow-xl active:scale-95 transition-all border-2 border-black">
                                <span class="relative z-20 font-headline font-extrabold text-base text-void group-hover/btn:text-highlight pl-14 pr-6 transition-colors duration-300">DAFTAR BIMBEL SEKARANG</span>
                                <span aria-hidden="true" class="absolute bottom-1 left-1 top-1 z-10 flex w-10 items-center justify-center overflow-hidden rounded-xl bg-[#193836] transition-[width] duration-300 ease-[cubic-bezier(0.65,0,0.35,1)] group-hover/btn:w-[calc(100%-0.5rem)]">
                                    <svg width="14" height="16" viewBox="0 0 14 16" class="shrink-0 overflow-visible">
                                        <g fill="#FFE500">
                                            <circle cx="2" cy="2" r="1" class="bd-dot" style="animation-delay:0s"/>
                                            <circle cx="5" cy="5" r="1" class="bd-dot" style="animation-delay:0.05s"/>
                                            <circle cx="8" cy="8" r="1" class="bd-dot" style="animation-delay:0.1s"/>
                                            <circle cx="5" cy="11" r="1" class="bd-dot" style="animation-delay:0.15s"/>
                                            <circle cx="2" cy="14" r="1" class="bd-dot" style="animation-delay:0.2s"/>
                                            <circle cx="6" cy="2" r="1" class="bd-dot" style="animation-delay:0.05s"/>
                                            <circle cx="9" cy="5" r="1" class="bd-dot" style="animation-delay:0.1s"/>
                                            <circle cx="12" cy="8" r="1" class="bd-dot" style="animation-delay:0.15s"/>
                                            <circle cx="9" cy="11" r="1" class="bd-dot" style="animation-delay:0.2s"/>
                                            <circle cx="6" cy="14" r="1" class="bd-dot" style="animation-delay:0.25s"/>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN CARD: Lokasi -->
                    <div class="order-3 lg:col-span-3">
                        <div class="bg-white rounded-3xl p-5 shadow-xl text-void border-2 border-black">
                            <div class="border-b border-[#193836]/10 pb-4">
                                <a href="https://maps.app.goo.gl/4mZR8LgBXbN69YL4A" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 group">
                                    <img src="{{ asset('images/gps.png') }}" alt="Red Location Pin" class="h-10 w-10 shrink-0 object-contain hover:scale-110 transition-transform" onerror="this.src='';this.alt='📍';this.className='text-2xl'">
                                    <div>
                                        <h3 class="font-headline text-base font-bold text-[#193836]">Lokasi</h3>
                                        <p class="font-subtitle text-xs text-primary">Manyaran, Semarang Barat</p>
                                    </div>
                                </a>
                            </div>
                            <div class="mt-4 rounded-2xl bg-primary/5 p-2 border border-primary/20 shadow-sm">
                                <img
                                    src="{{ asset('images/lokasi.jpg') }}"
                                    alt="Lokasi Bimbel Pelita Ilmu"
                                    class="h-72 w-full object-cover rounded-xl"
                                    onerror="this.src='{{ asset('images/WhatsApp_Image_2026-08-27_at_7.08.25_PM.jpeg') }}'"
                                >
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- FEATURE BAR SECTION -->
        <section class="relative bg-[#193836] text-white py-10 lg:py-12 border-b border-white/10">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <!-- Row 1: 3 features -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 pb-8 lg:border-b lg:border-white/15">

                    <!-- Pengajar Berpengalaman -->
                    <div class="group flex items-center gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-highlight transition-all lg:border-r-0 lg:rounded-none lg:bg-transparent lg:border-0 lg:border-b-0 lg:p-0 lg:pr-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-highlight group-hover:bg-highlight group-hover:text-void transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-subtitle text-base font-bold text-white group-hover:text-highlight transition-colors">Pengajar Berpengalaman</h3>
                            <p class="font-body text-xs text-white/80 mt-0.5">Pengajar berpendidikan S1 & S2 berkualitas tinggi.</p>
                        </div>
                    </div>

                    <!-- Active & Fun Learning -->
                    <div class="group flex items-center gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-highlight transition-all lg:border-r-0 lg:rounded-none lg:bg-transparent lg:border-0 lg:p-0 lg:pr-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-highlight group-hover:bg-highlight group-hover:text-void transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-subtitle text-base font-bold text-white group-hover:text-highlight transition-colors">Active & Fun Learning</h3>
                            <p class="font-body text-xs text-white/80 mt-0.5">Belajar dua arah, aktif, dan tidak membosankan.</p>
                        </div>
                    </div>

                    <!-- Pendidikan Berkarakter -->
                    <div class="group flex items-center gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-highlight transition-all lg:rounded-none lg:bg-transparent lg:border-0 lg:p-0">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-highlight group-hover:bg-highlight group-hover:text-void transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-subtitle text-base font-bold text-white group-hover:text-highlight transition-colors">Pendidikan Berkarakter</h3>
                            <p class="font-body text-xs text-white/80 mt-0.5">Menanamkan kedisiplinan dan moral baik siswa.</p>
                        </div>
                    </div>
                </div>

                <!-- Row 2: 3 features -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 pt-8">

                    <!-- Komunikatif & Terbuka -->
                    <div class="group flex items-center gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-highlight transition-all lg:border-r-0 lg:rounded-none lg:bg-transparent lg:border-0 lg:p-0 lg:pr-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-highlight group-hover:bg-highlight group-hover:text-void transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-subtitle text-base font-bold text-white group-hover:text-highlight transition-colors">Komunikatif & Terbuka</h3>
                            <p class="font-body text-xs text-white/80 mt-0.5">Pendekatan hangat kepada siswa dan orang tua.</p>
                        </div>
                    </div>

                    <!-- Area Belajar Nyaman -->
                    <div class="group flex items-center gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-highlight transition-all lg:border-r-0 lg:rounded-none lg:bg-transparent lg:border-0 lg:p-0 lg:pr-6">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-highlight group-hover:bg-highlight group-hover:text-void transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-subtitle text-base font-bold text-white group-hover:text-highlight transition-colors">Area Belajar Nyaman</h3>
                            <p class="font-body text-xs text-white/80 mt-0.5">Ruang kelas tenang, ber-AC, & tersedia Wi-Fi gratis.</p>
                        </div>
                    </div>

                    <!-- Harga Sangat Terjangkau -->
                    <div class="group flex items-center gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-highlight transition-all lg:rounded-none lg:bg-transparent lg:border-0 lg:p-0">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 bg-white/10 text-highlight group-hover:bg-highlight group-hover:text-void transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-subtitle text-base font-bold text-white group-hover:text-highlight transition-colors">Harga Sangat Terjangkau</h3>
                            <p class="font-body text-xs text-white/80 mt-0.5">Mulai Rp195.000/bulan kualitas pendidikan terjamin.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- PROGRAM SECTION -->
        <section id="program" class="bg-canvas py-16 lg:py-24 border-b border-[#193836]/10">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                    <div>
                        <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-bold text-[#193836]">
                            Program Lengkap Bimbel Pelita Ilmu
                        </h2>
                        <p class="mt-2 font-body text-sm sm:text-base text-void/70">
                            Satu kelas berkapasitas mini 4–6 siswa agar perhatian tentor merata ke seluruh anak.
                        </p>
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-white px-4 py-2 text-primary font-subtitle text-xs sm:text-sm font-bold shadow-sm shrink-0 self-start md:self-auto">
                        <svg class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Durasi 90 Menit Tiap Sesi</span>
                    </div>
                </div>

                <!-- Program Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">

                    <!-- CARD 1: Jenjang TK -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-[#193836] text-white p-6 relative border-b-2 border-black flex items-center justify-between min-h-[108px]">
                                <div class="flex-1 pr-2">
                                    <div class="h-8 flex items-center">
                                        <span class="text-[10px] font-subtitle font-bold text-highlight uppercase leading-tight tracking-wider">TINGKAT PRASEKOLAH</span>
                                    </div>
                                    <h3 class="font-headline text-2xl font-bold text-white">Jenjang TK</h3>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center shrink-0 border border-black shadow-sm">
                                    TK
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="pb-4 border-b border-[#193836]/10">
                                    <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Fokus Pembelajaran:</p>
                                    <p class="font-body text-xs text-void/80 leading-relaxed">
                                        Calistung (Membaca, Menulis, Berhitung), Mengaji, & Bahasa Inggris Dasar
                                    </p>
                                </div>
                                <ul class="py-2 space-y-2.5 font-body text-xs text-void/85 border-b border-[#193836]/10">
                                    <li class="flex items-center gap-2.5"><span class="text-primary font-bold">✓</span><span>3x Seminggu @90 menit</span></li>
                                    <li class="flex items-center gap-2.5"><span class="text-primary font-bold">✓</span><span>Flashcard & Game Edukasi</span></li>
                                    <li class="flex items-center gap-2.5"><span class="text-primary font-bold">✓</span><span>Metode Ramah Anak</span></li>
                                </ul>
                                <div class="py-2">
                                    <span class="text-[10px] font-subtitle font-bold text-void/60 uppercase tracking-wider block">BIAYA</span>
                                    <div class="font-headline text-2xl font-bold text-void mt-0.5">
                                        Rp 195.000 <span class="text-xs font-normal font-body text-void/70">/ bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CTA Button — Neobrutalist Style (dipertahankan) -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET TK &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 2: Jenjang SD -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-primary text-white p-6 relative border-b-2 border-black flex items-center justify-between min-h-[108px]">
                                <div class="flex-1 pr-2">
                                    <div class="h-8 flex items-center">
                                        <span class="text-[10px] font-subtitle font-bold text-highlight uppercase leading-tight tracking-wider">SEKOLAH DASAR</span>
                                    </div>
                                    <h3 class="font-headline text-2xl font-bold text-white">Jenjang SD</h3>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center shrink-0 border border-black shadow-sm">
                                    SD
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="pb-4 border-b border-[#193836]/10">
                                    <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Fokus Pembelajaran:</p>
                                    <p class="font-body text-xs text-void/80 leading-relaxed">
                                        Semua Mapel Pokok (Tematik, Matematika, IPA, B. Indonesia, B. Inggris)
                                    </p>
                                </div>
                                <ul class="py-2 space-y-2.5 font-body text-xs text-void/85 border-b border-[#193836]/10">
                                    <li class="flex items-center gap-2.5"><span class="text-primary font-bold">✓</span><span>3x Seminggu @90 menit</span></li>
                                    <li class="flex items-center gap-2.5"><span class="text-primary font-bold">✓</span><span>Pendampingan PR Sekolah</span></li>
                                    <li class="flex items-center gap-2.5"><span class="text-primary font-bold">✓</span><span>Persiapan Ulangan / PTS / PAS</span></li>
                                </ul>
                                <div class="py-2">
                                    <span class="text-[10px] font-subtitle font-bold text-void/60 uppercase tracking-wider block">BIAYA</span>
                                    <div class="font-headline text-2xl font-bold text-void mt-0.5">
                                        Rp 195.000 <span class="text-xs font-normal font-body text-void/70">/ bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET SD &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 3: Jenjang SMP -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-[#193836] text-white p-6 relative border-b-2 border-black flex items-center justify-between min-h-[108px]">
                                <div class="flex-1 pr-2">
                                    <div class="h-8 flex items-center">
                                        <span class="text-[10px] font-subtitle font-bold text-highlight uppercase leading-tight tracking-wider">SEKOLAH MENENGAH PERTAMA</span>
                                    </div>
                                    <h3 class="font-headline text-2xl font-bold text-white">Jenjang SMP</h3>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center shrink-0 border border-black shadow-sm">
                                    SMP
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="pb-4 border-b border-[#193836]/10">
                                    <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Mapel Pilihan:</p>
                                    <p class="font-body text-xs text-void/80 leading-relaxed">
                                        Matematika, IPA, Inggris, B. Indo, IPS, TKA
                                    </p>
                                </div>
                                <div class="py-2 divide-y divide-[#193836]/10 border-b border-[#193836]/10">
                                    <div class="flex items-center justify-between py-2.5 text-xs">
                                        <span class="font-subtitle font-bold text-void/90">Paket 3 Mapel</span>
                                        <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs border border-black">Rp 240k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between py-2.5 text-xs">
                                        <span class="font-subtitle font-bold text-void/90">Paket 4 Mapel</span>
                                        <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs border border-black">Rp 290k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between py-2.5 text-xs">
                                        <span class="font-subtitle font-bold text-void/90">Paket 5 Mapel</span>
                                        <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs border border-black">Rp 340k/bln</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-2">
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET SMP &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 4: SMA & UTBK -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-primary text-white p-6 relative border-b-2 border-black flex items-center justify-between min-h-[108px]">
                                <div class="flex-1 pr-2">
                                    <div class="h-8 flex items-center">
                                        <span class="text-[10px] font-subtitle font-bold text-highlight uppercase leading-tight tracking-wider">SEKOLAH MENENGAH ATAS</span>
                                    </div>
                                    <h3 class="font-headline text-2xl font-bold text-white">SMA & UTBK</h3>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-black text-xs flex items-center justify-center shrink-0 border border-black shadow-sm">
                                    SMA
                                </div>
                            </div>
                            <div class="p-6 space-y-3">
                                <div class="pb-4 border-b border-[#193836]/10">
                                    <p class="font-subtitle text-xs font-bold text-[#193836] mb-1">Mapel Pilihan:</p>
                                    <p class="font-body text-[11px] text-void/80 leading-relaxed">
                                        Matematika Lanjutan, Matematika Wajib, Fisika, Kimia, Biologi, B. Indo, B. Ing, Ekonomi, TKA
                                    </p>
                                </div>
                                <div class="py-2 divide-y divide-[#193836]/10 border-b border-[#193836]/10">
                                    <div class="flex items-center justify-between py-2.5 text-xs">
                                        <span class="font-subtitle font-bold text-void/90">Paket 4 Mapel</span>
                                        <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs border border-black">Rp 350k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between py-2.5 text-xs">
                                        <span class="font-subtitle font-bold text-void/90">Paket 5 Mapel</span>
                                        <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs border border-black">Rp 400k/bln</span>
                                    </div>
                                </div>
                                <div class="py-3 flex items-center gap-2 text-xs font-subtitle font-bold text-primary">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>Tersedia kelas UTBK / SNBT</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            <a href="{{ route('pendaftaran') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-highlight hover:bg-yellow-400 text-void font-headline font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET SMA &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- CTA & DAFTAR SECTION -->
        <section id="daftar" class="bg-canvas py-16 lg:py-24 border-b border-[#193836]/10">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <div class="relative bg-[#193836] text-white rounded-[32px] p-8 sm:p-12 lg:p-16 overflow-hidden border-2 border-black shadow-2xl">

                    <!-- Decorative Circles -->
                    <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-primary/30 pointer-events-none blur-2xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-highlight/20 pointer-events-none blur-3xl"></div>
                    <div class="absolute top-1/2 right-10 -translate-y-1/2 w-64 h-64 rounded-full border-8 border-white/10 pointer-events-none"></div>

                    <div class="relative z-10 max-w-3xl space-y-6">
                        <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                            Siap Antarkan Putra-Putri Anda Meraih Prestasi Terbaik?
                        </h2>

                        <p class="font-body text-white/85 text-sm sm:text-base leading-relaxed max-w-2xl">
                            Daftarkan putra-putri Anda hari ini di Bimbel Pelita Ilmu. Dapatkan bimbingan intensif 4-6 siswa per kelompok dengan pengajar S1/S2 berdedikasi tinggi di Bimbel Pelita Ilmu!
                        </p>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4">
                            <!-- Anti-Metal Yellow CTA Button -->
                            <a href="{{ route('pendaftaran') }}" class="group/btn relative inline-flex h-14 items-center justify-center overflow-hidden rounded-full bg-highlight active:scale-95 transition-all border-2 border-black shadow-md px-8">
                                <span class="relative z-20 font-headline font-extrabold text-sm text-void group-hover/btn:text-[#193836] uppercase tracking-wider transition-colors duration-300">
                                    DAFTAR SEKARANG SECARA ONLINE &rarr;
                                </span>
                            </a>

                            <!-- WhatsApp Button -->
                            <a href="https://wa.me/6289624601717?text=Halo%20Admin%20Pelita%20Ilmu,%20saya%20ingin%20bertanya%20mengenai%20bimbingan%20belajar" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-white hover:bg-stone-50 text-primary font-headline font-extrabold text-sm rounded-full border-2 border-black shadow-md transition-all text-center">
                                <svg class="w-5 h-5 fill-current text-[#25D366] shrink-0" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span class="text-primary">Konsultasi via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
@endsection
