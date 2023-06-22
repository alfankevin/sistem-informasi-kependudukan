<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Organisasi;
use App\Models\Agenda;
use App\Models\Potensi;
use App\Models\Galeri;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $countPenduduk = Penduduk::where('keterangan', 'Hidup')->count();
        $countL = Penduduk::where('jenis_kelamin', 'L')->where('keterangan', 'Hidup')->count();
        $countP = Penduduk::where('jenis_kelamin', 'P')->where('keterangan', 'Hidup')->count();
        $countKK = Penduduk::where('status_keluarga', true)->where('keterangan', 'Hidup')->count();
        $ormas = Organisasi::orderByDesc('id')->get();
        $agenda = Agenda::where('prioritas', 1)->get();
        $potensi = Potensi::orderBy('id', 'desc')->take(4)->get();
        $galeri = Galeri::orderBy('id', 'desc')->take(8)->get();
        
        return view('main.index', compact('countPenduduk', 'countL', 'countP', 'countKK', 'ormas', 'agenda', 'potensi', 'galeri'));
    }
    
    public function agenda() {
        $agenda = Agenda::orderBy('id', 'desc')->get();
        return view('main.page.agenda', compact('agenda'));
    }
    
    public function potensi() {
        $potensi = Potensi::orderBy('id', 'desc')->get();
        return view('main.page.potensi', compact('potensi'));
    }
    
    public function galeri() {
        $galeri = Galeri::orderBy('id', 'desc')->get();
        return view('main.page.galeri', compact('galeri'));
    }
}
