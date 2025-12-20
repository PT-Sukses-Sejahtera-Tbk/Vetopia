<?php

namespace Database\Seeders;

use App\Models\BookingKonsultasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingKonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users with 'user' role
        $users = User::role('user')->get();
        // Get users with 'doctor' role
        $doctors = User::role('doctor')->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder or DatabaseSeeder first.');
            return;
        }

        // Sample data for booking konsultasi
        $bookingData = [
            [
                'user_id' => $users->first()->id,
                'dokter_user_id' => $doctors->isNotEmpty() ? $doctors->first()->id : null,
                'nama_pemilik' => $users->first()->name,
                'nama_hewan' => 'Milo',
                'umur' => '3 tahun',
                'spesies' => 'Anjing',
                'ras' => 'Golden Retriever',
                'keluhan' => 'Hewan tidak mau makan dan terlihat lemas sejak 2 hari yang lalu',
                'tanggal_booking' => '2025-12-23',
                'status' => 'pending',
            ],
            [
                'user_id' => $users->count() > 1 ? $users->get(1)->id : $users->first()->id,
                'dokter_user_id' => $doctors->isNotEmpty() ? $doctors->first()->id : null,
                'nama_pemilik' => $users->count() > 1 ? $users->get(1)->name : $users->first()->name,
                'nama_hewan' => 'Luna',
                'umur' => '2 tahun',
                'spesies' => 'Kucing',
                'ras' => 'Persian',
                'keluhan' => 'Bulu rontok berlebihan dan sering menggaruk-garuk',
                'tanggal_booking' => '2025-12-24',
                'status' => 'approved',
            ],
            [
                'user_id' => $users->count() > 1 ? $users->get(1)->id : $users->first()->id,
                'dokter_user_id' => $doctors->isNotEmpty() ? $doctors->first()->id : null,
                'nama_pemilik' => $users->count() > 1 ? $users->get(1)->name : $users->first()->name,
                'nama_hewan' => 'Charlie',
                'umur' => '4 tahun',
                'spesies' => 'Anjing',
                'ras' => 'Beagle',
                'keluhan' => 'Check-up rutin dan vaksinasi tahunan',
                'tanggal_booking' => '2025-12-22',
                'status' => 'completed',
            ],
            [
                'user_id' => $users->count() > 1 ? $users->get(1)->id : $users->first()->id,
                'dokter_user_id' => $doctors->isNotEmpty() ? $doctors->first()->id : null,
                'nama_pemilik' => $users->count() > 1 ? $users->get(1)->name : $users->first()->name,
                'nama_hewan' => 'Luna',
                'umur' => '2 tahun',
                'spesies' => 'Kucing',
                'ras' => 'Persian',
                'keluhan' => 'Diare dan muntah sejak kemarin malam',
                'tanggal_booking' => '2025-12-25',
                'status' => 'pending',
            ],
            [
                'user_id' => $users->first()->id,
                'dokter_user_id' => $doctors->isNotEmpty() ? $doctors->first()->id : null,
                'nama_pemilik' => $users->first()->name,
                'nama_hewan' => 'Milo',
                'umur' => '3 tahun',
                'spesies' => 'Anjing',
                'ras' => 'Golden Retriever',
                'keluhan' => 'Vaksinasi pertama untuk anak anjing',
                'tanggal_booking' => '2025-12-21',
                'status' => 'completed',
            ],
        ];

        foreach ($bookingData as $data) {
            BookingKonsultasi::create($data);
        }

        $this->command->info('Booking Konsultasi seeded successfully!');
    }
}
