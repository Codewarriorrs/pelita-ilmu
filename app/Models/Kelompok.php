<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelompok extends Model
{
    protected $table = 'kelompok';

    protected $fillable = [
        'nama_kelompok',
        'mapel_id',
        'tentor_id',
        'jadwal_hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // Relasi ke Mata Pelajaran
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    // Relasi ke User (Tentor pengampu)
    public function tentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tentor_id');
    }

    // Relasi Many-to-Many ke Siswa anggota kelompok
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'pemetaan_kelompok', 'kelompok_id', 'siswa_id')
            ->withTimestamps();
    }

    // Relasi ke sesi pertemuan/jadwal
    public function jadwalKelompok(): HasMany
    {
        return $this->hasMany(JadwalKelompok::class, 'kelompok_id');
    }
}