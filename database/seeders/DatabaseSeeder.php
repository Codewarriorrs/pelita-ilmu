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
        // Admin Account 1
        User::updateOrCreate(
            ['email' => 'admin@pelitailmu.id'],
            [
                'name' => 'Administrator Pelita Ilmu',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'tanggal_daftar' => now(),
            ]
        );

        // Admin Account 2
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('admin123'),
                'role' => 'ADMIN',
                'tanggal_daftar' => now(),
            ]
        );

        // Tentor Account
        User::updateOrCreate(
            ['email' => 'tentor@pelitailmu.id'],
            [
                'name' => 'Tentor Pelita Ilmu',
                'password' => Hash::make('tentor123'),
                'role' => 'TENTOR',
                'tanggal_daftar' => now(),
            ]
        );

        // Guru Account
        User::updateOrCreate(
            ['email' => 'guru@pelitailmu.id'],
            [
                'name' => 'Guru Pengajar Pelita Ilmu',
                'password' => Hash::make('guru123'),
                'role' => 'TENTOR',
                'tanggal_daftar' => now(),
            ]
        );
    }
}
