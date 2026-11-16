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

        $hour = (int) now()->format('H');
        $sapaan = match (true) {
            $hour >= 4 && $hour < 11 => 'Pagi',
            $hour >= 11 && $hour < 15 => 'Siang',
            $hour >= 15 && $hour < 18 => 'Sore',
            default => 'Malam',
        };

        $namaOrtu = $this->nama_ortu ?: 'Bapak/Ibu';
        $namaSiswa = $this->nama_lengkap;
        $panggilan = $this->nama_panggilan ?: explode(' ', trim((string) $namaSiswa))[0];
        $program = $this->program_belajar ?: $this->minat_program ?: 'Bimbel';
        $tanggalDaftar = $this->tanggal_masuk ? $this->tanggal_masuk->translatedFormat('d F Y') : now()->translatedFormat('d F Y');

        $mapels = is_array($this->pilihan_mapel) ? $this->pilihan_mapel : [];
        $mapelList = !empty($mapels) ? implode(', ', $mapels) : ($this->program_belajar ?: '-');

        $kaosOrBiasa = !empty($this->ukuran_kaos)
            ? "Dengan Kaos (Ukuran {$this->ukuran_kaos})"
            : ($this->paket_pendaftaran ?: 'Pendaftaran Biasa (Tanpa Kaos)');

        $rincian = "• Program: {$program}\n• Mata Pelajaran: {$mapelList}\n• Paket: {$kaosOrBiasa}";

        $pesanTeks = "Selamat {$sapaan} Bapak/Ibu {$namaOrtu}, terima kasih telah mendaftarkan ananda {$namaSiswa} di Bimbel Pelita Ilmu untuk program {$program}. Kami ingin mengonfirmasi pendaftaran dan jadwal belajar ananda {$panggilan} yang baru saja mendaftar pada {$tanggalDaftar}. Apakah benar ananda {$namaSiswa} mendaftar pada Bimbingan Belajar kami dengan rincian sebagai berikut :\n\n{$rincian}\n\nksmi akan verifikasi dan memroses pendaftaran ke proses selanjutnya.\nTerima Kasih!";

        return "https://wa.me/{$phone}?text=" . rawurlencode($pesanTeks);
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
