<?php

namespace App\Services;

use App\Models\Penduduk;
use App\Models\RentangKriteria;

class SAWServices
{
    public function createValue($alternatif, $countBayi)
    {
        $ranges = RentangKriteria::all();
        $values = [];

        foreach ($countBayi as $index => $bayiId) {
            $alt = $alternatif->firstWhere('penduduk_id', $bayiId);

            if ($alt) {
                $bayisAge = now()->diffInMonths($alt->tgl_lahir);

                $values[$index] = [
                    $this->getRangeValue($ranges, 'C1', $alt->berat_badan),
                    $this->getRangeValue($ranges, 'C2', $alt->tinggi_badan),
                    $this->getRangeValue($ranges, 'C3', $alt->lingkar_kepala),
                    $this->getRangeValue($ranges, 'C4', $alt->lingkar_lengan),
                    $this->getRangeValue($ranges, 'C5', $bayisAge),
                ];
            }
        }
        return $values;
    }
    private function getRangeValue($ranges, $code, $value)
    {
        $range = $ranges->first(function ($range) use ($code, $value) {
            return $range->kode === $code && $value >= $range->rentang_min && $value <= $range->rentang_max;
        });
        return $range ? $range->nilai : null;
    }
    public function maxMin($value, $kriteria)
    {
        $maxMin = [];
        for ($i = 0; $i < count($kriteria); $i++) {
            $arrayNilai = array_column($value, $i);
            $maxMin[$i][0] = max($arrayNilai);
            $maxMin[$i][1] = min($arrayNilai);
        }
        return $maxMin;
    }

    public function normalizedSaw($value, $maxMin, $kriteria)
    {
        $normalizedMatrix = [];
        for ($i = 0; $i < count($value); $i++) {
            for ($j = 0; $j < count($kriteria); $j++) {
                if ($kriteria[$j]['jenis'] === 'benefit') {
                    $difference = $maxMin[$j][0] - $maxMin[$j][1];
                    $normalizedMatrix[$i][$j] = ($difference === 0 )? 0 : round(($value[$i][$j] - $maxMin[$j][1]) / $difference, 3);
                }
                if ($kriteria[$j]['jenis'] === 'cost') {
                    $difference = $maxMin[$j][1] - $maxMin[$j][0];
                    $normalizedMatrix[$i][$j] = ($difference === 0 )? 0 : round(($value[$i][$j] - $maxMin[$j][0]) / $difference, 3);
                }
            }
        }
        return $normalizedMatrix;
    }
    public function optimalizedSaw($value, $normalizedMatrix, $kriteria)
    {
        $matriksR = [];
        for ($i = 0; $i < count($value); $i++) {
            for ($j = 0; $j < count($kriteria); $j++) {
                $matriksR[$i][$j] = round($normalizedMatrix[$i][$j] * $kriteria[$j]['bobot'], 3);
            }
        }
        return $matriksR;
    }
    public function rankSaw($value, $matriksR, $kriteria)
    {
        $rangking = [];
        $sum = 0;
        for ($i = 0; $i < count($value); $i++) {
            $sum = 0;
            for ($j = 0; $j < count($kriteria); $j++) {
                $sum += $matriksR[$i][$j];
            }
            $rangking[$i] = round($sum, 3);
        }

        $indices = [];
        foreach ($rangking as $key => $value) {
            foreach ($rangking as $innerKey => $innerValue) {
                if ($key != $innerKey && abs($value - $innerValue) < 0.0001) {
                    if (!isset($indices[$value])) {
                        $indices[$value] = [];
                    }
                    if (!in_array($key, $indices[$value])) {
                        $indices[$value][] = $key;
                    }
                    if (!in_array($innerKey, $indices[$value])) {
                        $indices[$value][] = $innerKey;
                    }
                }
            }
        }
        // dump($indices);
        $duplicate = array_filter($indices, function($count) {
            return count($count) > 1;
        });
        // dd($duplicate);

        return $rangking;
    }
}