<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use File;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.galeri.index')->with([
            'galeri' => Galeri::orderBy('id', 'desc')->paginate(8),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galeri.create');
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
            'foto'=>'required|mimes:jpeg,png,jpg',
        ]);

        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/galeri/';
            $file = $file->move($path, $fileName);
        }

        $galeri = new Galeri(array(
            'foto' => $fileName,
        ));

        $galeri->save();

        return redirect()->route('galeri.index')
            ->with('success', 'Gambar berhasil ditambahkan');
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
        $galeri = Galeri::find($id);
        return view('admin.galeri.edit', compact('galeri'));
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
        $request->validate([
            'foto'=>'required|mimes:jpeg,png,jpg',
        ]);

        $galeri = Galeri::findorfail($id);

        if($request->hasFile('foto')) {

            $destination = 'assets/img/galeri/'.$galeri->foto;
            if (file_exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/galeri/';
            $file = $file->move($path, $fileName);
            $galeri->foto = $fileName;
        }

        $galeri->update();

        return redirect()->route('galeri.index')
            ->with('success', 'Gambar berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galeri $galeri)
    {
        $galeri->delete();

        return redirect()->route('galeri.index')
            ->with('success', 'Gambar berhasil dihapus');
    }
}
