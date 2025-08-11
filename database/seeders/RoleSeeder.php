<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $staffRole = Role::create(['name' => 'staff']);
        
        // Create superadmin user
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $superAdmin->assignRole($superAdminRole);
        
        // Assign the admin role to the first user (or create one if none exists)
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            $admin = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }
        
        $admin->assignRole($adminRole);
        
        // Assign the user role to all other users that don't have the admin or superadmin role
        User::whereNotIn('id', [$admin->id, $superAdmin->id])
            ->get()
            ->each(function ($user) use ($userRole) {
                $user->assignRole($userRole);
            });
    }
}
