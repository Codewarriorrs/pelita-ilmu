<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Otorisasi request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Sanitasi data sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('kelas') && !$this->filled('tingkat_kelas')) {
            $this->merge(['tingkat_kelas' => $this->input('kelas')]);
        }
        if ($this->filled('tingkat_kelas') && !$this->filled('kelas')) {
            $this->merge(['kelas' => $this->input('tingkat_kelas')]);
        }

        if ($this->filled('nomor_wali') && !$this->filled('no_telp_ortu')) {
            $this->merge(['no_telp_ortu' => $this->input('nomor_wali')]);
        }
        if ($this->filled('nama_wali') && !$this->filled('nama_ortu')) {
            $this->merge(['nama_ortu' => $this->input('nama_wali')]);
        }
        if ($this->filled('nomor_telepon_siswa') && !$this->filled('no_telp_siswa')) {
            $this->merge(['no_telp_siswa' => $this->input('nomor_telepon_siswa')]);
        }

        if ($this->filled('no_telp_siswa')) {
            $this->merge([
                'no_telp_siswa' => preg_replace('/[^\d+]/', '', (string) $this->input('no_telp_siswa')),
            ]);
        }

        if ($this->filled('no_telp_ortu')) {
            $this->merge([
                'no_telp_ortu' => preg_replace('/[^\d+]/', '', (string) $this->input('no_telp_ortu')),
            ]);
        }
    }

    /**
     * Aturan validasi server-side.
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'asal_sekolah' => ['required', 'string', 'max:100'],
            'kelas' => ['required', 'string', 'max:50'],
            'tingkat_kelas' => ['nullable', 'string', 'max:50'],
            'kategori_kelas' => ['nullable', 'string', 'in:Reguler,Privat,KELOMPOK,PRIVAT'],
            'minat_program' => ['required', 'string'],
            'mata_pelajaran' => ['nullable', 'array'],
            'alamat_rumah' => ['required', 'string', 'max:255'],
            'nama_ortu' => ['required', 'string', 'max:100'],
            'no_telp_ortu' => ['required', 'string'],
            'no_telp_siswa' => ['nullable', 'string'],
            'website_address' => ['nullable', 'max:0', 'prohibited'],
        ];
    }

    /**
     * Pesan validasi dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap calon siswa wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir calon siswa wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'asal_sekolah.required' => 'Asal sekolah calon siswa wajib diisi.',
            'kelas.required' => 'Kelas calon siswa wajib diisi.',
            'minat_program.required' => 'Silakan pilih program bimbingan belajar.',
            'alamat_rumah.required' => 'Alamat rumah tempat tinggal wajib diisi.',
            'nama_ortu.required' => 'Nama orang tua / wali wajib diisi.',
            'no_telp_ortu.required' => 'Nomor WhatsApp orang tua wajib diisi untuk konfirmasi pendaftaran.',
            'website_address.prohibited' => 'Aktivitas bot terdeteksi.',
        ];
    }
}
