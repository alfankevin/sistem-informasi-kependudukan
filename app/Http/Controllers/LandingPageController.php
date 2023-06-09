<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $agenda = Agenda::select('gambar_agenda')->where('prioritas', 1)->get();
        $countPenduduk = Penduduk::count();
        $countL = Penduduk::where('jenis_kelamin', 'L')->count();
        $countP = Penduduk::where('jenis_kelamin', 'P')->count();
        $countKK = Penduduk::where('status_keluarga', true)->count();

        return view('main.index', compact('agenda', 'countPenduduk', 'countL', 'countP', 'countKK'));
    }
}
