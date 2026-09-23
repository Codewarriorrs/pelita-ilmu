<?php

namespace App\Livewire;

use Livewire\Component;

class PendaftaranForm extends Component
{
    // Form Properties (Pure Client State)
    public string $nama_lengkap = '';
    public string $asal_sekolah = '';
    public string $kelas = '';
    public string $kategori_kelas = 'Reguler'; // Default: Reguler
    public string $minat_program = '';
    public string $nama_wali = '';
    public string $nomor_wali = '';
    public string $nomor_telepon_siswa = '';
    public string $tanggal_lahir = '';
    public string $alamat_rumah = '';

    // State Kontrol Tampilan (Form vs Success Summary)
    public bool $isSubmitted = false;
    public array $submittedData = [];

    // Daftar Pilihan Program (Sinkron dengan Tabel Harga Bimbel)
    public array $daftarProgram = [
        // TK
        'TK' => 'TK — Calistung, Mengaji, Bahasa Inggris',
        // SD
        'SD Kelas 1-5' => 'SD Kelas 1–5 — Semua Mapel Pokok & Tematik',
        'SD Kelas 6' => 'SD Kelas 6 — Persiapan US + Intensif',
        'SD Kelas 6 TKA' => 'SD Kelas 6 — Hanya TKA / Persiapan SMP',
        // SMP Reguler + TKA
        'SMP 1 Mapel' => 'SMP — 1 Mata Pelajaran (Reguler + TKA)',
        'SMP 2 Mapel' => 'SMP — 2 Mata Pelajaran (Reguler + TKA)',
        'SMP 3 Mapel' => 'SMP — 3 Mata Pelajaran (Reguler + TKA)',
        'SMP 4 Mapel' => 'SMP — 4 Mata Pelajaran (Reguler + TKA)',
        'SMP 5 Mapel' => 'SMP — 5 Mata Pelajaran (Reguler + TKA)',
        'SMP 6 Mapel' => 'SMP — 6 Mata Pelajaran (Reguler + TKA)',
        // SMP TKA Only
        'SMP TKA 1 Mapel' => 'SMP — 1 TKA (Khusus TKA Saja)',
        'SMP TKA 2 Mapel' => 'SMP — 2 TKA (Khusus TKA Saja)',
        // SMA Reguler
        'SMA 1 Mapel' => 'SMA — 1 Mata Pelajaran (Reguler)',
        'SMA 2 Mapel' => 'SMA — 2 Mata Pelajaran (Reguler)',
        'SMA 3 Mapel' => 'SMA — 3 Mata Pelajaran (Reguler)',
        'SMA 4 Mapel' => 'SMA — 4 Mata Pelajaran (Reguler)',
        'SMA 5 Mapel' => 'SMA — 5 Mata Pelajaran (Reguler)',
        'SMA 6 Mapel' => 'SMA — 6 Mata Pelajaran (Reguler)',
        // SMA UTBK
        'SMA UTBK 1' => 'SMA — 1 Mapel UTBK / SNBT',
        'SMA UTBK 2' => 'SMA — 2 Mapel UTBK / SNBT',
        'SMA UTBK 3' => 'SMA — 3 Mapel UTBK / SNBT',
        'SMA UTBK 4' => 'SMA — 4 Mapel UTBK / SNBT',
        // SMA UTBK + Reguler
        'SMA UTBK+Reg 1' => 'SMA — 1 Mapel UTBK + Reguler',
        'SMA UTBK+Reg 2' => 'SMA — 2 Mapel UTBK + Reguler',
        'SMA UTBK+Reg 3' => 'SMA — 3 Mapel UTBK + Reguler',
        'SMA UTBK+Reg 4' => 'SMA — 4 Mapel UTBK + Reguler',
    ];

    // Daftar Kategori Kelas
    public array $daftarKategori = [
        'Reguler' => 'Reguler (Kelas Mini 4-6 Siswa)',
        'Privat' => 'Privat (1-on-1 Intensif Khusus)',
    ];

    // Aturan Validasi Form
    protected function rules(): array
    {
        return [
            // 1. Nama lengkap: hanya huruf, spasi, petik/titik (tidak boleh angka dan simbol)
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s\'.]+$/'],

            // 3. Asal sekolah: harus memuat huruf dan tidak boleh simbol/angka saja
            'asal_sekolah' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/[a-zA-Z]/',
                'regex:/^[a-zA-Z0-9\s.,\'-]+$/'
            ],

            'kategori_kelas' => ['required', 'in:Reguler,Privat'],
            'kelas' => ['required', 'string', 'max:50'],
            'minat_program' => ['required', 'in:TK,SD Kelas 1-5,SD Kelas 6,SD Kelas 6 TKA,SMP 1 Mapel,SMP 2 Mapel,SMP 3 Mapel,SMP 4 Mapel,SMP 5 Mapel,SMP 6 Mapel,SMP TKA 1 Mapel,SMP TKA 2 Mapel,SMA 1 Mapel,SMA 2 Mapel,SMA 3 Mapel,SMA 4 Mapel,SMA 5 Mapel,SMA 6 Mapel,SMA UTBK 1,SMA UTBK 2,SMA UTBK 3,SMA UTBK 4,SMA UTBK+Reg 1,SMA UTBK+Reg 2,SMA UTBK+Reg 3,SMA UTBK+Reg 4'],

            // 4. Nama wali: hanya huruf dan spasi (tidak boleh angka dan simbol)
            'nama_wali' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s\'.]+$/'],

            // 5. Nomor WhatsApp Wali: hanya angka (10-15 digit) dan tidak boleh sama dengan siswa
            'nomor_wali' => [
                'required',
                'regex:/^[0-9]{10,15}$/',
                function ($attribute, $value, $fail) {
                    if (!empty($this->nomor_telepon_siswa) && $value === $this->nomor_telepon_siswa) {
                        $fail('Nomor WhatsApp orang tua tidak boleh sama dengan nomor telepon siswa.');
                    }
                },
            ],

            // 5. Nomor Telepon Siswa: opsional, hanya angka (10-15 digit), tidak boleh sama dengan wali
            'nomor_telepon_siswa' => [
                'nullable',
                'regex:/^[0-9]{10,15}$/',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && $value === $this->nomor_wali) {
                        $fail('Nomor telepon siswa tidak boleh sama dengan nomor WhatsApp orang tua.');
                    }
                },
            ],

            // 2. Tanggal lahir: tidak boleh lebih dari hari sekarang dan tidak boleh lebih tua dari 1950
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:1950-01-01'],

            // 6. Alamat: tidak boleh simbol khusus (hanya huruf, angka, titik, koma, strip, garis miring)
            'alamat_rumah' => [
                'required',
                'string',
                'min:5',
                'max:500',
                'regex:/[a-zA-Z]/',
                'regex:/^[a-zA-Z0-9\s.,\-\/]+$/',
            ],
        ];
    }

    // Pesan Kustom Validasi dalam Bahasa Indonesia yang Ramah & Tegas
    protected function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap siswa wajib diisi.',
            'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh berisi huruf dan spasi (tidak boleh angka atau simbol).',

            'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
            'asal_sekolah.regex' => 'Asal sekolah harus mengandung huruf dan tidak boleh berupa angka atau simbol saja.',

            'kategori_kelas.required' => 'Silakan pilih kategori kelas.',
            'kategori_kelas.in' => 'Pilihan kategori kelas tidak valid.',

            'kelas.required' => 'Kelas siswa wajib diisi.',

            'minat_program.required' => 'Silakan pilih program belajar yang diminati.',
            'minat_program.in' => 'Program belajar yang dipilih tidak valid.',

            'nama_wali.required' => 'Nama orang tua/wali wajib diisi.',
            'nama_wali.min' => 'Nama orang tua/wali minimal 3 karakter.',
            'nama_wali.regex' => 'Nama orang tua/wali hanya boleh berisi huruf dan spasi (tidak boleh angka atau simbol).',

            'nomor_wali.required' => 'Nomor WhatsApp orang tua wajib diisi.',
            'nomor_wali.regex' => 'Nomor WhatsApp hanya boleh berisi angka (10-15 digit, tanpa spasi, huruf, atau simbol).',

            'nomor_telepon_siswa.regex' => 'Nomor HP siswa hanya boleh berisi angka (10-15 digit, tanpa spasi, huruf, atau simbol).',

            'tanggal_lahir.required' => 'Tanggal lahir siswa wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'tanggal_lahir.after_or_equal' => 'Tahun kelahiran tidak boleh lebih lama dari tahun 1950.',

            'alamat_rumah.required' => 'Alamat tempat tinggal wajib diisi.',
            'alamat_rumah.min' => 'Alamat minimal 5 karakter agar lengkap.',
            'alamat_rumah.regex' => 'Alamat tidak boleh mengandung simbol khusus (hanya huruf, angka, titik, koma, strip, dan garis miring).',
        ];
    }

    // Validasi Real-Time saat user mengetik / berpindah field
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

        // Cross-validation bila nomor telepon diubah
        if ($propertyName === 'nomor_wali' && !empty($this->nomor_telepon_siswa)) {
            $this->validateOnly('nomor_telepon_siswa');
        }
        if ($propertyName === 'nomor_telepon_siswa' && !empty($this->nomor_wali)) {
            $this->validateOnly('nomor_wali');
        }
    }

    // Action Submit Form
    public function submit(): void
    {
        $validated = $this->validate();

        // Simpan data ke Client State (Tanpa Database)
        $this->submittedData = [
            'kode_registrasi' => 'PLI-' . strtoupper(substr(uniqid(), -6)),
            'tanggal_daftar' => now()->translatedFormat('d F Y, H:i') . ' WIB',
            'nama_lengkap' => $validated['nama_lengkap'],
            'asal_sekolah' => $validated['asal_sekolah'],
            'kelas' => $validated['kelas'],
            'tingkat_kelas' => $validated['kelas'],
            'kategori_kelas' => $validated['kategori_kelas'],
            'minat_program' => $validated['minat_program'],
            'label_program' => $this->daftarProgram[$validated['minat_program']] ?? $validated['minat_program'],
            'nama_wali' => $validated['nama_wali'],
            'nomor_wali' => $validated['nomor_wali'],
            'nomor_telepon_siswa' => $validated['nomor_telepon_siswa'] ?: '-',
            'tanggal_lahir' => \Carbon\Carbon::parse($validated['tanggal_lahir'])->translatedFormat('d F Y'),
            'alamat_rumah' => $validated['alamat_rumah'],
        ];

        // Transisi ke State Sukses & Ringkasan
        $this->isSubmitted = true;
    }

    // Action untuk mendaftar siswa baru lagi (Reset State)
    public function resetForm(): void
    {
        $this->reset([
            'nama_lengkap',
            'asal_sekolah',
            'kelas',
            'tingkat_kelas',
            'kategori_kelas',
            'minat_program',
            'nama_wali',
            'nomor_wali',
            'nomor_telepon_siswa',
            'tanggal_lahir',
            'alamat_rumah',
            'isSubmitted',
            'submittedData',
        ]);
        $this->kategori_kelas = 'Reguler';
        $this->resetValidation();
    }

    // Helper Link WhatsApp Konfirmasi Otomatis ke Admin
    public function getWhatsappUrlProperty(): string
    {
        if (empty($this->submittedData)) {
            return 'https://wa.me/6289624601717';
        }

        $pesan = "Halo Admin Bimbel Pelita Ilmu,\n\n"
            . "Saya telah mengisi Formulir Pendaftaran Online:\n"
            . "• No. Registrasi: {$this->submittedData['kode_registrasi']}\n"
            . "• Nama Siswa: {$this->submittedData['nama_lengkap']}\n"
            . "• Program: {$this->submittedData['minat_program']} ({$this->submittedData['kategori_kelas']})\n"
            . "• Asal Sekolah: {$this->submittedData['asal_sekolah']}\n"
            . "• Nama Wali: {$this->submittedData['nama_wali']}\n"
            . "• No. WhatsApp: {$this->submittedData['nomor_wali']}\n\n"
            . "Mohon konfirmasi pendaftarannya ya Admin. Terima kasih!";

        return 'https://wa.me/6289624601717?text=' . urlencode($pesan);
    }

    public function render()
    {
        return view('livewire.pendaftaran-form');
    }
}
