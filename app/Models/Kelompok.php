<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompoks';

    protected $fillable = [
        'nama_kelompok',
        'mapel_id',
        'tentor_id',
        'jadwal_hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function tentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tentor_id');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function jadwalKelompoks(): HasMany
    {
        return $this->hasMany(JadwalKelompok::class, 'kelompok_id');
    }

    public function siswas(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'pemetaan_kelompoks', 'kelompok_id', 'siswa_id')
            ->withTimestamps();
    }
}
