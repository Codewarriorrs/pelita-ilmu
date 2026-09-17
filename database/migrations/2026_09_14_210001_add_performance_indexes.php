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
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->index(['status_bayar', 'untuk_bulan', 'untuk_tahun']);
            $table->index('siswa_id');
            $table->index('admin_pencatat_id');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->index('status_tindak_lanjut');
            $table->index('tanggal_masuk');
        });

        Schema::table('kelompok', function (Blueprint $table) {
            $table->index('mapel_id');
            $table->index('tentor_id');
        });

        Schema::table('detail_presensi', function (Blueprint $table) {
            $table->index('status_kehadiran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropIndex(['status_bayar', 'untuk_bulan', 'untuk_tahun']);
            $table->dropIndex(['siswa_id']);
            $table->dropIndex(['admin_pencatat_id']);
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropIndex(['status_tindak_lanjut']);
            $table->dropIndex(['tanggal_masuk']);
        });

        Schema::table('kelompok', function (Blueprint $table) {
            $table->dropIndex(['mapel_id']);
            $table->dropIndex(['tentor_id']);
        });

        Schema::table('detail_presensi', function (Blueprint $table) {
            $table->dropIndex(['status_kehadiran']);
        });
    }
};
