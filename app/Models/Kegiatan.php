<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperKegiatan
 */
class Kegiatan extends Model
{
    /**
     * The attribute that became primary key
     */
    protected $primaryKey = 'kegiatan_id';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'kegiatan_id'
    ];

    /**
     * Eloquent Model Relationships
     */
    public function kader(): BelongsTo
    {
        return $this->belongsTo(Kader::class, 'kader_id', 'kader_id');
    }
}
