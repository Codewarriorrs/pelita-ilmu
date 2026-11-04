<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('paket_pendaftaran', 50)->nullable()->after('minat_program');
            $table->string('ukuran_kaos', 10)->nullable()->after('paket_pendaftaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['paket_pendaftaran', 'ukuran_kaos']);
        });
    }
};
