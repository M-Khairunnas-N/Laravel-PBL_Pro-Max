<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditBulananBayi;
use App\Models\Kriteria;
use App\Models\Pemeriksaan;
use App\Services\MabacServices;
use App\Services\SAWServices;
use App\Services\FilterServices;
use Illuminate\Http\Request;

class BantuanController extends Controller
{
    private FilterServices $filter;
    private MabacServices $mabac;
    private SAWServices $saw;
    public function __construct(MabacServices $mabac, SAWServices $saw, FilterServices $filter) {
        $this->mabac = $mabac;
        $this->saw = $saw;
        $this->filter = $filter;
    }
    public function alternatif(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Sistem Pengambilan Keputusan'
        ];

        $activeMenu = 'bantuan';

        $alternatifs = $this->filter->getFilteredAlternatif($request)->paginate(10);
        $alternatifs->appends(request()->all());

        $bayisData = Pemeriksaan::with('penduduk', 'pemeriksaan_bayi')->where('golongan', 'bayi')->where('tgl_pemeriksaan', '2024-05-15')->paginate(10);

        return view('admin.bantuan.alternatif', compact('breadcrumb', 'activeMenu', 'alternatifs', 'bayisData'));
    }
    public function saw(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Sistem Pengambilan Keputusan'
        ];

        $activeMenu = 'bantuan';

        $bayis = AuditBulananBayi::join('pemeriksaans', 'audit_bulanan_bayis.bulan_id', '=', 'pemeriksaans.pemeriksaan_id')
            ->join('penduduks', 'audit_bulanan_bayis.penduduk_id', '=', 'penduduks.penduduk_id')
            ->select('audit_bulanan_bayis.*', 'pemeriksaans.tgl_pemeriksaan', 'pemeriksaans.golongan', 'penduduks.NKK', 'penduduks.nama', 'penduduks.tgl_lahir')
            ->get();

        if ($request->penduduk_id === null) {
            return redirect()->intended('admin/bantuan/alternatif')
            ->with('error', 'Pilih setidaknya satu alternatif');
        }

        $kriteria = Kriteria::all();
        $countBayi = $request->penduduk_id;
        $values = $this->saw->createValue($bayis, $countBayi);
        $maxMin = $this->saw->maxMin($values, $kriteria);
        $normalize = $this->saw->normalizedSaw($values, $maxMin, $kriteria);
        $optimalize = $this->saw->optimalizedSaw($values, $normalize, $kriteria);
        $rank = $this->saw->rankSaw($values, $optimalize, $kriteria);
        arsort($rank);
        return view('admin.bantuan.saw', compact('breadcrumb', 'activeMenu', 'bayis', 'kriteria', 'countBayi', 'values', 'maxMin', 'normalize', 'optimalize', 'rank'));
    }
    public function mabac(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Sistem Pengambilan Keputusan'
        ];

        $activeMenu = 'bantuan';

        $bayis = AuditBulananBayi::join('pemeriksaans', 'audit_bulanan_bayis.bulan_id', '=', 'pemeriksaans.pemeriksaan_id')
            ->join('penduduks', 'audit_bulanan_bayis.penduduk_id', '=', 'penduduks.penduduk_id')
            ->select('audit_bulanan_bayis.*', 'pemeriksaans.tgl_pemeriksaan', 'pemeriksaans.golongan', 'penduduks.NKK', 'penduduks.nama', 'penduduks.tgl_lahir')
            ->get();

        if ($request->penduduk_id === null) {
            return redirect()->intended('admin/bantuan/alternatif')
            ->with('error', 'Pilih setidaknya satu alternatif');
        }

        $kriteria = Kriteria::all();
        $countBayi = $request->penduduk_id;
        $values = $this->mabac->createValue($bayis, $countBayi);
        $maxMin = $this->mabac->maxMin($values, $kriteria);
        $normalize = $this->mabac->normalizedMabac($values, $maxMin, $kriteria);
        $weighted = $this->mabac->weighMabac($values, $normalize, $kriteria);
        $areas = $this->mabac->areaMabac($values, $weighted, $kriteria);
        $distance = $this->mabac->distanceMabac($values, $weighted, $areas, $kriteria);
        $rank = $this->mabac->rankMabac($values, $distance, $kriteria);
        arsort($rank);
        return view('admin.bantuan.mabac', compact('breadcrumb', 'activeMenu', 'bayis', 'kriteria', 'countBayi', 'values', 'maxMin', 'normalize', 'weighted', 'areas', 'distance', 'rank'));
    }
}
