<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use App\Models\Penduduk;
use App\Models\Sosial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $penduduk = Penduduk::all();
        return view('admin.penduduk.index', compact('penduduk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sosial = Sosial::all();
        return view('admin.penduduk.create', compact('sosial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePendudukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePendudukRequest $request)
    {
        $request->validate([
            'no_kk'=>'required',
            'nik'=>'required',
            'nama'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir'=>'required',
            'jenis_kelamin'=>'required',
            'golongan_darah'=>'required',
            'agama'=>'required',
            'status_perkawinan'=>'required',
            'status_keluarga'=>'required',
            'pekerjaan'=>'required',
            'alamat'=>'required',
            'rt'=>'required',
            'keterangan'=>'required',
            'sosial_id'=>'required',
        ]);

        Penduduk::create($request->all());

        return redirect()->route('penduduk.index')
            ->with('success', 'Penduduk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penduduk  $penduduk
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $penduduk
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $penduduk = Penduduk::find($id);
        $sosial = Sosial::all();
        $nama_sosial = DB::select("SELECT nama_sosial FROM sosial WHERE id = (SELECT sosial_id FROM penduduk WHERE id = ?)", [$id]);
        return view('admin.penduduk.edit', compact('penduduk', 'sosial', 'nama_sosial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePendudukRequest  $request
     * @param  \App\Models\Penduduk  $penduduk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePendudukRequest $request, string $id)
    {
        $request->validate([
            'no_kk'=>'required',
            'nik'=>'required',
            'nama'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir'=>'required',
            'jenis_kelamin'=>'required',
            'golongan_darah'=>'required',
            'agama'=>'required',
            'status_perkawinan'=>'required',
            'status_keluarga'=>'required',
            'pekerjaan'=>'required',
            'alamat'=>'required',
            'rt'=>'required',
            'keterangan'=>'required',
            'sosial_id'=>'required',
        ]);

        Penduduk::find($id)->update($request->all());

        return redirect()->route('penduduk.index')
            ->with('success', 'Penduduk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $penduduk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('penduduk.index')
            ->with('success', 'Penduduk berhasil dihapus');
    }
}
