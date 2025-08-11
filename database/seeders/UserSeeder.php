<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        $this->createRegularUsers();
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
            ]
        );

        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superAdmin->assignRole($superAdminRole);

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
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole($adminRole);

        $this->command->info('Admin user created.');
    }

    /**
     * Create Regular users
     */
    private function createRegularUsers(): void
    {
        // Create a regular user
        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'phone' => '08123456787',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $user->assignRole($userRole);

        // Create staff user
        $staff = User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'phone' => '08123456786',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staff->assignRole($staffRole);

        $this->command->info('Regular users created.');
    }
} 