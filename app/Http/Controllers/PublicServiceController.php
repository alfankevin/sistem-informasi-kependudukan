<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    public function index ()  {
        return view('main.page.persuratan');
    }

    public function findNik () {
        $findPenduduk = Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', 'kartu_keluarga.no_kk')
            ->where('nik', request()->data)
            ->select('penduduk.*', 'kartu_keluarga.alamat')
            ->first();
        return response()->json(['data' => $findPenduduk]);
    }

    public function generatePDF () {
        $data['data'] = request()->all();
        $data['date'] = Carbon::now()->timezone('Asia/Jakarta');
        $data['gambar'] = asset("assets/img/malang.png");

        $pdf = Pdf::loadView('main.layouts.pdf_template', $data);
        return $pdf->stream('laporan.pdf');
    }
}
