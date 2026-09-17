<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@pelitailmu.id'],
            [
                'name' => 'Administrator Pelita Ilmu',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'tanggal_daftar' => now(),
            ]
        );

        // Tentor Account
        User::updateOrCreate(
            ['email' => 'tentor@pelitailmu.id'],
            [
                'name' => 'Tentor Pelita Ilmu',
                'password' => Hash::make('password'),
                'role' => 'TENTOR',
                'tanggal_daftar' => now(),
            ]
        );

        // Default Test Account
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('admin123'),
                'role' => 'ADMIN',
                'tanggal_daftar' => now(),
            ]
        );
    }
}
