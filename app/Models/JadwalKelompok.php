<?php

namespace App\Models;

use App\Models\DetailPresensi;
use App\Models\Kelompok;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalKelompok extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelompok';

    protected $fillable = [
        'kelompok_id',
        'tanggal_sesi',
        'jam_mulai',
        'jam_selesai',
        'ruang_kelas',
        'status_sesi',
        'materi_pembahasan',
        'catatan_tentor',
        'catatan',
    ];

    protected $casts = [
        'tanggal_sesi' => 'date',
    ];

    /**
     * Cek apakah waktu sesi sedang berlangsung (dalam rentang jam mulai s.d. jam selesai WIB).
     */
    public function canDoPresensi(): bool
    {
        if (! $this->tanggal_sesi) {
            return false;
        }

        $sesiDate = $this->tanggal_sesi->toDateString();
        $jamMulai = $this->effective_jam_mulai ?? '00:00:00';
        $jamSelesai = $this->effective_jam_selesai ?? '23:59:59';

        $sesiStartTime = \Illuminate\Support\Carbon::parse("{$sesiDate} {$jamMulai}", 'Asia/Jakarta');
        $sesiEndTime = \Illuminate\Support\Carbon::parse("{$sesiDate} {$jamSelesai}", 'Asia/Jakarta');
        $now = \Illuminate\Support\Carbon::now('Asia/Jakarta');

        return $now->gte($sesiStartTime) && $now->lte($sesiEndTime);
    }

    public function getPresensiStatusText(): string
    {
        if (! $this->tanggal_sesi) {
            return 'Tanggal sesi belum ditentukan';
        }

        $sesiDate = $this->tanggal_sesi->toDateString();
        $jamMulai = $this->effective_jam_mulai ?? '00:00:00';
        $jamSelesai = $this->effective_jam_selesai ?? '23:59:59';

        $sesiStart = \Illuminate\Support\Carbon::parse("{$sesiDate} {$jamMulai}", 'Asia/Jakarta');
        $sesiEnd = \Illuminate\Support\Carbon::parse("{$sesiDate} {$jamSelesai}", 'Asia/Jakarta');
        $now = \Illuminate\Support\Carbon::now('Asia/Jakarta');

        if ($now->lt($sesiStart)) {
            $jam = substr($jamMulai, 0, 5);
            $tgl = $this->tanggal_sesi->format('d M Y');
            return "Presensi terkunci. Sesi baru dibuka pada {$tgl} pk {$jam} WIB.";
        }

        if ($now->gt($sesiEnd)) {
            $jam = substr($jamSelesai, 0, 5);
            return "Presensi ditutup. Waktu sesi telah berakhir pada pk {$jam} WIB.";
        }

        return 'Isi / Edit Presensi (Sesi Sedang Berlangsung)';
    }

    public function getEffectiveJamMulaiAttribute(): ?string
    {
        return $this->jam_mulai ?? $this->kelompok?->jam_mulai;
    }

    public function getEffectiveJamSelesaiAttribute(): ?string
    {
        return $this->jam_selesai ?? $this->kelompok?->jam_selesai;
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
    public function detailPresensi(): HasMany
{
    return $this->hasMany(DetailPresensi::class, 'jadwal_id');
}
}
