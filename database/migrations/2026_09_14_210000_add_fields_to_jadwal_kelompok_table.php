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
            if (!Schema::hasColumn('jadwal_kelompok', 'status_sesi')) {
                $table->enum('status_sesi', ['TERJADWAL', 'SELESAI', 'BATAL'])->default('TERJADWAL')->after('tanggal_sesi');
            }
            if (!Schema::hasColumn('jadwal_kelompok', 'materi_pembahasan')) {
                $table->string('materi_pembahasan')->nullable()->after('status_sesi');
            }
            if (!Schema::hasColumn('jadwal_kelompok', 'catatan_tentor')) {
                $table->text('catatan_tentor')->nullable()->after('materi_pembahasan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_kelompok', function (Blueprint $table) {
            $table->dropColumn(['status_sesi', 'materi_pembahasan', 'catatan_tentor']);
        });
    }
};
