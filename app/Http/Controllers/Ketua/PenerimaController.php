<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;

class PenerimaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Penerima Bantuan'
        ];

        $activeMenu = 'bantuan';

        return view('ketua.bantuan.penerima', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
