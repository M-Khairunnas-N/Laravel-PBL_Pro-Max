<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditBulananBayiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'bulan_id' => 2,
                'sub_bulan_id' => 1,
                'penduduk_id' => 7,
                'berat_badan' => 2.3,
                'tinggi_badan' => 1.3,
                'lingkar_kepala' => 1.0,
                'lingkar_lengan' => 1.4,
                'created_at' => '2024-05-15',
            ],
            [
                'bulan_id' => 4,
                'sub_bulan_id' => 3,
                'penduduk_id' => 8,
                'berat_badan' => 1.2,
                'tinggi_badan' => 0.5,
                'lingkar_kepala' => 1.0,
                'lingkar_lengan' => 1.0,
                'created_at' => '2024-05-15',
            ],
            [
                'bulan_id' => 6,
                'sub_bulan_id' => 5,
                'penduduk_id' => 13,
                'berat_badan' => 0.7,
                'tinggi_badan' => 0.8,
                'lingkar_kepala' => 0.6,
                'lingkar_lengan' => 1.0,
                'created_at' => '2024-05-15',
            ],
            [
                'bulan_id' => 8,
                'sub_bulan_id' => 7,
                'penduduk_id' => 15,
                'berat_badan' => 0.7,
                'tinggi_badan' => 1.5,
                'lingkar_kepala' => 0.8,
                'lingkar_lengan' => 0.3,
                'created_at' => '2024-05-15',
            ],
            [
                'bulan_id' => 10,
                'sub_bulan_id' => 9,
                'penduduk_id' => 18,
                'berat_badan' => 0.6,
                'tinggi_badan' => 0.7,
                'lingkar_kepala' => 1.4,
                'lingkar_lengan' => 0.8,
                'created_at' => '2024-05-15',
            ],
            [
                'bulan_id' => 12,
                'sub_bulan_id' => 11,
                'penduduk_id' => 19,
                'berat_badan' => 0.7,
                'tinggi_badan' => 0.7,
                'lingkar_kepala' => 0.4,
                'lingkar_lengan' => 1.0,
                'created_at' => '2024-04-15',
            ],
            [
                'bulan_id' => 13,
                'sub_bulan_id' => 12,
                'penduduk_id' => 19,
                'berat_badan' => 1.7,
                'tinggi_badan' => 1.3,
                'lingkar_kepala' => 1.0,
                'lingkar_lengan' => 0.8,
                'created_at' => '2024-05-15',
            ],
        ];

        DB::table('audit_bulanan_bayis')->insert($data);
    }
}
