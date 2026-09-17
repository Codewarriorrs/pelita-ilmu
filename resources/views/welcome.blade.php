<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelita Ilmu — Bimbingan Belajar & Privat TK, SD, SMP, SMA</title>
    <meta name="description" content="Solusi bimbingan belajar terpercaya di Manyaran, Semarang untuk jenjang TK, SD, SMP, hingga SMA. Menghadirkan pengajar berpendidikan S1/S2 dengan metode belajar yang aktif, seru, dan berkarakter.">
    
    <!-- Google Fonts: Plus Jakarta Sans & Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Script -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#009688',
                        'primary-dark': '#00796B',
                        'primary-darker': '#193836',
                        highlight: '#FFE500',
                        'highlight-dark': '#F5D000',
                        canvas: '#F8FAFC',
                        main: '#009688',
                        border: '#000000',
                        bw: '#FFFFFF',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        heading: ['Quicksand', 'Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        neo: '4px 4px 0px 0px #000000',
                        'neo-sm': '3px 3px 0px 0px #000000',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
        }

        .font-heading {
            font-family: 'Quicksand', sans-serif;
        }

        /* Anti-Metal Dot Wave Animation */
        @keyframes bd-dot-wave {
            0%, 70%, 100% { opacity: 0.35; transform: scale(0.85); }
            35% { opacity: 1; transform: scale(1.1); }
        }
        .bd-dot {
            transform-box: fill-box;
            transform-origin: center;
            animation: bd-dot-wave 1.4s ease-in-out infinite;
        }

        /* Background Pattern Bubble Decor */
        .bubble-bg {
            background-image: radial-gradient(circle at 20% 20%, rgba(255, 229, 0, 0.15) 0%, transparent 40%),
                              radial-gradient(circle at 80% 80%, rgba(0, 150, 136, 0.2) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-canvas text-stone-800 min-h-screen flex flex-col justify-between antialiased selection:bg-[#009688] selection:text-white">

    <!-- SOLID HEADER NAVIGATION -->
    <header class="fixed top-0 left-0 right-0 z-50 h-20 bg-white border-b border-stone-200 shadow-sm">
        <nav class="mx-auto flex h-full max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Navigasi utama">
            
            <!-- Logo area with Minimal Light Bulb Icon 💡 -->
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-bimbel.png') }}" alt="Logo Pelita Ilmu" class="h-12 w-auto object-contain" onerror="this.src='{{ asset('images/logo-bimbel.jpeg') }}'">
                <div class="flex flex-col">
                    <span class="text-xl font-heading font-extrabold text-[#009688] leading-tight flex items-center gap-1.5">
                        Pelita Ilmu 
                        <svg class="w-5 h-5 text-[#FFE500] drop-shadow-sm shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7zm-2 18h4v1a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1z"/>
                        </svg>
                    </span>
                    <span class="text-xs font-bold text-stone-500 uppercase tracking-wider">
                        Bimbingan Belajar
                    </span>
                </div>
            </a>

            <!-- Desktop Links -->
            <div class="hidden lg:flex lg:items-center lg:gap-6 font-semibold text-sm">
                <a href="#beranda" class="px-3 py-2 text-[#009688] font-heading font-bold border-b-2 border-[#009688]">Beranda</a>
                <a href="#program" class="px-3 py-2 text-stone-700 hover:text-[#009688] font-heading font-bold transition-colors">Program</a>
                <a href="{{ route('daftar') }}" class="px-3 py-2 text-stone-700 hover:text-[#009688] font-heading font-bold transition-colors">Pendaftaran</a>
                <a href="#kontak" class="px-3 py-2 text-stone-700 hover:text-[#009688] font-heading font-bold transition-colors">Kontak</a>
                
                <!-- ANTI-METAL BUTTON: Primary Action -->
                <a href="{{ route('daftar') }}" class="group/btn relative inline-flex h-11 min-w-[220px] items-center justify-center overflow-hidden rounded-xl bg-[#009688] active:scale-[0.98] transition-transform shadow-md">
                    <span class="relative z-20 font-heading font-bold text-sm text-white pl-12 pr-5">Daftar Bimbel Sekarang</span>
                    <span aria-hidden="true" class="absolute bottom-1 left-1 top-1 z-10 flex w-9 items-center justify-center overflow-hidden rounded-lg bg-[#FFE500] transition-[width] duration-300 ease-[cubic-bezier(0.65,0,0.35,1)] group-hover/btn:w-[calc(100%-0.5rem)]">
                        <svg width="14" height="16" viewBox="0 0 14 16" class="shrink-0 overflow-visible">
                            <g fill="#193836">
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

            <!-- Mobile Hamburger Toggle -->
            <button
                type="button"
                onclick="toggleMobileMenu()"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border-2 border-black bg-white text-stone-900 shadow-neo hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all lg:hidden"
                aria-label="Buka menu"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>
        </nav>
    </header>

    <!-- Liquid Morph Floating Menu for Mobile -->
    <div id="liquid-mobile-menu" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] lg:hidden hidden">
        <div class="bg-[#193836] text-white rounded-3xl p-6 shadow-2xl border-2 border-[#FFE500] w-72 flex flex-col gap-4 text-center">
            <span class="text-xs font-bold text-[#FFE500] uppercase tracking-wider block mb-1">Navigasi Pelita Ilmu</span>
            <a href="#beranda" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-white hover:text-[#FFE500] transition-colors">Beranda</a>
            <a href="#program" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-white hover:text-[#FFE500] transition-colors">Program</a>
            <a href="{{ route('daftar') }}" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-[#FFE500]">Pendaftaran</a>
            <a href="#kontak" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-white hover:text-[#FFE500] transition-colors">Kontak</a>
            
            <button onclick="toggleMobileMenu()" class="mt-2 py-2.5 px-4 bg-[#FFE500] text-stone-950 font-heading font-black rounded-xl text-xs uppercase tracking-wider border-2 border-black shadow-neo hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                Tutup Menu
            </button>
        </div>
    </div>

    <main id="main-content" class="pt-20">
        
        <!-- HERO BANNER SECTION WITH BUBBLE / PATTERN ACCENTS -->
        <section id="beranda" class="bg-[#009688] relative py-12 lg:py-16 text-white overflow-hidden bubble-bg">
            
            <!-- Floating Decorative Circles/Bubbles -->
            <div class="absolute -top-12 -left-12 w-64 h-64 rounded-full bg-white/10 pointer-events-none blur-xl"></div>
            <div class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full bg-[#FFE500]/20 pointer-events-none blur-2xl"></div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- LEFT COLUMN CARD: Ruang Kelas -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-3xl p-5 shadow-xl text-stone-800 border-2 border-black">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-xl">🏫</span>
                                <div>
                                    <h3 class="font-heading font-extrabold text-stone-900 text-sm leading-tight">Ruang Kelas</h3>
                                    <p class="text-xs font-bold text-[#009688]">Nyaman & Terang</p>
                                </div>
                            </div>
                            <img 
                                src="{{ asset('images/WhatsApp_Image_2026-08-27_at_7.08.24_PM.jpeg') }}" 
                                alt="Ruang Kelas Pelita Ilmu" 
                                class="w-full aspect-[4/3] object-cover rounded-2xl border-2 border-black"
                                onerror="this.src='{{ asset('images/ilustrasi.jpeg') }}'"
                            >
                        </div>
                    </div>

                    <!-- CENTER COLUMN: MAIN DAFTAR & LOGO -->
                    <div class="lg:col-span-6 text-center py-2">
                        <h1 class="text-white font-heading font-extrabold text-2xl sm:text-3xl md:text-4xl tracking-tight uppercase leading-tight mb-2">
                            DAFTAR SEKARANG KE
                        </h1>

                        <!-- Logo Center with Bulb Icon -->
                        <div class="my-4 flex justify-center items-center gap-2">
                            <img 
                                src="{{ asset('images/logo-bimbel.png') }}" 
                                alt="Logo Bimbel Pelita Ilmu" 
                                class="h-28 sm:h-32 w-auto mx-auto object-contain filter drop-shadow-md"
                                onerror="this.src='{{ asset('images/logo-bimbel.jpeg') }}'"
                            >
                        </div>

                        <h2 class="text-[#FFE500] font-heading font-extrabold text-xl sm:text-2xl md:text-3xl tracking-wider uppercase mt-2">
                            DAN RAIH PRESTASIMU!
                        </h2>

                        <!-- ANTI-METAL BUTTON HERO CTA -->
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('daftar') }}" class="group/btn relative inline-flex h-14 min-w-[280px] items-center justify-center overflow-hidden rounded-2xl bg-[#FFE500] shadow-xl active:scale-95 transition-all">
                                <span class="relative z-20 font-heading font-extrabold text-base text-stone-950 pl-14 pr-6 group-hover/btn:text-white transition-colors duration-300">DAFTAR BIMBEL SEKARANG</span>
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
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-3xl p-5 shadow-xl text-stone-800 border-2 border-black">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-xl">📍</span>
                                <div>
                                    <h3 class="font-heading font-extrabold text-stone-900 text-sm leading-tight">Lokasi</h3>
                                    <p class="text-xs font-bold text-[#009688]">Manyaran, Semarang</p>
                                </div>
                            </div>
                            <img 
                                src="{{ asset('images/WhatsApp_Image_2026-08-27_at_7.08.25_PM.jpeg') }}" 
                                alt="Gedung Bimbel Pelita Ilmu" 
                                class="w-full aspect-[4/3] object-cover rounded-2xl border-2 border-black"
                                onerror="this.src='{{ asset('images/ilustrasi-mobile.png') }}'"
                            >
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- FEATURE BAR SECTION (IMAGE 2: SOFT YELLOW / SOFT TEAL CARDS WITH NEO-BRUTALIST BORDERS) -->
        <section class="bg-[#193836] text-white py-12 border-t border-[#00796B] relative overflow-hidden">
            <!-- Decorative circle overlay -->
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full bg-white/5 pointer-events-none"></div>
            
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#FEF9C3] text-stone-900 border-2 border-black shadow-neo">
                        <span class="text-2xl shrink-0">🎓</span>
                        <div>
                            <h4 class="font-heading font-extrabold text-stone-900 text-sm sm:text-base">Pengajar Berpengalaman</h4>
                            <p class="text-xs text-stone-700 mt-1 leading-relaxed">Pengajar berpendidikan S1 & S2 berkualitas tinggi.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#FEF9C3] text-stone-900 border-2 border-black shadow-neo">
                        <span class="text-2xl shrink-0">🙂</span>
                        <div>
                            <h4 class="font-heading font-extrabold text-stone-900 text-sm sm:text-base">Active & Fun Learning</h4>
                            <p class="text-xs text-stone-700 mt-1 leading-relaxed">Belajar dua arah, aktif, dan tidak membosankan.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#FEF9C3] text-stone-900 border-2 border-black shadow-neo">
                        <span class="text-2xl shrink-0">⭐</span>
                        <div>
                            <h4 class="font-heading font-extrabold text-stone-900 text-sm sm:text-base">Pendidikan Berkarakter</h4>
                            <p class="text-xs text-stone-700 mt-1 leading-relaxed">Menanamkan kedisiplinan dan moral baik siswa.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#FEF9C3] text-stone-900 border-2 border-black shadow-neo">
                        <span class="text-2xl shrink-0">💬</span>
                        <div>
                            <h4 class="font-heading font-extrabold text-stone-900 text-sm sm:text-base">Komunikatif & Terbuka</h4>
                            <p class="text-xs text-stone-700 mt-1 leading-relaxed">Pendekatan hangat kepada siswa dan orang tua.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#FEF9C3] text-stone-900 border-2 border-black shadow-neo">
                        <span class="text-2xl shrink-0">🏫</span>
                        <div>
                            <h4 class="font-heading font-extrabold text-stone-900 text-sm sm:text-base">Area Belajar Nyaman</h4>
                            <p class="text-xs text-stone-700 mt-1 leading-relaxed">Ruang kelas tenang, ber-AC, & tersedia Wi-Fi gratis.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-[#FEF9C3] text-stone-900 border-2 border-black shadow-neo">
                        <span class="text-2xl shrink-0">🏷️</span>
                        <div>
                            <h4 class="font-heading font-extrabold text-stone-900 text-sm sm:text-base">Harga Sangat Terjangkau</h4>
                            <p class="text-xs text-stone-700 mt-1 leading-relaxed">Mulai Rp195.000/bulan kualitas pendidikan terjamin.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- PROGRAM SECTION (IMAGE 3 MATCH: EXACT CONTENT, SUBSTANCE, PRICING & BUTTONS) -->
        <section id="program" class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs font-bold text-[#009688] uppercase tracking-wider block mb-1">Program Bimbingan</span>
                    <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-stone-900 tracking-tight">Jenjang TK, SD, SMP, & SMA</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                    
                    <!-- CARD 1: JENJANG TK -->
                    <div class="bg-white rounded-3xl border-2 border-black shadow-neo overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Header Banner -->
                            <div class="bg-[#193836] text-white p-6 relative">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">TINGKAT PRASEKOLAH</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">Jenjang TK</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    TK
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">Fokus Pembelajaran:</span>
                                    <p class="text-xs text-stone-800 font-medium leading-relaxed">
                                        Calistung (Membaca, Menulis, Berhitung), Mengaji, & Bahasa Inggris Dasar
                                    </p>
                                </div>

                                <ul class="space-y-2 text-xs font-semibold text-stone-700">
                                    <li class="flex items-center gap-2 text-[#009688]">
                                        <span>✓</span> <span class="text-stone-800">3x Seminggu @90 menit</span>
                                    </li>
                                    <li class="flex items-center gap-2 text-[#009688]">
                                        <span>✓</span> <span class="text-stone-800">Flashcard & Game Edukasi</span>
                                    </li>
                                    <li class="flex items-center gap-2 text-[#009688]">
                                        <span>✓</span> <span class="text-stone-800">Metode Ramah Anak</span>
                                    </li>
                                </ul>

                                <div class="pt-4 border-t border-stone-200">
                                    <span class="text-[10px] font-extrabold text-stone-400 uppercase tracking-wider block">BIAYA</span>
                                    <div class="text-xl font-heading font-extrabold text-stone-900 mt-0.5">
                                        Rp 195.000 <span class="text-xs font-normal text-stone-500">/ bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA BUTTON -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-[#009688] hover:bg-[#00796B] text-white font-heading font-extrabold text-xs uppercase tracking-wider rounded-full border border-black transition-all">
                                Pilih Paket TK &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 2: JENJANG SD -->
                    <div class="bg-white rounded-3xl border-2 border-black shadow-neo overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Header Banner -->
                            <div class="bg-[#009688] text-white p-6 relative">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">SEKOLAH DASAR</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">Jenjang SD</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    SD
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">Fokus Pembelajaran:</span>
                                    <p class="text-xs text-stone-800 font-medium leading-relaxed">
                                        Semua Mapel Pokok (Tematik, Matematika, IPA, B. Indonesia, B. Inggris)
                                    </p>
                                </div>

                                <ul class="space-y-2 text-xs font-semibold text-stone-700">
                                    <li class="flex items-center gap-2 text-[#009688]">
                                        <span>✓</span> <span class="text-stone-800">3x Seminggu @90 menit</span>
                                    </li>
                                    <li class="flex items-center gap-2 text-[#009688]">
                                        <span>✓</span> <span class="text-stone-800">Pendampingan PR Sekolah</span>
                                    </li>
                                    <li class="flex items-center gap-2 text-[#009688]">
                                        <span>✓</span> <span class="text-stone-800">Persiapan Ulangan / PTS / PAS</span>
                                    </li>
                                </ul>

                                <div class="pt-4 border-t border-stone-200">
                                    <span class="text-[10px] font-extrabold text-stone-400 uppercase tracking-wider block">BIAYA</span>
                                    <div class="text-xl font-heading font-extrabold text-stone-900 mt-0.5">
                                        Rp 195.000 <span class="text-xs font-normal text-stone-500">/ bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA BUTTON -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-[#009688] hover:bg-[#00796B] text-white font-heading font-extrabold text-xs uppercase tracking-wider rounded-full border border-black transition-all">
                                Pilih Paket SD &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 3: JENJANG SMP -->
                    <div class="bg-white rounded-3xl border-2 border-black shadow-neo overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Header Banner -->
                            <div class="bg-[#193836] text-white p-6 relative">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">SEKOLAH MENENGAH PERTAMA</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">Jenjang SMP</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    SMP
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">Mapel Pilihan:</span>
                                    <p class="text-xs text-stone-800 font-medium leading-relaxed">
                                        Matematika, IPA, Inggris, B. Indo, IPS, TKA
                                    </p>
                                </div>

                                <!-- Package Price Pills -->
                                <div class="space-y-2 pt-2 border-t border-stone-100">
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 3 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-2.5 py-0.5 rounded-lg border border-black">Rp 240k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 4 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-2.5 py-0.5 rounded-lg border border-black">Rp 290k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 5 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-2.5 py-0.5 rounded-lg border border-black">Rp 340k/bln</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA BUTTON -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-[#009688] hover:bg-[#00796B] text-white font-heading font-extrabold text-xs uppercase tracking-wider rounded-full border border-black transition-all">
                                Pilih Paket SMP &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 4: SMA & UTBK -->
                    <div class="bg-white rounded-3xl border-2 border-black shadow-neo overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Header Banner -->
                            <div class="bg-[#009688] text-white p-6 relative">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">SEKOLAH MENENGAH ATAS</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">SMA & UTBK</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    SMA
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-3">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">Mapel Pilihan:</span>
                                    <p class="text-[11px] text-stone-800 font-medium leading-relaxed">
                                        Matematika Lanjutan, Matematika Wajib, Fisika, Kimia, Biologi, B. Indo, B. Ing, Ekonomi, TKA
                                    </p>
                                </div>

                                <!-- Package Price Pills -->
                                <div class="space-y-2 pt-1 border-t border-stone-100">
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 4 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-2.5 py-0.5 rounded-lg border border-black">Rp 350k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 5 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-2.5 py-0.5 rounded-lg border border-black">Rp 400k/bln</span>
                                    </div>
                                </div>

                                <div class="pt-2 text-xs font-semibold text-[#009688] flex items-center gap-1.5">
                                    <span>✓</span> <span>Tersedia kelas UTBK / SNBT</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA BUTTON -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-[#009688] hover:bg-[#00796B] text-white font-heading font-extrabold text-xs uppercase tracking-wider rounded-full border border-black transition-all">
                                Pilih Paket SMA &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- CTA & KONTAK SECTION (IMAGE 4 MATCH: DECORATIVE BUBBLE/CIRCLE BG, CTA BUTTONS & WHATSAPP) -->
        <section class="py-16 bg-[#F8FAFC]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="relative bg-[#193836] text-white rounded-3xl p-8 sm:p-12 lg:p-16 overflow-hidden border-2 border-black shadow-2xl">
                    
                    <!-- Decorative Circles/Bubbles Background Layer (No Linear Solid) -->
                    <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-[#009688]/30 pointer-events-none blur-2xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-[#FFE500]/20 pointer-events-none blur-3xl"></div>
                    <div class="absolute top-1/2 right-10 -translate-y-1/2 w-64 h-64 rounded-full border-8 border-white/10 pointer-events-none"></div>

                    <div class="relative z-10 max-w-3xl space-y-6">
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-extrabold text-white leading-tight">
                            Siap Antarkan Putra-Putri Anda Meraih Prestasi Terbaik?
                        </h2>
                        
                        <p class="text-stone-200 text-sm sm:text-base leading-relaxed max-w-2xl font-medium">
                            Daftarkan putra-putri Anda hari ini di Bimbel Pelita Ilmu. Dapatkan bimbingan intensif 4-6 siswa per kelompok dengan pengajar S1/S2 berdedikasi tinggi di Bimbel Pelita Ilmu!
                        </p>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4">
                            <!-- Yellow CTA Online Registration Button -->
                            <a href="{{ route('daftar') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#FFE500] hover:bg-yellow-400 text-stone-950 font-heading font-extrabold text-sm uppercase tracking-wider rounded-full border-2 border-black shadow-neo hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center">
                                DAFTAR SEKARANG SECARA ONLINE &rarr;
                            </a>

                            <!-- White WhatsApp Consultation Button -->
                            <a href="https://wa.me/6289624601717?text=Halo%20Admin%20Pelita%20Ilmu,%20saya%20ingin%20bertanya%20mengenai%20bimbingan%20belajar" target="_blank" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-stone-100 text-[#193836] font-heading font-extrabold text-sm rounded-full border-2 border-black shadow-neo hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center">
                                💬 Konsultasi via WhatsApp
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    <!-- SOLID FOOTER -->
    <footer id="kontak" class="bg-[#193836] text-white border-t border-stone-700">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-12 items-start">
                <div class="md:col-span-5 flex items-start gap-4">
                    <img src="{{ asset('images/logo-bimbel.png') }}" alt="Logo Pelita Ilmu" class="h-16 w-16 shrink-0 object-contain drop-shadow" onerror="this.src='{{ asset('images/logo-bimbel.jpeg') }}'">
                    <div class="space-y-1">
                        <h2 class="text-xl font-heading font-extrabold text-white">Pelita Ilmu</h2>
                        <p class="text-xs text-[#FFE500] font-bold tracking-wide uppercase">Bimbingan Belajar</p>
                        <p class="text-xs text-stone-300 leading-relaxed mt-1">
                            Jl. Rorojonggrang XV No. 6 RT 05 RW 10 Manyaran, Semarang Barat.
                        </p>
                    </div>
                </div>
                <div class="md:col-span-4 space-y-2">
                    <h3 class="text-sm font-heading font-extrabold text-white uppercase tracking-wider">Hubungi Kami</h3>
                    <ul class="space-y-1 text-xs text-stone-300">
                        <li><strong>089 624 601 717</strong> (Admin)</li>
                        <li><strong>085 866 455 553</strong> (Lita)</li>
                    </ul>
                </div>
                <div class="md:col-span-3 space-y-2">
                    <h3 class="text-sm font-heading font-extrabold text-white uppercase tracking-wider">Media Sosial</h3>
                    <ul class="space-y-1 text-xs text-stone-300">
                        <li>Instagram: <strong>@bimbelpelitailmu</strong></li>
                        <li>TikTok: <strong>@bimbelpelitailmu</strong></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-stone-700 py-4 text-center text-xs text-stone-400">
            &copy; {{ date('Y') }} <strong class="text-white">Pelita Ilmu Bimbel</strong>. Semua hak dilindungi.
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('liquid-mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
