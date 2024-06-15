<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\AuditBulananBayi;
use App\Models\Kriteria;
use App\Models\Pemeriksaan;
use App\Models\Penduduk;
use App\Services\MabacServices;
use App\Services\SAWServices;
use Illuminate\Http\Request;
use App\Charts\SelisihChart;
use App\Services\FilterServices;
use Illuminate\Support\Facades\Validator;

class BantuanController extends Controller
{
    private MabacServices $mabac;
    private SAWServices $saw;
    private FilterServices $filter;
    public function __construct(MabacServices $mabac, SAWServices $saw,FilterServices $filter) {
        $this->mabac = $mabac;
        $this->saw = $saw;
        $this->filter = $filter;
    }
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Bantuan Rujukan'
        ];

        $activeMenu = 'bantuan';

        $bayisData = AuditBulananBayi::join('pemeriksaans', 'audit_bulanan_bayis.bulan_id', '=', 'pemeriksaans.pemeriksaan_id')
        ->join('penduduks', 'audit_bulanan_bayis.penduduk_id', '=', 'penduduks.penduduk_id')
        ->select('audit_bulanan_bayis.*', 'pemeriksaans.tgl_pemeriksaan', 'pemeriksaans.golongan', 'penduduks.NKK', 'penduduks.nama', 'penduduks.tgl_lahir')
        ->paginate(10);

        $parentsData = Penduduk::where('hubungan_keluarga', '!=', 'Anak')->get();

        return view('ketua.bantuan.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'bayis' => $bayisData, 'parents' => $parentsData]);

    }


    public function tambah(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Bantuan Rujukan'
        ];

        $activeMenu = 'bantuan';

        $alternatifs = $this->filter->getFilteredAlternatif($request)->paginate(10);
        $alternatifs->appends(request()->all());

        $bayisData = Pemeriksaan::with('penduduk', 'pemeriksaan_bayi')->where('golongan', 'bayi')->where('tgl_pemeriksaan', '2024-05-15')->paginate(10);

        return view('ketua.bantuan.penerima', compact('breadcrumb', 'activeMenu', 'alternatifs', 'bayisData'));
    }
    public function detail(SelisihChart $chart ,string $id)
    {

        $breadcrumb = (object) [
            'title' => 'Bantuan Rujukan'
        ];

        $activeMenu = 'detail';

        return view('ketua.bantuan.detail', ['chart' => $chart->build($id),'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu,'data' => $this->indexbantuan()]);
    }


    public function konfirmasi(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Bantuan Rujukan'
        ];

        $activeMenu = 'bantuan';

        $bayis = AuditBulananBayi::join('pemeriksaans', 'audit_bulanan_bayis.bulan_id', '=', 'pemeriksaans.pemeriksaan_id')
            ->join('penduduks', 'audit_bulanan_bayis.penduduk_id', '=', 'penduduks.penduduk_id')
            ->select('audit_bulanan_bayis.*', 'pemeriksaans.tgl_pemeriksaan', 'pemeriksaans.golongan', 'penduduks.NKK', 'penduduks.nama', 'penduduks.tgl_lahir')
            ->get();

            $validator = Validator::make($request->all(), [
                'nama' => 'equired|unique:penduduks,nama',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

        $kriteria = Kriteria::all();
        $countBayi = $request->penduduk_id;

        if ($countBayi === null) {
            return redirect()->intended('ketua/bantuan/penerima')
            ->with('error', 'Pilih setidaknya satu alternatif');
        }

        $count = array_count_values($countBayi);
        foreach ($count as $key) {
            if ($key > 1) {
                return redirect()->intended('ketua/bantuan/penerima')
                ->with('error', 'Terjadi duplikasi data, lakukan filter terlebih dahulu');
            }
        }

        // SAW
        $values = $this->saw->createValue($bayis, $countBayi);
        $maxMin = $this->saw->maxMin($values, $kriteria);
        $normalize = $this->saw->normalizedSaw($values, $maxMin, $kriteria);
        $optimalize = $this->saw->optimalizedSaw($values, $normalize, $kriteria);
        $bayiSAW = $this->saw->rankSaw($values, $optimalize, $kriteria);

        // Mabac
        $values = $this->mabac->createValue($bayis, $countBayi);
        $maxMin = $this->mabac->maxMin($values, $kriteria);
        $normalize = $this->mabac->normalizedMabac($values, $maxMin, $kriteria);
        $weighted = $this->mabac->weighMabac($values, $normalize, $kriteria);
        $areas = $this->mabac->areaMabac($values, $weighted, $kriteria);
        $distance = $this->mabac->distanceMabac($values, $weighted, $areas, $kriteria);
        $bayiMabac = $this->mabac->rankMabac($values, $distance, $kriteria);
        arsort($bayiSAW);
        arsort($bayiMabac);

        return view('ketua.bantuan.konfirmasi', compact('breadcrumb', 'activeMenu', 'bayis', 'values', 'bayiSAW', 'bayiMabac', 'countBayi'));
    }
    private function indexbantuan(): array
    {
        return $data = [
            'bb_all' => AuditBulananBayi::selectRaw('(berat_badan) as bb_avg')
                ->get(),
            'bb_subMonth' => AuditBulananBayi::selectRaw('(berat_badan) as bb_avg')
                ->whereDate('created_at', '>=', now()->subMonth())
                ->get(),
            'tb_subMonth' => AuditBulananBayi::selectRaw('(tinggi_badan) as tb_avg')
                ->whereDate('created_at', '>=', now()->subMonth())
                ->get(),
            'll_subMonth' => AuditBulananBayi::selectRaw('(lingkar_lengan) as ll_avg')
                ->whereDate('created_at', '>=', now()->subMonth())
                ->get(),
            'lk_subMonth' => AuditBulananBayi::selectRaw('(lingkar_kepala) as lk_avg')
                ->whereDate('created_at', '>=', now()->subMonth())
                ->get(),
        ];
    }
}
