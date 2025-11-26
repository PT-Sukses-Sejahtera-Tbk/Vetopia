<?php

namespace Database\Seeders;

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
        $userRole = Role::create(['name' => 'user']);
        $doctorRole = Role::create(['name' => 'doctor']);
        $adminRole = Role::create(['name' => 'admin']);

        // You can add permissions here if needed
        // Example:
        // $permission = Permission::create(['name' => 'edit articles']);
        // $adminRole->givePermissionTo($permission);

        $this->command->info('Roles created successfully!');
    }
}
