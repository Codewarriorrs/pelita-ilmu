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
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        heading: ['Quicksand', 'Plus Jakarta Sans', 'sans-serif'],
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
                
                <!-- ANTI-METAL BUTTON: Primary Action (HOVER TEXT TURNS TO DARK GREEN #193836) -->
                <a href="{{ route('daftar') }}" class="group/btn relative inline-flex h-11 min-w-[220px] items-center justify-center overflow-hidden rounded-xl bg-[#009688] active:scale-[0.98] transition-transform shadow-md">
                    <span class="relative z-20 font-heading font-bold text-sm text-white group-hover/btn:text-[#193836] pl-12 pr-5 transition-colors duration-300">Daftar Bimbel Sekarang</span>
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
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border-2 border-black bg-white text-stone-900 shadow-sm hover:bg-stone-50 transition-all lg:hidden"
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
            
            <button onclick="toggleMobileMenu()" class="mt-2 py-2.5 px-4 bg-[#FFE500] text-stone-950 font-heading font-black rounded-xl text-xs uppercase tracking-wider shadow-sm hover:bg-yellow-400 transition-all">
                Tutup Menu
            </button>
        </div>
    </div>

    <main id="main-content" class="pt-20">
        
        <!-- HERO BANNER SECTION -->
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

                        <!-- ANTI-METAL BUTTON HERO CTA (HOVER TEXT TURNS TO DARK GREEN #193836) -->
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('daftar') }}" class="group/btn relative inline-flex h-14 min-w-[280px] items-center justify-center overflow-hidden rounded-2xl bg-[#FFE500] shadow-xl active:scale-95 transition-all border-2 border-black">
                                <span class="relative z-20 font-heading font-extrabold text-base text-stone-950 group-hover/btn:text-[#193836] pl-14 pr-6 transition-colors duration-300">DAFTAR BIMBEL SEKARANG</span>
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

        <!-- FEATURE BAR SECTION (SLEEK DARK TEAL CARDS WITH VECTOR ICONS) -->
        <section class="bg-[#193836] text-white py-12 border-t border-[#00796B] relative overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- CARD 1: Pengajar Berpengalaman -->
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-[#FFE500] transition-all">
                        <div class="w-12 h-12 rounded-xl bg-[#FFE500]/15 border border-[#FFE500]/30 text-[#FFE500] flex items-center justify-center shrink-0 group-hover:bg-[#FFE500] group-hover:text-stone-950 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v6.5"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-extrabold text-white group-hover:text-[#FFE500] transition-colors text-sm sm:text-base">Pengajar Berpengalaman</h4>
                            <p class="text-xs text-stone-300 mt-1 leading-relaxed">Pengajar berpendidikan S1 & S2 berkualitas tinggi.</p>
                        </div>
                    </div>

                    <!-- CARD 2: Active & Fun Learning -->
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-[#FFE500] transition-all">
                        <div class="w-12 h-12 rounded-xl bg-[#FFE500]/15 border border-[#FFE500]/30 text-[#FFE500] flex items-center justify-center shrink-0 group-hover:bg-[#FFE500] group-hover:text-stone-950 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-extrabold text-white group-hover:text-[#FFE500] transition-colors text-sm sm:text-base">Active & Fun Learning</h4>
                            <p class="text-xs text-stone-300 mt-1 leading-relaxed">Belajar dua arah, aktif, dan tidak membosankan.</p>
                        </div>
                    </div>

                    <!-- CARD 3: Pendidikan Berkarakter -->
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-[#FFE500] transition-all">
                        <div class="w-12 h-12 rounded-xl bg-[#FFE500]/15 border border-[#FFE500]/30 text-[#FFE500] flex items-center justify-center shrink-0 group-hover:bg-[#FFE500] group-hover:text-stone-950 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-extrabold text-white group-hover:text-[#FFE500] transition-colors text-sm sm:text-base">Pendidikan Berkarakter</h4>
                            <p class="text-xs text-stone-300 mt-1 leading-relaxed">Menanamkan kedisiplinan dan moral baik siswa.</p>
                        </div>
                    </div>

                    <!-- CARD 4: Komunikatif & Terbuka -->
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-[#FFE500] transition-all">
                        <div class="w-12 h-12 rounded-xl bg-[#FFE500]/15 border border-[#FFE500]/30 text-[#FFE500] flex items-center justify-center shrink-0 group-hover:bg-[#FFE500] group-hover:text-stone-950 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-extrabold text-white group-hover:text-[#FFE500] transition-colors text-sm sm:text-base">Komunikatif & Terbuka</h4>
                            <p class="text-xs text-stone-300 mt-1 leading-relaxed">Pendekatan hangat kepada siswa dan orang tua.</p>
                        </div>
                    </div>

                    <!-- CARD 5: Area Belajar Nyaman -->
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-[#FFE500] transition-all">
                        <div class="w-12 h-12 rounded-xl bg-[#FFE500]/15 border border-[#FFE500]/30 text-[#FFE500] flex items-center justify-center shrink-0 group-hover:bg-[#FFE500] group-hover:text-stone-950 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-extrabold text-white group-hover:text-[#FFE500] transition-colors text-sm sm:text-base">Area Belajar Nyaman</h4>
                            <p class="text-xs text-stone-300 mt-1 leading-relaxed">Ruang kelas tenang, ber-AC, & tersedia Wi-Fi gratis.</p>
                        </div>
                    </div>

                    <!-- CARD 6: Harga Sangat Terjangkau -->
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-[#122A28] border-2 border-stone-700/80 shadow-md hover:border-[#FFE500] transition-all">
                        <div class="w-12 h-12 rounded-xl bg-[#FFE500]/15 border border-[#FFE500]/30 text-[#FFE500] flex items-center justify-center shrink-0 group-hover:bg-[#FFE500] group-hover:text-stone-950 transition-all">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-heading font-extrabold text-white group-hover:text-[#FFE500] transition-colors text-sm sm:text-base">Harga Sangat Terjangkau</h4>
                            <p class="text-xs text-stone-300 mt-1 leading-relaxed">Mulai Rp195.000/bulan kualitas pendidikan terjamin.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- PROGRAM SECTION (UNIFORM STYLING & YELLOW NEOBRUTALIST BOX CTA BUTTONS) -->
        <section id="program" class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs font-bold text-[#009688] uppercase tracking-wider block mb-1">Program Bimbingan</span>
                    <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-stone-900 tracking-tight">Jenjang TK, SD, SMP, & SMA</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                    
                    <!-- CARD 1: JENJANG TK -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Uniform Header Banner -->
                            <div class="bg-[#009688] text-white p-6 relative border-b-2 border-black">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">TINGKAT PRASEKOLAH</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">Jenjang TK</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    TK
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">FOKUS PEMBELAJARAN:</span>
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
                        
                        <!-- CTA BUTTON (YELLOW KOTAK NEOBRUTALIST BUTTON) -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-[#FFE500] hover:bg-yellow-400 text-stone-950 font-heading font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET TK &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 2: JENJANG SD -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Uniform Header Banner -->
                            <div class="bg-[#009688] text-white p-6 relative border-b-2 border-black">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">SEKOLAH DASAR</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">Jenjang SD</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    SD
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">FOKUS PEMBELAJARAN:</span>
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
                        
                        <!-- CTA BUTTON (YELLOW KOTAK NEOBRUTALIST BUTTON) -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-[#FFE500] hover:bg-yellow-400 text-stone-950 font-heading font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET SD &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 3: JENJANG SMP -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Uniform Header Banner -->
                            <div class="bg-[#009688] text-white p-6 relative border-b-2 border-black">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">SEKOLAH MENENGAH PERTAMA</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">Jenjang SMP</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    SMP
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">MAPEL PILIHAN:</span>
                                    <p class="text-xs text-stone-800 font-medium leading-relaxed">
                                        Matematika, IPA, Inggris, B. Indo, IPS, TKA
                                    </p>
                                </div>

                                <!-- Package Price Pills -->
                                <div class="space-y-2 pt-2 border-t border-stone-100">
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 3 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-3 py-1 rounded-full border border-black shadow-sm">Rp 240k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 4 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-3 py-1 rounded-full border border-black shadow-sm">Rp 290k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 5 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-3 py-1 rounded-full border border-black shadow-sm">Rp 340k/bln</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA BUTTON (YELLOW KOTAK NEOBRUTALIST BUTTON) -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-[#FFE500] hover:bg-yellow-400 text-stone-950 font-heading font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET SMP &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- CARD 4: SMA & UTBK -->
                    <div class="bg-white rounded-[32px] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Uniform Header Banner -->
                            <div class="bg-[#009688] text-white p-6 relative border-b-2 border-black">
                                <span class="text-[10px] font-extrabold text-[#FFE500] uppercase tracking-wider block mb-1">SEKOLAH MENENGAH ATAS</span>
                                <h3 class="text-2xl font-heading font-extrabold text-white">SMA & UTBK</h3>
                                <span class="absolute top-5 right-5 w-9 h-9 rounded-full bg-[#FFE500] text-stone-950 font-black flex items-center justify-center text-xs border border-black shadow-sm">
                                    SMA
                                </span>
                            </div>

                            <!-- Body Content -->
                            <div class="p-6 space-y-3">
                                <div>
                                    <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider block mb-1">MAPEL PILIHAN:</span>
                                    <p class="text-[11px] text-stone-800 font-medium leading-relaxed">
                                        Matematika Lanjutan, Matematika Wajib, Fisika, Kimia, Biologi, B. Indo, B. Ing, Ekonomi, TKA
                                    </p>
                                </div>

                                <!-- Package Price Pills -->
                                <div class="space-y-2 pt-1 border-t border-stone-100">
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 4 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-3 py-1 rounded-full border border-black shadow-sm">Rp 350k/bln</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs py-1.5 px-3 rounded-xl bg-stone-50 border border-stone-200">
                                        <span class="font-bold text-stone-700">Paket 5 Mapel</span>
                                        <span class="font-extrabold text-stone-950 bg-[#FFE500] px-3 py-1 rounded-full border border-black shadow-sm">Rp 400k/bln</span>
                                    </div>
                                </div>

                                <div class="pt-2 text-xs font-semibold text-[#009688] flex items-center gap-1.5">
                                    <span>✓</span> <span>Tersedia kelas UTBK / SNBT</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA BUTTON (YELLOW KOTAK NEOBRUTALIST BUTTON) -->
                        <div class="p-6 pt-0">
                            <a href="{{ route('daftar') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 bg-[#FFE500] hover:bg-yellow-400 text-stone-950 font-heading font-extrabold text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all text-center">
                                PILIH PAKET SMA &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- CTA & KONTAK SECTION (WHATSAPP LOGO ADDED & GREEN TEXT) -->
        <section class="py-16 bg-[#F8FAFC]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="relative bg-[#193836] text-white rounded-3xl p-8 sm:p-12 lg:p-16 overflow-hidden border-2 border-black shadow-2xl">
                    
                    <!-- Decorative Circles/Bubbles Background Layer -->
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
                            <!-- Yellow CTA Online Registration Button (HOVER TEXT TURNS TO DARK GREEN #193836) -->
                            <a href="{{ route('daftar') }}" class="group/btn relative inline-flex h-14 items-center justify-center overflow-hidden rounded-full bg-[#FFE500] active:scale-95 transition-all border-2 border-black shadow-md px-8">
                                <span class="relative z-20 font-heading font-extrabold text-sm text-stone-950 group-hover/btn:text-[#193836] uppercase tracking-wider transition-colors duration-300">
                                    DAFTAR SEKARANG SECARA ONLINE &rarr;
                                </span>
                            </a>

                            <!-- White WhatsApp Button with WhatsApp SVG Logo & Green Text -->
                            <a href="https://wa.me/6289624601717?text=Halo%20Admin%20Pelita%20Ilmu,%20saya%20ingin%20bertanya%20mengenai%20bimbingan%20belajar" target="_blank" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-white hover:bg-stone-50 text-[#009688] font-heading font-extrabold text-sm rounded-full border-2 border-black shadow-md transition-all text-center">
                                <svg class="w-5 h-5 fill-current text-[#25D366] shrink-0" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span class="text-[#009688]">Konsultasi via WhatsApp</span>
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
            &copy; {{ date('Y') }} 
            <button type="button" onclick="triggerEasterEgg()" class="text-white hover:text-[#FFE500] font-bold transition-all inline-flex items-center gap-1 group focus:outline-none" title="Klik untuk kejutan Easter Egg! 💡">
                <span>Pelita Ilmu Bimbel</span>
                <span class="text-[#FFE500] group-hover:scale-125 transition-transform inline-block">💡✨</span>
            </button>. Semua hak dilindungi.
        </div>
    </footer>

    <!-- EASTER EGG MODAL -->
    <div id="easter-egg-modal" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/70 backdrop-blur-md p-4">
        <div class="relative w-full max-w-md bg-[#193836] border-4 border-[#FFE500] rounded-3xl p-6 sm:p-8 text-white shadow-2xl text-center overflow-hidden animate-bounce-once">
            <!-- Floating Glow Decor -->
            <div class="absolute -top-10 -left-10 w-36 h-36 bg-[#FFE500]/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -right-10 w-36 h-36 bg-[#009688]/40 rounded-full blur-2xl"></div>
            
            <!-- Trophy Lightbulb Badge -->
            <div class="relative mx-auto mb-4 w-20 h-20 rounded-full bg-[#FFE500] text-stone-950 flex items-center justify-center border-4 border-black shadow-xl animate-pulse">
                <svg class="w-10 h-10 text-stone-950" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7zm-2 18h4v1a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1z"/>
                </svg>
            </div>

            <span class="inline-block px-3 py-1 bg-[#009688] text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3 border border-black shadow-sm">
                🎉 YOU FOUND THE EASTER EGG!
            </span>
            
            <h3 class="text-2xl font-heading font-extrabold text-[#FFE500] mb-2">
                Rahasia Pelita Ilmu 🌟
            </h3>
            
            <p class="text-xs sm:text-sm text-stone-200 leading-relaxed mb-6 font-medium">
                "Pendidikan adalah senjata paling mematikan di dunia, karena dengan pendidikan Anda dapat mengubah dunia."
                <span class="block text-[#FFE500] font-bold mt-2">— Nelson Mandela</span>
            </p>

            <div class="p-3.5 bg-white/10 rounded-2xl border border-white/20 mb-6 text-xs text-stone-300 leading-relaxed">
                ⚡ <strong>Tips Sukses Belajar:</strong> Konsistensi 30 menit belajar setiap hari jauh lebih efektif dari belajar semalaman! Tetap semangat meraih mimpi bareng Pelita Ilmu! 🚀
            </div>

            <button type="button" onclick="closeEasterEgg()" class="w-full py-3.5 bg-[#FFE500] hover:bg-yellow-400 text-stone-950 font-heading font-black rounded-xl text-xs uppercase tracking-wider border-2 border-black shadow-md transition-all">
                Siap Berprestasi! 🎓
            </button>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('liquid-mobile-menu');
            menu.classList.toggle('hidden');
        }

        function triggerEasterEgg() {
            const modal = document.getElementById('easter-egg-modal');
            if (modal) {
                modal.classList.remove('hidden');
                createConfetti();
            }
        }

        function closeEasterEgg() {
            const modal = document.getElementById('easter-egg-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function createConfetti() {
            const colors = ['#FFE500', '#009688', '#ffffff', '#FF5722', '#4CAF50'];
            for (let i = 0; i < 40; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'fixed pointer-events-none z-[130] rounded-full';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = Math.random() * 100 + 'vh';
                confetti.style.width = (Math.random() * 10 + 6) + 'px';
                confetti.style.height = (Math.random() * 10 + 6) + 'px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.opacity = Math.random();
                confetti.style.transition = 'all 1.5s ease-out';
                document.body.appendChild(confetti);

                setTimeout(() => {
                    confetti.style.transform = `translate(${(Math.random() - 0.5) * 200}px, ${(Math.random() - 0.5) * 200}px) scale(0)`;
                    confetti.style.opacity = '0';
                }, 50);

                setTimeout(() => confetti.remove(), 1500);
            }
        }
    </script>
</body>
</html>
