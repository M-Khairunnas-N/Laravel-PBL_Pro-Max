<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemeriksaanBayiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'pemeriksaan_id' => 1,
                'lingkar_kepala' => 13.3,
                'lingkar_lengan' => 5.1,
                'asi' => 'iya',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 2,
                'lingkar_kepala' => 14.3,
                'lingkar_lengan' => 6.5,
                'asi' => 'iya',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 3,
                'lingkar_kepala' => 10.3,
                'lingkar_lengan' => 7.3,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 4,
                'lingkar_kepala' => 11.3,
                'lingkar_lengan' => 8.3,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 5,
                'lingkar_kepala' => 12.7,
                'lingkar_lengan' => 8.1,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 6,
                'lingkar_kepala' => 13.3,
                'lingkar_lengan' => 9.1,
                'asi' => 'iya',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 7,
                'lingkar_kepala' => 14.3,
                'lingkar_lengan' => 9.5,
                'asi' => 'iya',
                'kategori_golongan' => 'balita',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 8,
                'lingkar_kepala' => 15.1,
                'lingkar_lengan' => 9.8,
                'asi' => 'tidak',
                'kategori_golongan' => 'balita',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 9,
                'lingkar_kepala' => 20.3,
                'lingkar_lengan' => 9.3,
                'asi' => 'tidak',
                'kategori_golongan' => 'balita',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 10,
                'lingkar_kepala' => 21.7,
                'lingkar_lengan' => 10.1,
                'asi' => 'tidak',
                'kategori_golongan' => 'balita',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 11,
                'lingkar_kepala' => 17.3,
                'lingkar_lengan' => 8.3,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-03-15',
                'updated_at' => '2024-03-15',
            ], [
                'pemeriksaan_id' => 12,
                'lingkar_kepala' => 17.7,
                'lingkar_lengan' => 9.3,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'pemeriksaan_id' => 13,
                'lingkar_kepala' => 18.7,
                'lingkar_lengan' => 10.1,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ], [
                'pemeriksaan_id' => 25,
                'lingkar_kepala' => 19.7,
                'lingkar_lengan' => 11.1,
                'asi' => 'tidak',
                'kategori_golongan' => 'bayi',
                'created_at' => '2024-05-10',
                'updated_at' => '2024-05-10',
            ],
        ];

        DB::table('pemeriksaan_bayis')->insert($data);
    }
}
