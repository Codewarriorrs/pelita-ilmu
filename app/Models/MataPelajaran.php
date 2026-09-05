<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'nama_mapel',
        'jenjang',
    ];

    public function kelompoks(): HasMany
    {
        return $this->hasMany(Kelompok::class, 'mapel_id');
    }
}
