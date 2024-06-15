<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
use App\Models\PemeriksaanLansia;
use App\Models\Penduduk;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SearchController extends Controller
{
    public function searchLansia(Request $request)
    {
        $search = $request->input('search', '');
        $query = Pemeriksaan::with('pemeriksaan_lansia', 'penduduk')->where('golongan', 'lansia');

        $field = preg_match('/^\d/', $search) ? 'NKK' : 'nama';
        $penduduk = $query
            ->whereHas('penduduk', function($q) use ($search, $field) {
                $q->where($field, 'like', "%{$search}%");
            })
            ->paginate(10);

        if ($penduduk->isEmpty()) {
            return response()->json(['error' => 'No results found'], 404);
        }

        return response()->json($penduduk, 200);
    }

    public function searchBayi(Request $request)
    {
        $search = $request->input('search', '');
        $query = Pemeriksaan::with('pemeriksaan_bayi','penduduk')->where('golongan', 'bayi');

        $field = preg_match('/^\d/', $search) ? 'NKK' : 'nama';
        $penduduk = $query
            ->whereHas('penduduk', function($q) use ($search, $field) {
                $q ->where($field, 'like', "%{$search}%");
            })
            ->paginate(10);

        if ($penduduk->isEmpty()) {
            return response()->json(['error' => 'No results found'], 404);
        }

        return response()->json([$penduduk], 200);
    }

    public function searchPenduduk(Request $request)
    {
        $search = $request->input('search', '');

        $field = preg_match('/^\d/', $search) ? 'NKK' : 'nama';

        $penduduk = Penduduk::where($field, 'like', "%{$search}%")
            ->paginate(10);

        if ($penduduk->isEmpty()) {
            return response()->json(['error' => 'No results found'], 404);
        }

        return response()->json([$penduduk], 200);
    }
    
    public function searchInformasi(Request $request)
    {
        $search = $request->input('search', '');

        $informasi = Kegiatan::where('nama', 'like', "%{$search}%")
        ->paginate(10);
        
        if($informasi->isEmpty()) {
            $informasi = Kegiatan::where('tempat', 'like', "%{$search}%")
            ->paginate(10);
        }


        if ($informasi->isEmpty()) {
            return response()->json(['error' => 'No results found'], 404);
        }

        return response()->json([$informasi], 200);
    }
    
    public function searchUser(Request $request)
    {
        $search = $request->input('search', '');

        $informasi = User::whereRaw('LOWER(username) LIKE ?', ['%' . strtolower($search) . '%'])
        ->paginate(10);

        if ($informasi->isEmpty()) {
            return response()->json(['error' => 'No results found'], 404);
        }

        return response()->json([$informasi], 200);
    }
}