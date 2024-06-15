<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperPemeriksaan
 */
class Pemeriksaan extends Model
{
    /**
     * The attribute that became primary key
     */
    protected $primaryKey = 'pemeriksaan_id';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'pemeriksaan_id'
    ];

    /**
     * Eloquent Model Relationships
     */
    public function kader(): BelongsTo
    {
        return $this->belongsTo(Kader::class, 'kader_id', 'kader_id');
    }
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }
    public function pemeriksaan_bayi(): HasOne
    {
        return $this->hasOne(PemeriksaanBayi::class, 'pemeriksaan_id', 'pemeriksaan_id');
    }
    public function pemeriksaan_lansia(): HasOne
    {
        return $this->hasOne(PemeriksaanLansia::class, 'pemeriksaan_id', 'pemeriksaan_id');
    }
}
