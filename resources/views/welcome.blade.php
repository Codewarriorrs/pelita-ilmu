<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Pelita Ilmu — Bimbingan Belajar & Privat TK, SD, SMP, SMA</title>
    <meta name="description" content="Solusi bimbingan belajar terpercaya di Manyaran, Semarang untuk jenjang TK, SD, SMP, hingga SMA. Menghadirkan pengajar berpendidikan S1/S2 dengan metode belajar yang aktif, seru, dan berkarakter.">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Script -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            700: '#0F766E',
                            800: '#115E59',
                            900: '#134E4A',
                            brand: '#0F766E',
                        },
                        yellow: {
                            brand: '#FFE500',
                            brandDark: '#F5D000',
                            card: '#FEF9E7',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFAFA;
            color: #2D3748;
        }
    </style>
</head>
<body class="bg-[#FAFAFA] text-stone-800 antialiased selection:bg-teal-700 selection:text-white">

    <!-- HEADER / NAVIGATION (Sesuai Referensi Gambar) -->
    <header class="bg-white border-b border-stone-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Left Logo -->
            <a href="/" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-teal-900 border-2 border-teal-700 p-1 flex items-center justify-center text-center shadow-sm">
                    <span class="text-[9px] font-black text-yellow-brand leading-none">Pelita<br><span class="text-white text-[8px]">Ilmu</span></span>
                </div>
                <div>
                    <span class="block text-xl font-extrabold text-stone-900 tracking-tight leading-none">Pelita Ilmu</span>
                    <span class="block text-[10px] font-bold text-teal-700 tracking-wider uppercase mt-1">Bimbingan Belajar</span>
                </div>
            </a>

            <!-- Middle Nav Links -->
            <nav class="hidden lg:flex items-center gap-6 font-semibold text-sm text-stone-700">
                <a href="/" class="bg-teal-50 text-teal-800 font-bold px-4 py-1.5 rounded-full border border-teal-200/60">Beranda</a>
                <a href="#tentang" class="hover:text-teal-700 transition-colors">Tentang Kami</a>
                <a href="#program" class="hover:text-teal-700 transition-colors">Program Bimbel</a>
                <a href="#keunggulan" class="hover:text-teal-700 transition-colors">Keunggulan</a>
                <a href="#lokasi" class="hover:text-teal-700 transition-colors">Lokasi</a>
                <a href="#kontak" class="hover:text-teal-700 transition-colors">Kontak</a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('daftar') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full font-bold text-sm text-stone-950 bg-yellow-brand hover:bg-yellow-brandDark shadow-sm hover:shadow transition-all">
                    Daftar Sekarang
                </a>
                
                <!-- Circular Login Icon Button -->
                <a href="{{ url('/admin/login') }}" class="w-10 h-10 rounded-full bg-teal-800 hover:bg-teal-900 text-white flex items-center justify-center shadow-sm transition-colors" title="Login Dashboard Admin / Guru">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>

        </div>
    </header>

    <main id="main-content">
        <!-- HERO SECTION (IDENTIK DENGAN GAMBAR REFERENSI) -->
        <section class="pt-10 pb-16 lg:pt-14 lg:pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                    
                    <!-- LEFT SIDE: TITLE, VALUE DESCRIPTION, CTA & METRICS -->
                    <div class="lg:col-span-6 xl:col-span-7">
                        
                        <!-- Yellow Highlight Title Box -->
                        <div class="bg-yellow-brand rounded-2xl px-6 sm:px-8 py-5 mb-6 inline-block max-w-2xl shadow-sm">
                            <h1 class="text-stone-950 font-black text-3xl sm:text-4xl md:text-5xl lg:text-[52px] tracking-tight leading-[1.12]">
                                Pelita<br>
                                Ilmu & Raih Prestasimu!
                            </h1>
                        </div>

                        <!-- Description Paragraph -->
                        <p class="text-stone-600 text-base sm:text-lg leading-relaxed mb-8 max-w-xl font-normal">
                            Solusi bimbingan belajar terpercaya di Manyaran, Semarang untuk jenjang TK, SD, SMP, hingga SMA. Menghadirkan pengajar berpendidikan S1/S2 dengan metode belajar yang aktif, seru, dan berkarakter.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap items-center gap-4 mb-10">
                            <!-- Button 1: Daftar Sekarang (Yellow Pill) -->
                            <a href="{{ route('daftar') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full font-bold text-sm sm:text-base text-stone-950 bg-yellow-brand hover:bg-yellow-brandDark shadow-sm hover:shadow active:scale-[0.99] transition-all">
                                <span>Daftar Sekarang</span>
                                <svg class="w-4 h-4 text-stone-950" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>

                            <!-- Button 2: Lihat Program Paket (Teal Pill) -->
                            <a href="#program" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full font-bold text-sm sm:text-base text-white bg-teal-700 hover:bg-teal-800 shadow-sm hover:shadow active:scale-[0.99] transition-all">
                                <span>Lihat Program Paket</span>
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </a>
                        </div>

                        <!-- 3 Metric Cards Grid -->
                        <div class="grid grid-cols-3 gap-3 sm:gap-4 max-w-lg">
                            <!-- Card 1 -->
                            <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm">
                                <span class="block text-teal-700 font-extrabold text-base sm:text-lg">100%</span>
                                <span class="block text-stone-500 text-xs mt-0.5 font-medium">Guru S1 & S2</span>
                            </div>

                            <!-- Card 2 -->
                            <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm">
                                <span class="block text-teal-700 font-extrabold text-base sm:text-lg">4 Jenjang</span>
                                <span class="block text-stone-500 text-xs mt-0.5 font-medium">TK • SD • SMP • SMA</span>
                            </div>

                            <!-- Card 3 -->
                            <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm">
                                <span class="block text-teal-700 font-extrabold text-base sm:text-lg">4 – 6 Siswa</span>
                                <span class="block text-stone-500 text-xs mt-0.5 font-medium">Kelas Intensif</span>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT SIDE: PHOTO CARD INSIDE TEAL FRAME -->
                    <div class="lg:col-span-6 xl:col-span-5">
                        <!-- Thick Teal Outer Container Frame -->
                        <div class="border-[6px] border-teal-700 rounded-[28px] p-3 bg-white shadow-xl max-w-md mx-auto">
                            
                            <!-- Image Classroom with Overlay Badge -->
                            <div class="relative rounded-2xl overflow-hidden aspect-[4/3] bg-stone-100">
                                <img 
                                    src="{{ asset('images/hero-belajar.jpg') }}" 
                                    alt="Suasana Belajar Bimbel Pelita Ilmu" 
                                    class="w-full h-full object-cover object-center"
                                    onerror="this.src='https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80'"
                                >
                                
                                <!-- Floating Pill Badge on Photo -->
                                <div class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-sm px-3.5 py-1.5 rounded-full text-xs font-bold text-stone-800 shadow-md flex items-center gap-1.5 border border-white">
                                    <svg class="w-3.5 h-3.5 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Suasana Belajar Ceria</span>
                                </div>
                            </div>

                            <!-- Light Yellow Bottom Price Card -->
                            <div class="bg-yellow-card p-3.5 sm:p-4 rounded-2xl flex items-center justify-between mt-3 border border-yellow-200/60">
                                <div class="flex items-center gap-3">
                                    <!-- Wallet/Piggy Icon -->
                                    <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center text-teal-700 shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-[11px] text-stone-500 font-semibold leading-tight">Biaya Mulai Dari</span>
                                        <span class="block text-stone-900 font-extrabold text-base sm:text-lg leading-tight">Rp 195.000<span class="text-xs font-normal text-stone-500">/bln</span></span>
                                    </div>
                                </div>

                                <a href="#program" class="bg-yellow-brand hover:bg-yellow-brandDark text-stone-950 font-bold text-xs px-4 py-2 rounded-full shadow-sm transition-all">
                                    Pilih Kelas
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- PROGRAM & BIAYA SECTION -->
        <section id="program" class="py-16 bg-white border-t border-stone-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-1">
                        Pilihan Jenjang & Biaya
                    </span>
                    <h2 class="text-3xl font-extrabold text-stone-900 mb-2">
                        Program Belajar Sesuai Kebutuhan
                    </h2>
                    <p class="text-stone-600 text-sm">
                        Biaya transparan per bulan sudah termasuk modul belajar, bimbingan tugas harian, dan tryout berkala.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- TK -->
                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm flex flex-col justify-between hover:border-teal-700 transition-all">
                        <div>
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-2">TK / PAUD</span>
                            <h3 class="text-xl font-bold text-stone-900 mb-1">Calistung Ceria</h3>
                            <p class="text-xs text-stone-500 mb-4">Baca, Tulis, Hitung & Motorik</p>
                            <div class="mb-4 pb-4 border-b border-stone-100">
                                <span class="text-2xl font-black text-teal-700">Rp 195.000</span>
                                <span class="text-xs text-stone-500">/bulan</span>
                            </div>
                            <ul class="space-y-2 text-xs text-stone-600 mb-6">
                                <li>✔ Metode fonik interaktif</li>
                                <li>✔ Modul bergambar ramah anak</li>
                                <li>✔ Maksimal 4 siswa/kelas</li>
                            </ul>
                        </div>
                        <a href="{{ route('daftar') }}?program=TK" class="w-full py-2.5 rounded-full text-center text-xs font-bold text-stone-950 bg-yellow-brand hover:bg-yellow-brandDark transition-colors">
                            Daftar TK
                        </a>
                    </div>

                    <!-- SD (Paling Populer) -->
                    <div class="bg-white rounded-2xl p-6 border-2 border-yellow-brand shadow-md flex flex-col justify-between relative -translate-y-1">
                        <div class="absolute -top-3 left-6 bg-yellow-brand text-stone-950 font-black text-[10px] px-3 py-0.5 rounded-full uppercase tracking-wider">
                            Paling Diminati
                        </div>
                        <div>
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-2 mt-1">SD (Kelas 1-6)</span>
                            <h3 class="text-xl font-bold text-stone-900 mb-1">Juara Kelas & Konsep</h3>
                            <p class="text-xs text-stone-500 mb-4">Matematika, IPA, Bahasa & Bantuan PR</p>
                            <div class="mb-4 pb-4 border-b border-stone-100">
                                <span class="text-2xl font-black text-teal-700">Rp 250.000</span>
                                <span class="text-xs text-stone-500">/bulan</span>
                            </div>
                            <ul class="space-y-2 text-xs text-stone-600 mb-6">
                                <li>✔ Bimbingan PR setiap hari</li>
                                <li>✔ Pemahaman konsep dasar</li>
                                <li>✔ Persiapan Asesmen & Ujian</li>
                            </ul>
                        </div>
                        <a href="{{ route('daftar') }}?program=SD" class="w-full py-2.5 rounded-full text-center text-xs font-bold text-stone-950 bg-yellow-brand hover:bg-yellow-brandDark transition-colors">
                            Daftar SD
                        </a>
                    </div>

                    <!-- SMP -->
                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm flex flex-col justify-between hover:border-teal-700 transition-all">
                        <div>
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-2">SMP (Kelas 7-9)</span>
                            <h3 class="text-xl font-bold text-stone-900 mb-1">Penguatan MIPA</h3>
                            <p class="text-xs text-stone-500 mb-4">Matematika, Fisika-Biologi, Inggris</p>
                            <div class="mb-4 pb-4 border-b border-stone-100">
                                <span class="text-2xl font-black text-teal-700">Rp 350.000</span>
                                <span class="text-xs text-stone-500">/bulan</span>
                            </div>
                            <ul class="space-y-2 text-xs text-stone-600 mb-6">
                                <li>✔ Trik logika soal olimpiade/PTS</li>
                                <li>✔ Simulasi berkala asesmen</li>
                                <li>✔ Target SMA Unggulan</li>
                            </ul>
                        </div>
                        <a href="{{ route('daftar') }}?program=SMP" class="w-full py-2.5 rounded-full text-center text-xs font-bold text-stone-950 bg-yellow-brand hover:bg-yellow-brandDark transition-colors">
                            Daftar SMP
                        </a>
                    </div>

                    <!-- SMA -->
                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm flex flex-col justify-between hover:border-teal-700 transition-all">
                        <div>
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-2">SMA (Kelas 10-12)</span>
                            <h3 class="text-xl font-bold text-stone-900 mb-1">Fokus UTBK & PTN</h3>
                            <p class="text-xs text-stone-500 mb-4">IPA / IPS & Penalaran Skolastik SNBT</p>
                            <div class="mb-4 pb-4 border-b border-stone-100">
                                <span class="text-2xl font-black text-teal-700">Rp 450.000</span>
                                <span class="text-xs text-stone-500">/bulan</span>
                            </div>
                            <ul class="space-y-2 text-xs text-stone-600 mb-6">
                                <li>✔ Bedah tipe soal SNBT & Mandiri</li>
                                <li>✔ Konsultasi pemilihan jurusan PTN</li>
                                <li>✔ Tryout berkala analisis skor</li>
                            </ul>
                        </div>
                        <a href="{{ route('daftar') }}?program=SMA" class="w-full py-2.5 rounded-full text-center text-xs font-bold text-stone-950 bg-yellow-brand hover:bg-yellow-brandDark transition-colors">
                            Daftar SMA
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- KEUNGGULAN SECTION -->
        <section id="keunggulan" class="py-16 bg-[#FAFAFA] border-t border-stone-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-1">Keunggulan Kami</span>
                    <h2 class="text-3xl font-extrabold text-stone-900">Kenapa Memilih Bimbel Pelita Ilmu?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <h4 class="font-bold text-stone-900 mb-1">Guru S1 & S2 Berdedikasi</h4>
                        <p class="text-xs text-stone-500 leading-relaxed">Pengajar berpengalaman yang sabar dan memahami karakter psikologi anak.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h4 class="font-bold text-stone-900 mb-1">Kelas Kecil 4-6 Siswa</h4>
                        <p class="text-xs text-stone-500 leading-relaxed">Perhatian penuh dan bimbingan yang fokus pada setiap kendala belajar siswa.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                        </div>
                        <h4 class="font-bold text-stone-900 mb-1">Pendekatan Paham Konsep</h4>
                        <p class="text-xs text-stone-500 leading-relaxed">Bukan sekadar hafalan kilat, siswa diajak memahami dasar logika agar tidak lupa.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-stone-200 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h4 class="font-bold text-stone-900 mb-1">Laporan Rutin ke Orang Tua</h4>
                        <p class="text-xs text-stone-500 leading-relaxed">Evaluasi dan progres nilai dikirim langsung ke WhatsApp orang tua secara berkala.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- LOKASI & KONTAK SECTION -->
        <section id="lokasi" class="py-16 bg-white border-t border-stone-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-teal-900 text-white rounded-3xl p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <span class="text-xs font-bold text-yellow-brand uppercase tracking-wider block mb-2">Lokasi Bimbel</span>
                        <h2 class="text-3xl font-extrabold mb-3">Kunjungi Kantor Bimbel Pelita Ilmu</h2>
                        <p class="text-teal-100 text-sm max-w-lg mb-4">
                            📍 Jl. Cendrawasih No. 18, Manyaran, Semarang Barat, Kota Semarang.<br>
                            Buka Senin – Sabtu (08.00 – 18.00 WIB).
                        </p>
                        <p class="text-xs text-teal-200">
                            WhatsApp Layanan Orang Tua: <strong>0812-3456-7890</strong>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://wa.me/6281234567890" target="_blank" class="px-6 py-3 rounded-full bg-yellow-brand hover:bg-yellow-brandDark text-stone-950 font-bold text-sm text-center transition-all">
                            Konsultasi via WhatsApp
                        </a>
                        <a href="{{ route('daftar') }}" class="px-6 py-3 rounded-full bg-white hover:bg-teal-50 text-teal-900 font-bold text-sm text-center transition-all">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-stone-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
            <p>&copy; {{ date('Y') }} Bimbel Pelita Ilmu. Seluruh hak cipta dilindungi.</p>
            <p>Mencerdaskan Generasi dengan Hati & Prestasi.</p>
        </div>
    </footer>
</body>
</html>
