<?php

namespace App\Events\Bayi;

use App\Models\Pemeriksaan;
use App\Models\PemeriksaanBayi;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PemeriksaanBayiUpdated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $pemeriksaan_id,
        public Pemeriksaan|Collection $originalPemeriksaan,
        public PemeriksaanBayi|Collection $originalPemeriksaanBayi,
        public array $updatedPemeriksaan,
        public array $updatedPemeriksaanBayi
    )
    {

    }
}
