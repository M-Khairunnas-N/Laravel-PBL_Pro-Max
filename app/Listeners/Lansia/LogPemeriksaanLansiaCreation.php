<?php

namespace App\Listeners\Lansia;

use App\Events\Lansia\PemeriksaanLansiaCreated;
use App\Models\AuditBulananLansia;
use App\Models\PemeriksaanLansia;
use App\Services\ArrayOperation;
use App\Services\AuditOperation;

class LogPemeriksaanLansiaCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PemeriksaanLansiaCreated $event): void
    {
        /**
         * data from event created from pemeriksaans_table that used column used in auditing process
         */
        $pemeriksaan = $event->pemeriksaan;

        /**
         * get sub_month pemeriksaan from event data
         */
        $pemeriksaanSubMonth = AuditOperation::getPemeriksaanSubMonth(
            golongan: 'lansia',
            penduduk_id: $pemeriksaan->penduduk_id,
            columns: ['pemeriksaan_id', 'berat_badan', 'tinggi_badan']
        );

        /**
         * if there is no available data for compare logic to make
         * auditing process, we not make audit_bulanan_lansias data
         */
        if (!$pemeriksaanSubMonth->containsOneItem()) {
            return;
        }
        $pemeriksaanSubMonth = $pemeriksaanSubMonth[0];

        /**
         * retrieve data sub_month in pemeriksaan_lansias table from our
         * sub_month data pemeriksaans table
         */
        $pemeriksaanLansiaSubMonth = PemeriksaanLansia::find($pemeriksaanSubMonth->pemeriksaan_id);

        /**
         * data for compliment in audit_bulanan_lansias table that in
         * comparable logic not used, just hold data for other purpose than
         * auditing
         */
        $penduduk_id['penduduk_id'] = $pemeriksaan->penduduk_id;
        $bulan_id['bulan_id'] = $pemeriksaan->pemeriksaan_id;
        $sub_bulan_id['sub_bulan_id'] = $pemeriksaanSubMonth->pemeriksaan_id;

        /**
         * cutting data that from query that we want to use in audit_bulanan_lansias table
         */
        $pemeriksaan = $pemeriksaan->only(['berat_badan', 'tinggi_badan']);
        $pemeriksaanSubMonth = $pemeriksaanSubMonth->only( ['berat_badan', 'tinggi_badan']);
        $pemeriksaanLansia = $event->pemeriksaanLansia->only(['lingkar_perut', 'gula_darah', 'kolesterol', 'tensi_darah', 'asam_urat']);
        $pemeriksaanLansiaSubMonth = $pemeriksaanLansiaSubMonth->only(['lingkar_perut', 'gula_darah', 'kolesterol', 'tensi_darah', 'asam_urat']);

        /**
         * subtract different in new and old data from  pemeriksaans
         * table and pemeriksaan_lansias table that use for value in
         * audit_bulanan_lansias
         *
         * And merge those key with value from subtract, because in
         * audit_bulanan_bayis has same key column with our all
         * subtracted data
         */
        $logMontlyData = array_merge(
            ArrayOperation::calculateElements($pemeriksaan, $pemeriksaanSubMonth, '-'),
            ArrayOperation::calculateElements($pemeriksaanLansia, $pemeriksaanLansiaSubMonth, '-'),
            $penduduk_id,
            $bulan_id,
            $sub_bulan_id
        );

        /**
         * create new record data in database
         */
        AuditBulananLansia::create($logMontlyData);
    }
}
