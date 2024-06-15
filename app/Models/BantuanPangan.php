<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperBantuanPangan
 */
class BantuanPangan extends Model
{
    /**
     * The attribute that became primary key
     */
    protected $primaryKey = 'bp_id';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'bp_id'
    ];

    /**
     * Eloquent Model Relationship
     */
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id', 'penduduk_id');
    }

}
