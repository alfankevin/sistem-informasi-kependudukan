<?php

namespace App\Http\Controllers\Publik;
use App\Http\Controllers\Controller;
use App\Mail\SendPengajuanSuratMail;
use App\Models\HistoriSurat;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\PengurusWilayah;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Str;

class PengajuanSuratController extends Controller
{
    public function create()
    {
        return view('main.page.pengajuan_surat.create');
    }

    public function findNik(Request $request)
    {
        $findPenduduk = Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', 'kartu_keluarga.no_kk')
            ->where('nik', $request->data)
            ->select('penduduk.*', 'kartu_keluarga.*')
            ->first();
        return response()->json(['data' => $findPenduduk]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
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
            'rt' => 'required|string|digits:3',
            'rw' => 'required|string|digits:3',
            'jenis_surat' => 'required',
            'ktp' => [
                Rule::requiredIf($request->jenis_surat !== 'sktp'),
                'file',
                'mimes:jpeg,png,jpg,pdf',
                'max:5120', // 5 MB
            ],
            'kk' => [
                Rule::requiredIf($request->jenis_surat !== 'spkk'),
                'file',
                'mimes:jpeg,png,jpg,pdf',
                'max:5120', // 5 MB
            ],
            'attachment_file' => [
                Rule::requiredIf($request->jenis_surat === 'spaw'),
                'file',
                'mimes:jpeg,png,jpg,pdf',
                'max:5120', // 5 MB
            ],
        ]);

        DB::beginTransaction();


        try {
            $tahun = date('Y');
            $nomorUrut = PengajuanSurat::whereYear('created_at', $tahun)->orderBy('created_at', 'desc')->count('id');

            $ketuaRW = PengurusWilayah::with('penduduk')
                ->where('wilayah_rw', $request->rw)
                ->where('jabatan', 'ketua-rw')
                ->first();

            $ketuaRT = PengurusWilayah::with('penduduk')
                ->where('wilayah_rw', $request->rw)
                ->where('wilayah_rt', $request->rt)
                ->where('jabatan', 'ketua-rt')
                ->first();
            $base64_signature = request('signature');
            $dataSurat = [
                'dataPenduduk' => $request->all(),
                'date' => Carbon::now()->timezone('Asia/Jakarta'),
                'gambar' => asset("assets/img/malang.png"),
                'signature' => $base64_signature,
                'nomor_urut' => $nomorUrut,
                'ketua_rw' => $ketuaRW,
                'ketua_rt' => $ketuaRT,
            ];

            $pdfSuratPath = storage_path('app/temp_surat.pdf');
            $pdf = Pdf::loadView('main.page.pengajuan_surat.pdf_template', $dataSurat)->save($pdfSuratPath);

            $fpdi = new Fpdi();

            // Tambahkan surat
            $pageCount = $fpdi->setSourceFile($pdfSuratPath);
            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $fpdi->importPage($i);
                $fpdi->AddPage();
                $fpdi->useTemplate($tpl);
            }

            // Process KTP
            if (!empty($request->ktp)) {
                $this->KTPorKKProcessing($fpdi, $request->ktp, 'ktp');
            }

            // Process KK
            if (!empty($request->kk)) {
                $this->KTPorKKProcessing($fpdi, $request->kk, 'kk');
            }
            // Simpan pdf
            $fileName = $request->jenis_surat . time() . '.pdf';
            $pdfFinalPath = public_path('assets/files/form_pengajuan/' . $fileName);
            $fpdi->output($pdfFinalPath, 'F');

            if (File::exists($pdfSuratPath)) {
                File::delete($pdfSuratPath);
            }

            $penduduk = Penduduk::where('nik', $request->nik)->firstOrFail();
            $surat = PengajuanSurat::create([
                'id_penduduk' => $penduduk->id ?? null,
                'tracking_token' => $request->jenis_surat . '-0' . ($nomorUrut + 1) . '/' . $tahun . Str::random(9),
                'nik_pemohon' => $request->nik,
                'nama_pemohon' => $request->nama,
                'alamat_pemohon' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'keperluan' => request('keperluan') ?? '',
                'jenis_surat' => $request->jenis_surat,
                'pdf_path' => $fileName,
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]);

            if (!empty($request->attachment_file)) {
                $attachmentFileName = $surat->id . '_attachment_file_' . time() . '.' . $request->attachment_file->getClientOriginalExtension();
                $request->attachment_file->move(
                    public_path('assets/files/attachment_files'),
                    $attachmentFileName
                );

                $surat->update([
                    'lampiran' => $attachmentFileName
                ]);
            }

            HistoriSurat::create([
                'surat_pengajuan_id' => $surat->id,
                'status' => 'diajukan',
                'keterangan' => '',
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);

            Mail::to(users: $request->email)->send(new SendPengajuanSuratMail($surat));

            DB::commit();

            return redirect()->back()
                ->with('success', true)
                ->with('trackingToken', $surat->tracking_token)
                ->with('pdfPath', $surat->pdf_path);
        } catch (Exception $e) {
            DB::rollBack();

            // Catat error biar gampang debug
            Log::error('Generate PDF Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses surat. Silakan coba lagi.');
        }
    }

    public function track(Request $request)
    {
        $pengajuan = null;

        $historiPengajuan = collect(); // default kosong biar aman

        if (!empty($request->token)) {
            $pengajuan = PengajuanSurat::where('tracking_token', $request->token)->first();

            if ($pengajuan) {
                $historiPengajuan = HistoriSurat::where('surat_pengajuan_id', $pengajuan->id)
                    ->with('pengajuanSurat')
                    ->orderBy('created_at')
                    ->get();
            }
        }

        return view('main.page.pengajuan_surat.track', compact('pengajuan', 'historiPengajuan'));
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
