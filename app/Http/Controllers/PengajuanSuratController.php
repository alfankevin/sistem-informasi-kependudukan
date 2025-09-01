<?php

namespace App\Http\Controllers;

use App\Mail\SendPengajuanSuratKelurahanMail;
use App\Models\HistoriSurat;
use App\Models\PengajuanSurat;
use App\Models\PengurusWilayah;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi;

class PengajuanSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pengurus = PengurusWilayah::where('user_id', $user->id)->first();

        if ($user->hasRole('ketua-rw')) {
            $pengajuan_surat = PengajuanSurat::where('rw', $pengurus)->orderBy('created_at')->with('historiSurat')->paginate(25);
        }

        $pengajuan_surat = PengajuanSurat::orderBy('created_at')->with('historiSurat')->paginate(25);
        return view('admin.pengajuan_surat.index', compact(
            'pengajuan_surat'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approveSurat($id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $suratPath = public_path('assets/files/form_pengajuan/' . $pengajuan->pdf_path);

        $user = Auth::user();
        $signPath = PengurusWilayah::where('user_id', $user->id)->first()->ttd_path;
        $sign = public_path('assets/img/ttd_pengurus/' . $signPath);

        $pengajuan->update(["status" => $user->hasRole('ketua-rt') ? 'disetujui_rt' : ($user->hasRole('ketua-rw') ? 'disetujui_rw' : '')]);

        HistoriSurat::create([
            'surat_pengajuan_id' => $pengajuan->id,
            'status' => $pengajuan->status,
            'keterangan' => '',
            'created_at' => now(),
        ]);

        $pdf = new Fpdi();

        $pdf->addPage();
        $pdf->setSourceFile($suratPath);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);

        $pdf->Image($sign, 25, 225, 40, 0);
        $pdf->Output($suratPath, 'F');

        return response()->json([
            'status' => 'success',
            'pdf' => asset('assets/files/form_pengajuan/' . $pengajuan->pdf_path),
        ]);
    }

    public function kirimKeKelurahan(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'subjek' => 'required',
            'pesan' => 'required',
            'pdf' => 'required'
        ]);

        try {
            Mail::to(users: $request->email)->send(new SendPengajuanSuratKelurahanMail($request->all()));
            $pengajuan = PengajuanSurat::findOrFail($id);
            $pengajuan->update(['status' => 'selesai']);

            HistoriSurat::create([
                'surat_pengajuan_id' => $pengajuan->id,
                'status' => $pengajuan->status,
                'keterangan' => 'Telah diserahkan ke Kelurahan',
                'created_at' => now(),
            ]);

            return redirect()->route('pengajuan-surat.index')->with('success', 'Email berhasil dikirim ke kelurahan.');
        } catch (Exception $e) {
            return redirect()->route('pengajuan-surat.index')->with('error', $e->getMessage());
        }


    }
}
