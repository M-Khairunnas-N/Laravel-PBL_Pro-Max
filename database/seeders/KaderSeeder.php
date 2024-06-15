<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id'=> 2,
                'penduduk_id' => 2,
            ],
            [
                'user_id'=> 3,
                'penduduk_id' => 4,
            ],
            [
                'user_id'=> 4,
                'penduduk_id' => 6,
            ],
            [
                'user_id'=> 5,
                'penduduk_id' => 12,
            ],
            [
                'user_id'=> 6,
                'penduduk_id' => 14,
            ],
            [
                'user_id'=> 7,
                'penduduk_id' => 17,
            ],
        ];

        DB::table('kaders')->insert($data);
    }
}
