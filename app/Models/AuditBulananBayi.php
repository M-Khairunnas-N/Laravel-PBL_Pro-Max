<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuditBulananBayi
 */
class AuditBulananBayi extends Model
{
    protected $table = 'audit_bulanan_bayis';
    protected $primaryKey = 'aby_id';
    protected $fillable = [
        'penduduk_id',
        'bulan_id',
        'sub_bulan_id',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
    ];
}
