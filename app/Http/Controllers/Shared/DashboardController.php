<?php

namespace App\Http\Controllers\Shared;

use App\Charts\KunjunganChart;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Pemeriksaan;
use App\Models\Penduduk;

class
DashboardController extends Controller
{
    public function indexKader(KunjunganChart $chart){
        $breadcrumb = (object) [
            'title' => 'Dashboard',
        ];

        $activeMenu = 'dashboard';

        return view('kader.index', ['chart' => $chart->build(), 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'data' => $this->indexData()]);
    }

    public function indexKetua(KunjunganChart $chart){
        $breadcrumb = (object) [
            'title' => 'Dashboard',
        ];

        $activeMenu = 'dashboard';

        return view('ketua.index', ['chart' => $chart->build(), 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'data' => $this->indexData()]);
    }

    public function indexAdmin(KunjunganChart $chart){
        $breadcrumb = (object) [
            'title' => 'Dashboard',
        ];

        $activeMenu = 'dashboard';

        return view('admin.index', ['chart' => $chart->build(), 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'data' => $this->indexDataAdmin()]);
    }

    private function indexData(): array
    {
        return $data = [
            'golongan_all' => Pemeriksaan::selectRaw('count(pemeriksaan_id) as total, golongan')
                ->groupBy('golongan')->get(),
            'golongan_subMonth' => Pemeriksaan::selectRaw('count(pemeriksaan_id) as total, golongan')
                ->whereDate('tgl_pemeriksaan', '>=', now()->subMonth())
                ->groupBy('golongan')->get(),
            'status' => Pemeriksaan::selectRaw('count(pemeriksaan_id) as total, golongan')
                ->whereDate('tgl_pemeriksaan', '>=', now()->subMonth())
                ->where('status', '=', 'sakit')
                ->groupBy('golongan')->get(),
            'kegiatan' => Kegiatan::paginate(10),
        ];
    }
    private function indexDataAdmin(): array
    {
        return $data = [
            'golongan_subMonth' => Pemeriksaan::selectRaw('count(pemeriksaan_id) as total, golongan')
                ->whereDate('tgl_pemeriksaan', '>=', now()->subMonth())
                ->groupBy('golongan')->get(),
            'golongan_all' => Pemeriksaan::selectRaw('count(pemeriksaan_id) as total, golongan')
                ->groupBy('golongan')->get(),
            'status' => Pemeriksaan::selectRaw('count(pemeriksaan_id) as total, golongan')
                ->whereDate('tgl_pemeriksaan', '>=', now()->subMonth())
                ->where('status', '=', 'sakit')
                ->groupBy('golongan')->get(),
            'kegiatan' => Kegiatan::paginate(10),
            'penduduk_all' => Penduduk::selectRaw('count(penduduk_id) as total')
                ->get(),
            'penduduk_laki' => Penduduk::selectRaw('count(penduduk_id) as total')
                ->where('jenis_kelamin', '=', 'L')
                ->get(),
            'penduduk_perempuan' => Penduduk::selectRaw('count(penduduk_id) as total')
                ->where('jenis_kelamin', '=', 'P')
                ->get(),
        ];
    }
}