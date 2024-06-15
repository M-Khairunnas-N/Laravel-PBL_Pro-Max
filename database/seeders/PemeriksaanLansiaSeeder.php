<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemeriksaanLansiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'pemeriksaan_id' => 14,
                'lingkar_perut' => 13.3,
                'gula_darah' => 140,
                'kolesterol' => 180,
                'tensi_darah' => 129,
                'asam_urat' => 4.2,
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 15,
                'lingkar_perut' => 13.6,
                'gula_darah' => 145,
                'kolesterol' => 160,
                'tensi_darah' => 132,
                'asam_urat' => 3.2,
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 16,
                'lingkar_perut' => 13.5,
                'gula_darah' => 140,
                'kolesterol' => 163,
                'tensi_darah' => 135,
                'asam_urat' => 4.7,
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 17,
                'lingkar_perut' => 13.3,
                'gula_darah' => 140,
                'kolesterol' => 180,
                'tensi_darah' => 129,
                'asam_urat' => 4.2,
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 18,
                'lingkar_perut' => 11.3,
                'gula_darah' => 145,
                'kolesterol' => 160,
                'tensi_darah' => 132,
                'asam_urat' => 3.2,
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 19,
                'lingkar_perut' => 13.5,
                'gula_darah' => 140,
                'kolesterol' => 163,
                'tensi_darah' => 135,
                'asam_urat' => 4.7,
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 20,
                'lingkar_perut' => 13.3,
                'gula_darah' => 140,
                'kolesterol' => 180,
                'tensi_darah' => 129,
                'asam_urat' => 4.2,
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 21,
                'lingkar_perut' => 12.7,
                'gula_darah' => 145,
                'kolesterol' => 160,
                'tensi_darah' => 130,
                'asam_urat' => 3.4,
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 22,
                'lingkar_perut' => 13.5,
                'gula_darah' => 140,
                'kolesterol' => 163,
                'tensi_darah' => 135,
                'asam_urat' => 4.7,
                'created_at' => '2024-03-15',
                'updated_at' => '2024-03-15',
            ], [
                'pemeriksaan_id' => 23,
                'lingkar_perut' => 13.3,
                'gula_darah' => 145,
                'kolesterol' => 160,
                'tensi_darah' => 132,
                'asam_urat' => 3.2,
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 24,
                'lingkar_perut' => 14.5,
                'gula_darah' => 144,
                'kolesterol' => 159,
                'tensi_darah' => 140,
                'asam_urat' => 4.7,
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ],
        ];

        DB::table('pemeriksaan_lansias')->insert($data);
    }
}
