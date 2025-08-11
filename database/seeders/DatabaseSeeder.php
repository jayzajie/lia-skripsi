<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeders in the right order
        // Di dalam method run()
        $this->call([
            // Seeder lainnya...
            AcademicYearSeeder::class,
        ]);

        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        
        // Get or create a test superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        
        // Assign role to user
        $superadmin->assignRole($superadminRole);
        
        // Find existing users and assign roles if needed
        $users = User::all();
        foreach ($users as $user) {
            if ($user->email !== 'superadmin@example.com' && !$user->hasAnyRole()) {
                $user->assignRole('student');
            }
        }
    }
}
