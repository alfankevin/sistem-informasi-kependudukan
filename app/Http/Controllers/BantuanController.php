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
        $data = DB::select('
            SELECT FLOOR(DATEDIFF(CURDATE(), tanggal_lahir) / 365) AS usia, CASE WHEN jenis_kelamin = "L" THEN "Laki-laki" WHEN jenis_kelamin = "P" THEN "Perempuan"
            ELSE jenis_kelamin END AS gender, penduduk.*, kartu_keluarga.alamat, kartu_keluarga.rt, kartu_keluarga.rw, kartu_keluarga.kabupaten, kartu_keluarga.kelurahan, kartu_keluarga.kecamatan, kartu_keluarga.provinsi, sosial.nama_sosial
            FROM penduduk INNER JOIN sosial ON penduduk.id_sosial = sosial.id LEFT JOIN kartu_keluarga ON penduduk.no_kk = kartu_keluarga.no_kk WHERE sosial.id != 1
            ORDER BY penduduk.updated_at DESC
        ');
        foreach ($data as $item) {
            $item->tanggal_lahir = date_format(date_create($item->tanggal_lahir), 'd-m-Y');
        }
        return view('admin.bantuan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penduduk = Penduduk::where('id_sosial', '=', 1)->orderByDesc('id')->get();
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
            'id_sosial' => $sosial,
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
        $nama_sosial = DB::select("SELECT nama_sosial FROM sosial WHERE id = (SELECT id_sosial FROM penduduk WHERE id = ?)", [$id]);
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
            'id_sosial'=>'required',
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
            'id_sosial' => '1',
        ]);
        
        return redirect()->route('bantuan.index')
            ->with('success', 'Penerima berhasil dihapus');
    }
}