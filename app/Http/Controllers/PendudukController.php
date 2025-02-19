<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Sosial;
use Illuminate\Http\Request;
use App\Exports\pendudukExport;
use App\Imports\pendudukImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use Illuminate\Support\Facades\Session;
use Exception;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $penduduks = DB::select('
        //     SELECT penduduk.*, DATE_FORMAT(tanggal_lahir, "%d-%m-%Y") AS tanggal_lahir, sosial.nama_sosial
        //     FROM penduduk INNER JOIN sosial ON penduduk.id_sosial = sosial.id
        //     ORDER BY penduduk.updated_at DESC
        // ');

        if ($request->ajax()) {
            try {
                $columns = array(
                    0 => 'id',
                    1 => 'nama',
                    2 => 'tempat_lahir',
                    3 => 'tanggal_lahir',
                    4 => 'jenis_kelamin',
                    5 => 'golongan_darah',
                    6 => 'agama',
                    7 => 'pekerjaan',
                    8 => 'alamat',
                    9 => 'rt',
                    10 => 'keterangan',
                );

                $totalData = Penduduk::count();

                $totalFiltered = $totalData;

                $limit = $request->input('length', 10);
                $start = $request->input('start', 0);
                $order = $columns[$request->input('order.0.column', 'id')];
                $dir = $request->input('order.0.dir', 'asc');

                if (empty($request->input('search.value'))) {
                    $penduduks = Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->select('penduduk.*', 'kartu_keluarga.alamat', 'kartu_keluarga.rt', 'kartu_keluarga.rw', 'kartu_keluarga.kode_pos', 'kartu_keluarga.kelurahan', 'kartu_keluarga.kecamatan', 'kartu_keluarga.kabupaten', 'kartu_keluarga.provinsi')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy('penduduk.updated_at', 'desc')
                        ->get();
                } else {
                    $search = $request->input('search.value');

                    $penduduks =  Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->where(function ($query) use ($search) {
                            $query->where('nama', 'LIKE', "%{$search}%")
                                ->orWhere('tempat_lahir', 'LIKE', "%{$search}%")
                                ->orWhere('tanggal_lahir', 'LIKE', "%{$search}%")
                                ->orWhere('jenis_kelamin', 'LIKE', "%{$search}%")
                                ->orWhere('golongan_darah', 'LIKE', "%{$search}%")
                                ->orWhere('agama', 'LIKE', "%{$search}%")
                                ->orWhere('pekerjaan', 'LIKE', "%{$search}%")
                                ->orWhere('alamat', 'LIKE', "%{$search}%")
                                ->orWhere('rt', 'LIKE', "%u{$search}%")
                                ->orWhere('keterangan', 'LIKE', "%{$search}%");
                        })
                        ->select('penduduk.*', 'kartu_keluarga.alamat', 'kartu_keluarga.rt', 'kartu_keluarga.rw', 'kartu_keluarga.kode_pos', 'kartu_keluarga.kelurahan', 'kartu_keluarga.kecamatan', 'kartu_keluarga.kabupaten', 'kartu_keluarga.provinsi')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy('penduduk.id', 'asc')
                        ->get();

                    $totalFiltered = Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->where(function ($query) use ($search) {
                            $query->where('penduduk.id', 'LIKE', "%{$search}%")
                                ->orWhere('nama', 'LIKE', "%{$search}%")
                                ->orWhere('tempat_lahir', 'LIKE', "%{$search}%")
                                ->orWhere('tanggal_lahir', 'LIKE', "%{$search}%")
                                ->orWhere('jenis_kelamin', 'LIKE', "%{$search}%")
                                ->orWhere('golongan_darah', 'LIKE', "%{$search}%")
                                ->orWhere('agama', 'LIKE', "%{$search}%")
                                ->orWhere('pekerjaan', 'LIKE', "%{$search}%")
                                ->orWhere('alamat', 'LIKE', "%{$search}%")
                                ->orWhere('rt', 'LIKE', "%{$search}%")
                                ->orWhere('keterangan', 'LIKE', "%{$search}%");
                        })
                        ->select('penduduk.*')
                        ->count();
                }
                $penduduks = $penduduks->map(function ($penduduk) {
                    $penduduk->action = (string) view('admin.penduduk.action', [
                        'item' => $penduduk
                    ]);
                    $penduduk->tanggal_lahir = date('d-m-Y', strtotime($penduduk->tanggal_lahir));
                    return $penduduk;
                });
            } catch (Exception $e) {
                return $e;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $penduduks
            );

            return json_encode($json_data);
        }

        return view('admin.penduduk.index');
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

    public function create_kk()
    {
        return view('admin.penduduk.create_kk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePendudukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePendudukRequest $request)
    {
        $import_kk = $request->input('import_kk');

        if(!$import_kk) {
            Penduduk::create($request->all());
        } else {
            $penduduk = $request->input('penduduk');
            list($rt, $rw) = explode('/', $request->input('rt_rw'));

            KartuKeluarga::updateOrCreate(
                ['no_kk' => $request->input('no_kk')],
                [
                    'alamat' => $request->input('alamat'),
                    'rt' => ltrim($rt, '0'),
                    'rw' => ltrim($rw, '0'),
                    'kode_pos' => $request->input('kode_pos'),
                    'kelurahan' => $request->input('kelurahan'),
                    'kecamatan' => $request->input('kecamatan'),
                    'kabupaten' => $request->input('kabupaten'),
                    'provinsi' => $request->input('provinsi')
                ]
            );

            foreach ($penduduk as $data) {
                Penduduk::create([
                    'no_kk' => $request->input('no_kk'),
                    'nik' => $data['nik'],
                    'nama' => $data['nama'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'golongan_darah' => $data['golongan_darah'],
                    'agama' => $data['agama'],
                    'status_perkawinan' => $data['status_perkawinan'],
                    'status_keluarga' => $data['status_keluarga'],
                    'pekerjaan' => $data['pekerjaan'],
                    'keterangan' => $data['keterangan'],
                    'id_sosial' => $data['id_sosial'],
                ]);
            }
        }

        return redirect()->route('penduduk.index')->with('success', 'Penduduk berhasil ditambahkan');
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

        $result = DB::select(
            '
            SELECT *, DATE_FORMAT(tanggal_lahir, "%d-%m-%Y") AS tanggal_lahir,
            CASE
                WHEN jenis_kelamin = "L" THEN "Laki-laki"
                WHEN jenis_kelamin = "P" THEN "Perempuan"
                ELSE jenis_kelamin
            END AS jenis_kelamin,
            CASE
            WHEN status_keluarga = "1" THEN "Kepala Keluarga"
            WHEN status_keluarga = "2" THEN "Istri"
            WHEN status_keluarga = "3" THEN "Anak"
                ELSE "-"
            END AS status_keluarga
            FROM penduduk WHERE no_kk = ?
            ORDER BY CAST(status_keluarga AS UNSIGNED), YEAR(tanggal_lahir)
            ',
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
        Penduduk::find($id)->update($request->all());

        KartuKeluarga::firstOrCreate(['no_kk' => $request->input('no_kk')]);

        return redirect()->route('penduduk.index')->with('success', 'Penduduk berhasil diupdate');
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

        return redirect()->route('penduduk.index')->with('success', 'Penduduk berhasil dihapus');
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
