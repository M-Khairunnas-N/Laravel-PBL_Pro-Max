<?php

namespace App\Charts;

use App\Models\Penduduk;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class KunjunganLandingPage
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): BarChart
    {
        /** This function in laravel is same below query in mysql
         *
         * select count(pm.penduduk_id), RT from penduduks p join pemeriksaans pm on p.penduduk_id = pm.penduduk_id GROUP BY p.RT ORDER BY p.RT;
         */
        $dataRt = Penduduk::selectRaw(('count(pemeriksaans.penduduk_id) as pemeriksaans_count'))
            ->join('pemeriksaans', 'penduduks.penduduk_id',
                '=', 'pemeriksaans.penduduk_id')
            ->groupBy('RT')
            ->orderBy('RT', 'ASC')
            ->get();

        /**
         * retrieve data per RT, if null make those value 0
         */
        $data = $dataRt->pluck('pemeriksaans_count')->toArray();;
        for ($i = 0; $i <= 5; $i++) {
            $rt[$i + 1] = $data[$i] ?? 0;
        }

        return $this->chart->barChart()
            ->addData('Pengunjung', [$rt[1], $rt[2], $rt[3], $rt[4], $rt[5], $rt[6]])
            ->setXAxis(['RT 01', 'RT 02', 'RT 03', 'RT 04', 'RT 05', 'RT 06', 'RT 07', 'RT 08'])
            ->setFontFamily('Plus Jakarta Sans')
            ->setHeight(341)
            ->setMarkers(['#F87171', '#3498DB'], 1, 2)
        ;
    }
}
