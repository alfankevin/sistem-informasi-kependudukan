<?php

namespace App\Http\Controllers;

use App\Models\Sosial;
use Illuminate\Http\Request;

class SosialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')) {
            $sosial = Sosial::where('nama_sosial','like','%'.$request->search.'%')->paginate(15);
        } else {
            $sosial = Sosial::all();
            $sosial = Sosial::orderBy('id', 'desc')->paginate(15);
        }
        
        return view('admin.sosial.index', compact('sosial'));
        with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sosial.create');
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
            'nama_sosial'=>'required',
        ]);

        Sosial::create($request->all());

        return redirect()->route('sosial.index')
            ->with('success', 'Bantuan sosial berhasil ditambahkan');
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
        $sosial = Sosial::find($id);
        return view('admin.sosial.edit', compact('sosial'));
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
            'nama_sosial'=>'required',
        ]);

        Sosial::find($id)->update($request->all());

        return redirect()->route('sosial.index')
            ->with('success', 'Bantuan sosial berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sosial $sosial)
    {
        $sosial->delete();

        return redirect()->route('sosial.index')
            ->with('success', 'Bantuan sosial berhasil dihapus');
    }
}
