<?php

namespace App\Events\Bayi;

use App\Models\Pemeriksaan;
use App\Models\PemeriksaanBayi;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PemeriksaanBayiCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Pemeriksaan $pemeriksaan,
        public PemeriksaanBayi $pemeriksaanBayi
    )
    {

    }
}
