<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countPenduduk = Penduduk::all();;

        return view('admin.home', compact('countPenduduk'));
    }
}
