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
        return view('potensi.index')->with([
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
        return view('potensi.create');
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

        Potensi::create($request->all());

        return redirect()->route('potensi.index')
            ->with('success', 'Potensi berhasil ditambahkan');
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
        return view('potensi.edit', compact('potensi'));
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
            ->with('success', 'Potensi berhasil diupdate');
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
            ->with('success', 'Potensi berhasil dihapus');
    }
}
