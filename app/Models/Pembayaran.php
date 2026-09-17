<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'siswa_id',
        'admin_pencatat_id',
        'status_bayar',
        'untuk_bulan',
        'untuk_tahun',
        'biaya_dibayar',
        'tanggal_bayar',
        'metode_bayar',
    ];

    protected $casts = [
        'untuk_bulan' => 'integer',
        'untuk_tahun' => 'integer',
        'biaya_dibayar' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function adminPencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_pencatat_id');
    }
}
