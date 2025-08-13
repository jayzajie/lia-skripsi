<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with specific roles
        $this->createSuperAdmin();
        $this->createAdmin();
        $this->createGuru();
        $this->createSiswa();
        $this->createOrangtua();
    }

    /**
     * Create Super Admin user
     */
    private function createSuperAdmin(): void
    {
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'phone' => '08123456789',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        $this->command->info('Super Admin user created.');
    }

    /**
     * Create Admin user
     */
    private function createAdmin(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'phone' => '08123456788',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->command->info('Admin user created.');
    }

    /**
     * Create Guru user
     */
    private function createGuru(): void
    {
        $guru = User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Contoh',
                'email' => 'guru@example.com',
                'phone' => '08123456777',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'guru',
                'is_active' => true,
            ]
        );

        $this->command->info('Guru user created.');
    }

    /**
     * Create Siswa user
     */
    private function createSiswa(): void
    {
        $siswa = User::updateOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa Contoh',
                'email' => 'siswa@example.com',
                'phone' => '08123456776',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'siswa',
                'is_active' => true,
            ]
        );

        $this->command->info('Siswa user created.');
    }

    /**
     * Create Orangtua user
     */
    private function createOrangtua(): void
    {
        $orangtua = User::updateOrCreate(
            ['email' => 'orangtua@example.com'],
            [
                'name' => 'Orang Tua Contoh',
                'email' => 'orangtua@example.com',
                'phone' => '08123456775',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'orangtua',
                'is_active' => true,
            ]
        );

        $this->command->info('Orangtua user created.');
    }
}
