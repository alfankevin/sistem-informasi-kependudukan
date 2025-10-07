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

                // Query Left Join Penduduk
                $query = Penduduk::leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk');

                if ($request->filled('golongan_darah') && $request->golongan_darah !== 'semua') {
                    $query->where('penduduk.golongan_darah', $request->golongan_darah);
                }

                if ($request->filled('umur_min') || $request->filled('umur_max')) {
                    $query->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR, penduduk.tanggal_lahir, CURDATE())'), [
                        $request->input('umur_min', 0),
                        $request->input('umur_max', 200)
                    ]);
                }

                if ($request->filled('agama') && $request->agama !== "semua") {
                    $query->where('penduduk.agama', $request->agama);
                }

                if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== "semua") {
                    $query->where('penduduk.jenis_kelamin', $request->jenis_kelamin);
                }

                $totalData = $query->count();
                $totalFiltered = $totalData;

                $limit = $request->input('length', 10);
                $start = $request->input('start', 0);

                // Order dari datatables
                $orderColumnIndex = $request->input('order.0.column', 0);
                $order = $columns[$orderColumnIndex] ?? 'penduduk.nama';
                $dir = $request->input('order.0.dir', 'asc');

                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');

                    $query->where(function ($q) use ($search) {
                        $q->where('nama', 'LIKE', "%{$search}%")
                            ->orWhere('tempat_lahir', 'LIKE', "%{$search}%")
                            ->orWhere('tanggal_lahir', 'LIKE', "%{$search}%")
                            ->orWhere('jenis_kelamin', 'LIKE', "%{$search}%")
                            ->orWhere('golongan_darah', 'LIKE', "%{$search}%")
                            ->orWhere('agama', 'LIKE', "%{$search}%")
                            ->orWhere('pekerjaan', 'LIKE', "%{$search}%")
                            ->orWhere('alamat', 'LIKE', "%{$search}%")
                            ->orWhere('rt', 'LIKE', "%u{$search}%")
                            ->orWhere('keterangan', 'LIKE', "%{$search}%");
                    });

                    $totalFiltered = $query->count();
                }

                // Default order "hidup dulu, meninggal di belakang"
                if ($order === 'penduduk.keterangan') {
                    $query->orderByRaw("CASE WHEN penduduk.keterangan = 'hidup' THEN 1 ELSE 2 END {$dir}");
                } else if ($order === 'golongan_darah') {
                    $query->orderByRaw("CASE
                        WHEN penduduk.golongan_darah = 'A' THEN 1
                        WHEN penduduk.golongan_darah = 'A+' THEN 2
                        WHEN penduduk.golongan_darah = 'A-' THEN 3
                        WHEN penduduk.golongan_darah = 'B' THEN 4
                        WHEN penduduk.golongan_darah = 'B+' THEN 5
                        WHEN penduduk.golongan_darah = 'B-' THEN 6
                        WHEN penduduk.golongan_darah = 'AB' THEN 7
                        WHEN penduduk.golongan_darah = 'AB+' THEN 8
                        WHEN penduduk.golongan_darah = 'AB-' THEN 9
                        WHEN penduduk.golongan_darah = 'O' THEN 10
                        WHEN penduduk.golongan_darah = 'O+' THEN 11
                        WHEN penduduk.golongan_darah = 'O-' THEN 12
                        ELSE 13
                    END $dir");
                } else {
                    // Tetap prioritaskan hidup dulu, baru pakai order lain
                    $query->orderByRaw("CASE WHEN penduduk.keterangan = 'hidup' THEN 1 ELSE 2 END ASC");
                    $query->orderBy($order, $dir);
                }

                $penduduks = $query
                    ->select('penduduk.*', 'kartu_keluarga.alamat', 'kartu_keluarga.rt', 'kartu_keluarga.rw', 'kartu_keluarga.kode_pos', 'kartu_keluarga.kelurahan', 'kartu_keluarga.kecamatan', 'kartu_keluarga.kabupaten', 'kartu_keluarga.provinsi')
                    ->offset($start)
                    ->limit($limit)
                    ->get();

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
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $penduduks
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

        if (!$import_kk) {
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

        return redirect()->route('penduduk.index')->with('success', value: 'Penduduk berhasil ditambahkan');
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

    public function import(Request $request)
    {
        // Excel::import(new pendudukImport, request()->file('file'));

        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'csv') {
            Excel::import(new PendudukImport, $file);
            return redirect()->route('penduduk.index')->with('success', 'Penduduk berhasil diimport');
        } else {
            // Simpan file sementara di session
            $fileData = base64_encode(file_get_contents($file));
            $fileName = $file->getClientOriginalName();

            Session::put('image_data', $fileData);
            Session::put('image_name', $fileName);

            return redirect()->route('penduduk.create')->with('info', 'Silakan input data pengguna.');
        }
    }

    public function export()
    {
        return Excel::download(new pendudukExport, 'penduduk.xlsx');
    }
}
