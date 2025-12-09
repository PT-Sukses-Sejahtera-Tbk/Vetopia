<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hewan;
use App\Models\Dokter;
use App\Models\Layanan;
use App\Models\RekamMedis;
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

        // Create dokter profile for doctor user
        $dokterProfile = Dokter::create([
            'user_id' => $doctor->id,
            'spesialisasi' => 'Dokter Hewan Umum',
            'deskripsi' => 'Berpengalaman dalam merawat berbagai jenis hewan peliharaan',
        ]);

        // Create layanans
        $layanan1 = Layanan::create([
            'nama' => 'Konsultasi Umum',
            'deskripsi' => 'Pemeriksaan kesehatan umum hewan peliharaan',
            'harga' => 100000,
        ]);

        $layanan2 = Layanan::create([
            'nama' => 'Perawatan Intensif',
            'deskripsi' => 'Perawatan untuk hewan dengan kondisi serius',
            'harga' => 250000,
        ]);

        // Create hewans
        $milo = Hewan::create([
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

        // Create rekam medis for Milo
        RekamMedis::create([
            'hewan_id' => $milo->id,
            'dokter_id' => $dokterProfile->id,
            'layanan_id' => $layanan1->id,
            'tanggal_periksa' => '2025-12-01',
            'diagnosa' => 'Ditemukan Infeksi saluran pernapasan',
            'tindakan' => "1. AntiBiotik 3x sehari\n2. Vitamin B",
        ]);

        RekamMedis::create([
            'hewan_id' => $milo->id,
            'dokter_id' => $dokterProfile->id,
            'layanan_id' => $layanan2->id,
            'tanggal_periksa' => '2025-11-15',
            'diagnosa' => 'Gangguan pencernaan ringan',
            'tindakan' => "1. Probiotik 2x sehari\n2. Diet khusus selama 5 hari\n3. Vitamin C",
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Hewans created successfully!');
        $this->command->info('Dokter and Layanan created successfully!');
        $this->command->info('Rekam Medis created successfully!');
    }
}
