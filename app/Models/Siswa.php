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
        'kelas',
        'kategori_kelas',
        'pilihan_mapel',
        'tipe_belajar',
        'tipe_jatuh_tempo',
        'status_siswa',
        'tanggal_daftar',
        'tanggal_keluar',
        'tanggal_lahir',
        'alamat_rumah',
        'no_telp_siswa',
        'nama_ortu',
        'no_telp_ortu',
        'biaya_bulanan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tanggal_keluar' => 'date',
        'tanggal_lahir' => 'date',
        'pilihan_mapel' => 'array',
        'biaya_bulanan' => 'decimal:2',
    ];

    /**
     * Scope siswa yang aktif terdaftar pada rentang periode tertentu.
     */
    public function scopeAktifDiPeriode(\Illuminate\Database\Eloquent\Builder $query, ?\Illuminate\Support\Carbon $awalPeriode, ?\Illuminate\Support\Carbon $akhirPeriode): \Illuminate\Database\Eloquent\Builder
    {
        if ($akhirPeriode !== null) {
            $query->where(function (\Illuminate\Database\Eloquent\Builder $q) use ($akhirPeriode): void {
                $q->whereNull('tanggal_daftar')
                    ->orWhere('tanggal_daftar', '<=', $akhirPeriode->toDateString());
            });
        }

        if ($awalPeriode !== null) {
            $query->where(function (\Illuminate\Database\Eloquent\Builder $q) use ($awalPeriode): void {
                $q->whereNull('tanggal_keluar')
                    ->orWhere('tanggal_keluar', '>=', $awalPeriode->toDateString());
            });
        }

        return $query;
    }

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

    /**
     * Alias relasi ke Kelompok belajar (plural).
     */
    public function kelompoks(): BelongsToMany
    {
        return $this->kelompok();
    }

    public function detailPresensi(): HasMany
    {
        return $this->hasMany(DetailPresensi::class, 'siswa_id');
    }
}
