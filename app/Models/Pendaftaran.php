<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nama_lengkap',
        'nama_panggilan',
        'asal_sekolah',
        'kelas',
        'kategori_kelas',
        'program_belajar',
        'pilihan_mapel',
        'tanggal_lahir',
        'nama_ortu',
        'no_telp_ortu',
        'no_telp_siswa',
        'alamat_rumah',
        'minat_program',
        'paket_pendaftaran',
        'ukuran_kaos',
        'nomor_wa',
        'status_tindak_lanjut',
        'tanggal_masuk',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'datetime',
        'pilihan_mapel' => 'array',
    ];

    /**
     * Parse daftar mata pelajaran (dari array pilihan_mapel atau regex minat_program).
     *
     * @return array<int, string>
     */
    public function getMapelListAttribute(): array
    {
        if (!empty($this->pilihan_mapel) && is_array($this->pilihan_mapel)) {
            return array_values(array_filter(array_map('trim', $this->pilihan_mapel)));
        }

        if (!empty($this->minat_program) && preg_match('/\(Mapel:\s*(.*?)\)/i', $this->minat_program, $matches)) {
            $raw = explode(',', $matches[1]);
            return array_values(array_filter(array_map('trim', $raw)));
        }

        return [];
    }

    /**
     * Format nomor WhatsApp menjadi standar 628xxx (menghapus karakter non-angka).
     */
    public function getFormattedWaAttribute(): string
    {
        $raw = $this->no_telp_ortu ?: $this->nomor_wa ?: $this->no_telp_siswa ?: '';
        $digits = preg_replace('/[^\d]/', '', (string) $raw);

        if (empty($digits)) {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }

    /**
     * Link langsung ke WhatsApp wa.me.
     */
    public function getWaUrlAttribute(): string
    {
        $phone = $this->formatted_wa;
        if (empty($phone)) {
            return '#';
        }

        $nama = $this->nama_lengkap;
        $namaOrtu = $this->nama_ortu ?: 'Bapak/Ibu';
        $program = $this->program_belajar ?: $this->minat_program ?: 'Bimbel';
        $pesan = urlencode("Halo {$namaOrtu}, terima kasih telah mendaftarkan ananda {$nama} di Bimbel Pelita Ilmu untuk program {$program}. Kami ingin mengonfirmasi pendaftaran dan jadwal belajar ananda.");

        return "https://wa.me/{$phone}?text={$pesan}";
    }

    /**
     * Teks program bersih tanpa embel-embel (Mapel: ...).
     */
    public function getProgramCleanAttribute(): string
    {
        if (!empty($this->minat_program)) {
            return trim(preg_replace('/\(Mapel:.*?\)/i', '', $this->minat_program));
        }

        $parts = [];
        if ($this->kelas) $parts[] = "[{$this->kelas}]";
        if ($this->kategori_kelas) $parts[] = $this->kategori_kelas;
        if ($this->program_belajar) $parts[] = "- {$this->program_belajar}";

        return implode(' ', $parts) ?: 'Bimbel';
    }
}
