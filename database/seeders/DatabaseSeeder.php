<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call([
            RoleSeeder::class,
        ]);

        // Create users with specific roles
        $user = User::create([
            'name' => 'Mas Amba',
            'email' => 'user@vetopia.com',
            'password' => bcrypt('user123'),
            'phone_number' => '081234567890',
        ]);
        $user->assignRole('user');

        $doctor = User::create([
            'name' => 'Ambaruwo',
            'email' => 'doctor@vetopia.com',
            'password' => bcrypt('doctor123'),
            'phone_number' => '081234567891',
        ]);
        $doctor->assignRole('doctor');

        $admin = User::create([
            'name' => 'Atmint',
            'email' => 'admin@vetopia.com',
            'password' => bcrypt('admin123'),
            'phone_number' => '081234567892',
        ]);
        $admin->assignRole('admin');

        $this->command->info('Users created successfully!');
    }
}
