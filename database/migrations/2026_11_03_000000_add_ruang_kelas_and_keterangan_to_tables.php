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
            if (!Schema::hasColumn('jadwal_kelompok', 'ruang_kelas')) {
                $table->string('ruang_kelas')->nullable()->after('tanggal_sesi');
            }
        });

        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelompok', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_kelompok', 'ruang_kelas')) {
                $table->dropColumn('ruang_kelas');
            }
        });

        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};

