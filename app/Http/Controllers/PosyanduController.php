<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use App\Imports\PosyanduImport;
use Exception;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class PosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $columns = array(
                    0 => 'id',
                    1 => 'nama',
                    2 => 'tanggal_lahir',
                    3 => 'jenis_kelamin',
                    4 => 'alamat',
                    5 => 'usia',
                    6 => 'berat_badan',
                    7 => 'tinggi_badan',
                    8 => 'lingkar_lengan_atas',
                    9 => 'lingkar_lengan_bawah',
                    10 => 'lingkar_dada',
                    11 => 'lingkar_perut',
                    12 => 'lingkar_kepala',
                    13 => 'gizi',
                );

                $totalData = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                    ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length', 10);
                $start = $request->input('start', 0);
                $order = $columns[$request->input('order.0.column', 'id')];
                $dir = $request->input('order.0.dir', 'asc');

                if (empty($request->input('search.value'))) {
                    $penduduks = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                        ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->select('penduduk.nama', 'penduduk.tanggal_lahir', 'penduduk.jenis_kelamin', 'kartu_keluarga.alamat', 'posyandu.*')
                        ->where('penduduk.tanggal_lahir', '>=', \Carbon\Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy('posyandu.updated_at', 'desc')
                        ->get();
                } else {
                    $search = $request->input('search.value');

                    $penduduks = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                        ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->select('penduduk.*', 'kartu_keluarga.alamat', 'posyandu.*')
                        ->where('penduduk.tanggal_lahir', '>=', \Carbon\Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                        ->where(function ($query) use ($search) {
                            $query->where('penduduk.nama', 'LIKE', "%{$search}%")
                                ->orWhere('penduduk.jenis_kelamin', 'LIKE', "%{$search}%")
                                ->orWhere('kartu_keluarga.alamat', 'LIKE', "%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy('posyandu.updated_at', 'desc')
                        ->get();

                    $totalFiltered = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                        ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->where('penduduk.tanggal_lahir', '>=', \Carbon\Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                        ->where(function ($query) use ($search) {
                            $query->where('penduduk.nama', 'LIKE', "%{$search}%")
                                ->orWhere('penduduk.jenis_kelamin', 'LIKE', "%{$search}%")
                                ->orWhere('kartu_keluarga.alamat', 'LIKE', "%{$search}%");
                        })
                        ->count();
                }


                $penduduks = $penduduks->map(function ($penduduk) {
                    $penduduk->action = (string) view('admin.posyandu.action', [
                        'item' => $penduduk
                    ]);
                    $penduduk->tanggal_lahir = date('d-m-Y', strtotime($penduduk->tanggal_lahir));
                    return $penduduk;
                });
            } catch (Exception $e) {
                return $e;
            }

            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $penduduks
            );

            return json_encode($json_data);
        }

        return view('admin.posyandu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('q')) {
            // Ini dipakai untuk pencarian AJAX dari Select2
            $search = $request->q;

            $penduduk = Penduduk::where('tanggal_lahir', '>=', \Carbon\Carbon::now()->subYears(3)->toDateString())
                ->where('nama', 'like', '%' . $search . '%')
                ->where('keterangan', '!=', 'Meninggal')
                ->whereDoesntHave('posyandu')
                ->select('id', 'nama')
                ->limit(10)
                ->get();

            return response()->json($penduduk);
        }

        $penduduk = Penduduk::where('tanggal_lahir', '>=', \Carbon\Carbon::now()->subYears(3)->toDateString())
            ->get();

        return view('admin.posyandu.create', compact('penduduk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penduduk = Penduduk::where('nik', $request->input('nik'))->firstOrFail();
        Posyandu::updateOrCreate(
            ['id_penduduk' => $penduduk->id],
            [
                'usia' => $request->input('usia'),
                'berat_badan' => $request->input('berat_badan'),
                'tinggi_badan' => $request->input('tinggi_badan'),
                'lingkar_lengan_atas' => $request->input('lingkar_lengan_atas'),
                'lingkar_lengan_bawah' => $request->input('lingkar_lengan_bawah'),
                'lingkar_dada' => $request->input('lingkar_dada'),
                'lingkar_perut' => $request->input('lingkar_perut'),
                'lingkar_kepala' => $request->input('lingkar_kepala'),
                'gizi' => 0
            ]
        );


        return redirect()->route('posyandu.index')->with('success', value: 'Batita berhasil ditambahkan');
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
    public function edit($id)
    {
        $posyandu = Posyandu::with('penduduk')->findOrFail($id);
        return view('admin.posyandu.edit', compact('posyandu'));
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
        Posyandu::find(id: $id)->update($request->all());
        return redirect()->route('posyandu.index')->with('success', 'Posyandu berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Posyandu::find(id: $id)->delete();
        return redirect()->route('posyandu.index')->with('success', value: 'Batita berhasil dihapus');
    }

    public function import(Request $request)
    {
        // Excel::import(new pendudukImport, request()->file('file'));

        $validate = $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'csv') {
            Excel::import(new PosyanduImport, $file);
            return redirect()->route('posyandu.index')->with('success', 'Posyandu berhasil diimport');
        } else {
            // Simpan file sementara di session
            $fileData = base64_encode(file_get_contents($file));
            $fileName = $file->getClientOriginalName();

            Session::put('image_data', $fileData);
            Session::put('image_name', $fileName);

            return redirect()->route('posyandu.create')->with('info', 'Silakan input data pengguna.');
        }
    }
}
