<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nama_lengkap',
        'asal_sekolah',
        'kategori_kelas',
        'tipe_belajar',
        'tipe_jatuh_tempo',
        'status_siswa',
        'tanggal_daftar',
        'tanggal_lahir',
        'alamat_rumah',
        'no_telp_siswa',
        'nama_ortu',
        'no_telp_ortu',
        'biaya_bulanan',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tanggal_lahir' => 'date',
        'biaya_bulanan' => 'decimal:2',
    ];

    /**
     * Relasi ke Pembayaran.
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }

    /**
     * Relasi ke Kelompok belajar.
     */
    public function kelompok(): BelongsToMany
    {
        return $this->belongsToMany(Kelompok::class, 'pemetaan_kelompok', 'siswa_id', 'kelompok_id')
            ->withTimestamps();
    }
    public function detailPresensi(): HasMany
    {
        return $this->hasMany(DetailPresensi::class, 'siswa_id');
    }
}
