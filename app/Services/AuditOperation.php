<?php

namespace App\Services;

use App\Models\Pemeriksaan;
use Illuminate\Database\Eloquent\Collection;

class AuditOperation
{

    /**
     * get one data from pemeriksaans table sub month (maximal 30 day difference)
     *
     * with 5 day margin error (25 day minimal difference)
     * @param string $golongan
     * @param int $penduduk_id
     * @param array $columns
     * @return Collection
     */
    public static function getPemeriksaanSubMonth(string $golongan, int $penduduk_id, array $columns): Collection
    {
        return Pemeriksaan::where('golongan', '=', $golongan)
            ->where('penduduk_id', '=', $penduduk_id)
            ->whereBetween('tgl_pemeriksaan', [now()->subMonth()
            ->format('Y-m-d'), now()->subDays(25)->format('Y-m-d')])
            ->orderBy('tgl_pemeriksaan')->limit(1)->get($columns);
    }
}
