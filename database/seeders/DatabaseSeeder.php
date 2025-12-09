<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hewan;
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
        $user1 = User::create([
            'name' => 'Mas Amba',
            'email' => 'amba@vetopia.com',
            'password' => bcrypt('amba123'),
            'phone_number' => '081234567890',
        ]);
        $user1->assignRole('user');

        $user2 = User::create([
            'name' => 'Imut Rizman',
            'email' => 'imut@vetopia.com',
            'password' => bcrypt('imut123'),
            'phone_number' => '081234567891',
        ]);
        $user2->assignRole('user');

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

        // Create hewans
        Hewan::create([
            'user_id' => $user1->id,
            'nama' => 'Milo',
            'jenis' => 'Anjing',
            'ras' => 'Golden Retriever',
            'umur' => 3,
        ]);

        Hewan::create([
            'user_id' => $user2->id,
            'nama' => 'Luna',
            'jenis' => 'Kucing',
            'ras' => 'Persian',
            'umur' => 2,
        ]);

        Hewan::create([
            'user_id' => $user2->id,
            'nama' => 'Charlie',
            'jenis' => 'Anjing',
            'ras' => 'Beagle',
            'umur' => 4,
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Hewans created successfully!');
    }
}
