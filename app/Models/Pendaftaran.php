<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nama_lengkap',
        'asal_sekolah',
        'kelas',
        'kategori_kelas',
        'program_belajar',
        'pilihan_mapel',
        'tanggal_lahir',
        'nama_ortu',
        'no_telp_ortu',
        'no_telp_siswa',
        'alamat_rumah',
        'minat_program',
        'nomor_wa',
        'status_tindak_lanjut',
        'tanggal_masuk',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'datetime',
        'pilihan_mapel' => 'array',
    ];
}
