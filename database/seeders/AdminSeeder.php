<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id'=> 1,
                'penduduk_id' => 3,
            ],
            [
                'user_id'=> 8,
                'penduduk_id' => 11,
            ],
        ];

        DB::table('admins')->insert($data);
    }
}
