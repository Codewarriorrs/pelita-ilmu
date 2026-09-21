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
        'status_sesi',
        'materi_pembahasan',
        'catatan_tentor',
        'catatan',
    ];

    protected $casts = [
        'tanggal_sesi' => 'date',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
    public function detailPresensi(): HasMany
{
    return $this->hasMany(DetailPresensi::class, 'jadwal_id');
}
}
