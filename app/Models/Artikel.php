<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperArtikel
 */
class Artikel extends Model
{
    /**
     * The attribute that became primary key
     */
    protected $primaryKey = 'artikel_id';


    protected $fillable = [
        'kader_id',
        'judul',
        'isi',
        'tag',
        'foto_artikel'
    ];

    /**
     * Define an accessor for the 'foto_artikel' attribute
     */
    public function getFotoArtikelAttribute(): string
    {
        return asset('artikel/' . $this->attributes['foto_artikel']);
    }

    /**
     * Eloquent Model Relationship
     */
    public function kader(): BelongsTo
    {
        return $this->belongsTo(Kader::class, 'kader_id', 'kader_id');
    }
}
