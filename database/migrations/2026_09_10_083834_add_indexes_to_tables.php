<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_kelompok', function (Blueprint $table) {
            $table->index('kelompok_id');
            $table->index('tanggal_sesi');
        });

        Schema::table('detail_presensi', function (Blueprint $table) {
            $table->index(['jadwal_id', 'siswa_id']);
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->index('status_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
