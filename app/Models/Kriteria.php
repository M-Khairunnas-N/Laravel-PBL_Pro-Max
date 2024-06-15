<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperKriteria
 */
class Kriteria extends Model
{
    /**
     * The attribute that became primary key
     */
    protected $primaryKey = 'kode';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama',
        'bobot',
        'jenis',
    ];
    protected $casts = [
        'kode' => 'string',
    ];
}
