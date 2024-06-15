<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PendudukSeeder::class,
            KaderSeeder::class,
            AdminSeeder::class,
            KegiatanSeeder::class,
            ArtikelSeeder::class,
            PemeriksaanSeeder::class,
            PemeriksaanBayiSeeder::class,
            PemeriksaanLansiaSeeder::class,
            BantuanPanganSeeder::class,
            AuditBulananBayiSeeder::class,
            AuditBulananLansiaSeeder::class,
            KriteriaSeeder::class,
            RentangKriteriaSeeder::class,
        ]);
    }
}
