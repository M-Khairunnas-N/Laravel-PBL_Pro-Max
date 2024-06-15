<?php

namespace App\Services;

use App\Models\AuditBulananBayi;
use App\Models\Pemeriksaan;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;

Class FilterServices
{
    public function getFilteredDataBayi(Request $request)
    {
        $query = Pemeriksaan::with('penduduk', 'pemeriksaan_bayi')->where('golongan', 'bayi')->orderBy('created_at', 'desc');

        if ($request->has('statusKes')) {
            $query->where('status', $request->input('statusKes'));
        }

        if ($request->has('golUmur')) {
            $query->whereHas('pemeriksaan_bayi', function($query) use ($request) {
                $query->where('kategori_golongan', $request->input('golUmur'));
            });
        }

        $tanggal = $request->input('tanggal');
        if (isset($tanggal) and $request->has('tanggal')) {
            list($tahun, $bulan) = explode('-', $tanggal);
            $query->whereMonth('created_at', '=', $bulan)
                  ->whereYear('created_at', '=', $tahun);
        }

        return $query;
    }

    public function getFilteredDataLansia(Request $request)
    {
        $query = Pemeriksaan::with('penduduk', 'pemeriksaan_lansia')->where('golongan', 'lansia')->orderBy('created_at', 'desc');
        $indikasi = $request->input('indikasi');
        $asam_urat = 6.5;
        $gula = 140.0;
        $kolesterol = 200.0;

        if ($request->has('statusKes')) {
            $query->where('status', $request->input('statusKes'));
        }

        if ($request->has('indikasi')) {
            $query->whereHas('pemeriksaan_lansia', function($query) use ($indikasi, $gula, $asam_urat, $kolesterol, $request) {
                if($indikasi === 'asam_urat')
                {
                    $query->where('asam_urat', '>', $asam_urat);
                }
                elseif($indikasi === 'gula')
                {
                    $query->where('gula_darah', '>', $gula);
                }
                elseif($indikasi === 'kolesterol')
                {
                    $query->where('kolesterol', '>', $kolesterol);
                }
            });
        }

        $tanggal = $request->input('tanggal');
        if (isset($tanggal) and $request->has('tanggal')) {
            list($tahun, $bulan) = explode('-', $tanggal);
            $query->whereMonth('created_at', '=', $bulan)
                  ->whereYear('created_at', '=', $tahun);
        }

        return $query;
    }

    public function getFilteredData(Request $request)
    {
        $query = Penduduk::orderBy('created_at', 'desc');

        if ($request->has('hubKeluarga')) {
            $query->where('hubungan_keluarga', $request->input('hubKeluarga'));
        }

        if ($request->has('golUmur')) {
            $query->whereHas('pemeriksaan_bayi', function($query) use ($request) {
                $query->where('kategori_golongan', $request->input('golUmur'));
            });
        }

        if ($request->has('rt')) {
            $query->where('RT', $request->input('rt'));
        }

        if ($request->has('kelamin')) {
            $query->where('jenis_kelamin', $request->input('kelamin'));
        }

        return $query;
    }
    public function getFilteredAlternatif(Request $request)
    {
        $query = AuditBulananBayi::join('pemeriksaans', 'audit_bulanan_bayis.bulan_id', '=', 'pemeriksaans.pemeriksaan_id')
        ->join('penduduks', 'audit_bulanan_bayis.penduduk_id', '=', 'penduduks.penduduk_id')
        ->select('audit_bulanan_bayis.*', 'pemeriksaans.tgl_pemeriksaan', 'pemeriksaans.golongan', 'penduduks.NKK', 'penduduks.nama', 'penduduks.tgl_lahir');

        $tanggal = $request->input('tanggal');
        if (isset($tanggal) and $request->has('tanggal')) {
            list($tahun, $bulan) = explode('-', $tanggal);
            $query->whereMonth('audit_bulanan_bayis.created_at', '=', $bulan)
                  ->whereYear('audit_bulanan_bayis.created_at', '=', $tahun);
        }

        return $query->orderBy('audit_bulanan_bayis.created_at', 'desc');
    }

    public function getFilteredUser(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        if ($request->has('level')) {
            $query->where('level', '=', $request->input('level'));
        }

        $tanggal = $request->input('tanggal');
        if (isset($tanggal) and $request->has('tanggal')) {
            list($tahun, $bulan) = explode('-', $tanggal);
            $query->whereYear('created_at', '=', $tahun)
                  ->whereMonth('created_at', '=', $bulan);
        }

        return $query;
    }
}