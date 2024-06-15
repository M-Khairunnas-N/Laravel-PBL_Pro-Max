<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditBulananLansiaSeeder extends Seeder
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
                'penduduk_id' => 9,
                'berat_badan' => 2.7,
                'tinggi_badan' => 0.3,
                'lingkar_perut' => 0.3,
                'gula_darah' => 5,
                'kolesterol' => -20,
                'tensi_darah' => 3,
                'asam_urat' => 1.0,
            ],
            [
                'bulan_id' => 4,
                'sub_bulan_id' => 3,
                'penduduk_id' => 10,
                'berat_badan' => 0.6,
                'tinggi_badan' => 0.5,
                'lingkar_perut' => -0.2,
                'gula_darah' => 0,
                'kolesterol' => 17,
                'tensi_darah' => -6,
                'asam_urat' => -0.5,
            ],
            [
                'bulan_id' => 6,
                'sub_bulan_id' => 5,
                'penduduk_id' => 20,
                'berat_badan' => 1.3,
                'tinggi_badan' => 0.6,
                'lingkar_perut' => 2.2,
                'gula_darah' => 5,
                'kolesterol' => 3,
                'tensi_darah' => 3,
                'asam_urat' => 1.5,
            ],
            [
                'bulan_id' => 8,
                'sub_bulan_id' => 7,
                'penduduk_id' => 21,
                'berat_badan' => 1.3,
                'tinggi_badan' => 0.3,
                'lingkar_perut' => -1.5,
                'gula_darah' => 5,
                'kolesterol' => -20,
                'tensi_darah' => 1,
                'asam_urat' => -1.2,
            ],
            [
                'bulan_id' => 10,
                'sub_bulan_id' => 9,
                'penduduk_id' => 22,
                'berat_badan' => 0.7,
                'tinggi_badan' => 0.4,
                'lingkar_perut' => -0.2,
                'gula_darah' => 5,
                'kolesterol' => -3,
                'tensi_darah' => -3,
                'asam_urat' => -1.5,
            ],
            [
                'bulan_id' => 11,
                'sub_bulan_id' => 10,
                'penduduk_id' => 22,
                'berat_badan' => 0.2,
                'tinggi_badan' => 0.3,
                'lingkar_perut' => 1.2,
                'gula_darah' => -1,
                'kolesterol' => -1,
                'tensi_darah' => 8,
                'asam_urat' => 1.5,
            ],
        ];

        DB::table('audit_bulanan_lansias')->insert($data);
    }
}
