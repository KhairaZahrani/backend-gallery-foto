<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\Komentar;
use App\Models\Like;

class DashboardController extends Controller
{
    public function index(){
        $totalAlbum = Album::count();
        $totalFoto = Foto::count();
        $totalKomentar = Komentar::count();
        $totalLike = Like::count();

        return view('dashboard', compact('totalAlbum','totalFoto','totalKomentar','totalLike'));
    }
}
