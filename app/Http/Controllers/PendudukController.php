<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use App\Models\Penduduk;
use App\Models\Sosial;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')) {
            $penduduk = Penduduk::where('nama','like','%'.$request->search.'%')->paginate(15);
        } else {
            $penduduk = Penduduk::all();
        }

        return view('admin.penduduk.index', compact('penduduk'));
        with('i', (request()->input('page', 1) - 1) * 10);
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
        // $nama_sosial = select nama_sosial from sosial where id = (select sosial_id from penduduk where id = $id);
        return view('admin.penduduk.edit', compact('penduduk', 'sosial'));
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
