@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Siswa Baru - Pelita Ilmu Bimbel')

@section('content')
    <!-- SOLID HEADER BANNER -->
    <section class="bg-primary text-white py-10 lg:py-12 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
            <p class="text-highlight text-xs sm:text-sm font-headline font-black uppercase tracking-widest mb-3">
                Formulir Pendaftaran Siswa Baru
            </p>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-headline font-extrabold text-white tracking-tight leading-tight">
                Mulai Raih Prestasimu Bersama Kami
            </h1>
            <p class="text-stone-100 text-xs sm:text-sm max-w-xl mx-auto mt-2 font-body font-medium">
                Silakan lengkapi biodata calon siswa di bawah ini. Tim admin Pelita Ilmu akan segera mengonfirmasi pendaftaran Anda via WhatsApp.
            </p>
        </div>
    </section>

    <!-- WIDER MAIN FORM CONTAINER -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20 pb-16">
        
        <div class="rounded-3xl border-2 border-black bg-white p-8 sm:p-12 lg:p-14 shadow-xl">
            
            <!-- Flash Alert Success -->
            @if (session('success'))
                <div class="mb-8 p-6 bg-[#193836] text-white rounded-2xl shadow-lg border-2 border-highlight flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-highlight text-void flex items-center justify-center shrink-0 font-black text-lg border border-black">
                        ✓
                    </div>
                    <div>
                        <h3 class="text-base font-headline font-extrabold text-highlight">Pendaftaran Berhasil Terkirim</h3>
                        <p class="text-xs sm:text-sm text-stone-200 mt-1 leading-relaxed font-body">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-8 p-5 bg-red-50 text-red-900 rounded-2xl border-2 border-black text-xs sm:text-sm space-y-1 shadow-sm font-body">
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
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-white font-headline font-extrabold text-sm border border-black shadow-sm">1</span>
                        <h2 class="text-xl sm:text-2xl font-headline font-extrabold text-void">Data Calon Siswa</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="nama_lengkap" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Nama Lengkap Siswa <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_lengkap"
                                name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                placeholder="Contoh: Muhammad Rian Pratama"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Tanggal Lahir Siswa <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="date"
                                id="tanggal_lahir"
                                name="tanggal_lahir"
                                max="{{ date('Y-m-d') }}"
                                value="{{ old('tanggal_lahir') }}"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                        </div>

                        <!-- Asal Sekolah -->
                        <div class="md:col-span-2">
                            <label for="asal_sekolah" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Asal Sekolah <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="asal_sekolah"
                                name="asal_sekolah"
                                value="{{ old('asal_sekolah') }}"
                                placeholder="Contoh: SD Negeri Manyaran 01 / SMP Negeri 1 Semarang"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                        </div>

                        <!-- Jenjang Pendidikan -->
                        <div>
                            <label for="jenjang" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Jenjang Pendidikan <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="jenjang"
                                name="jenjang"
                                onchange="handleJenjangChange()"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                                <option value="">-- Pilih Jenjang Sekolah --</option>
                                <option value="TK" {{ old('jenjang', request('jenjang')) == 'TK' ? 'selected' : '' }}>TK / Prasekolah</option>
                                <option value="SD" {{ old('jenjang', request('jenjang')) == 'SD' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                                <option value="SMP" {{ old('jenjang', request('jenjang')) == 'SMP' ? 'selected' : '' }}>SMP (Menengah Pertama)</option>
                                <option value="SMA" {{ old('jenjang', request('jenjang')) == 'SMA' ? 'selected' : '' }}>SMA / SMK / UTBK SNBT</option>
                            </select>
                        </div>

                        <!-- Kelas -->
                        <div>
                            <label for="kelas" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Tingkat Kelas <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="kelas"
                                name="kelas"
                                onchange="handleKelasChange()"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body disabled:opacity-50 disabled:bg-stone-200"
                            >
                                <option value="">-- Pilih Jenjang Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: PILIHAN PROGRAM & KATEGORI -->
                <div class="pt-6 border-t-2 border-black">
                    <div class="flex items-center gap-3 pb-3 mb-6 border-b-2 border-black">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-white font-headline font-extrabold text-sm border border-black shadow-sm">2</span>
                        <h2 class="text-xl sm:text-2xl font-headline font-extrabold text-void">Pilihan Program & Kategori</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori Kelas Radio -->
                        <div class="md:col-span-2">
                            <label class="block text-xs sm:text-sm font-bold text-void mb-2 font-subtitle">
                                Kategori Kelas <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 rounded-xl border-2 border-black cursor-pointer transition-all bg-white text-void shadow-sm hover:border-primary">
                                    <input
                                        type="radio"
                                        name="kategori_kelas"
                                        value="Reguler"
                                        checked
                                        class="h-4 w-4 text-primary border-black focus:ring-0"
                                    >
                                    <div class="ml-3">
                                        <span class="text-sm font-headline font-bold block">Reguler</span>
                                        <span class="text-xs text-stone-500 font-body">Reguler (Kelas Kelompok)</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 rounded-xl border-2 border-black cursor-pointer transition-all bg-white text-void shadow-sm hover:border-primary">
                                    <input
                                        type="radio"
                                        name="kategori_kelas"
                                        value="Privat"
                                        class="h-4 w-4 text-primary border-black focus:ring-0"
                                    >
                                    <div class="ml-3">
                                        <span class="text-sm font-headline font-bold block">Privat</span>
                                        <span class="text-xs text-stone-500 font-body">Privat (1-on-1 Intensif Khusus)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Minat Program Dropdown -->
                        <div class="md:col-span-2">
                            <label for="minat_program" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Pilih Program Belajar <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="minat_program"
                                name="minat_program"
                                onchange="updateMapelOptions()"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body disabled:opacity-50 disabled:bg-stone-200"
                            >
                                <option value="">-- Pilih Jenjang & Kelas Terlebih Dahulu --</option>
                            </select>
                            <p class="text-xs text-stone-500 mt-1 font-body">Pilihan program belajar disesuaikan otomatis dengan jenjang dan kelas yang dipilih.</p>
                        </div>

                        <!-- DINAMIS MATA PELAJARAN -->
                        <div id="mapel-container" class="md:col-span-2 hidden pt-3">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs sm:text-sm font-bold text-void font-subtitle">
                                    Pilih Mata Pelajaran <span class="text-rose-500">*</span>
                                </label>
                                <span id="mapel-limit-badge" class="bg-primary text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm font-body">
                                    Terpilih: 0 / 3
                                </span>
                            </div>
                            <p id="mapel-info-text" class="text-xs text-stone-600 mb-3 font-body">
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
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-white font-headline font-extrabold text-sm border border-black shadow-sm">3</span>
                        <h2 class="text-xl sm:text-2xl font-headline font-extrabold text-void">Data Orang Tua & Kontak</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ortu -->
                        <div class="md:col-span-2">
                            <label for="nama_wali" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Nama Orang Tua / Wali <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_wali"
                                name="nama_ortu"
                                value="{{ old('nama_ortu') }}"
                                placeholder="Contoh: Bapak Hendra / Ibu Sri"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                        </div>

                        <!-- No WA Ortu -->
                        <div>
                            <label for="nomor_wali" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Nomor WhatsApp Orang Tua <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="tel"
                                id="nomor_wali"
                                name="no_telp_ortu"
                                value="{{ old('no_telp_ortu') }}"
                                placeholder="08xxxxxxxxxx (hanya angka)"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                            <p class="mt-1 text-[11px] text-stone-500 font-body">Nomor ini digunakan untuk konfirmasi pendaftaran & jadwal belajar.</p>
                        </div>

                        <!-- No Telp Siswa -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="nomor_telepon_siswa" class="block text-xs sm:text-sm font-bold text-void font-subtitle">
                                    Nomor WhatsApp / HP Siswa
                                </label>
                                <span class="text-[11px] text-stone-500 bg-stone-100 px-2 py-0.5 rounded-md border border-black font-body">Opsional</span>
                            </div>
                            <input
                                type="tel"
                                id="nomor_telepon_siswa"
                                name="no_telp_siswa"
                                value="{{ old('no_telp_siswa') }}"
                                placeholder="08xxxxxxxxxx (bila ada)"
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
                            <p class="mt-1 text-[11px] text-stone-500 font-body">Boleh dikosongkan untuk siswa jenjang TK / SD.</p>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: ALAMAT TEMPAT TINGGAL -->
                <div class="pt-6 border-t-2 border-black">
                    <div class="flex items-center gap-3 pb-3 mb-6 border-b-2 border-black">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-white font-headline font-extrabold text-sm border border-black shadow-sm">4</span>
                        <h2 class="text-xl sm:text-2xl font-headline font-extrabold text-void">Alamat Tempat Tinggal</h2>
                    </div>
                    <div>
                        <label for="alamat_rumah" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                            Alamat Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <textarea
                            id="alamat_rumah"
                            name="alamat_rumah"
                            rows="3"
                            placeholder="Contoh: Jl. Rorojonggrang Barat No. 12 RT 03 RW 08, Manyaran, Semarang Barat"
                            required
                            class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all resize-none shadow-sm font-body"
                        >{{ old('alamat_rumah') }}</textarea>
                    </div>
                </div>

                <!-- SUBMIT ACTION AREA -->
                <div class="pt-6 border-t-2 border-black">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        
                        <!-- BACK BUTTON -->
                        <a
                            href="{{ route('home') }}"
                            class="inline-flex items-center justify-center rounded-full border-2 border-black bg-white px-6 py-3.5 text-sm font-headline font-extrabold text-void hover:bg-stone-50 transition-all text-center shadow-sm"
                        >
                            Kembali ke Beranda
                        </a>

                        <!-- ANTI-METAL STYLED SUBMIT BUTTON -->
                        <button
                            type="submit"
                            id="btn-submit-pendaftaran"
                            class="group/btn relative inline-flex h-12 min-w-[280px] items-center justify-center overflow-hidden rounded-xl bg-[#193836] active:scale-[0.98] transition-transform cursor-pointer border-2 border-black shadow-md"
                        >
                            <span class="relative z-20 flex items-center justify-center font-headline font-extrabold text-sm text-white group-hover/btn:text-[#193836] pl-14 pr-6 transition-colors duration-300">
                                KIRIM PENDAFTARAN SEKARANG
                            </span>
                            <span aria-hidden="true" class="absolute bottom-1 left-1 top-1 z-10 flex w-9 items-center justify-center overflow-hidden rounded-lg bg-highlight transition-[width] duration-300 ease-[cubic-bezier(0.65,0,0.35,1)] group-hover/btn:w-[calc(100%-0.5rem)]">
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

                    <div class="mt-5 text-center text-xs text-stone-500 font-body">
                        Data pendaftaran Anda aman dan langsung diproses secara privat oleh manajemen Bimbel Pelita Ilmu.
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- JAVASCRIPT DINAMIS KELAS, PROGRAM & CHECKBOX MATA PELAJARAN -->
    <script>
        const smpMapelList = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA Fisika', 'IPA Biologi', 'IPS'];
        const smaMapelList = ['Matematika Wajib / Lanjut', 'Fisika / Ekonomi', 'Kimia / Geografi', 'Biologi / Sosiologi', 'Bahasa Inggris', 'Informatika / Sejarah'];

        const mapelData = {
            'TK': ['Membaca & Calistung', 'Mengaji / Iqro', 'Bahasa Inggris Dasar', 'Kreativitas & Seni'],
            'SD Kelas 1-5': ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Bahasa Inggris', 'Pendidikan Agama / Mengaji'],
            'SD Kelas 6': ['Matematika', 'Bahasa Indonesia', 'IPA', 'Bahasa Inggris', 'Persiapan Ujian Sekolah'],
            'SD Kelas 6 TKA': ['TKA Matematika SD', 'TKA Bahasa Indonesia SD', 'TKA Sains SD'],
            'SMP 1 Mapel': smpMapelList,
            'SMP 2 Mapel': smpMapelList,
            'SMP 3 Mapel': smpMapelList,
            'SMP 4 Mapel': smpMapelList,
            'SMP 5 Mapel': smpMapelList,
            'SMP 6 Mapel': smpMapelList,
            'SMP TKA 1 Mapel': ['TKA Matematika SMP', 'TKA Bahasa Indonesia SMP', 'TKA Bahasa Inggris SMP', 'TKA IPA SMP'],
            'SMP TKA 2 Mapel': ['TKA Matematika SMP', 'TKA Bahasa Indonesia SMP', 'TKA Bahasa Inggris SMP', 'TKA IPA SMP'],
            'SMA 1 Mapel': smaMapelList,
            'SMA 2 Mapel': smaMapelList,
            'SMA 3 Mapel': smaMapelList,
            'SMA 4 Mapel': smaMapelList,
            'SMA 5 Mapel': smaMapelList,
            'SMA 6 Mapel': smaMapelList,
            'SMA UTBK 1': ['TPS (Tes Potensi Skolastik)', 'Penalaran Matematika', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Pengetahuan Kuantitatif'],
            'SMA UTBK 2': ['TPS (Tes Potensi Skolastik)', 'Penalaran Matematika', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Pengetahuan Kuantitatif'],
            'SMA UTBK 3': ['TPS (Tes Potensi Skolastik)', 'Penalaran Matematika', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Pengetahuan Kuantitatif'],
            'SMA UTBK 4': ['TPS (Tes Potensi Skolastik)', 'Penalaran Matematika', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Pengetahuan Kuantitatif'],
            'SMA UTBK+Reg 1': smaMapelList.concat(['Penalaran UTBK']),
            'SMA UTBK+Reg 2': smaMapelList.concat(['Penalaran UTBK']),
            'SMA UTBK+Reg 3': smaMapelList.concat(['Penalaran UTBK']),
            'SMA UTBK+Reg 4': smaMapelList.concat(['Penalaran UTBK']),
        };

        const kelasOptions = {
            'TK': ['TK A', 'TK B', 'PAUD'],
            'SD': ['Kelas 1 SD', 'Kelas 2 SD', 'Kelas 3 SD', 'Kelas 4 SD', 'Kelas 5 SD', 'Kelas 6 SD'],
            'SMP': ['Kelas 7 SMP', 'Kelas 8 SMP', 'Kelas 9 SMP'],
            'SMA': ['Kelas 10 SMA', 'Kelas 11 SMA', 'Kelas 12 SMA', 'Alumni / Gap Year (Persiapan UTBK)']
        };

        const programsByJenjang = {
            'TK': [
                { value: 'TK', label: 'TK — Calistung, Mengaji, Bahasa Inggris' }
            ],
            'SD': [
                { value: 'SD Kelas 1-5', label: 'SD Kelas 1–5 — Semua Mapel Pokok & Tematik', kelasFilter: ['Kelas 1 SD', 'Kelas 2 SD', 'Kelas 3 SD', 'Kelas 4 SD', 'Kelas 5 SD'] },
                { value: 'SD Kelas 6', label: 'SD Kelas 6 — Persiapan US + Intensif', kelasFilter: ['Kelas 6 SD'] },
                { value: 'SD Kelas 6 TKA', label: 'SD Kelas 6 — Hanya TKA / Persiapan SMP', kelasFilter: ['Kelas 6 SD'] }
            ],
            'SMP': [
                { value: 'SMP 1 Mapel', label: 'SMP — 1 Mata Pelajaran' },
                { value: 'SMP 2 Mapel', label: 'SMP — 2 Mata Pelajaran' },
                { value: 'SMP 3 Mapel', label: 'SMP — 3 Mata Pelajaran' },
                { value: 'SMP 4 Mapel', label: 'SMP — 4 Mata Pelajaran' },
                { value: 'SMP 5 Mapel', label: 'SMP — 5 Mata Pelajaran' },
                { value: 'SMP 6 Mapel', label: 'SMP — 6 Mata Pelajaran' },
                { value: 'SMP TKA 1 Mapel', label: 'SMP — 1 TKA (Khusus TKA Saja)' },
                { value: 'SMP TKA 2 Mapel', label: 'SMP — 2 TKA (Khusus TKA Saja)' }
            ],
            'SMA': [
                { value: 'SMA 1 Mapel', label: 'SMA — 1 Mata Pelajaran' },
                { value: 'SMA 2 Mapel', label: 'SMA — 2 Mata Pelajaran' },
                { value: 'SMA 3 Mapel', label: 'SMA — 3 Mata Pelajaran' },
                { value: 'SMA 4 Mapel', label: 'SMA — 4 Mata Pelajaran' },
                { value: 'SMA 5 Mapel', label: 'SMA — 5 Mata Pelajaran' },
                { value: 'SMA 6 Mapel', label: 'SMA — 6 Mata Pelajaran' },
                { value: 'SMA UTBK 1', label: 'SMA — 1 Mapel UTBK / SNBT' },
                { value: 'SMA UTBK 2', label: 'SMA — 2 Mapel UTBK / SNBT' },
                { value: 'SMA UTBK 3', label: 'SMA — 3 Mapel UTBK / SNBT' },
                { value: 'SMA UTBK 4', label: 'SMA — 4 Mapel UTBK / SNBT' },
                { value: 'SMA UTBK+Reg 1', label: 'SMA — 1 Mapel UTBK + Reguler' },
                { value: 'SMA UTBK+Reg 2', label: 'SMA — 2 Mapel UTBK + Reguler' },
                { value: 'SMA UTBK+Reg 3', label: 'SMA — 3 Mapel UTBK + Reguler' },
                { value: 'SMA UTBK+Reg 4', label: 'SMA — 4 Mapel UTBK + Reguler' }
            ]
        };

        const initialJenjang = @json(old('jenjang', request('jenjang', '')));
        const initialKelas = @json(old('kelas', old('tingkat_kelas', '')));
        const initialProgram = @json(old('minat_program', ''));

        function handleJenjangChange(preserve = false) {
            const jenjangSelect = document.getElementById('jenjang');
            const kelasSelect = document.getElementById('kelas');
            const programSelect = document.getElementById('minat_program');
            const mapelContainer = document.getElementById('mapel-container');

            if (!jenjangSelect || !kelasSelect || !programSelect) return;

            const selectedJenjang = jenjangSelect.value;
            kelasSelect.innerHTML = '';

            if (!selectedJenjang || !kelasOptions[selectedJenjang]) {
                kelasSelect.disabled = true;
                kelasSelect.innerHTML = '<option value="">-- Pilih Jenjang Terlebih Dahulu --</option>';
                programSelect.disabled = true;
                programSelect.innerHTML = '<option value="">-- Pilih Jenjang & Kelas Terlebih Dahulu --</option>';
                if (mapelContainer) mapelContainer.classList.add('hidden');
                return;
            }

            kelasSelect.disabled = false;
            kelasSelect.innerHTML = '<option value="">-- Pilih Tingkat Kelas --</option>';
            kelasOptions[selectedJenjang].forEach((item) => {
                const opt = document.createElement('option');
                opt.value = item;
                opt.textContent = item;
                kelasSelect.appendChild(opt);
            });

            if (preserve && initialKelas) {
                kelasSelect.value = initialKelas;
            }

            handleKelasChange(preserve);
        }

        function handleKelasChange(preserve = false) {
            const jenjangSelect = document.getElementById('jenjang');
            const kelasSelect = document.getElementById('kelas');
            const programSelect = document.getElementById('minat_program');
            const mapelContainer = document.getElementById('mapel-container');

            if (!jenjangSelect || !kelasSelect || !programSelect) return;

            const selectedJenjang = jenjangSelect.value;
            const selectedKelas = kelasSelect.value;

            programSelect.innerHTML = '';

            if (!selectedKelas) {
                programSelect.disabled = true;
                programSelect.innerHTML = '<option value="">-- Pilih Tingkat Kelas Terlebih Dahulu --</option>';
                if (mapelContainer) mapelContainer.classList.add('hidden');
                return;
            }

            programSelect.disabled = false;
            programSelect.innerHTML = '<option value="">-- Pilih Program Belajar --</option>';

            const programList = programsByJenjang[selectedJenjang] || [];
            programList.forEach((prog) => {
                if (prog.kelasFilter && !prog.kelasFilter.includes(selectedKelas)) {
                    return;
                }
                const opt = document.createElement('option');
                opt.value = prog.value;
                opt.textContent = prog.label;
                programSelect.appendChild(opt);
            });

            if (preserve && initialProgram) {
                programSelect.value = initialProgram;
            } else if (programSelect.options.length === 2) {
                // Jika hanya ada 1 pilihan program (misal TK), otomatis pilihkan
                programSelect.selectedIndex = 1;
            } else if (programSelect.options.length > 1 && !preserve) {
                programSelect.selectedIndex = 1;
            }

            updateMapelOptions();
        }

        function getExactMapelRequired(program) {
            const match = program.match(/(\d+)\s*Mapel/i) || program.match(/UTBK\s*(\d+)/i) || program.match(/TKA\s*(\d+)/i);
            if (match) return parseInt(match[1]);
            return null; // Otomatis/bebas untuk TK/SD
        }

        function updateMapelOptions() {
            const select = document.getElementById('minat_program');
            const container = document.getElementById('mapel-container');
            const checkboxesDiv = document.getElementById('mapel-checkboxes');
            const infoText = document.getElementById('mapel-info-text');
            const badge = document.getElementById('mapel-limit-badge');

            if (!select || !container || !checkboxesDiv || !infoText) return;

            const selectedProgram = select.value;
            if (!selectedProgram) {
                container.classList.add('hidden');
                return;
            }

            const jenjangSelect = document.getElementById('jenjang');
            const currentJenjang = jenjangSelect ? jenjangSelect.value : '';

            // Untuk Jenjang TK dan SD: Otomatis mencakup semua mapel (tanpa checkbox manual)
            if (currentJenjang === 'TK' || currentJenjang === 'SD' || selectedProgram === 'TK' || selectedProgram.startsWith('SD')) {
                container.classList.remove('hidden');
                checkboxesDiv.innerHTML = `
                    <div class="col-span-full p-4 rounded-xl border-2 border-emerald-600 bg-emerald-50 text-emerald-950 flex items-start gap-3 shadow-sm font-body">
                        <span class="text-emerald-700 text-lg font-black leading-none">✓</span>
                        <div class="text-xs">
                            <strong class="font-headline font-bold block text-sm mb-1 text-emerald-900">
                                Paket Komplit — Semua Mata Pelajaran Termasuk Otomatis
                            </strong>
                            <p class="text-emerald-800 leading-relaxed">
                                Untuk jenjang <strong>${currentJenjang === 'TK' ? 'TK' : 'SD'}</strong>, bimbingan belajar langsung mencakup seluruh mata pelajaran pokok & bimbingan tugas sekolah secara menyeluruh (${currentJenjang === 'TK' ? 'Calistung, Mengaji, dan Bahasa Inggris' : 'Matematika, IPA, IPS, B. Indonesia, B. Inggris, & Tematik'}). Anda tidak perlu mencentang mata pelajaran.
                            </p>
                        </div>
                    </div>
                `;
                infoText.textContent = `Cakupan program untuk jenjang ${currentJenjang === 'TK' ? 'TK' : 'SD'}:`;
                if (badge) {
                    badge.textContent = 'Semua Mapel Otomatis Aktif ✓';
                    badge.className = 'bg-emerald-600 text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm font-body';
                }
                return;
            }

            // Untuk Jenjang SMP & SMA: Tampilkan pilihan mata pelajaran sesuai paket
            container.classList.remove('hidden');
            checkboxesDiv.innerHTML = '';

            const list = mapelData[selectedProgram] || smaMapelList;
            const exactCount = getExactMapelRequired(selectedProgram);

            if (exactCount !== null) {
                infoText.innerHTML = `Anda memilih <strong>${selectedProgram}</strong>. Wajib mencentang <span class="text-rose-600 font-bold underline">tepat ${exactCount} mata pelajaran</span>:`;
            } else {
                infoText.textContent = `Pilihan mata pelajaran fokus untuk program ${selectedProgram}:`;
            }

            list.forEach((mapel) => {
                const label = document.createElement('label');
                label.className = 'flex items-center gap-2.5 p-3.5 rounded-xl border-2 border-black bg-stone-50 hover:bg-white hover:border-primary cursor-pointer text-xs font-semibold text-void transition-all shadow-sm font-body';
                label.innerHTML = `
                    <input type="checkbox" name="mata_pelajaran[]" value="${mapel}" onchange="handleMapelCheck(this, ${exactCount})" class="mapel-cb h-4 w-4 text-primary rounded border-black focus:ring-0">
                    <span>${mapel}</span>
                `;
                checkboxesDiv.appendChild(label);
            });

            updateMapelBadge(exactCount);
        }

        function handleMapelCheck(checkbox, exactCount) {
            const checkedCount = document.querySelectorAll('.mapel-cb:checked').length;
            if (exactCount !== null && checkedCount > exactCount) {
                checkbox.checked = false;
                alert(`Perhatian: Anda memilih paket ${document.getElementById('minat_program').value}, kuota maksimal hanya ${exactCount} mata pelajaran. Hapus centang mapel lain terlebih dahulu jika ingin mengganti pilihan.`);
            }
            updateMapelBadge(exactCount);
        }

        function updateMapelBadge(exactCount) {
            const checkedCount = document.querySelectorAll('.mapel-cb:checked').length;
            const badge = document.getElementById('mapel-limit-badge');
            if (!badge) return;

            if (exactCount !== null) {
                if (checkedCount === exactCount) {
                    badge.textContent = `Terpilih: ${checkedCount} / ${exactCount} (Sesuai Kuota Paket ✓)`;
                    badge.className = 'bg-emerald-600 text-white text-[11px] font-bold px-3.5 py-1 rounded-full border border-black shadow-sm font-body animate-pulse';
                } else {
                    const sisa = exactCount - checkedCount;
                    badge.textContent = `Terpilih: ${checkedCount} / ${exactCount} (Kurang ${sisa} Mapel)`;
                    badge.className = 'bg-amber-500 text-white text-[11px] font-bold px-3.5 py-1 rounded-full border border-black shadow-sm font-body';
                }
            } else {
                badge.textContent = `Terpilih: ${checkedCount} Mapel`;
                badge.className = 'bg-primary text-white text-[11px] font-bold px-3.5 py-1 rounded-full border border-black shadow-sm font-body';
            }
        }

        // Initialize on DOMContentLoaded & Submit guard
        document.addEventListener('DOMContentLoaded', function() {
            if (initialJenjang) {
                const jenjangSelect = document.getElementById('jenjang');
                if (jenjangSelect) {
                    jenjangSelect.value = initialJenjang;
                    handleJenjangChange(true);
                }
            }

            const form = document.querySelector('form[action*="daftar"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const programSelect = document.getElementById('minat_program');
                    if (!programSelect || !programSelect.value) {
                        e.preventDefault();
                        alert('Silakan pilih jenjang, kelas, dan paket program belajar terlebih dahulu.');
                        return;
                    }

                    const exactCount = getExactMapelRequired(programSelect.value);
                    if (exactCount !== null) {
                        const checkedCount = document.querySelectorAll('.mapel-cb:checked').length;
                        if (checkedCount !== exactCount) {
                            e.preventDefault();
                            alert(`Pendaftaran belum dapat dikirim:\nUntuk paket "${programSelect.value}", Anda wajib memilih tepat ${exactCount} mata pelajaran.\n\nSaat ini baru terpilih: ${checkedCount} mapel. Mohon lengkapi pilihan mapel terlebih dahulu.`);
                            document.getElementById('mapel-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            }
        });
    </script>
@endsection
