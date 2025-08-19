<?php

namespace App\Http\Controllers;

use App\Models\HistoriSurat;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Illuminate\Validation\Rule;
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
            'ktp' => [
                Rule::requiredIf(request('jenis_surat') !== 'sktp'),
                'file',
                'mimes:jpeg,png,jpg,pdf',
                'max:5120', // 5 MB
            ],
            'kk' => [
                Rule::requiredIf(request('jenis_surat') !== 'spkk'),
                'file',
                'mimes:jpeg,png,jpg,pdf',
                'max:5120', // 5 MB
            ],
            'attachment_file' => [
                Rule::requiredIf(request('jenis_surat') !== 'spaw'),
                'file',
                'mimes:jpeg,png,jpg,pdf',
                'max:5120', // 5 MB
            ],
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

        $pdfSuratPath = storage_path('app/temp_surat.pdf');
        $pdf = Pdf::loadView('main.layouts.pdf_template', $dataSurat)->save($pdfSuratPath);

        $fpdi = new Fpdi();

        // Tambahkan surat
        $pageCount = $fpdi->setSourceFile($pdfSuratPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $tpl = $fpdi->importPage($i);
            $fpdi->AddPage();
            $fpdi->useTemplate($tpl);
        }

        // Process KTP
        if (!empty($validatedData['ktp'])) {
            $this->KTPorKKProcessing($fpdi, $validatedData['ktp'], 'ktp');
        }

        // Process KK
        if (!empty($validatedData['kk'])) {
            $this->KTPorKKProcessing($fpdi, $validatedData['kk'], 'kk');
        }
        // Simpan pdf
        $fileName = $validatedData['jenis_surat'] . time() . '.pdf';
        $pdfFinalPath = public_path('assets/files/form_pengajuan/' . $fileName);
        $fpdi->output($pdfFinalPath, 'F');

        if (File::exists($pdfSuratPath)) {
            File::delete($pdfSuratPath);
        }

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
            'pdf_path' => 'form_pengajuan/' . $fileName,
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);

        if (!empty($validatedData['attachment_file'])) {
            $attachmentFileName = $surat->id . '_attachment_file_' . time() . '.' . $validatedData['attachment_file']->getClientOriginalExtension();
            $validatedData['attachment_file']->move(
                public_path('assets/files/attachment_files'),
                $attachmentFileName
            );

            $surat->update([
                'lampiran' => 'attachment_files/' . $attachmentFileName
            ]);
        }

        HistoriSurat::create([
            'surat_pengajuan_id' => $surat->id,
            'status' => 'diajukan',
            'keterangan' => '',
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);

        return response()->file($pdfFinalPath);
    }

    function KTPorKKProcessing($fpdi, $file, $KTPorKK)
    {

        if (str_starts_with($file->getMimeType(), 'image/')) {
            $tmpPath = storage_path('app/temp_' . $KTPorKK . '.' . $file->extension());
            copy($file->getRealPath(), $tmpPath);

            $fpdi->AddPage();
            $fpdi->Image($tmpPath, 0, 0, 210);

            if (File::exists($tmpPath)) {
                File::delete($tmpPath);
            }
        } elseif ($file->getMimeType() === 'application/pdf') {
            $pageCount = $fpdi->setSourceFile($file->getRealPath());
            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $fpdi->importPage($i);
                $fpdi->AddPage();
                $fpdi->useTemplate($tpl);
            }
        }
    }
}
