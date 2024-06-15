<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kader_id'=> 2,
                'nama' => 'Posyandu Delima Merah Peduli Penduduk',
                'tgl_kegiatan' => '2024-04-15',
                'jam_mulai' => '07:30:00',
                'tempat' => 'Kediaman Bapak Sujito',
                'created_at' => '2024-04-15',
                'updated_at' => '2024-04-15',
            ], [
                'kader_id'=> 2,
                'nama' => 'Pemeriksaan Kesehatan Gratis: Layanan Utama Posyandu Delima Merah',
                'tgl_kegiatan' => '2024-04-20',
                'jam_mulai' => '08:00:00',
                'tempat' => 'Ruang Posyandu Delima Merah',
                'created_at' => '2024-04-20',
                'updated_at' => '2024-04-20',
            ], [
                'kader_id'=> 2,
                'nama' => 'Penyuluhan Ibu Hamil: Mendukung Kehamilan Sehat dan Bahagia',
                'tgl_kegiatan' => '2024-04-25',
                'jam_mulai' => '09:00:00',
                'tempat' => 'Aula Desa Manukwari',
                'created_at' => '2024-04-25',
                'updated_at' => '2024-04-25',
            ],
        ];

        DB::table('kegiatans')->insert($data);
    }
}
