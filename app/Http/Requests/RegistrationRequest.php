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
     * Sanitasi data sebelum validasi (pembersihan format no telepon).
     */
    protected function prepareForValidation(): void
    {
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
     * Aturan validasi server-side sesuai PRD & Form.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'asal_sekolah' => ['required', 'string', 'max:100'],
            'alamat_rumah' => ['required', 'string', 'max:255'],
            'no_telp_siswa' => ['nullable', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{7,11}$/'],
            'nama_ortu' => ['required', 'string', 'max:100'],
            'no_telp_ortu' => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{7,11}$/'],
            'paket_bulanan' => ['required', 'in:TK,SD,SMP,SMA'],
            'biaya_pendaftaran' => ['accepted'],
            'setuju_syarat' => ['accepted'],
            'website_address' => ['nullable', 'max:0', 'prohibited'],
        ];
    }

    /**
     * Pesan validasi dalam bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap calon siswa wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir calon siswa wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'asal_sekolah.required' => 'Asal sekolah calon siswa wajib diisi.',
            'alamat_rumah.required' => 'Alamat rumah wajib diisi.',
            'nama_ortu.required' => 'Nama orang tua / wali wajib diisi.',
            'no_telp_ortu.required' => 'Nomor WhatsApp orang tua wajib diisi untuk konfirmasi jadwal.',
            'no_telp_ortu.regex' => 'Format nomor WhatsApp orang tua tidak valid (gunakan 08xx / +628xx).',
            'no_telp_siswa.regex' => 'Format nomor WhatsApp siswa tidak valid (gunakan 08xx / +628xx).',
            'paket_bulanan.required' => 'Silakan pilih paket bimbingan bulanan.',
            'biaya_pendaftaran.accepted' => 'Centang konfirmasi biaya pendaftaran Rp. 35.000 untuk melanjutkan.',
            'setuju_syarat.accepted' => 'Anda harus menyetujui syarat dan ketentuan bimbingan Pelita Ilmu.',
            'website_address.prohibited' => 'Aktivitas bot terdeteksi.',
        ];
    }
}
