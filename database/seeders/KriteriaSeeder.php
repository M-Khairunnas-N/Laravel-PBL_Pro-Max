<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'C1',
                'nama' => 'Berat Badan',
                'bobot' => 0.2,
                'jenis' => 'benefit',
            ],
            [
                'kode' => 'C2',
                'nama' => 'Tinggi Badan',
                'bobot' => 0.3,
                'jenis' => 'benefit',
            ],
            [
                'kode' => 'C3',
                'nama' => 'Lingkar Kepala',
                'bobot' => 0.2,
                'jenis' => 'benefit',
            ],
            [
                'kode' => 'C4',
                'nama' => 'Lingkar Lengan',
                'bobot' => 0.1,
                'jenis' => 'benefit',
            ],
            [
                'kode' => 'C5',
                'nama' => 'Umur',
                'bobot' => 0.2,
                'jenis' => 'cost',
            ],
        ];

        DB::table('kriterias')->insert($data);
    }
}
