<?php

namespace App\Http\Controllers;

use App\Mail\SendPengajuanSuratKelurahanMail;
use App\Models\HistoriSurat;
use App\Models\PengajuanSurat;
use App\Models\PengurusWilayah;
use Auth;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $pengurus = PengurusWilayah::where('user_id', $user->id)->first();

        if ($request->ajax()) {
            try {
                $columns = array(
                    0 => 'id',
                    1 => 'nik_pemohon',
                    2 => 'nama_pemohon',
                    3 => 'alamat_pemohon',
                    4 => 'jenis_surat',
                    5 => 'status',
                );

                $query = PengajuanSurat::query();

                // Filter role RW
                if ($user->hasRole('ketua-rw')) {
                    $query->where('rw', $pengurus->wilayah_rw);
                } else if ($user->hasRole('ketua-rt')) {
                    $query->where('rw', $pengurus->wilayah_rw)->where('rt', $pengurus->wilayah_rt);
                }

                $totalData = $query->count();
                $totalFiltered = $totalData;

                $limit = $request->input('length', 10);
                $start = $request->input('start', 0);
                $order = $columns[$request->input('order.0.column', 'id')];
                $dir = $request->input('order.0.dir', 'asc');


                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');

                    $query->where(function ($q) use ($search) {
                        $q->where('nik_pemohon', 'LIKE', "%{$search}%")
                            ->orWhere('nama_pemohon', 'LIKE', "%{$search}%")
                            ->orWhere('alamat_pemohon', 'LIKE', "%{$search}%")
                            ->orWhere('status', 'LIKE', "%{$search}%");
                    });

                    $totalFiltered = $query->count();
                }

                $query->orderByRaw("
                    CASE
                        WHEN status = 'diajukan' THEN 1
                        WHEN status LIKE 'disetujui%' THEN 2
                        WHEN status LIKE 'ditolak%' THEN 3
                        WHEN status = 'selesai' THEN 4
                        ELSE 5
                    END ASC
                ");

                $pengajuan_surat = $query
                    ->when($order !== 'status', function ($q) use ($order, $dir) {
                        $q->orderBy($order, $dir);
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->get();

                $pengajuan_surat = $pengajuan_surat->map(function ($pengajuan) {
                    $pengajuan->action = (string) view('admin.pengajuan_surat.partials.action', [
                        'item' => $pengajuan
                    ]);

                    return $pengajuan;
                });
            } catch (Exception $e) {
                return $e;
            }

            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $pengajuan_surat
            );

            return json_encode($json_data);
        }

        return view('admin.pengajuan_surat.index');
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
            'keterangan' => strtoupper(explode('-', $user->getRoleNames()->first())[1]) . ' memverifikasi dokumen',
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($suratPath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->addPage();
            $tplIdx = $pdf->importPage($i);
            $pdf->useTemplate($tplIdx, 0, 0, 210);

            if ($i === 1) {
                $pdf->Image($sign, 25, 235, 40, 0);
            }
        }

        $pdf->Output($suratPath, 'F');

        return response()->json([
            'status' => 'success',
            'pdf' => asset('assets/files/form_pengajuan/' . $pengajuan->pdf_path),
        ]);
    }

    public function tolakSurat(Request $request, $id)
    {
        $user = Auth::user();

        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update(["status" => $user->hasRole('ketua-rt') ? 'ditolak_rt' : ($user->hasRole('ketua-rw') ? 'ditolak_rw' : '')]);

        HistoriSurat::create([
            'surat_pengajuan_id' => $pengajuan->id,
            'status' => $pengajuan->status,
            'keterangan' => $request->keterangan,
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);

        return response()->json([
            'status' => 'success',
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
                'keterangan' => 'Dokumen dikirim ke Kelurahan dan bisa diambil di kantor desa',
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);

            return redirect()->route('pengajuan-surat.index')->with('success', 'Email berhasil dikirim ke kelurahan.');
        } catch (Exception $e) {
            return redirect()->route('pengajuan-surat.index')->with('error', $e->getMessage());
        }
    }
}
