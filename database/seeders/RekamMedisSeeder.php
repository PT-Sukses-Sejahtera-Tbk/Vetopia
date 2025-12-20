<?php

namespace Database\Seeders;

use App\Models\RekamMedis;
use App\Models\Hewan;
use App\Models\Dokter;
use App\Models\Layanan;
use Illuminate\Database\Seeder;

class RekamMedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing records
        $hewans = Hewan::all();
        $dokters = Dokter::all();
        $layanans = Layanan::all();

        if ($hewans->isEmpty() || $dokters->isEmpty() || $layanans->isEmpty()) {
            $this->command->warn('Required data (Hewan, Dokter, or Layanan) not found. Please seed them first.');
            return;
        }

        // Sample data for rekam medis
        $rekamMedisData = [
            [
                'hewan_id' => $hewans->first()->id,
                'dokter_id' => $dokters->first()->id,
                'layanan_id' => $layanans->first()->id,
                'tanggal_periksa' => '2025-12-01',
                'diagnosa' => 'Infeksi saluran pernapasan atas',
                'tindakan' => "1. Antibiotik Amoxicillin 3x sehari\n2. Vitamin B kompleks\n3. Istirahat cukup",
            ],
            [
                'hewan_id' => $hewans->count() > 1 ? $hewans->get(1)->id : $hewans->first()->id,
                'dokter_id' => $dokters->first()->id,
                'layanan_id' => $layanans->first()->id,
                'tanggal_periksa' => '2025-12-05',
                'diagnosa' => 'Dermatitis alergi',
                'tindakan' => "1. Salep anti-inflamasi 2x sehari\n2. Antihistamin\n3. Ganti pakan hypoallergenic",
            ],
            [
                'hewan_id' => $hewans->first()->id,
                'dokter_id' => $dokters->first()->id,
                'layanan_id' => $layanans->count() > 1 ? $layanans->get(1)->id : $layanans->first()->id,
                'tanggal_periksa' => '2025-11-15',
                'diagnosa' => 'Gangguan pencernaan ringan',
                'tindakan' => "1. Probiotik 2x sehari\n2. Diet khusus selama 5 hari\n3. Vitamin C\n4. Perbanyak minum air",
            ],
            [
                'hewan_id' => $hewans->count() > 2 ? $hewans->get(2)->id : $hewans->first()->id,
                'dokter_id' => $dokters->first()->id,
                'layanan_id' => $layanans->first()->id,
                'tanggal_periksa' => '2025-12-10',
                'diagnosa' => 'Vaksinasi rabies tahunan',
                'tindakan' => "1. Vaksin rabies telah diberikan\n2. Observasi 30 menit post vaksinasi\n3. Jadwal vaksinasi berikutnya: Desember 2026",
            ],
            [
                'hewan_id' => $hewans->count() > 1 ? $hewans->get(1)->id : $hewans->first()->id,
                'dokter_id' => $dokters->first()->id,
                'layanan_id' => $layanans->count() > 1 ? $layanans->get(1)->id : $layanans->first()->id,
                'tanggal_periksa' => '2025-11-20',
                'diagnosa' => 'Otitis externa (infeksi telinga)',
                'tindakan' => "1. Tetes telinga antibiotik 2x sehari\n2. Bersihkan telinga dengan cotton bud steril\n3. Hindari air masuk ke telinga\n4. Kontrol seminggu lagi",
            ],
            [
                'hewan_id' => $hewans->first()->id,
                'dokter_id' => $dokters->first()->id,
                'layanan_id' => $layanans->first()->id,
                'tanggal_periksa' => '2025-12-15',
                'diagnosa' => 'Pemeriksaan rutin - Sehat',
                'tindakan' => "1. Kondisi hewan baik\n2. Lanjutkan pola makan yang sehat\n3. Rutin olahraga/bermain\n4. Check-up berikutnya 3 bulan lagi",
            ],
        ];

        foreach ($rekamMedisData as $data) {
            RekamMedis::create($data);
        }

        $this->command->info('Rekam Medis seeded successfully!');
    }
}
