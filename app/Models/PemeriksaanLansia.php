<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperPemeriksaanLansia
 */
class PemeriksaanLansia extends Model
{
    /**
     * The attribute that became primary key
     */
    protected $primaryKey = 'pemeriksaan_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pemeriksaan_id',
        'lingkar_perut',
        'gula_darah',
        'kolesterol',
        'tensi_darah',
        'asam_urat',
        'created_at',
        'updated_at',
    ];

    /**
     * Eloquent Model Relationship
     */
    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class, 'pemeriksaan_id', 'pemeriksaan_id');
    }

}
