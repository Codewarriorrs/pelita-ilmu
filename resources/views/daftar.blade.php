<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Pendaftaran Siswa Baru - Pelita Ilmu Bimbel</title>
    
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
    </style>
</head>
<body class="bg-canvas text-stone-800 min-h-screen flex flex-col justify-between antialiased selection:bg-[#009688] selection:text-white">

    <!-- SOLID HEADER NAVIGATION -->
    <header class="fixed top-0 left-0 right-0 z-50 h-20 bg-white border-b border-stone-200 shadow-sm">
        <nav class="mx-auto flex h-full max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Navigasi utama">
            
            <!-- Logo area -->
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
                <a href="{{ route('home') }}" class="px-3 py-2 text-stone-700 hover:text-[#009688] font-heading font-bold transition-colors">Beranda</a>
                <a href="{{ route('home') }}#program" class="px-3 py-2 text-stone-700 hover:text-[#009688] font-heading font-bold transition-colors">Program</a>
                <a href="{{ route('pendaftaran') }}" class="px-3 py-2 text-[#009688] font-heading font-bold border-b-2 border-[#009688]">Pendaftaran</a>
                <a href="{{ route('home') }}#kontak" class="px-3 py-2 text-stone-700 hover:text-[#009688] font-heading font-bold transition-colors">Kontak</a>
                
                <!-- ANTI-METAL BUTTON: Primary Header Action (HOVER TEXT TURNS TO DARK GREEN #193836) -->
                <a href="{{ route('pendaftaran') }}" class="group/btn relative inline-flex h-11 min-w-[220px] items-center justify-center overflow-hidden rounded-xl bg-[#009688] active:scale-[0.98] transition-transform shadow-md">
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
            <a href="{{ route('home') }}" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-white hover:text-[#FFE500] transition-colors">Beranda</a>
            <a href="{{ route('home') }}#program" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-white hover:text-[#FFE500] transition-colors">Program</a>
            <a href="{{ route('pendaftaran') }}" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-[#FFE500]">Pendaftaran</a>
            <a href="{{ route('home') }}#kontak" onclick="toggleMobileMenu()" class="text-base font-heading font-extrabold text-white hover:text-[#FFE500] transition-colors">Kontak</a>
            <button onclick="toggleMobileMenu()" class="mt-2 py-2.5 px-4 bg-[#FFE500] text-stone-950 font-heading font-black rounded-xl text-xs uppercase tracking-wider shadow-sm hover:bg-yellow-400 transition-all">
                Tutup Menu
            </button>
        </div>
    </div>

    <!-- MAIN REGISTRATION CONTENT -->
    <main class="flex-1 pt-24 pb-16">
        
        <!-- SOLID HEADER BANNER -->
        <section class="bg-[#009688] text-white py-10 lg:py-12 relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
                <span class="inline-block bg-[#FFE500] text-stone-950 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider mb-3 shadow-sm border border-black">
                    Formulir Pendaftaran Siswa Baru
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-extrabold text-white tracking-tight leading-tight">
                    Mulai Raih Prestasimu Bersama Kami
                </h1>
                <p class="text-stone-100 text-xs sm:text-sm max-w-xl mx-auto mt-2 font-medium">
                    Silakan lengkapi biodata calon siswa di bawah ini. Tim admin Pelita Ilmu akan segera mengonfirmasi pendaftaran Anda via WhatsApp.
                </p>
            </div>
        </section>

        <!-- WIDER MAIN FORM CONTAINER (MAX-W-6XL FOR EXPANDED SPACIOUS LAYOUT) -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
            
            <div class="rounded-3xl border-2 border-black bg-white p-8 sm:p-12 lg:p-14 shadow-xl">
                
                <!-- Flash Alert Success -->
                @if (session('success'))
                    <div class="mb-8 p-6 bg-[#193836] text-white rounded-2xl shadow-lg border-2 border-[#FFE500] flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#FFE500] text-stone-950 flex items-center justify-center shrink-0 font-black text-lg border border-black">
                            ✓
                        </div>
                        <div>
                            <h3 class="text-base font-heading font-extrabold text-[#FFE500]">Pendaftaran Berhasil Terkirim</h3>
                            <p class="text-xs sm:text-sm text-stone-200 mt-1 leading-relaxed">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-8 p-5 bg-red-50 text-red-900 rounded-2xl border-2 border-black text-xs sm:text-sm space-y-1 shadow-sm">
                        <strong class="block font-bold">Mohon periksa kembali isian formulir:</strong>
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('daftar.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <input type="text" name="website_address" class="hidden" tabindex="-1" autocomplete="off">

                    <!-- SECTION 1: DATA CALON SISWA -->
                    <div>
                        <div class="flex items-center gap-3 pb-3 mb-6 border-b-2 border-black">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#009688] text-white font-heading font-extrabold text-sm border border-black shadow-sm">1</span>
                            <h2 class="text-xl sm:text-2xl font-heading font-extrabold text-stone-900">Data Calon Siswa</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                    Nama Lengkap Siswa <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama_lengkap"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap') }}"
                                    placeholder="Contoh: Muhammad Rian Pratama"
                                    required
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                    Tanggal Lahir Siswa <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="tanggal_lahir"
                                    name="tanggal_lahir"
                                    max="{{ date('Y-m-d') }}"
                                    value="{{ old('tanggal_lahir') }}"
                                    required
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                            </div>

                            <!-- Asal Sekolah -->
                            <div>
                                <label for="asal_sekolah" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                    Asal Sekolah <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="asal_sekolah"
                                    name="asal_sekolah"
                                    value="{{ old('asal_sekolah') }}"
                                    placeholder="Contoh: SD Negeri Manyaran 01"
                                    required
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: PILIHAN PROGRAM & KATEGORI -->
                    <div class="pt-6 border-t-2 border-black">
                        <div class="flex items-center gap-3 pb-3 mb-6 border-b-2 border-black">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#009688] text-white font-heading font-extrabold text-sm border border-black shadow-sm">2</span>
                            <h2 class="text-xl sm:text-2xl font-heading font-extrabold text-stone-900">Pilihan Program & Kategori</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kategori Kelas Radio -->
                            <div class="md:col-span-2">
                                <label class="block text-xs sm:text-sm font-bold text-stone-700 mb-2">
                                    Kategori Kelas <span class="text-rose-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label class="flex items-center p-4 rounded-xl border-2 border-black cursor-pointer transition-all bg-white text-stone-900 shadow-sm hover:border-[#009688]">
                                        <input
                                            type="radio"
                                            name="kategori_kelas"
                                            value="Reguler"
                                            checked
                                            class="h-4 w-4 text-[#009688] border-black focus:ring-0"
                                        >
                                        <div class="ml-3">
                                            <span class="text-sm font-heading font-bold block">Reguler</span>
                                            <span class="text-xs text-stone-500">Reguler (Kelas Mini 4-6 Siswa)</span>
                                        </div>
                                    </label>

                                    <label class="flex items-center p-4 rounded-xl border-2 border-black cursor-pointer transition-all bg-white text-stone-900 shadow-sm hover:border-[#009688]">
                                        <input
                                            type="radio"
                                            name="kategori_kelas"
                                            value="Privat"
                                            class="h-4 w-4 text-[#009688] border-black focus:ring-0"
                                        >
                                        <div class="ml-3">
                                            <span class="text-sm font-heading font-bold block">Privat</span>
                                            <span class="text-xs text-stone-500">Privat (1-on-1 Intensif Khusus)</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Minat Program Dropdown -->
                            <div class="md:col-span-2">
                                <label for="minat_program" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                    Pilih Program Belajar <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="minat_program"
                                    name="minat_program"
                                    onchange="updateMapelOptions()"
                                    required
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                                    <option value="">-- Pilih Jenjang & Paket Program --</option>
                                    <option value="TK">Jenjang TK (Calistung, Mengaji, B. Inggris)</option>
                                    <option value="SD">Jenjang SD (Semua Mapel Pokok & Tematik)</option>
                                    <option value="SMP 3 Mapel">Jenjang SMP - Paket 3 Mapel</option>
                                    <option value="SMP 4 Mapel">Jenjang SMP - Paket 4 Mapel</option>
                                    <option value="SMP 5 Mapel">Jenjang SMP - Paket 5 Mapel</option>
                                    <option value="SMA 4 Mapel">Jenjang SMA - Paket 4 Mapel</option>
                                    <option value="SMA 5 Mapel">Jenjang SMA - Paket 5 Mapel</option>
                                    <option value="Kelas UTBK">Jenjang SMA - Intensif UTBK / SNBT</option>
                                </select>
                            </div>

                            <!-- DINAMIS MATA PELAJARAN -->
                            <div id="mapel-container" class="md:col-span-2 hidden pt-3">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-xs sm:text-sm font-bold text-stone-900">
                                        Pilih Mata Pelajaran <span class="text-rose-500">*</span>
                                    </label>
                                    <span id="mapel-limit-badge" class="bg-[#009688] text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm">
                                        Terpilih: 0 / 3
                                    </span>
                                </div>
                                <p id="mapel-info-text" class="text-xs text-stone-600 mb-3">
                                    Silakan centang mata pelajaran yang ingin diambil sesuai kuota paket program:
                                </p>

                                <div id="mapel-checkboxes" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <!-- Dynamic Checkboxes -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: DATA ORANG TUA & KONTAK -->
                    <div class="pt-6 border-t-2 border-black">
                        <div class="flex items-center gap-3 pb-3 mb-6 border-b-2 border-black">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#009688] text-white font-heading font-extrabold text-sm border border-black shadow-sm">3</span>
                            <h2 class="text-xl sm:text-2xl font-heading font-extrabold text-stone-900">Data Orang Tua & Kontak</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Ortu -->
                            <div class="md:col-span-2">
                                <label for="nama_wali" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                    Nama Orang Tua / Wali <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama_wali"
                                    name="nama_ortu"
                                    value="{{ old('nama_ortu') }}"
                                    placeholder="Contoh: Bapak Hendra / Ibu Sri"
                                    required
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                            </div>

                            <!-- No WA Ortu -->
                            <div>
                                <label for="nomor_wali" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                    Nomor WhatsApp Orang Tua <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="tel"
                                    id="nomor_wali"
                                    name="no_telp_ortu"
                                    value="{{ old('no_telp_ortu') }}"
                                    placeholder="08xxxxxxxxxx (hanya angka)"
                                    required
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                                <p class="mt-1 text-[11px] text-stone-500">Nomor ini digunakan untuk konfirmasi pendaftaran & jadwal belajar.</p>
                            </div>

                            <!-- No Telp Siswa -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="nomor_telepon_siswa" class="block text-xs sm:text-sm font-bold text-stone-700">
                                        Nomor Telepon Siswa
                                    </label>
                                    <span class="text-[11px] text-stone-500 bg-stone-100 px-2 py-0.5 rounded-md border border-black">Opsional</span>
                                </div>
                                <input
                                    type="tel"
                                    id="nomor_telepon_siswa"
                                    name="no_telp_siswa"
                                    value="{{ old('no_telp_siswa') }}"
                                    placeholder="08xxxxxxxxxx (bila ada)"
                                    class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-[#009688] focus:bg-white focus:outline-none transition-all shadow-sm"
                                >
                                <p class="mt-1 text-[11px] text-stone-500">Boleh dikosongkan untuk siswa jenjang TK / SD.</p>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: ALAMAT TEMPAT TINGGAL -->
                    <div class="pt-6 border-t-2 border-black">
                        <div class="flex items-center gap-3 pb-3 mb-6 border-b-2 border-black">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#009688] text-white font-heading font-extrabold text-sm border border-black shadow-sm">4</span>
                            <h2 class="text-xl sm:text-2xl font-heading font-extrabold text-stone-900">Alamat Tempat Tinggal</h2>
                        </div>
                        <div>
                            <label for="alamat_rumah" class="block text-xs sm:text-sm font-bold text-stone-700 mb-1.5">
                                Alamat Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <textarea
                                id="alamat_rumah"
                                name="alamat_rumah"
                                rows="3"
                                placeholder="Contoh: Jl. Rorojonggrang Barat No. 12 RT 03 RW 08, Manyaran, Semarang Barat"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-[#009688] focus:bg-white focus:outline-none transition-all resize-none shadow-sm"
                            >{{ old('alamat_rumah') }}</textarea>
                        </div>
                    </div>

                    <!-- SUBMIT ACTION AREA -->
                    <div class="pt-6 border-t-2 border-black">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            
                            <!-- BACK BUTTON -->
                            <a
                                href="/"
                                class="inline-flex items-center justify-center rounded-full border-2 border-black bg-white px-6 py-3.5 text-sm font-heading font-extrabold text-stone-900 hover:bg-stone-50 transition-all text-center shadow-sm"
                            >
                                Kembali ke Beranda
                            </a>

                            <!-- ANTI-METAL STYLED SUBMIT BUTTON (HOVER TEXT TURNS TO DARK GREEN #193836) -->
                            <button
                                type="submit"
                                class="group/btn relative inline-flex h-12 min-w-[280px] items-center justify-center overflow-hidden rounded-xl bg-[#193836] active:scale-[0.98] transition-transform cursor-pointer border-2 border-black shadow-md"
                            >
                                <span class="relative z-20 flex items-center justify-center font-heading font-extrabold text-sm text-white group-hover/btn:text-[#193836] pl-14 pr-6 transition-colors duration-300">
                                    KIRIM PENDAFTARAN SEKARANG
                                </span>
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
                            </button>
                        </div>

                        <div class="mt-5 text-center text-xs text-stone-500">
                            Data pendaftaran Anda aman dan langsung diproses secara privat oleh manajemen Bimbel Pelita Ilmu.
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <!-- SOLID FOOTER -->
    <footer id="kontak" class="bg-[#193836] text-white border-t border-stone-700">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-12 items-start">
                <div class="md:col-span-5 flex items-start gap-4">
                    <img src="{{ asset('images/logo-bimbel.png') }}" alt="Logo Pelita Ilmu" class="h-16 w-16 shrink-0 object-contain drop-shadow" onerror="this.src='{{ asset('images/logo-bimbel.jpeg') }}'">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-white">Pelita Ilmu</h2>
                        <p class="text-xs text-[#FFE500] font-bold tracking-wide uppercase">Bimbingan Belajar</p>
                        <p class="text-xs text-stone-300 leading-relaxed mt-1">
                            Jl. Rorojonggrang XV No. 6 RT 05 RW 10 Manyaran, Semarang Barat.
                        </p>
                    </div>
                </div>
                <div class="md:col-span-4 space-y-2">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Hubungi Kami</h3>
                    <ul class="space-y-1 text-xs text-stone-300">
                        <li><strong>089 624 601 717</strong> (Admin)</li>
                        <li><strong>085 866 455 553</strong> (Lita)</li>
                    </ul>
                </div>
                <div class="md:col-span-3 space-y-2">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Media Sosial</h3>
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
        <div class="relative w-full max-w-md bg-[#193836] border-4 border-[#FFE500] rounded-3xl p-6 sm:p-8 text-white shadow-2xl text-center overflow-hidden">
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

    <!-- JAVASCRIPT DINAMIS CHECKBOX MATA PELAJARAN & EASTER EGG -->
    <script>
        const mapelData = {
            'TK': ['Membaca & Calistung', 'Mengaji / Iqro', 'Bahasa Inggris Dasar', 'Kreativitas & Seni'],
            'SD': ['Matematika', 'Bahasa Indonesia', 'IPA (Ilmu Pengetahuan Alam)', 'IPS (Ilmu Pengetahuan Sosial)', 'Bahasa Inggris', 'Pendidikan Agama / Mengaji'],
            'SMP 3 Mapel': ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA (Fisika & Biologi)', 'IPS'],
            'SMP 4 Mapel': ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA (Fisika & Biologi)', 'IPS'],
            'SMP 5 Mapel': ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA (Fisika & Biologi)', 'IPS'],
            'SMA 4 Mapel': ['Matematika Wajib / Lanjut', 'Fisika / Ekonomi', 'Kimia / Geografi', 'Biologi / Sosiologi', 'Bahasa Inggris'],
            'SMA 5 Mapel': ['Matematika Wajib / Lanjut', 'Fisika / Ekonomi', 'Kimia / Geografi', 'Biologi / Sosiologi', 'Bahasa Inggris'],
            'Kelas UTBK': ['TPS (Tes Potensi Skolastik)', 'Penalaran Matematika', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Pengetahuan Kuantitatif']
        };

        function getMapelLimit(program) {
            if (program === 'SMP 3 Mapel') return 3;
            if (program === 'SMP 4 Mapel' || program === 'SMA 4 Mapel') return 4;
            if (program === 'SMP 5 Mapel' || program === 'SMA 5 Mapel') return 5;
            return 99;
        }

        function updateMapelOptions() {
            const select = document.getElementById('minat_program');
            const container = document.getElementById('mapel-container');
            const checkboxesDiv = document.getElementById('mapel-checkboxes');
            const infoText = document.getElementById('mapel-info-text');

            const selectedProgram = select.value;
            if (!selectedProgram) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            checkboxesDiv.innerHTML = '';

            const list = mapelData[selectedProgram] || mapelData['SD'];
            const maxLimit = getMapelLimit(selectedProgram);

            if (maxLimit < 99) {
                infoText.textContent = `Pilih maksimal ${maxLimit} mata pelajaran favorit sesuai paket ${selectedProgram}:`;
            } else {
                infoText.textContent = `Pilih mata pelajaran yang ingin difokuskan:`;
            }

            list.forEach((mapel) => {
                const label = document.createElement('label');
                label.className = 'flex items-center gap-2.5 p-3.5 rounded-xl border-2 border-black bg-stone-50 hover:bg-white hover:border-[#009688] cursor-pointer text-xs font-semibold text-stone-800 transition-all shadow-sm';
                label.innerHTML = `
                    <input type="checkbox" name="mata_pelajaran[]" value="${mapel}" onchange="handleMapelCheck(this, ${maxLimit})" class="mapel-cb h-4 w-4 text-[#009688] rounded border-black focus:ring-0">
                    <span>${mapel}</span>
                `;
                checkboxesDiv.appendChild(label);
            });

            updateMapelBadge(maxLimit);
        }

        function handleMapelCheck(checkbox, maxLimit) {
            const checkedCount = document.querySelectorAll('.mapel-cb:checked').length;
            if (maxLimit < 99 && checkedCount > maxLimit) {
                checkbox.checked = false;
                alert(`Batas maksimal untuk ${document.getElementById('minat_program').value} adalah ${maxLimit} mata pelajaran.`);
            }
            updateMapelBadge(maxLimit);
        }

        function updateMapelBadge(maxLimit) {
            const checkedCount = document.querySelectorAll('.mapel-cb:checked').length;
            const badge = document.getElementById('mapel-limit-badge');
            if (maxLimit < 99) {
                badge.textContent = `Terpilih: ${checkedCount} / ${maxLimit}`;
                if (checkedCount === maxLimit) {
                    badge.className = 'bg-[#009688] text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm';
                } else {
                    badge.className = 'bg-amber-500 text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm';
                }
            } else {
                badge.textContent = `Terpilih: ${checkedCount} Mapel`;
                badge.className = 'bg-[#009688] text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm';
            }
        }

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
