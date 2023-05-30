<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $countPenduduk = Penduduk::count();
        $countLaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $countPerempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $countKK = Penduduk::where('kepala_keluarga', true)->count();

        $golDarah = DB::table('penduduk')
            ->select('golongan_darah', DB::raw('count(*) as total'))
            ->groupBy('golongan_darah')
            ->get();

        $agama = DB::table('penduduk')
            ->select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')
            ->get();

        $labelGolDarah = $golDarah->pluck('golongan_darah');
        $dataGolDarah = $golDarah->pluck('total');
        $labelAgama = $agama->pluck('agama');
        $dataAgama = $agama->pluck('total');

        return view('admin.home', compact('countPenduduk', 'countLaki', 'countPerempuan', 'countKK', 'labelGolDarah', 'dataGolDarah', 'labelAgama', 'dataAgama'));
    }
}
