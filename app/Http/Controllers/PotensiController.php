<?php

namespace App\Http\Controllers;

use App\Models\Potensi;
use Illuminate\Http\Request;

class PotensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.potensi.index')->with([
            'potensi' => Potensi::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.potensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_umkm'=>'required',
            'alamat_umkm'=>'required',
            'deskripsi_umkm'=>'required',
            'sosial_media'=>'required',
            'gambar_umkm'=>'required',
        ]);

        if($request->hasFile('gambar_umkm')) {
            $file = $request->file('gambar_umkm');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/potensi/';
            $file = $file->move($path, $fileName);
        }

        $potensi = new Potensi(array(
            'nama_umkm' => $request->get('nama_umkm'),
            'alamat_umkm' => $request->get('alamat_umkm'),
            'deskripsi_umkm' => $request->get('deskripsi_umkm'),
            'sosial_media' => $request->get('sosial_media'),
            'gambar_umkm' => $fileName,
        ));

        $potensi->save();

        return redirect()->route('potensi.index')
            ->with('success', 'UMKM berhasil ditambahkan');
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
        $potensi = Potensi::find($id);
        return view('admin.potensi.edit', compact('potensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_umkm'=>'required',
            'alamat_umkm'=>'required',
            'deskripsi_umkm'=>'required',
            'sosial_media'=>'required',
            'gambar_umkm'=>'required',
        ]);

        Potensi::find($id)->update($request->all());

        return redirect()->route('potensi.index')
            ->with('success', 'UMKM berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Potensi $potensi)
    {
        $potensi->delete();

        return redirect()->route('potensi.index')
            ->with('success', 'UMKM berhasil dihapus');
    }
}
