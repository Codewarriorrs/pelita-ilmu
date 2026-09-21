@extends('layouts.app')

@section('title', 'Pelita Ilmu Bimbel - Raih Prestasimu')

@section('content')
    {{-- ================= HERO SECTION ================= --}}
    <section id="beranda" class="relative overflow-hidden border-b border-primary-2/10 bg-primary py-16 lg:py-24">
        <div class="absolute inset-0 pointer-events-none">
            <div class="hero-orbit hero-orbit-one"></div>
            <div class="hero-orbit hero-orbit-two"></div>
            <div class="hero-orbit hero-orbit-three"></div>
            <svg class="absolute bottom-8 left-1/4 h-24 w-36 text-primary-2/40 hidden lg:block" fill="none" viewBox="0 0 140 80" stroke="currentColor" stroke-width="2">
                <line x1="0" y1="15" x2="140" y2="15" stroke-dasharray="6 6" />
                <line x1="0" y1="35" x2="140" y2="35" stroke-dasharray="6 6" />
                <line x1="0" y1="55" x2="140" y2="55" stroke-dasharray="6 6" />
                <line x1="0" y1="75" x2="140" y2="75" stroke-dasharray="6 6" />
            </svg>
            <svg class="absolute top-10 right-1/4 h-28 w-28 text-primary-2/35 hidden lg:block" fill="none" viewBox="0 0 100 100" stroke="currentColor" stroke-width="2">
                <line x1="0" y1="20" x2="80" y2="100" stroke-dasharray="4 4" />
                <line x1="20" y1="0" x2="100" y2="80" stroke-dasharray="4 4" />
                <line x1="40" y1="0" x2="100" y2="60" stroke-dasharray="4 4" />
            </svg>
        </div>

        <div class="relative z-10 mx-auto max-w-[90rem] px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                {{-- KIRI: Ruang Kelas Card --}}
                <div class="order-2 lg:order-1 lg:col-span-3">
                    <div class="rounded-3xl border-2 border-primary-2/15 bg-canvas p-5 shadow-sm">
                        <div class="flex items-center gap-3 border-b border-primary-2/10 pb-4">
                            <img src="{{ asset('images/kursi.png') }}" alt="Kursi" class="h-10 w-10 shrink-0 object-contain hover:scale-110 transition-transform">
                            <div>
                                <h3 class="font-headline text-base font-bold text-primary-2">Ruang Kelas</h3>
                                <p class="font-subtitle text-xs text-primary">Nyaman &amp; Terang</p>
                            </div>
                        </div>

                        {{-- Box Foto yang Lebih Panjang (h-72 = 288px) --}}
                        <div class="mt-4 rounded-2xl bg-primary/5 p-2 border border-primary/20 shadow-sm">
                            <img src="{{ asset('images/ruang.jpg') }}" alt="Suasana Belajar" class="h-72 w-full object-cover rounded-xl">
                        </div>
                    </div>
                </div>
                
                {{-- TENGAH: Hero Content --}}
                <div class="lg:col-span-6 order-1 lg:order-2 text-center">
                    <h1 class="hero-title font-headline text-3xl font-bold leading-tight text-canvas sm:text-4xl lg:text-[42px] tracking-wide">
                        DAFTAR SEKARANG KE
                    </h1>

                    <div class="hero-logo my-4 flex justify-center">
                        <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-44 w-44 object-contain sm:h-56 sm:w-56 drop-shadow-lg">
                    </div>

                    <h2 class="hero-subtitle font-headline text-xl font-bold text-highlight sm:text-3xl lg:text-3xl tracking-wide">
                        DAN RAIH PRESTASIMU!
                    </h2>

                    <div class="mt-8 flex justify-center hero-cta">
                        <a href="#pendaftaran" class="inline-flex items-center gap-2 rounded-full bg-highlight px-8 py-3.5 font-subtitle text-sm font-bold text-void shadow-md transition-all hover:scale-105 hover:bg-[#ffe84a]">
                            <span>Daftar Bimbel Sekarang</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>

                {{-- KANAN: Lokasi Card --}}
                <div class="order-3 lg:order-3 lg:col-span-3">
                    <div class="rounded-3xl border-2 border-primary-2/15 bg-canvas p-5 shadow-sm">
                        <div class="border-b border-primary-2/10 pb-4">
                            <a href="https://maps.app.goo.gl/4mZR8LgBXbN69YL4A" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 group">
                                <img src="{{ asset('images/gps.png') }}" alt="Red Location Pin" class="h-10 w-10 shrink-0 object-contain hover:scale-110 transition-transform">
                                <div>
                                    <h3 class="font-headline text-base font-bold text-primary-2">Lokasi</h3>
                                    <p class="font-subtitle text-xs text-primary">Manyaran, Semarang Barat</p>
                                </div>
                            </a>
                        </div>

                        {{-- Box Foto yang Lebih Panjang (h-72 = 288px) --}}
                        <div class="mt-4 rounded-2xl bg-primary/5 p-2 border border-primary/20 shadow-sm">
                            <img src="{{ asset('images/lokasi.jpg') }}" alt="Lokasi Bimbel" class="h-72 w-full object-cover rounded-xl">
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Mobile Only Cards (Visible only on small screens) --}}
            <div class="mt-12 grid grid-cols-1 gap-6 md:hidden">
                <article class="overflow-hidden rounded-3xl bg-white p-4 shadow-xl">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M4 7.5A2.5 2.5 0 016.5 5h11A2.5 2.5 0 0120 7.5v9A2.5 2.5 0 0117.5 19h-11A2.5 2.5 0 014 16.5v-9z" />
                                <path d="M8 9.5h8M8 13.5h5" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-headline text-base font-bold text-primary-2">Ruang Kelas</h3>
                            <p class="font-subtitle text-xs text-primary">Nyaman &amp; Terang</p>
                        </div>
                    </div>
                    <img src="{{ asset('images/ruang.jpg') }}" alt="Suasana Belajar Pelita Ilmu" class="h-64 w-full rounded-2xl object-cover" />
                </article>

                <article class="overflow-hidden rounded-3xl bg-white p-4 shadow-xl">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-highlight/20 text-primary-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 21s6-4.35 9-9.1C21.6 9.17 19.47 4 15.4 4A4.76 4.76 0 0012 6.08 4.76 4.76 0 008.6 4C4.53 4 2.4 9.17 3 11.9 6 16.65 12 21 12 21z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-headline text-base font-bold text-primary-2">Lokasi</h3>
                            <p class="font-subtitle text-xs text-primary">Manyaran, Semarang Barat</p>
                        </div>
                    </div>
                    <img src="{{ asset('images/lokasi.jpg') }}" alt="Lokasi Bimbel Pelita Ilmu" class="h-64 w-full rounded-2xl object-cover" />
                </article>
            </div>
        </div>
    </section>

        {{-- ================= SECTION KEUNGGULAN (HORIZONTAL BANNER 2 BARIS) ================= --}}
    <section class="relative bg-primary-2 text-canvas py-10 lg:py-12 border-b border-canvas/10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- Baris 1 (3 Keunggulan Pertama) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 pb-8 lg:border-b lg:border-canvas/15">
                {{-- 1. Pengajar S1 & S2 --}}
                <div class="flex items-center gap-4 lg:border-r lg:border-canvas/15 lg:pr-6">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-canvas/20 bg-canvas/10 text-highlight">
                        {{-- Icon Toga / Sarjana --}}
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-canvas">Pengajar Berpengalaman</h3>
                        <p class="font-body text-xs text-canvas/80 mt-0.5">Pengajar berpendidikan S1 &amp; S2</p>
                    </div>
                </div>

                {{-- 2. Active & Fun Learning --}}
                <div class="flex items-center gap-4 lg:border-r lg:border-canvas/15 lg:pr-6">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-canvas/20 bg-canvas/10 text-highlight">
                        {{-- Icon Senyum / Fun --}}
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-canvas">Active &amp; Fun Learning</h3>
                        <p class="font-body text-xs text-canvas/80 mt-0.5">Belajar dua arah, aktif, dan tidak membosankan</p>
                    </div>
                </div>

                {{-- 3. Pendidikan Berkarakter --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-canvas/20 bg-canvas/10 text-highlight">
                        {{-- Icon Bintang / Karakter --}}
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-canvas">Pendidikan Berkarakter</h3>
                        <p class="font-body text-xs text-canvas/80 mt-0.5">Menanamkan kedisiplinan dan moral baik siswa</p>
                    </div>
                </div>
            </div>

            {{-- Baris 2 (3 Keunggulan Kedua) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 pt-8">
                {{-- 4. Komunikatif dengan Ortu --}}
                <div class="flex items-center gap-4 lg:border-r lg:border-canvas/15 lg:pr-6">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-canvas/20 bg-canvas/10 text-highlight">
                        {{-- Icon Percakapan / Komunikatif --}}
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-canvas">Komunikatif &amp; Terbuka</h3>
                        <p class="font-body text-xs text-canvas/80 mt-0.5">Pendekatan kepada siswa dan orang tua</p>
                    </div>
                </div>

                {{-- 5. Area Belajar Nyaman & Wi-Fi --}}
                <div class="flex items-center gap-4 lg:border-r lg:border-canvas/15 lg:pr-6">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-canvas/20 bg-canvas/10 text-highlight">
                        {{-- Icon Gedung / Ruang Belajar --}}
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-canvas">Area Belajar Nyaman</h3>
                        <p class="font-body text-xs text-canvas/80 mt-0.5">Ruang kelas tenang, ber-AC, &amp; tersedia Wi-Fi</p>
                    </div>
                </div>

                {{-- 6. Harga Terjangkau --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-canvas/20 bg-canvas/10 text-highlight">
                        {{-- Icon Tag Harga Terjangkau --}}
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-subtitle text-base font-bold text-canvas">Harga Sangat Terjangkau</h3>
                        <p class="font-body text-xs text-canvas/80 mt-0.5">Mulai Rp195.000/bulan kualitas terjamin</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= SECTION PROGRAM & HARGA ================= --}}
    <section id="program" class="bg-canvas py-16 lg:py-24 border-b border-primary-2/10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section (Judul Kiri + Badge Durasi Kanan) --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-bold text-primary-2">
                        Program Lengkap Bimbel Pelita Ilmu
                    </h2>
                    <p class="mt-2 font-body text-sm sm:text-base text-void/70">
                        Satu kelas berkapasitas mini 4–6 siswa agar perhatian tentor merata ke seluruh anak.
                    </p>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-canvas px-4 py-2 text-primary font-subtitle text-xs sm:text-sm font-bold shadow-sm shrink-0 self-start md:self-auto">
                    <svg class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Durasi 90 Menit Tiap Sesi</span>
                </div>
            </div>

            {{-- Grid 4 Card Program (TK, SD, SMP, SMA) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 items-stretch">
                
                {{-- 1. CARD TK (Header: Primary 2) --}}
                <div class="flex flex-col rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    {{-- Card Header (Tinggi seragam min-h-[108px]) --}}
                    <div class="bg-primary-2 p-5 sm:p-6 text-canvas flex items-center justify-between min-h-[108px]">
                        <div class="flex-1 pr-2">
                            <div class="h-8 flex items-center">
                                <span class="text-[10px] sm:text-[11px] font-subtitle font-bold text-highlight uppercase leading-tight">
                                    TINGKAT PRASEKOLAH
                                </span>
                            </div>
                            <h3 class="font-headline text-xl sm:text-2xl font-bold text-canvas">
                                Jenjang TK
                            </h3>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-bold text-xs flex items-center justify-center shrink-0">
                            TK
                        </div>
                    </div>

                    {{-- Card Body (Garis Pembatas Bersih Tanpa Nested Card) --}}
                    <div class="p-5 sm:p-6 bg-canvas flex-1 flex flex-col justify-between border-2 border-t-0 border-primary-2/15 rounded-b-3xl">
                        <div>
                            {{-- Fokus Pembelajaran --}}
                            <div class="pb-4 border-b border-primary-2/10">
                                <p class="font-subtitle text-xs font-bold text-primary-2 mb-1">Fokus Pembelajaran:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">
                                    Calistung (Membaca, Menulis, Berhitung), Mengaji, &amp; Bahasa Inggris Dasar
                                </p>
                            </div>

                            {{-- Bullet List --}}
                            <ul class="py-4 space-y-2.5 font-body text-xs sm:text-sm text-void/85 border-b border-primary-2/10">
                                <li class="flex items-center gap-2.5">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>3x Seminggu @90 menit</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>Flashcard &amp; Game Edukasi</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>Metode Ramah Anak</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            {{-- Biaya (Tanpa Card Box) --}}
                            <div class="py-4">
                                <span class="text-[10px] font-subtitle font-bold text-void/60 uppercase tracking-wider block">
                                    BIAYA 
                                </span>
                                <p class="font-headline text-2xl font-bold text-void mt-0.5">
                                    Rp 195.000 <span class="text-xs font-normal font-body text-void/70">/ bulan</span>
                                </p>
                            </div>

                            <a href="#daftar" class="w-full rounded-full bg-primary hover:bg-primary-2 text-canvas font-subtitle text-xs sm:text-sm font-bold py-3 px-4 text-center transition-all shadow-sm flex items-center justify-center gap-1.5 hover:translate-y-0.5">
                                Pilih Paket TK ➔
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 2. CARD SD (Header: Primary) --}}
                <div class="flex flex-col rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    {{-- Card Header (Tinggi seragam min-h-[108px]) --}}
                    <div class="bg-primary p-5 sm:p-6 text-canvas flex items-center justify-between min-h-[108px]">
                        <div class="flex-1 pr-2">
                            <div class="h-8 flex items-center">
                                <span class="text-[10px] sm:text-[11px] font-subtitle font-bold text-highlight uppercase leading-tight">
                                    SEKOLAH DASAR
                                </span>
                            </div>
                            <h3 class="font-headline text-xl sm:text-2xl font-bold text-canvas">
                                Jenjang SD
                            </h3>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-bold text-xs flex items-center justify-center shrink-0">
                            SD
                        </div>
                    </div>

                    {{-- Card Body (Garis Pembatas Bersih Tanpa Nested Card) --}}
                    <div class="p-5 sm:p-6 bg-canvas flex-1 flex flex-col justify-between border-2 border-t-0 border-primary-2/15 rounded-b-3xl">
                        <div>
                            {{-- Fokus Pembelajaran --}}
                            <div class="pb-4 border-b border-primary-2/10">
                                <p class="font-subtitle text-xs font-bold text-primary-2 mb-1">Fokus Pembelajaran:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">
                                    Semua Mapel Pokok (Tematik, Matematika, IPA, B. Indonesia, B. Inggris)
                                </p>
                            </div>

                            {{-- Bullet List --}}
                            <ul class="py-4 space-y-2.5 font-body text-xs sm:text-sm text-void/85 border-b border-primary-2/10">
                                <li class="flex items-center gap-2.5">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>3x Seminggu @90 menit</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>Pendampingan PR Sekolah</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="text-primary font-bold">✓</span>
                                    <span>Persiapan Ulangan / PTS / PAS</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            {{-- Biaya (Tanpa Card Box) --}}
                            <div class="py-4">
                                <span class="text-[10px] font-subtitle font-bold text-void/60 uppercase tracking-wider block">
                                    BIAYA
                                </span>
                                <p class="font-headline text-2xl font-bold text-void mt-0.5">
                                    Rp 195.000 <span class="text-xs font-normal font-body text-void/70">/ bulan</span>
                                </p>
                            </div>

                            <a href="#daftar" class="w-full rounded-full bg-primary hover:bg-primary-2 text-canvas font-subtitle text-xs sm:text-sm font-bold py-3 px-4 text-center transition-all shadow-sm flex items-center justify-center gap-1.5 hover:translate-y-0.5">
                                Pilih Paket SD ➔
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. CARD SMP (Header: Primary 2) --}}
                <div class="flex flex-col rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    {{-- Card Header (Tinggi seragam min-h-[108px]) --}}
                    <div class="bg-primary-2 p-5 sm:p-6 text-canvas flex items-center justify-between min-h-[108px]">
                        <div class="flex-1 pr-2">
                            <div class="h-8 flex items-center">
                                <span class="text-[10px] sm:text-[11px] font-subtitle font-bold text-highlight uppercase leading-tight">
                                    SEKOLAH MENENGAH PERTAMA
                                </span>
                            </div>
                            <h3 class="font-headline text-xl sm:text-2xl font-bold text-canvas">
                                Jenjang SMP
                            </h3>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-bold text-xs flex items-center justify-center shrink-0">
                            SMP
                        </div>
                    </div>

                    {{-- Card Body (Garis Pembatas Bersih Tanpa Nested Card) --}}
                    <div class="p-5 sm:p-6 bg-canvas flex-1 flex flex-col justify-between border-2 border-t-0 border-primary-2/15 rounded-b-3xl">
                        <div>
                            {{-- Mapel Pilihan --}}
                            <div class="pb-4 border-b border-primary-2/10">
                                <p class="font-subtitle text-xs font-bold text-primary-2 mb-1">Mapel Pilihan:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">
                                    Matematika, IPA, Inggris, B. Indo, IPS, TKA
                                </p>
                            </div>

                            {{-- Daftar Paket Harga SMP (Clean Divide-Y Garis) --}}
                            <div class="py-2 divide-y divide-primary-2/10 border-b border-primary-2/10">
                                <div class="flex items-center justify-between py-2.5 text-xs">
                                    <span class="font-subtitle font-bold text-void/90">Paket 3 Mapel</span>
                                    <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs">Rp 240k/bln</span>
                                </div>
                                <div class="flex items-center justify-between py-2.5 text-xs">
                                    <span class="font-subtitle font-bold text-void/90">Paket 4 Mapel</span>
                                    <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs">Rp 290k/bln</span>
                                </div>
                                <div class="flex items-center justify-between py-2.5 text-xs">
                                    <span class="font-subtitle font-bold text-void/90">Paket 5 Mapel</span>
                                    <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs">Rp 340k/bln</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="#daftar" class="w-full rounded-full bg-primary hover:bg-primary-2 text-canvas font-subtitle text-xs sm:text-sm font-bold py-3 px-4 text-center transition-all shadow-sm flex items-center justify-center gap-1.5 hover:translate-y-0.5">
                                Pilih Paket SMP ➔
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 4. CARD SMA (Header: Primary) --}}
                <div class="flex flex-col rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    {{-- Card Header (Tinggi seragam min-h-[108px]) --}}
                    <div class="bg-primary p-5 sm:p-6 text-canvas flex items-center justify-between min-h-[108px]">
                        <div class="flex-1 pr-2">
                            <div class="h-8 flex items-center">
                                <span class="text-[10px] sm:text-[11px] font-subtitle font-bold text-highlight uppercase leading-tight">
                                    SEKOLAH MENENGAH ATAS
                                </span>
                            </div>
                            <h3 class="font-headline text-xl sm:text-2xl font-bold text-canvas">
                                SMA &amp; UTBK
                            </h3>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-highlight text-void font-headline font-bold text-xs flex items-center justify-center shrink-0">
                            SMA
                        </div>
                    </div>

                    {{-- Card Body (Garis Pembatas Bersih Tanpa Nested Card) --}}
                    <div class="p-5 sm:p-6 bg-canvas flex-1 flex flex-col justify-between border-2 border-t-0 border-primary-2/15 rounded-b-3xl">
                        <div>
                            {{-- Mapel Pilihan --}}
                            <div class="pb-4 border-b border-primary-2/10">
                                <p class="font-subtitle text-xs font-bold text-primary-2 mb-1">Mapel Pilihan:</p>
                                <p class="font-body text-xs text-void/80 leading-relaxed">
                                    Matematika Lanjutan, Matematika Wajib, Fisika, Kimia, Biologi, B. Indo, B. Ing, Ekonomi, TKA
                                </p>
                            </div>

                            {{-- Daftar Paket Harga SMA (Clean Divide-Y Garis) --}}
                            <div class="py-2 divide-y divide-primary-2/10 border-b border-primary-2/10">
                                <div class="flex items-center justify-between py-2.5 text-xs">
                                    <span class="font-subtitle font-bold text-void/90">Paket 4 Mapel</span>
                                    <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs">Rp 350k/bln</span>
                                </div>
                                <div class="flex items-center justify-between py-2.5 text-xs">
                                    <span class="font-subtitle font-bold text-void/90">Paket 5 Mapel</span>
                                    <span class="font-headline font-bold bg-highlight text-void px-2.5 py-1 rounded-md text-xs">Rp 400k/bln</span>
                                </div>
                            </div>

                            {{-- Highlight UTBK (Garis Bersih) --}}
                            <div class="py-3 flex items-center gap-2 text-xs font-subtitle font-bold text-primary-2">
                                <span class="text-primary font-bold">✓</span>
                                <span>Tersedia kelas UTBK / SNBT</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="#daftar" class="w-full rounded-full bg-primary hover:bg-primary-2 text-canvas font-subtitle text-xs sm:text-sm font-bold py-3 px-4 text-center transition-all shadow-sm flex items-center justify-center gap-1.5 hover:translate-y-0.5">
                                Pilih Paket SMA ➔
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

        {{-- ================= SECTION PENDAFTARAN (CTA BANNER & FORM) ================= --}}
    <section id="pendaftaran" class="bg-canvas py-16 lg:py-24 border-b border-primary-2/10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- Big CTA Card (Sesuai Gambar) --}}
            <div class="relative rounded-[32px] bg-primary-2 text-canvas p-8 sm:p-12 lg:p-16 overflow-hidden shadow-xl">
                
                {{-- Aksen Dekorasi Lingkaran Halus di Latar --}}
                <div class="absolute -bottom-20 -right-20 h-80 w-80 rounded-full border-4 border-canvas/10 pointer-events-none"></div>
                <div class="absolute -top-16 -right-16 h-64 w-64 rounded-full bg-canvas/5 pointer-events-none"></div>
                <div class="absolute -bottom-16 left-1/3 h-56 w-56 rounded-full bg-black/10 pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl">
                    {{-- Headline --}}
                    <h2 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-canvas">
                        Siap Antarkan Putra-Putri Anda Meraih Prestasi Terbaik?
                    </h2>

                    {{-- Subtitle --}}
                    <p class="font-body text-sm sm:text-base text-canvas/85 mt-5 leading-relaxed max-w-2xl">
                        Daftarkan putra-putri Anda hari ini di Bimbel Pelita Ilmu. Dapatkan bimbingan intensif 4-6 siswa per kelompok dengan pengajar S1/S2 berdedikasi tinggi di Bimbel Pelita Ilmu!
                    </p>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        {{-- Tombol 1: Menuju Halaman Formulir Pendaftaran --}}
                        <a
                            href="daftar"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-full bg-highlight px-8 py-3.5 font-subtitle text-xs sm:text-sm font-bold text-void shadow-lg hover:bg-highlight/80 hover:translate-y-0.5 transition-all text-center"
                        >
                            DAFTAR SEKARANG SECARA ONLINE ➔
                        </a>

                        {{-- Tombol 2: Konsultasi Langsung via WhatsApp --}}
                        <a 
                            href="https://wa.me/6289624601717?text=Halo%20Admin%20Pelita%20Ilmu,%20saya%20ingin%20konsultasi%20bimbingan%20belajar" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-canvas px-7 py-3.5 font-subtitle text-xs sm:text-sm font-bold text-void shadow-sm hover:bg-canvas/90 hover:translate-y-0.5 transition-all"
                        >
                            <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                            </svg>
                            <span>Konsultasi via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
