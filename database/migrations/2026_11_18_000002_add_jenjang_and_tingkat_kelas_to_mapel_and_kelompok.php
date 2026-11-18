<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mata_pelajaran')) {
            Schema::table('mata_pelajaran', function (Blueprint $table) {
                if (!Schema::hasColumn('mata_pelajaran', 'jenjang')) {
                    $table->string('jenjang', 50)->nullable()->index();
                }
                if (!Schema::hasColumn('mata_pelajaran', 'tingkat_kelas')) {
                    $table->string('tingkat_kelas', 100)->nullable()->index();
                }
            });
        }

        if (Schema::hasTable('kelompok')) {
            Schema::table('kelompok', function (Blueprint $table) {
                if (!Schema::hasColumn('kelompok', 'jenjang')) {
                    $table->string('jenjang', 50)->nullable()->index();
                }
                if (!Schema::hasColumn('kelompok', 'tingkat_kelas')) {
                    $table->string('tingkat_kelas', 100)->nullable()->index();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mata_pelajaran')) {
            Schema::table('mata_pelajaran', function (Blueprint $table) {
                if (Schema::hasColumn('mata_pelajaran', 'tingkat_kelas')) {
                    $table->dropColumn('tingkat_kelas');
                }
                if (Schema::hasColumn('mata_pelajaran', 'jenjang')) {
                    $table->dropColumn('jenjang');
                }
            });
        }

        if (Schema::hasTable('kelompok')) {
            Schema::table('kelompok', function (Blueprint $table) {
                if (Schema::hasColumn('kelompok', 'tingkat_kelas')) {
                    $table->dropColumn('tingkat_kelas');
                }
                if (Schema::hasColumn('kelompok', 'jenjang')) {
                    $table->dropColumn('jenjang');
                }
            });
        }
    }
};
