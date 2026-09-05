<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalKelompok extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelompoks';

    protected $fillable = [
        'kelompok_id',
        'tanggal_sesi',
        'status_sesi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_sesi' => 'date',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }
}
