<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;
use File;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')) {
            $organisasi = Organisasi::where('nama_organisasi','like','%'.$request->search.'%')
            ->orWhere('deskripsi_organisasi','like','%'.$request->search.'%')->paginate(15);
        } else {
            $organisasi = Organisasi::orderBy('id', 'desc')->paginate(15);
        }

        return view('admin.organisasi.index', compact('organisasi'));
        with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.organisasi.create');
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
            'nama_organisasi'=>'required|max:128',
            'deskripsi_organisasi'=>'required|max:512',
            'gambar_organisasi'=>'required|mimes:jpeg,png,jpg',
        ]);

        if($request->hasFile('gambar_organisasi')) {
            $file = $request->file('gambar_organisasi');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/organisasi/';
            $file = $file->move($path, $fileName);
        }

        $organisasi = new Organisasi(array(
            'nama_organisasi' => $request->get('nama_organisasi'),
            'deskripsi_organisasi' => $request->get('deskripsi_organisasi'),
            'gambar_organisasi' => $fileName,
        ));

        $organisasi->save();

        return redirect()->route('organisasi.index')
            ->with('success', 'Organisasi berhasil ditambahkan');
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
        $organisasi = Organisasi::find($id);
        return view('admin.organisasi.edit', compact('organisasi'));
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
            'nama_organisasi'=>'required|max:128',
            'deskripsi_organisasi'=>'required|max:512',
        ]);

        $organisasi = Organisasi::findorfail($id);

        $organisasi->update($request->all());

        if($request->hasFile('gambar_organisasi')) {

            $destination = 'assets/img/organisasi/'.$organisasi->gambar_organisasi;
            if (file_exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('gambar_organisasi');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/organisasi/';
            $file = $file->move($path, $fileName);
            $organisasi->gambar_organisasi = $fileName;
        }

        $organisasi->update();

        return redirect()->route('organisasi.index')
            ->with('success', 'Organisasi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisasi $organisasi)
    {
        $organisasi->delete();

        return redirect()->route('organisasi.index')
            ->with('success', 'Organisasi berhasil dihapus');
    }
}
