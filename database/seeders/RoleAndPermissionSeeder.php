<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $this->createPermissions();

        // Create roles and assign permissions
        $this->createRolesWithPermissions();
    }

    /**
     * Create permissions for different sections
     */
    private function createPermissions(): void
    {
        // Student management permissions
        $studentPermissions = [
            'view students',
            'create students',
            'edit students',
            'delete students',
        ];

        // Staff management permissions
        $staffPermissions = [
            'view staff',
            'create staff',
            'edit staff',
            'delete staff',
        ];

        // Activities management permissions
        $activityPermissions = [
            'view activities',
            'create activities',
            'edit activities',
            'delete activities',
            'publish activities',
        ];

        // Subject management permissions
        $subjectPermissions = [
            'view subjects',
            'create subjects',
            'edit subjects',
            'delete subjects',
            'assign teachers',
        ];

        // Evaluation management permissions
        $evaluationPermissions = [
            'view evaluations',
            'create evaluations',
            'edit evaluations',
            'delete evaluations',
            'generate reports',
        ];

        // Schedule management permissions
        $schedulePermissions = [
            'view schedules',
            'create schedules',
            'edit schedules',
            'delete schedules',
        ];

        // User management permissions
        $userPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
        ];

        // Create all permissions
        $allPermissions = array_merge(
            $studentPermissions,
            $staffPermissions,
            $activityPermissions,
            $subjectPermissions,
            $evaluationPermissions,
            $schedulePermissions,
            $userPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->command->info('Permissions created.');
    }

    /**
     * Create roles and assign permissions
     */
    private function createRolesWithPermissions(): void
    {
        // Create Super Admin role with all permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create Admin role with limited permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view students', 'create students', 'edit students',
            'view staff', 'create staff', 'edit staff',
            'view activities', 'create activities', 'edit activities', 'publish activities',
            'view subjects', 'create subjects', 'edit subjects',
            'view evaluations', 'create evaluations', 'edit evaluations', 'generate reports',
            'view schedules', 'create schedules', 'edit schedules',
            'view users',
        ]);

        // Create Staff role with very limited permissions
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view students',
            'view activities',
            'view subjects',
            'view evaluations', 'create evaluations', 'edit evaluations',
            'view schedules',
        ]);

        // Create User role with minimal permissions
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo([
            'view activities',
            'view schedules',
        ]);

        $this->command->info('Roles created and permissions assigned.');
    }
} 