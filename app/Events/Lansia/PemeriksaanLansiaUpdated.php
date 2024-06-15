<?php

namespace App\Events\Lansia;

use App\Models\Pemeriksaan;
use App\Models\PemeriksaanLansia;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PemeriksaanLansiaUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $pemeriksaan_id,
        public Pemeriksaan|Collection $originalPemeriksaan,
        public PemeriksaanLansia|Collection $originalPemeriksaanLansia,
        public array $updatedPemeriksaan,
        public array $updatedPemeriksaanLansia
    )
    {

    }
}
