<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'fauziii',
                'password' => Hash::make('Admin123'),
                'level' => 'admin',
                'foto_profil' => 'IyIppQBsQ8RTEChHVHPMR0vmpJRKRyXPXCge7BQK.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(2),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(2)
            ], [
                'username' => 'ketua1',
                'password' => Hash::make('Ketua123'),
                'level' => 'ketua',
                'foto_profil' => 'SVnIUMMRutUsdBgoimEw3bpRojoiUpuruIhKFzuC.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths()
            ], [
                'username' => 'kader1',
                'password' => Hash::make('Kader123'),
                'level' => 'kader',
                'foto_profil' => 'i4FUI1OSKGy8GrJqT2RfH4NsdV6s8Ku8jTTefLIV.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(3),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(3)

            ], [
                'username' => 'kader2',
                'password' => Hash::make('Kader234'),
                'level' => 'kader',
                'foto_profil' => 'M4Xaa6jgSvFTj2Pg5HuOhg7e5IdFX1y8ra7JRfq1.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(2),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(2)
            ], [
                'username' => 'kader3',
                'password' => Hash::make('Kader345'),
                'level' => 'kader',
                'foto_profil' => 'x2PE80QA8XuDeD1M8jhhoTNCFn3FPup9MakWq3jY.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(5),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(5)
            ], [
                'username' => 'kader4',
                'password' => Hash::make('Kader456'),
                'level' => 'kader',
                'foto_profil' => 'SuUCXj7ICiNe75sHQL1uXsRBmXHRXR3o1NitYuto.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(2),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(2)
            ], [
                'username' => 'kader5',
                'password' => Hash::make('Kader567'),
                'level' => 'kader',
                'foto_profil' => 'KmhSxAL33vlWwBtzen6XQkbFISRgiSq9Pw1t2tj1.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(3),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(3)
            ], [
                'username' => 'admin2',
                'password' => Hash::make('Admin234'),
                'level' => 'admin',
                'foto_profil' => 'FpUIzk1IGp7USGeqDQUBaxic92GcEjTspQZ6xT9K.jpg',
                'created_at' => now('Asia/Jakarta')->locale('id')->subMonths(5),
                'updated_at' => now('Asia/Jakarta')->locale('id')->subMonths(5)
            ],
        ];

        DB::table('users')->insert($data);
    }
}
