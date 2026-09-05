<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Formulir Pendaftaran Siswa Baru — Bimbel Pelita Ilmu</title>
    <meta name="description" content="Formulir pendaftaran bimbingan belajar tatap muka & privat di Bimbel Pelita Ilmu untuk jenjang TK, SD, SMP, dan SMA.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Script -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            850: '#0c5c56',
                            900: '#0F766E', // Teal gelap utama
                            950: '#134E4A',
                        },
                        cream: {
                            50: '#FDFCF7',
                            100: '#FDF6E9', // Krem hangat dasar
                            200: '#F7EBD4',
                            300: '#EBD8B8',
                        },
                        gold: {
                            400: '#FFC82C',
                            500: '#F5B700', // Aksen terbatas
                            600: '#DBA300',
                        }
                    },
                    fontFamily: {
                        display: ['Fredoka', 'system-ui', 'sans-serif'],
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'warm-sm': '0 2px 6px rgba(0, 0, 0, 0.04)',
                        'warm': '0 6px 16px rgba(0, 0, 0, 0.06)',
                        'warm-lg': '0 12px 24px rgba(0, 0, 0, 0.08)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDF6E9;
            color: #2D3748;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Fredoka', cursive, sans-serif;
        }
    </style>
</head>
<body class="bg-cream-100 text-stone-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-cream-100/95 border-b border-cream-300 py-4">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-teal-900 flex items-center justify-center text-gold-500 shadow-warm-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block font-heading text-xl font-bold text-teal-900 leading-none">Pelita Ilmu</span>
                    <span class="block text-xs font-semibold text-stone-600 tracking-wider uppercase mt-0.5">Bimbel & Privat</span>
                </div>
            </a>

            <a href="/" class="text-xs sm:text-sm font-semibold text-teal-900 hover:text-teal-950 flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </header>

    <!-- Main Registration Section -->
    <main class="py-10 sm:py-14 flex-grow">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">

            <!-- Card Header -->
            <div class="text-center mb-8">
                <span class="text-xs font-bold text-teal-900 uppercase tracking-wider block mb-1">
                    Penerimaan Siswa Baru
                </span>
                <h1 class="font-heading text-3xl sm:text-4xl font-bold text-teal-900 mb-2">
                    Formulir Pendaftaran Siswa
                </h1>
                <p class="text-sm text-stone-600 max-w-lg mx-auto">
                    Silakan lengkapi data calon siswa dan orang tua di bawah ini untuk memulai proses belajar dan pemetaan kelas.
                </p>
            </div>

            <!-- Flash Alert Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-teal-50 border border-teal-600/30 rounded-xl flex items-start gap-3 text-teal-900 text-sm">
                    <svg class="w-5 h-5 text-teal-900 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong class="block font-semibold">Pendaftaran Berhasil!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 text-red-900 text-sm">
                    <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong class="block font-semibold">Gagal Menyimpan Data</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form Card Wrapper -->
            <div class="bg-white rounded-2xl p-6 sm:p-10 border border-stone-200 shadow-warm">
                <form action="{{ route('daftar.store') }}" method="POST" id="form-pendaftaran" class="space-y-8">
                    @csrf

                    <!-- Honeypot anti bot spam -->
                    <div class="hidden" aria-hidden="true" style="display: none !important;">
                        <input type="text" name="website_address" tabindex="-1" autocomplete="off" value="{{ old('website_address') }}">
                    </div>

                    <!-- BAGIAN 1: DATA CALON SISWA -->
                    <div>
                        <div class="border-b border-stone-200 pb-2 mb-5">
                            <h2 class="font-heading text-lg font-bold text-teal-900">1. Data Calon Siswa</h2>
                            <p class="text-xs text-stone-500">Informasi identitas dasar siswa yang akan didaftarkan.</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="nama_lengkap" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nama_lengkap" 
                                    name="nama_lengkap" 
                                    value="{{ old('nama_lengkap') }}"
                                    required
                                    maxlength="100"
                                    placeholder="Contoh: Muhammad Al-Fatih"
                                    class="w-full px-3.5 py-2.5 rounded-lg border @error('nama_lengkap') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                >
                                @error('nama_lengkap')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Tanggal Lahir (Date Picker) -->
                                <div>
                                    <label for="tanggal_lahir" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                        Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="date" 
                                        id="tanggal_lahir" 
                                        name="tanggal_lahir" 
                                        value="{{ old('tanggal_lahir') }}"
                                        required
                                        class="w-full px-3.5 py-2.5 rounded-lg border @error('tanggal_lahir') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                    >
                                    @error('tanggal_lahir')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Asal Sekolah -->
                                <div>
                                    <label for="asal_sekolah" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                        Asal Sekolah <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="asal_sekolah" 
                                        name="asal_sekolah" 
                                        value="{{ old('asal_sekolah') }}"
                                        required
                                        placeholder="Contoh: SD Negeri 1 Tembalang"
                                        class="w-full px-3.5 py-2.5 rounded-lg border @error('asal_sekolah') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                    >
                                    @error('asal_sekolah')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat Rumah -->
                            <div>
                                <label for="alamat_rumah" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Alamat Rumah <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="alamat_rumah" 
                                    name="alamat_rumah" 
                                    rows="2"
                                    required
                                    placeholder="Contoh: Jl. Tirto Agung No. 12, RT 02 / RW 03, Kel. Pedalangan"
                                    class="w-full px-3.5 py-2.5 rounded-lg border @error('alamat_rumah') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                >{{ old('alamat_rumah') }}</textarea>
                                @error('alamat_rumah')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telepon Siswa -->
                            <div>
                                <label for="no_telp_siswa" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Nomor WhatsApp/Telepon Siswa <span class="text-stone-400 font-normal lowercase">(opsional jika belum ada HP)</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="no_telp_siswa" 
                                    name="no_telp_siswa" 
                                    value="{{ old('no_telp_siswa') }}"
                                    placeholder="Contoh: 08123456789"
                                    class="w-full px-3.5 py-2.5 rounded-lg border @error('no_telp_siswa') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                >
                                @error('no_telp_siswa')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 2: DATA ORANG TUA / WALI -->
                    <div>
                        <div class="border-b border-stone-200 pb-2 mb-5">
                            <h2 class="font-heading text-lg font-bold text-teal-900">2. Data Orang Tua / Wali</h2>
                            <p class="text-xs text-stone-500">Kontak utama untuk konfirmasi jadwal, laporan berkala, dan administrasi.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nama Orang Tua -->
                            <div>
                                <label for="nama_ortu" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Nama Orang Tua / Wali <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nama_ortu" 
                                    name="nama_ortu" 
                                    value="{{ old('nama_ortu') }}"
                                    required
                                    placeholder="Contoh: Ibu Rina Susanti"
                                    class="w-full px-3.5 py-2.5 rounded-lg border @error('nama_ortu') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                >
                                @error('nama_ortu')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telepon Orang Tua -->
                            <div>
                                <label for="no_telp_ortu" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Nomor WhatsApp Orang Tua <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="no_telp_ortu" 
                                    name="no_telp_ortu" 
                                    value="{{ old('no_telp_ortu') }}"
                                    required
                                    placeholder="Contoh: 081234567890"
                                    class="w-full px-3.5 py-2.5 rounded-lg border @error('no_telp_ortu') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                >
                                @error('no_telp_ortu')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 3: PROGRAM & BIAYA -->
                    <div>
                        <div class="border-b border-stone-200 pb-2 mb-5">
                            <h2 class="font-heading text-lg font-bold text-teal-900">3. Paket Belajar & Administrasi</h2>
                            <p class="text-xs text-stone-500">Pilih jenjang bimbingan bulanan yang sesuai kebutuhan ananda.</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Paket Bulanan -->
                            <div>
                                <label for="paket_bulanan" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Pilihan Paket Bimbingan <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="paket_bulanan" 
                                    name="paket_bulanan" 
                                    required
                                    class="w-full px-3.5 py-2.5 rounded-lg border @error('paket_bulanan') border-red-500 bg-red-50/40 @else border-stone-300 bg-white @enderror focus:border-teal-900 focus:outline-none focus:ring-1 focus:ring-teal-900 text-sm shadow-warm-sm"
                                >
                                    <option value="" disabled {{ !request('program') && !old('paket_bulanan') ? 'selected' : '' }}>-- Pilih Paket Bulanan --</option>
                                    <option value="TK" {{ (request('program') == 'TK' || old('paket_bulanan') == 'TK') ? 'selected' : '' }}>TK / Calistung Ceria — Rp 350.000 / bulan (8 sesi)</option>
                                    <option value="SD" {{ (request('program') == 'SD' || old('paket_bulanan') == 'SD') ? 'selected' : '' }}>SD (Kelas 1 - 6) — Rp 450.000 / bulan (12 sesi)</option>
                                    <option value="SMP" {{ (request('program') == 'SMP' || old('paket_bulanan') == 'SMP') ? 'selected' : '' }}>SMP (Kelas 7 - 9) — Rp 550.000 / bulan (12 sesi)</option>
                                    <option value="SMA" {{ (request('program') == 'SMA' || old('paket_bulanan') == 'SMA') ? 'selected' : '' }}>SMA & UTBK (Kelas 10 - 12) — Rp 700.000 / bulan (16 sesi)</option>
                                </select>
                                @error('paket_bulanan')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checkbox Biaya Pendaftaran Rp 35.000 (Required) -->
                            <div class="p-4 bg-cream-100 border border-cream-300 rounded-xl">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        id="biaya_pendaftaran" 
                                        name="biaya_pendaftaran" 
                                        value="1" 
                                        required 
                                        {{ old('biaya_pendaftaran') ? 'checked' : '' }}
                                        class="mt-1 w-4 h-4 text-teal-900 border-stone-300 rounded focus:ring-teal-900"
                                    >
                                    <span class="text-xs sm:text-sm text-stone-800 leading-snug">
                                        <strong>Biaya Pendaftaran Rp. 35.000</strong> (Wajib, dibayarkan 1x saat pertama kali bergabung. Sudah termasuk pencetakan modul belajar & buku agenda siswa). <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                @error('biaya_pendaftaran')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 4: ACCORDION SYARAT DAN KETENTUAN -->
                    <div>
                        <div class="border-b border-stone-200 pb-2 mb-4">
                            <h2 class="font-heading text-lg font-bold text-teal-900">4. Syarat dan Ketentuan Bimbingan</h2>
                            <p class="text-xs text-stone-500">Klik tab di bawah untuk membaca rincian aturan dan tata tertib bimbel.</p>
                        </div>

                        <!-- Accordion Items -->
                        <div class="space-y-3 mb-6">
                            
                            <!-- Accordion 1: Kehadiran & Jadwal -->
                            <div class="border border-stone-200 rounded-xl overflow-hidden bg-cream-50">
                                <button type="button" onclick="toggleAccordion('acc-1')" class="w-full px-4 py-3 text-left font-heading text-sm font-semibold text-stone-900 flex items-center justify-between hover:bg-cream-100 transition-colors">
                                    <span>A. Ketentuan Jadwal & Kehadiran Sesi</span>
                                    <svg id="icon-acc-1" class="w-4 h-4 text-stone-600 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div id="acc-1" class="hidden px-4 pb-4 pt-1 text-xs text-stone-600 leading-relaxed border-t border-stone-200 bg-white">
                                    <ul class="list-disc list-inside space-y-1.5">
                                        <li>Siswa diharapkan hadir 5 menit sebelum sesi bimbingan dimulai.</li>
                                        <li>Jika siswa berhalangan hadir (sakit/izin), orang tua wajib mengabari admin bimbel minimal 3 jam sebelum jadwal agar materi dapat disesuaikan.</li>
                                        <li>Untuk kelas privat, sesi pengganti (make-up class) dapat dijadwalkan maksimal 1x per bulan sesuai kesepakatan tutor.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Accordion 2: Pembayaran SPP & Jatuh Tempo -->
                            <div class="border border-stone-200 rounded-xl overflow-hidden bg-cream-50">
                                <button type="button" onclick="toggleAccordion('acc-2')" class="w-full px-4 py-3 text-left font-heading text-sm font-semibold text-stone-900 flex items-center justify-between hover:bg-cream-100 transition-colors">
                                    <span>B. Pembayaran SPP Bulanan & Jatuh Tempo</span>
                                    <svg id="icon-acc-2" class="w-4 h-4 text-stone-600 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div id="acc-2" class="hidden px-4 pb-4 pt-1 text-xs text-stone-600 leading-relaxed border-t border-stone-200 bg-white">
                                    <ul class="list-disc list-inside space-y-1.5">
                                        <li>Pembayaran SPP bulanan dilakukan secara transfer bank resmi atau tunai di kantor bimbel.</li>
                                        <li>Pilihan tipe jatuh tempo dapat dipilih: Awal Bulan (maksimal tgl 10) atau Akhir Bulan (maksimal tgl 25).</li>
                                        <li>Kuitansi pembayaran digital akan langsung dikirimkan ke nomor WhatsApp orang tua setelah pembayaran terkonfirmasi.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Accordion 3: Hak Modul & Konsultasi PR -->
                            <div class="border border-stone-200 rounded-xl overflow-hidden bg-cream-50">
                                <button type="button" onclick="toggleAccordion('acc-3')" class="w-full px-4 py-3 text-left font-heading text-sm font-semibold text-stone-900 flex items-center justify-between hover:bg-cream-100 transition-colors">
                                    <span>C. Modul Belajar & Konsultasi PR Harian</span>
                                    <svg id="icon-acc-3" class="w-4 h-4 text-stone-600 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div id="acc-3" class="hidden px-4 pb-4 pt-1 text-xs text-stone-600 leading-relaxed border-t border-stone-200 bg-white">
                                    <ul class="list-disc list-inside space-y-1.5">
                                        <li>Siswa berhak mendapatkan modul cetak kurikulum merdeka/nasional sesuai jenjang.</li>
                                        <li>Konsultasi PR dapat dilakukan pada saat jam sesi bimbingan atau melalui grup belajar WhatsApp yang dipantau tutor.</li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <!-- Checkbox Persetujuan S&K (Required) -->
                        <div class="p-3.5 bg-stone-50 border border-stone-300 rounded-xl">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="setuju_syarat" 
                                    name="setuju_syarat" 
                                    value="1" 
                                    required 
                                    {{ old('setuju_syarat') ? 'checked' : '' }}
                                    class="mt-0.5 w-4 h-4 text-teal-900 border-stone-300 rounded focus:ring-teal-900"
                                >
                                <span class="text-xs sm:text-sm text-stone-800 font-medium leading-snug">
                                    Saya menyetujui seluruh syarat dan ketentuan yang berlaku di Bimbel Pelita Ilmu. <span class="text-red-500">*</span>
                                </span>
                            </label>
                            @error('setuju_syarat')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            id="btn-submit"
                            class="w-full py-3.5 px-6 rounded-lg font-heading text-base font-bold text-stone-950 bg-gold-500 hover:bg-gold-400 border border-gold-600/30 shadow-warm-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed"
                        >
                            <svg id="spinner" class="hidden animate-spin h-5 w-5 text-stone-950" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="btn-text">Kirim Formulir Pendaftaran</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="bg-teal-950 text-cream-200 py-6 border-t border-teal-900 text-center text-xs">
        <p>&copy; {{ date('Y') }} Bimbel Pelita Ilmu. Konsultasi & Info: 0812-3456-7890</p>
    </footer>

    <!-- Accordion & Submit Script -->
    <script>
        function toggleAccordion(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                el.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-pendaftaran');
            const btn = document.getElementById('btn-submit');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btn-text');

            if (form && btn) {
                form.addEventListener('submit', function () {
                    if (!form.checkValidity()) return;
                    btn.disabled = true;
                    if (spinner) spinner.classList.remove('hidden');
                    if (btnText) btnText.textContent = 'Memproses Pendaftaran...';
                });
            }
        });
    </script>
</body>
</html>
