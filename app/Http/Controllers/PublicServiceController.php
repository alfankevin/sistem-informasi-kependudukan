<?php

namespace App\Http\Controllers;

use App\Models\HistoriSurat;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class PublicServiceController extends Controller
{
    public function index()
    {
        return view('main.page.persuratan');
    }

    public function findNik()
    {
        $findPenduduk = Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', 'kartu_keluarga.no_kk')
            ->where('nik', request()->data)
            ->select('penduduk.*', 'kartu_keluarga.*')
            ->first();
        return response()->json(['data' => $findPenduduk]);
    }

    public function generatePDF()
    {
        $validatedData = request()->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'nik' => 'required|numeric',
            'no_kk' => 'required|numeric',
            'pekerjaan' => 'required',
            'pendidikan' => 'required',
            'alamat' => 'required',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'jenis_surat' => 'required',
            'ktp' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tahun = date('Y');
        $nomorUrut = PengajuanSurat::whereYear('created_at', $tahun)->orderBy('created_at', 'desc')->count('id');

        $base64_signature = request('signature');
        $dataSurat = [
            'dataPenduduk' => request()->all(),
            'date' => Carbon::now()->timezone('Asia/Jakarta'),
            'gambar' => asset("assets/img/malang.png"),
            'signature' => $base64_signature,
            'nomor_urut' => $nomorUrut
        ];

        // Process KTP
        $ktpFile = $validatedData['ktp'];
        $ktpContents = file_get_contents($ktpFile->getRealPath());
        $ktpBase64 = 'data:' . $ktpFile->getMimeType() . ';base64,' . base64_encode($ktpContents);

        // Kirim ke view PDF, Gabungkan data
        $data = array_merge($dataSurat, [
            'ktp_base64' => $ktpBase64,
        ]);

        $pdf = Pdf::loadView('main.layouts.pdf_template', $data);

        // Simpan pdf
        $fileName = $validatedData['jenis_surat'] . time() . '.pdf';
        $pdfPath = public_path('assets/pdf/'. $fileName);
        $pdf->save($pdfPath);

        $penduduk = Penduduk::where('nik', $validatedData['nik'])->firstOrFail();
        $surat = PengajuanSurat::create([
            'id_penduduk' => $penduduk->id ?? null,
            'tracking_token' => $validatedData['jenis_surat'] . '-0' . ($nomorUrut + 1) . '/' . $tahun . Str::random(9),
            'nik_pemohon' => $validatedData['nik'],
            'nama_pemohon' => $validatedData['nama'],
            'alamat_pemohon' => $validatedData['alamat'],
            'rt' => $validatedData['rt'],
            'rw' => $validatedData['rw'],
            'keperluan' => request('keperluan') ?? '',
            'jenis_surat' => $validatedData['jenis_surat'],
            'pdf_path' => 'pdf/'. $fileName,
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);

        HistoriSurat::create([
            'surat_pengajuan_id' => $surat->id,
            'status' =>'diajukan',
            'keterangan' => '',
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);

        return $pdf->stream('laporan.pdf');
    }
}
