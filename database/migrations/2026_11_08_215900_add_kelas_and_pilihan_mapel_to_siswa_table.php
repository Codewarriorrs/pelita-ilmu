<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'kelas')) {
                $table->string('kelas')->nullable()->after('asal_sekolah');
            }
            if (!Schema::hasColumn('siswa', 'pilihan_mapel')) {
                $table->json('pilihan_mapel')->nullable()->after('kategori_kelas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'kelas')) {
                $table->dropColumn('kelas');
            }
            if (Schema::hasColumn('siswa', 'pilihan_mapel')) {
                $table->dropColumn('pilihan_mapel');
            }
        });
    }
};
