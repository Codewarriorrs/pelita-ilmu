<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'siswa_id',
        'status_bayar',
        'untuk_bulan',
        'untuk_tahun',
        'biaya_bulanan',
        'tanggal_bayar',
        'metode_bayar',
        'keterangan',
    ];

    protected $casts = [
        'untuk_bulan' => 'integer',
        'untuk_tahun' => 'integer',
        'biaya_bulanan' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
