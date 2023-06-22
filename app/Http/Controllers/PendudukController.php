<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Sosial;
use Illuminate\Http\Request;
use App\Exports\pendudukExport;
use App\Imports\pendudukImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $penduduk = DB::select('
            SELECT penduduk.*, DATE_FORMAT(tanggal_lahir, "%d-%m-%Y") AS tanggal_lahir, sosial.nama_sosial
            FROM penduduk INNER JOIN sosial ON penduduk.id_sosial = sosial.id
            ORDER BY penduduk.updated_at DESC
        ');

        return view('admin.penduduk.index', compact('penduduk'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.penduduk.create');
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
            'no_kk'=>'required|max:16',
            'nik'=>'required|max:16',
            'nama'=>'required|max:128',
            'tempat_lahir'=>'required|max:128',
            'tanggal_lahir'=>'required',
            'jenis_kelamin'=>'required',
            'golongan_darah'=>'required|max:3',
            'agama'=>'required|max:16',
            'status_perkawinan'=>'required|max:32',
            'status_keluarga'=>'required',
            'pekerjaan'=>'required|max:128',
            'alamat'=>'required|max:256',
            'rt'=>'required|integer',
            'keterangan'=>'required|max:128',
            'id_sosial'=>'required',
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
    public function show(Request $request)
    {
        $no_kk = $request->input('no_kk');

        $result = DB::select('
            SELECT *, DATE_FORMAT(tanggal_lahir, "%d-%m-%Y") AS tanggal_lahir,
            CASE 
                WHEN jenis_kelamin = "L" THEN "Laki-laki"
                WHEN jenis_kelamin = "P" THEN "Perempuan"
                ELSE jenis_kelamin
            END AS jenis_kelamin,
            CASE
            WHEN status_keluarga = "1" THEN "Kepala Keluarga"
                ELSE "-"
            END AS status_keluarga
            FROM penduduk WHERE no_kk = ?
            ORDER BY YEAR(tanggal_lahir)',
            [$no_kk]
        );
        
        return response()->json($result);
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
        
        return view('admin.penduduk.edit', compact('penduduk'));
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
            'no_kk'=>'required|max:16',
            'nik'=>'required|max:16',
            'nama'=>'required|max:128',
            'tempat_lahir'=>'required|max:128',
            'tanggal_lahir'=>'required',
            'jenis_kelamin'=>'required',
            'golongan_darah'=>'required|max:3',
            'agama'=>'required|max:16',
            'status_perkawinan'=>'required|max:32',
            'status_keluarga'=>'required',
            'pekerjaan'=>'required|max:128',
            'alamat'=>'required|max:256',
            'rt'=>'required|integer',
            'keterangan'=>'required|max:128',
            'id_sosial'=>'required',
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
    
    public function import()
    {
        Excel::import(new pendudukImport, request()->file('file'));

        return redirect()->route('penduduk.index')
            ->with('success', 'Penduduk berhasil diimport');
    }
    
    public function export()
    {
        return Excel::download(new pendudukExport, 'penduduk.xlsx');
    }
}