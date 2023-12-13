<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Organisasi;
use App\Models\Agenda;
use App\Models\Potensi;
use App\Models\Galeri;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    public function index()
    {
        $cacheKey = 'count_penduduk';
        // $durationInMinutes = 1440;

        $data = Cache::remember($cacheKey, 86400, function () {
            $countPenduduk = Penduduk::where('keterangan', 'Hidup')->count();
            $countL = Penduduk::where('jenis_kelamin', 'L')->where('keterangan', 'Hidup')->count();
            $countP = Penduduk::where('jenis_kelamin', 'P')->where('keterangan', 'Hidup')->count();
            $countKK = Penduduk::where('status_keluarga', true)->where('keterangan', 'Hidup')->count();

            return [
                'countPenduduk' => $countPenduduk,
                'countL' => $countL,
                'countP' => $countP,
                'countKK' => $countKK,
            ];
        });

        $countPenduduk = $data['countPenduduk'];
        $countL = $data['countL'];
        $countP = $data['countP'];
        $countKK = $data['countKK'];

        $ormas = Organisasi::orderByDesc('id')->get();
        $agenda = Agenda::where('prioritas', 1)->get();
        $potensi = Potensi::orderBy('id', 'desc')->get();
        $galeri = Galeri::orderBy('id', 'desc')->take(8)->get();

        foreach ($potensi as $item) {
            $hargaFormat = number_format($item->harga_umkm, 0, ',', '.');
            $item->harga_umkm = $hargaFormat;
        }

        return view('main.index', compact('countPenduduk', 'countL', 'countP', 'countKK', 'ormas', 'agenda', 'potensi', 'galeri'));
    }

    public function agenda()
    {
        $agenda = Agenda::orderBy('id', 'desc')->get();
        return view('main.page.agenda', compact('agenda'));
    }

    public function potensi()
    {
        $potensi = Potensi::orderBy('id', 'desc')->get();
        foreach ($potensi as $item) {
            $hargaFormat = number_format($item->harga_umkm, 0, ',', '.');
            $item->harga_umkm = $hargaFormat;
        }
        return view('main.page.potensi', compact('potensi'));
    }

    public function galeri()
    {
        $galeri = Galeri::orderBy('id', 'desc')->get();
        return view('main.page.galeri', compact('galeri'));
    }
}
