<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBantuanRequest;
use App\Http\Requests\UpdateBantuanRequest;
use App\Models\Penduduk;
use App\Models\Sosial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::select("SELECT FLOOR(DATEDIFF(CURDATE(), tanggal_lahir) / 365) AS usia, penduduk.id, penduduk.nama, penduduk.jenis_kelamin, penduduk.agama, penduduk.pekerjaan, penduduk.alamat, penduduk.rt, sosial.nama_sosial
            FROM penduduk INNER JOIN sosial ON penduduk.sosial_id = sosial.id WHERE sosial.id != 1 ORDER BY penduduk.updated_at DESC");
        return view('admin.bantuan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penduduk = Penduduk::where('sosial_id', '=', 1)->get();
        $sosial = Sosial::where('id', '!=', 1)->get();
        return view('admin.bantuan.create', compact('penduduk', 'sosial'));
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
        $sosial = $request->input('sosial');

        DB::table('penduduk')
        ->where('id', $penduduk)
        ->update([
            'sosial_id' => $sosial,
        ]);

        $model = Penduduk::find($penduduk);
        $model->touch();
        $model->save();
        
        return redirect()->route('bantuan.index')
            ->with('success', 'Penerima berhasil ditambahkan');
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
    public function edit(string $id)
    {
        $penduduk = Penduduk::find($id);
        $sosial = Sosial::where('id', '!=', 1)->get();
        $nama_sosial = DB::select("SELECT nama_sosial FROM sosial WHERE id = (SELECT sosial_id FROM penduduk WHERE id = ?)", [$id]);
        return view('admin.bantuan.edit', compact('penduduk', 'sosial', 'nama_sosial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBantuanRequest $request, string $id)
    {
        $request->validate([
            'nama'=>'required',
            'sosial_id'=>'required',
        ]);

        Penduduk::find($id)->update($request->all());

        return redirect()->route('bantuan.index')
            ->with('success', 'Penerima berhasil diupdate');
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
            'sosial_id' => '1',
        ]);
        
        return redirect()->route('bantuan.index')
            ->with('success', 'Penerima berhasil dihapus');
    }
}