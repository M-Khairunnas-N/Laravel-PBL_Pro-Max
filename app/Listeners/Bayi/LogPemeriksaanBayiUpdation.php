<?php

namespace App\Listeners\Bayi;

use App\Events\Bayi\PemeriksaanBayiUpdated;
use App\Models\AuditBulananBayi;
use App\Services\ArrayOperation;

class LogPemeriksaanBayiUpdation
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
    public function handle(PemeriksaanBayiUpdated $event): void
    {
        /**
         * if all data changes is emtpy, we not change value inside
         * audit_bulanan_bayis table
         *
         * but when one table pemeriksaans or pemeriksaan_bayis
         * updated, we just change those column inside
         * audit_bulanan_bayis
         */
        if ($event->updatedPemeriksaan === [] and $event->updatedPemeriksaanBayi === []) {
            return;
        }

        /**
         * retrieve original and updated data from when event occur
         */
        $id = $event->pemeriksaan_id;
        $originalPemeriksaan = $event->originalPemeriksaan->toArray();
        $originalPemeriksaanBayi = $event->originalPemeriksaanBayi->toArray();
        $updatedPemeriksaan = ArrayOperation::removeKeys($event->updatedPemeriksaan, ['kader_id', 'status']);
        $updatedPemeriksaanBayi = ArrayOperation::removeKeys($event->updatedPemeriksaanBayi, ['asi']);

        /**
         * merge and intersect key in all original base updated data
         * and merge that to update audit_bulanan_bayis table
         */
        $originalChanges = array_merge(
            array_intersect_key($originalPemeriksaan, $updatedPemeriksaan),
            array_intersect_key($originalPemeriksaanBayi, $updatedPemeriksaanBayi)
        );
        /**
         * merge and intersect key in all updated data and merge that
         * to do calculation with orginalChanges variable
         */
        $updatedChanges = array_merge(
            $updatedPemeriksaan,
            $updatedPemeriksaanBayi
        );

        /**
         * retrieve all keys that data are updated to update just right
         * data in audit_bulanan_bayis query below(in only() method)
         */
        $keyChanges = array_keys($updatedChanges);
        /**
         * calculate difference in subtractc between updated and
         * original data changes
         */
        $dataChanges = ArrayOperation::calculateElements($updatedChanges, $originalChanges, '-');

        /**
         * retrieve for positive changes: this mark with bulan_id,
         * because when compare or insert data in audit_bulanan_bayis,
         * we subtract bulan_id data with sub_bulan_id
         *
         * opposite with positive changes, negative changes is mark with
         * sub_bulan_id, because we flip those logic when insert
         */
        $positiveChanges = AuditBulananBayi::where('bulan_id', $id)->get();
        $negativeChanges = AuditBulananBayi::where('sub_bulan_id',  $id)->get();

        /**update postive and negative changes with specific keyChanges
         * for retrieve specific column and with dataChanges for
         * specfic value for our column
         */
        foreach ($positiveChanges as $positive) {
            $positive->update(ArrayOperation::calculateElements($positive->only($keyChanges), $dataChanges, '+'));
        }
        foreach ($negativeChanges as $negative) {
            $negative->update(ArrayOperation::calculateElements($negative->only($keyChanges), $dataChanges, '-'));
        }
    }
}
