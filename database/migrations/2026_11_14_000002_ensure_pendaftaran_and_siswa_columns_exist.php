<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran', 'paket_pendaftaran')) {
                $table->string('paket_pendaftaran', 50)->nullable();
            }
            if (!Schema::hasColumn('pendaftaran', 'ukuran_kaos')) {
                $table->string('ukuran_kaos', 10)->nullable();
            }
            if (!Schema::hasColumn('pendaftaran', 'nama_panggilan')) {
                $table->string('nama_panggilan', 50)->nullable();
            }
            if (!Schema::hasColumn('pendaftaran', 'program_belajar')) {
                $table->string('program_belajar', 100)->nullable();
            }
            if (!Schema::hasColumn('pendaftaran', 'pilihan_mapel')) {
                $table->json('pilihan_mapel')->nullable();
            }
        });

        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'kelas')) {
                $table->string('kelas')->nullable();
            }
            if (!Schema::hasColumn('siswa', 'pilihan_mapel')) {
                $table->json('pilihan_mapel')->nullable();
            }
        });
    }

    public function down(): void
    {
    }
};
