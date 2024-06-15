<?php

namespace App\Events\Lansia;

use App\Models\Pemeriksaan;
use App\Models\PemeriksaanLansia;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PemeriksaanLansiaCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Pemeriksaan $pemeriksaan,
        public PemeriksaanLansia $pemeriksaanLansia
    )
    {

    }
}
