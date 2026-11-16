<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::table('jadwal_kelompok', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_kelompok', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable()->after('tanggal_sesi');
            }
            if (!Schema::hasColumn('jadwal_kelompok', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable()->after('jam_mulai');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelompok', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_kelompok', 'jam_selesai')) {
                $table->dropColumn('jam_selesai');
            }
            if (Schema::hasColumn('jadwal_kelompok', 'jam_mulai')) {
                $table->dropColumn('jam_mulai');
            }
        });
    }
};
