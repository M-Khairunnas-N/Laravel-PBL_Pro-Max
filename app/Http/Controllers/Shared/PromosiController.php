<?php

namespace App\Http\Controllers\Shared;

use App\Charts\KunjunganLandingPage;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Artikel;
use App\Models\Penduduk;
use App\Models\Kader;

class PromosiController extends Controller
{
    public function jadwal()
    {
        $breadcrumb = (object) [
            'title' => 'Jadwal Kegiatan'
        ];

        $activeMenu = 'jadwal';
        $kegiatans = Kegiatan::orderBy('created_at', 'desc')->paginate(10);

        return view('promosi.jadwal', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'kegiatans' => $kegiatans]);
    }

    public function profil()
    {
        $breadcrumb = (object) [
            'title' => 'Profil Posyandu'
        ];

        $activeMenu = 'profil';

        return view('promosi.profil', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function landingpage(KunjunganLandingPage $chart)
    {
        $breadcrumb = (object) [
            'title' => 'Landing Page'
        ];

        $imageUrl = asset('img/background1.jpg');

        $activeMenu = 'berita';

        $artikels = Artikel::paginate(8);
        // $kegiatans = Artikel::where('tag', 'like', '%kegiatan%')->paginate(8);
        $kegiatans = Artikel::whereRaw('LOWER(tag) LIKE ?', ['%' . strtolower('kegiatan') . '%'])->paginate(8);
        $informasi = Artikel::whereRaw('LOWER(tag) LIKE ?', ['%' . strtolower('informasi') . '%'])->paginate(8);
        $edukasi = Artikel::whereRaw('LOWER(tag) LIKE ?', ['%' . strtolower('edukasi') . '%'])->paginate(8);
        $balita = Artikel::whereRaw('LOWER(tag) LIKE ?', ['%' . strtolower('balita') . '%'])->paginate(8);
        $ibuHamil = Artikel::whereRaw('LOWER(tag) LIKE ?', ['%' . strtolower('ibu_hamil') . '%'])->paginate(8);
        $ibuMenyusui = Artikel::whereRaw('LOWER(tag) LIKE ?', ['%' . strtolower('ibu_menyusui') . '%'])->paginate(8);

        return view('promosi.landing', ['chart' => $chart->build(), 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'imageUrl' => $imageUrl, 'artikels' => $artikels, 'kegiatans' => $kegiatans, 'informasi' => $informasi, 'edukasi' => $edukasi, 'balita' => $balita, 'ibuHamil' => $ibuHamil, 'ibuMenyusui' => $ibuMenyusui]);
    }


    public function read(string $id)
    {
        $artikels = Artikel::find($id);
        if ($artikels === null) {
            return redirect()->intended(route('artikel.index'))->with('error', 'Data artikel baru saja dihapus kader lain');
        }

        // $publisher = Artikel::with('penduduk', 'kader')->find($id);
        $recommendation = Artikel::whereNotIn('artikel_id', [$id])->get();

        $breadcrumb = (object) [
            'title' => 'Artikel'
        ];

        $activeMenu = 'berita';

        return view('promosi.artikel.read', compact('breadcrumb', 'activeMenu', 'artikels', 'recommendation'));
    }

}
