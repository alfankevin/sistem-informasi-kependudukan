<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
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
        $penduduk = Penduduk::orderByDesc('id')->get()->map(function($item) {
            $item->tanggal_lahir = date('d-m-Y', strtotime($item->tanggal_lahir));
            return $item;
        });

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