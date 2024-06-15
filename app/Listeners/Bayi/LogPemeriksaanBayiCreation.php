<?php

namespace App\Listeners\Bayi;

use App\Events\Bayi\PemeriksaanBayiCreated;
use App\Models\AuditBulananBayi;
use App\Models\PemeriksaanBayi;
use App\Services\ArrayOperation;
use App\Services\AuditOperation;

class LogPemeriksaanBayiCreation
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
    public function handle(PemeriksaanBayiCreated $event): void
    {
        /**
         * data from event created from pemeriksaans_table that used column used in auditing process
         */
        $pemeriksaan = $event->pemeriksaan;

        /**
         * get sub_month pemeriksaan from event data
         */
        $pemeriksaanSubMonth = AuditOperation::getPemeriksaanSubMonth(
            golongan: 'bayi',
            penduduk_id: $pemeriksaan->penduduk_id,
            columns: ['pemeriksaan_id', 'berat_badan', 'tinggi_badan']);

        /**
         * if there is no available data for compare logic to make
         * auditing process, we not make audit_bulanan_bayi data
         */
        if (!$pemeriksaanSubMonth->containsOneItem()) {
            return;
        }
        $pemeriksaanSubMonth = $pemeriksaanSubMonth[0];

        /**
         * retrieve data sub_month in pemeriksaan_bayis table from our
         * sub_month data pemeriksaans table
         */
        $pemeriksaanBayiSubMonth = PemeriksaanBayi::find($pemeriksaanSubMonth->pemeriksaan_id);

        /**
         * data for compliment in audit_bulanan_bayis table that in
         * comparable logic not used, just hold data for other purpose than
         * auditing
         */
        $penduduk_id['penduduk_id'] = $pemeriksaan->penduduk_id;
        $bulan_id['bulan_id'] = $pemeriksaan->pemeriksaan_id;
        $sub_bulan_id['sub_bulan_id'] = $pemeriksaanSubMonth->pemeriksaan_id;

        /**
         * cutting data that from query that we want to use in audit_bulanan_bayis table
         */
        $pemeriksaan = $pemeriksaan->only('berat_badan', 'tinggi_badan');
        $pemeriksaanSubMonth = $pemeriksaanSubMonth->only( 'berat_badan', 'tinggi_badan');
        $pemeriksaanBayi = $event->pemeriksaanBayi->only('lingkar_kepala', 'lingkar_lengan');
        $pemeriksaanBayiSubMonth = $pemeriksaanBayiSubMonth->only('lingkar_kepala', 'lingkar_lengan');

        /**
         * subtract different in new and old data from  pemeriksaans
         * table and pemeriksaan_bayis table that use for value in
         * audit_bulanan_bayis
         *
         * And merge those key with value from subtract, because in
         * audit_bulanan_bayis has same key column with our all
         * subtracted data
         */
        $logMontlyData = array_merge(
            ArrayOperation::calculateElements($pemeriksaan, $pemeriksaanSubMonth, '-'),
            ArrayOperation::calculateElements($pemeriksaanBayi, $pemeriksaanBayiSubMonth, '-'),
            $penduduk_id,
            $bulan_id,
            $sub_bulan_id
        );

        /**
         * create new record data in database
         */
        AuditBulananBayi::create($logMontlyData);
    }
}
