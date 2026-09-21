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
                        <div>
                            <label for="asal_sekolah" class="block text-xs sm:text-sm font-bold text-void mb-1.5 font-subtitle">
                                Asal Sekolah <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="asal_sekolah"
                                name="asal_sekolah"
                                value="{{ old('asal_sekolah') }}"
                                placeholder="Contoh: SD Negeri Manyaran 01"
                                required
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void placeholder:text-stone-400 focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
                            >
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
                                        <span class="text-xs text-stone-500 font-body">Reguler (Kelas Mini 4-6 Siswa)</span>
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
                                class="w-full rounded-xl border-2 border-black bg-stone-50 px-5 py-3.5 text-sm text-void focus:border-primary focus:bg-white focus:outline-none transition-all shadow-sm font-body"
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
                                    Nomor Telepon Siswa
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

    <!-- JAVASCRIPT DINAMIS CHECKBOX MATA PELAJARAN -->
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

            if (!select || !container || !checkboxesDiv || !infoText) return;

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
                label.className = 'flex items-center gap-2.5 p-3.5 rounded-xl border-2 border-black bg-stone-50 hover:bg-white hover:border-primary cursor-pointer text-xs font-semibold text-void transition-all shadow-sm font-body';
                label.innerHTML = `
                    <input type="checkbox" name="mata_pelajaran[]" value="${mapel}" onchange="handleMapelCheck(this, ${maxLimit})" class="mapel-cb h-4 w-4 text-primary rounded border-black focus:ring-0">
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
            if (!badge) return;

            if (maxLimit < 99) {
                badge.textContent = `Terpilih: ${checkedCount} / ${maxLimit}`;
                if (checkedCount === maxLimit) {
                    badge.className = 'bg-primary text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm font-body';
                } else {
                    badge.className = 'bg-amber-500 text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm font-body';
                }
            } else {
                badge.textContent = `Terpilih: ${checkedCount} Mapel`;
                badge.className = 'bg-primary text-white text-[11px] font-bold px-3 py-1 rounded-full border border-black shadow-sm font-body';
            }
        }
    </script>
@endsection
