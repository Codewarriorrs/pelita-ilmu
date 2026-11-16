<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        // Jalankan seeder reset data simulasi saat deploy CI/CD migrate --force di server
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\DatabaseSeeder',
            '--force' => true,
        ]);
    }

    public function down(): void
    {
    }
};
