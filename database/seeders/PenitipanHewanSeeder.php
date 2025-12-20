<?php

namespace Database\Seeders;

use App\Models\PenitipanHewan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenitipanHewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users with 'user' role
        $users = User::role('user')->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder or DatabaseSeeder first.');
            return;
        }

        // Sample data for penitipan hewan
        $penitipanData = [
            [
                'user_id' => $users->first()->id,
                'nama_pemilik' => $users->first()->name,
                'nama_hewan' => 'Milo',
                'umur' => '3 tahun',
                'spesies' => 'Anjing',
                'ras' => 'Golden Retriever',
                'alamat_rumah' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'tanggal_titip' => '2025-12-22',
                'tanggal_ambil' => '2025-12-25',
                'jenis_service' => 'Pick-up',
                'status' => 'pending',
            ],
            [
                'user_id' => $users->count() > 1 ? $users->get(1)->id : $users->first()->id,
                'nama_pemilik' => $users->count() > 1 ? $users->get(1)->name : $users->first()->name,
                'nama_hewan' => 'Luna',
                'umur' => '2 tahun',
                'spesies' => 'Kucing',
                'ras' => 'Persian',
                'alamat_rumah' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
                'tanggal_titip' => '2025-12-23',
                'tanggal_ambil' => '2025-12-26',
                'jenis_service' => 'Drop-off',
                'status' => 'pending',
            ],
            [
                'user_id' => $users->count() > 1 ? $users->get(1)->id : $users->first()->id,
                'nama_pemilik' => $users->count() > 1 ? $users->get(1)->name : $users->first()->name,
                'nama_hewan' => 'Charlie',
                'umur' => '4 tahun',
                'spesies' => 'Anjing',
                'ras' => 'Beagle',
                'alamat_rumah' => 'Jl. Thamrin No. 88, Jakarta Selatan',
                'tanggal_titip' => '2025-12-20',
                'tanggal_ambil' => '2025-12-24',
                'jenis_service' => 'Pick-up',
                'status' => 'approved',
            ],
            [
                'user_id' => $users->first()->id,
                'nama_pemilik' => $users->first()->name,
                'nama_hewan' => 'Milo',
                'umur' => '3 tahun',
                'spesies' => 'Anjing',
                'ras' => 'Golden Retriever',
                'alamat_rumah' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'tanggal_titip' => '2025-12-15',
                'tanggal_ambil' => '2025-12-18',
                'jenis_service' => 'Drop-off',
                'status' => 'completed',
            ],
        ];

        foreach ($penitipanData as $data) {
            PenitipanHewan::create($data);
        }

        $this->command->info('Penitipan Hewan seeded successfully!');
    }
}
