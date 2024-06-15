<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuditBulananLansia
 */
class AuditBulananLansia extends Model
{
    protected $table = 'audit_bulanan_lansias';
    protected $primaryKey = 'abl_id';

    protected $fillable = [
        'bulan_id',
        'sub_bulan_id',
        'penduduk_id',
        'berat_badan',
        'tinggi_badan',
        'lingkar_perut',
        'gula_darah',
        'kolesterol',
        'tensi_darah',
        'asam_urat',
    ];
}
