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
        $countKK = Penduduk::where('status_keluarga', true)->count();

        $golDarah = DB::table('penduduk')
            ->select('golongan_darah', DB::raw('count(*) as total'))
            ->where('golongan_darah','<>','-')
            ->groupBy('golongan_darah')
            ->get();

        $agama = DB::table('penduduk')
            ->select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')
            ->get();

        $labelGolDarah = $golDarah->where('golongan_darah','<>','-')->pluck('golongan_darah');
        $dataGolDarah = $golDarah->pluck('total');
        $labelAgama = $agama->pluck('agama');
        $dataAgama = $agama->pluck('total');

        $umurL = Penduduk::select(DB::raw('CASE
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 0 AND 5 THEN "0-5"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 6 AND 10 THEN "06-10"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 11 AND 15 THEN "11-15"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 16 AND 20 THEN "16-20"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 21 AND 25 THEN "21-25"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 26 AND 30 THEN "26-30"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 31 AND 35 THEN "31-35"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 36 AND 40 THEN "36-40"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 41 AND 45 THEN "41-45"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 46 AND 50 THEN "46-50"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 51 AND 55 THEN "51-55"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 56 AND 60 THEN "56-60"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 61 AND 65 THEN "61-65"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 66 AND 70 THEN "66-70"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 71 AND 75 THEN "71-75"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 76 AND 80 THEN "76-80"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 81 AND 85 THEN "81-85"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 86 AND 90 THEN "86-90"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 91 AND 95 THEN "91-95"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 96 AND 100 THEN "96-100"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) >100 THEN "100+"
                END AS age_group, COUNT(*) as total'))
            ->groupBy('age_group')
            ->where('jenis_kelamin', 'L')
            ->get();

        $umurP = Penduduk::select(DB::raw('CASE
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 0 AND 5 THEN "0-5"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 6 AND 10 THEN "06-10"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 11 AND 15 THEN "11-15"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 16 AND 20 THEN "16-20"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 21 AND 25 THEN "21-25"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 26 AND 30 THEN "26-30"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 31 AND 35 THEN "31-35"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 36 AND 40 THEN "36-40"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 41 AND 45 THEN "41-45"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 46 AND 50 THEN "46-50"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 51 AND 55 THEN "51-55"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 56 AND 60 THEN "56-60"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 61 AND 65 THEN "61-65"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 66 AND 70 THEN "66-70"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 71 AND 75 THEN "71-75"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 76 AND 80 THEN "76-80"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 81 AND 85 THEN "81-85"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 86 AND 90 THEN "86-90"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 91 AND 95 THEN "91-95"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 96 AND 100 THEN "96-100"
            WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) >100 THEN "100+"
                END AS age_group, COUNT(*) as total'))
            ->groupBy('age_group')
            ->where('jenis_kelamin', 'P')
            ->get();

        $labelUmurL = $umurL->pluck('age_group');
        $dataUmurL = $umurL->pluck('total');
        $labelUmurP = $umurP->pluck('age_group');
        $dataUmurP = $umurP->pluck('total');

        return view('admin.home', compact('countPenduduk', 'countLaki', 'countPerempuan', 'countKK', 'labelGolDarah', 'dataGolDarah', 'labelAgama', 'dataAgama', 'labelUmurL', 'dataUmurL', 'labelUmurP', 'dataUmurP'));
    }
}
