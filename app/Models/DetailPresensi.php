<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPresensi extends Model
{
    use HasFactory;

    // Supaya Eloquent tidak mencari tabel jamak 'detail_presensis'
    protected $table = 'detail_presensi';

    protected $fillable = [
        'jadwal_id',
        'siswa_id',
        'status_kehadiran',
    ];

    // Relasi ke Jadwal Kelompok (Sesi pertemuan)
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalKelompok::class, 'jadwal_id');
    }

    // Relasi ke Siswa yang diabsen
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}