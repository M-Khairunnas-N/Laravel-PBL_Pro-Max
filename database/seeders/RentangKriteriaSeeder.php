<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentangKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'C1',
                'rentang_min' => -20.1,
                'rentang_max' => -4.0,
                'nilai' => 9,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => -4.0,
                'rentang_max' => -2.1,
                'nilai' => 8,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => -2.0,
                'rentang_max' => -0.1,
                'nilai' => 7,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => 0.0,
                'rentang_max' => 0.5,
                'nilai' => 6,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => 0.6,
                'rentang_max' => 1.0,
                'nilai' => 5,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => 1.1,
                'rentang_max' => 1.5,
                'nilai' => 4,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => 1.6,
                'rentang_max' => 2.0,
                'nilai' => 3,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => 2.1,
                'rentang_max' => 2.5,
                'nilai' => 2,
            ],
            [
                'kode' => 'C1',
                'rentang_min' => 2.6,
                'rentang_max' => 3.0,
                'nilai' => 1,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => -20.1,
                'rentang_max' => -4.0,
                'nilai' => 9,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => -4.0,
                'rentang_max' => -2.1,
                'nilai' => 8,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => -2.0,
                'rentang_max' => -0.1,
                'nilai' => 7,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => 0.0,
                'rentang_max' => 0.5,
                'nilai' => 6,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => 0.6,
                'rentang_max' => 1.0,
                'nilai' => 5,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => 1.1,
                'rentang_max' => 1.5,
                'nilai' => 4,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => 1.6,
                'rentang_max' => 2.0,
                'nilai' => 3,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => 2.1,
                'rentang_max' => 2.5,
                'nilai' => 2,
            ],
            [
                'kode' => 'C2',
                'rentang_min' => 2.6,
                'rentang_max' => 3.0,
                'nilai' => 1,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => -20.1,
                'rentang_max' => -4.0,
                'nilai' => 9,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => -4.0,
                'rentang_max' => -2.1,
                'nilai' => 8,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => -2.0,
                'rentang_max' => -0.1,
                'nilai' => 7,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => 0.0,
                'rentang_max' => 0.5,
                'nilai' => 6,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => 0.6,
                'rentang_max' => 1.0,
                'nilai' => 5,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => 1.1,
                'rentang_max' => 1.5,
                'nilai' => 4,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => 1.6,
                'rentang_max' => 2.0,
                'nilai' => 3,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => 2.1,
                'rentang_max' => 2.5,
                'nilai' => 2,
            ],
            [
                'kode' => 'C3',
                'rentang_min' => 2.6,
                'rentang_max' => 3.0,
                'nilai' => 1,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => -20.1,
                'rentang_max' => -4.0,
                'nilai' => 9,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => -4.0,
                'rentang_max' => -2.1,
                'nilai' => 8,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => -2.0,
                'rentang_max' => -0.1,
                'nilai' => 7,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => 0.0,
                'rentang_max' => 0.5,
                'nilai' => 6,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => 0.6,
                'rentang_max' => 1.0,
                'nilai' => 5,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => 1.1,
                'rentang_max' => 1.5,
                'nilai' => 4,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => 1.6,
                'rentang_max' => 2.0,
                'nilai' => 3,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => 2.1,
                'rentang_max' => 2.5,
                'nilai' => 2,
            ],
            [
                'kode' => 'C4',
                'rentang_min' => 2.6,
                'rentang_max' => 3.0,
                'nilai' => 1,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 48.6,
                'rentang_max' => 60.0,
                'nilai' => 1,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 42.6,
                'rentang_max' => 48.5,
                'nilai' => 2,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 36.6,
                'rentang_max' => 42.5,
                'nilai' => 3,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 30.6,
                'rentang_max' => 36.5,
                'nilai' => 4,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 24.6,
                'rentang_max' => 30.5,
                'nilai' => 5,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 18.6,
                'rentang_max' => 24.5,
                'nilai' => 6,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 12.6,
                'rentang_max' => 18.5,
                'nilai' => 7,
            ],
            [
                'kode' => 'C5',
                'rentang_min' => 6.6,
                'rentang_max' => 12.5,
                'nilai' => 8,
                ],
            [
                'kode' => 'C5',
                'rentang_min' => 0.0,
                'rentang_max' => 6.5,
                'nilai' => 9,
            ],
        ];

        DB::table('rentang_kriterias')->insert($data);
    }
}
