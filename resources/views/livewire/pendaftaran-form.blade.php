<div class="relative min-h-screen bg-canvas py-10 lg:py-16 overflow-hidden">
    {{-- Background Geometric Elements (Sesuai Karakteristik Visual Pelita Ilmu) --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full border-4 border-primary-2/15"></div>
        <div class="absolute top-1/4 -left-20 h-72 w-72 rounded-full border-2 border-dashed border-primary/20"></div>
        <div class="absolute bottom-10 right-10 h-64 w-64 rounded-full border-2 border-dashed border-primary-2/20"></div>
    </div>

    <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        @if (! $isSubmitted)
            {{-- ========================================== --}}
            {{-- STATE 1: TAMPILAN FORMULIR PENDAFTARAN     --}}
            {{-- ========================================== --}}
            <div class="rounded-3xl border-2 border-primary-2/15 bg-canvas p-6 sm:p-10 lg:p-12 shadow-xl">
                
                {{-- Header Formulir --}}
                <div class="text-center max-w-2xl mx-auto pb-8 border-b border-primary-2/10">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-4 py-1.5 font-subtitle text-xs font-bold text-primary uppercase tracking-wider">
                        ★ Formulir Pendaftaran Siswa Baru
                    </span>
                    <h1 class="mt-3 font-headline text-2xl sm:text-3xl lg:text-4xl font-bold text-primary-2">
                        Mulai Raih Prestasimu Bersama Kami
                    </h1>
                    <p class="mt-2 font-body text-xs sm:text-sm text-void/70 leading-relaxed">
                        Silakan lengkapi biodata calon siswa di bawah ini. Tim admin Bimbel Pelita Ilmu akan segera mengonfirmasi jadwal belajar dan kelompok kelas.
                    </p>
                </div>

                {{-- Form Body --}}
                <form wire:submit.prevent="submit" class="mt-8 space-y-8">

                    {{-- BAGIAN 1: DATA CALON SISWA --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-canvas font-headline text-xs font-bold">1</span>
                            <h2 class="font-headline text-lg sm:text-xl font-bold text-primary-2">Data Calon Siswa</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Field 1: Nama Lengkap Siswa --}}
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                    Nama Lengkap Siswa <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama_lengkap"
                                    wire:model.live.debounce.300ms="nama_lengkap"
                                    placeholder="Contoh: Muhammad Rian Pratama"
                                    class="w-full rounded-xl border @error('nama_lengkap') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void placeholder:text-void/40 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                                @error('nama_lengkap')
                                    <p class="mt-1.5 font-body text-xs text-rose-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Field 2: Tanggal Lahir --}}
                            <div>
                                <label for="tanggal_lahir" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                    Tanggal Lahir Siswa <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="tanggal_lahir"
                                    min="1950-01-01"
                                    max="{{ date('Y-m-d') }}"
                                    wire:model.live="tanggal_lahir"
                                    class="w-full rounded-xl border @error('tanggal_lahir') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                                @error('tanggal_lahir')
                                    <p class="mt-1.5 font-body text-xs text-rose-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Field 3: Asal Sekolah --}}
                            <div>
                                <label for="asal_sekolah" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                    Asal Sekolah <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="asal_sekolah"
                                    wire:model.live.debounce.300ms="asal_sekolah"
                                    placeholder="Contoh: SD Negeri Manyaran 01"
                                    class="w-full rounded-xl border @error('asal_sekolah') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void placeholder:text-void/40 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                                @error('asal_sekolah')
                                    <p class="mt-1.5 font-body text-xs text-rose-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN 2: PILIHAN PROGRAM & KATEGORI BELAJAR --}}
                    <div class="pt-6 border-t border-primary-2/10">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-canvas font-headline text-xs font-bold">2</span>
                            <h2 class="font-headline text-lg sm:text-xl font-bold text-primary-2">Pilihan Program &amp; Kategori</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Field 4: Kategori Kelas (Reguler vs Privat) --}}
                            <div class="md:col-span-2">
                                <label class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-2">
                                    Kategori Kelas <span class="text-rose-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach ($daftarKategori as $value => $label)
                                        <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all {{ $kategori_kelas === $value ? 'border-primary bg-primary/5 text-primary-2 shadow-sm' : 'border-primary-2/15 hover:border-primary-2/30 bg-canvas text-void' }}">
                                            <input
                                                type="radio"
                                                name="kategori_kelas"
                                                value="{{ $value }}"
                                                wire:model.live="kategori_kelas"
                                                class="h-4 w-4 text-primary border-primary-2/30 focus:ring-primary"
                                            >
                                            <div class="ml-3">
                                                <span class="font-subtitle text-sm font-bold block">{{ $value }}</span>
                                                <span class="font-body text-xs text-void/70">{{ $label }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('kategori_kelas')
                                    <p class="mt-1.5 font-body text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Field 5: Minat Program Belajar --}}
                            <div class="md:col-span-2">
                                <label for="minat_program" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                    Pilih Program Belajar <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    id="minat_program"
                                    wire:model.live="minat_program"
                                    class="w-full rounded-xl border @error('minat_program') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                                    <option value="">-- Pilih Jenjang &amp; Paket Program --</option>
                                    @foreach ($daftarProgram as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('minat_program')
                                    <p class="mt-1.5 font-body text-xs text-rose-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN 3: DATA ORANG TUA / WALI & KONTAK --}}
                    <div class="pt-6 border-t border-primary-2/10">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-canvas font-headline text-xs font-bold">3</span>
                            <h2 class="font-headline text-lg sm:text-xl font-bold text-primary-2">Data Orang Tua &amp; Kontak</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Field 6: Nama Wali --}}
                            <div class="md:col-span-2">
                                <label for="nama_wali" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                    Nama Orang Tua / Wali <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama_wali"
                                    wire:model.live.debounce.300ms="nama_wali"
                                    placeholder="Contoh: Bapak Hendra / Ibu Sri"
                                    class="w-full rounded-xl border @error('nama_wali') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void placeholder:text-void/40 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                                @error('nama_wali')
                                    <p class="mt-1.5 font-body text-xs text-rose-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Field 7: Nomor WhatsApp / HP Wali --}}
                            <div>
                                <label for="nomor_wali" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                    Nomor WhatsApp Orang Tua <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="tel"
                                        inputmode="numeric"
                                        maxlength="15"
                                        id="nomor_wali"
                                        wire:model.live.debounce.300ms="nomor_wali"
                                        placeholder="08xxxxxxxxxx (hanya angka)"
                                        class="w-full rounded-xl border @error('nomor_wali') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void placeholder:text-void/40 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                    >
                                </div>
                                <p class="mt-1 font-body text-[11px] text-void/60">Nomor ini digunakan untuk konfirmasi pendaftaran &amp; jadwal belajar.</p>
                                @error('nomor_wali')
                                    <p class="mt-1 font-body text-xs text-rose-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Field 8: Nomor Telepon Siswa (Opsional) --}}
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="nomor_telepon_siswa" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2">
                                        Nomor Telepon Siswa
                                    </label>
                                    <span class="font-body text-[11px] text-void/50 bg-primary-2/5 px-2 py-0.5 rounded-md">Opsional</span>
                                </div>
                                <input
                                    type="tel"
                                    inputmode="numeric"
                                    maxlength="15"
                                    id="nomor_telepon_siswa"
                                    wire:model.live.debounce.300ms="nomor_telepon_siswa"
                                    placeholder="08xxxxxxxxxx (hanya angka, bila ada)"
                                    class="w-full rounded-xl border @error('nomor_telepon_siswa') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void placeholder:text-void/40 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                                >
                                <p class="mt-1 font-body text-[11px] text-void/60">Boleh dikosongkan untuk siswa jenjang TK / SD.</p>
                                @error('nomor_telepon_siswa')
                                    <p class="mt-1 font-body text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN 4: ALAMAT TEMPAT TINGGAL --}}
                    <div class="pt-6 border-t border-primary-2/10">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-canvas font-headline text-xs font-bold">4</span>
                            <h2 class="font-headline text-lg sm:text-xl font-bold text-primary-2">Alamat Tempat Tinggal</h2>
                        </div>

                        <div>
                            {{-- Field 9: Alamat Rumah --}}
                            <label for="alamat_rumah" class="block font-subtitle text-xs sm:text-sm font-bold text-primary-2 mb-1.5">
                                Alamat Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <textarea
                                id="alamat_rumah"
                                rows="3"
                                wire:model.live.debounce.300ms="alamat_rumah"
                                placeholder="Contoh: Jl. Rorojonggrang Barat No. 12 RT 03 RW 08, Manyaran, Semarang Barat"
                                class="w-full rounded-xl border @error('alamat_rumah') border-rose-500 bg-rose-50/30 @else border-primary-2/20 bg-canvas @enderror px-4 py-3 font-body text-sm text-void placeholder:text-void/40 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all"
                            ></textarea>
                            @error('alamat_rumah')
                                <p class="mt-1.5 font-body text-xs text-rose-600 flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- SUBMIT BAR & CATATAN KEAMANAN --}}
                    <div class="pt-6 border-t border-primary-2/10">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <a
                                href="{{ route('beranda') }}"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-primary-2/20 px-5 py-3.5 font-subtitle text-sm font-bold text-primary-2 hover:bg-primary-2/5 transition-all text-center"
                            >
                                ← Kembali ke Beranda
                            </a>

                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-highlight px-8 py-3.5 font-subtitle text-base font-bold text-void shadow-md hover:bg-highlight/85 hover:translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                            >
                                <span wire:loading.remove wire:target="submit">KIRIM PENDAFTARAN SEKARANG ➜</span>
                                <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-void" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses Data...
                                </span>
                            </button>
                        </div>

                        <div class="mt-4 flex items-center justify-center gap-2 text-center text-xs font-body text-void/60">
                            <svg class="h-4 w-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Data pendaftaran Anda aman dan langsung diproses secara privat oleh manajemen Bimbel Pelita Ilmu.</span>
                        </div>
                    </div>

                </form>

            </div>

        @else
            {{-- ========================================== --}}
            {{-- STATE 2: TAMPILAN RINGKASAN SUKSES         --}}
            {{-- ========================================== --}}
            <div class="rounded-3xl border-2 border-primary-2/15 bg-canvas p-6 sm:p-10 lg:p-12 shadow-xl">
                
                {{-- Badge Sukses & Headline --}}
                <div class="text-center max-w-xl mx-auto">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-primary text-highlight shadow-sm">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <span class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 px-3.5 py-1 font-subtitle text-xs font-bold uppercase tracking-wider">
                        ● Formulir Berhasil Diterima
                    </span>

                    <h2 class="mt-2 font-headline text-2xl sm:text-3xl lg:text-4xl font-bold text-primary-2">
                        Pendaftaran Berhasil Dikirim!
                    </h2>

                    <p class="mt-2 font-body text-xs sm:text-sm text-void/70 leading-relaxed">
                        Terima kasih, <strong class="text-void font-bold">{{ $submittedData['nama_wali'] }}</strong>. Data calon siswa atas nama <strong class="text-void font-bold">{{ $submittedData['nama_lengkap'] }}</strong> telah tercatat pada sistem penerimaan Bimbel Pelita Ilmu.
                    </p>
                </div>

                {{-- Banner Kode Registrasi --}}
                <div class="mt-8 rounded-2xl bg-primary-2 p-5 text-canvas flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="font-subtitle text-xs text-canvas/70 uppercase tracking-wider block">KODE REGISTRASI PENDAFTARAN</span>
                        <p class="font-headline text-2xl sm:text-3xl font-bold text-highlight mt-0.5 tracking-wider">
                            {{ $submittedData['kode_registrasi'] }}
                        </p>
                    </div>
                    <div class="text-right sm:text-right text-center">
                        <span class="font-subtitle text-xs text-canvas/70 block">Waktu Submit:</span>
                        <span class="font-body text-xs sm:text-sm text-canvas/90">{{ $submittedData['tanggal_daftar'] }}</span>
                    </div>
                </div>

                {{-- Tabel Ringkasan Data --}}
                <div class="mt-6 rounded-2xl border border-primary-2/15 overflow-hidden">
                    <div class="bg-primary/5 px-5 py-3 border-b border-primary-2/10">
                        <h3 class="font-headline text-sm font-bold text-primary-2 uppercase tracking-wide">
                            Ringkasan Data Calon Siswa
                        </h3>
                    </div>

                    <div class="divide-y divide-primary-2/10 font-body text-xs sm:text-sm">
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Nama Lengkap Siswa</span>
                            <span class="sm:col-span-2 font-subtitle font-bold text-void">{{ $submittedData['nama_lengkap'] }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Tanggal Lahir</span>
                            <span class="sm:col-span-2 text-void">{{ $submittedData['tanggal_lahir'] }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Asal Sekolah</span>
                            <span class="sm:col-span-2 text-void">{{ $submittedData['asal_sekolah'] }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Program Belajar</span>
                            <span class="sm:col-span-2 text-primary font-subtitle font-bold">
                                {{ $submittedData['label_program'] }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Kategori Kelas</span>
                            <span class="sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold font-subtitle bg-primary/10 text-primary">
                                    {{ $submittedData['kategori_kelas'] }}
                                </span>
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Nama Orang Tua / Wali</span>
                            <span class="sm:col-span-2 text-void">{{ $submittedData['nama_wali'] }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">WhatsApp Orang Tua</span>
                            <span class="sm:col-span-2 text-void font-subtitle font-bold">{{ $submittedData['nomor_wali'] }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Nomor Telepon Siswa</span>
                            <span class="sm:col-span-2 text-void">{{ $submittedData['nomor_telepon_siswa'] }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 p-4 gap-1">
                            <span class="font-subtitle font-bold text-void/60">Alamat Rumah</span>
                            <span class="sm:col-span-2 text-void leading-relaxed">{{ $submittedData['alamat_rumah'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Kotak Langkah Selanjutnya --}}
                <div class="mt-6 rounded-2xl bg-primary/5 border border-primary/20 p-5 flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-canvas">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-headline text-base font-bold text-primary-2">Langkah Selanjutnya</h4>
                        <p class="font-body text-xs sm:text-sm text-void/75 mt-1 leading-relaxed">
                            Admin Bimbel Pelita Ilmu akan meninjau ketersediaan slot kelas dan menghubungi Anda melalui WhatsApp dalam <strong>1x24 jam</strong>. Untuk konfirmasi lebih cepat, Anda juga dapat langsung mengirimkan kode registrasi ke WhatsApp Admin dengan tombol di bawah.
                        </p>
                    </div>
                </div>

                {{-- Action Buttons Tampilan Sukses --}}
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    {{-- Primary CTA: Kirim ke WhatsApp Admin --}}
                    <a
                        href="{{ $this->whatsapp_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-highlight px-8 py-3.5 font-subtitle text-sm sm:text-base font-bold text-void shadow-md hover:bg-highlight/85 hover:translate-y-0.5 transition-all text-center"
                    >
                        <svg class="h-5 w-5 text-void shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                        </svg>
                        <span>Konfirmasi via WhatsApp Sekarang ➜</span>
                    </a>

                    {{-- Secondary Button: Reset / Daftar Siswa Baru --}}
                    <button
                        type="button"
                        wire:click="resetForm"
                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border-2 border-primary-2/20 px-6 py-3.5 font-subtitle text-sm font-bold text-primary-2 hover:bg-primary-2/5 transition-all text-center"
                    >
                        Daftarkan Siswa Lain +
                    </button>

                    {{-- Link Beranda --}}
                    <a
                        href="{{ route('beranda') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-3.5 font-subtitle text-sm font-bold text-void/70 hover:text-primary transition-colors text-center"
                    >
                        Ke Halaman Beranda
                    </a>
                </div>

            </div>
        @endif

    </div>
</div>
