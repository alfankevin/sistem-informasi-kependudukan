<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeluargaRequest;
use App\Http\Requests\UpdateKeluargaRequest;
use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::select("SELECT DISTINCT penduduk.*, kartu_keluarga.*, penduduk.id AS id_2, kartu_keluarga.id AS id, penduduk.no_kk AS no_kk, kartu_keluarga.no_kk AS no_kk_2 FROM penduduk LEFT JOIN kartu_keluarga ON penduduk.no_kk = kartu_keluarga.no_kk WHERE penduduk.status_keluarga = 1 ORDER BY penduduk.updated_at DESC");
        return view('admin.keluarga.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::select("SELECT id, nik, nama
            FROM penduduk
            WHERE no_kk NOT IN (
                SELECT no_kk
                FROM penduduk
                WHERE status_keluarga = 1
            )
            GROUP BY id, nik, nama
            ORDER BY id DESC"
        );
        
        return view('admin.keluarga.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penduduk = $request->input('penduduk');

        DB::table('penduduk')
        ->where('id', $penduduk)
        ->update([
            'status_keluarga' => '1',
        ]);

        $model = Penduduk::find($penduduk);
        $model->touch();
        $model->save();
        
        return redirect()->route('keluarga.index')
            ->with('success', 'Kartu berhasil ditambahkan');
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
        $kartu_keluarga = KartuKeluarga::find($id);
        return view('admin.keluarga.edit', compact('kartu_keluarga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKeluargaRequest $request, string $id)
    {
        list($rt, $rw) = explode('/', $request->input('rt_rw'));

        $request->merge([
            'rt' => $rt,
            'rw' => $rw,
        ]);
        
        KartuKeluarga::find($id)->update($request->all());

        // $penduduk = DB::table('penduduk')->where('id', $id)->first();
        // $kkLama = $penduduk->no_kk;
        // $kkBaru = $request->input('no_kk');
        // $nama = $request->input('nama');
        // $alamat = $request->input('alamat');
        // $rt = $request->input('rt');
        
        // DB::table('penduduk')
        //     ->where('id', $id)
        //     ->update(['nama' => $nama]);
        
        // DB::table('penduduk')
        //     ->where('no_kk', $kkLama)
        //     ->update(['alamat' => $alamat]);
        
        // DB::table('penduduk')
        //     ->where('no_kk', $kkLama)
        //     ->update(['rt' => $rt]);
        
        // DB::table('penduduk')
        //     ->where('no_kk', $kkLama)
        //     ->update(['no_kk' => $kkBaru]);
        
        return redirect()->route('keluarga.index')
            ->with('success', 'Kartu berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        DB::table('penduduk')
        ->where('id', $id)
        ->update([
            'status_keluarga' => '0',
        ]);

        return redirect()->route('keluarga.index')
            ->with('success', 'Kartu berhasil dihapus');
    }
}
