<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countPenduduk = Penduduk::count();
        $countLaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $countPerempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $countKK = Penduduk::where('kepala_keluarga', true)->count();

        return view('admin.home', compact('countPenduduk', 'countLaki', 'countPerempuan', 'countKK'));
    }
}
