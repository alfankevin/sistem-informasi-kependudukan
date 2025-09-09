<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use App\Models\Sosial;
use App\Models\OCR;
use Illuminate\Http\Request;
use App\Exports\pendudukExport;
use App\Imports\pendudukImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
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
                                ->orWhere('keterangan', 'LIKE', "%{$search}%")
                                ->orWhere('nik', 'LIKE', "%{$search}%");
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
                                ->orWhere('keterangan', 'LIKE', "%{$search}%")
                                ->orWhere('nik', 'LIKE', "%{$search}%");
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePendudukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePendudukRequest $request)
    {
        $kartuKeluarga = KartuKeluarga::firstOrCreate(['no_kk' => $request->input('no_kk')]);
        $penduduk = $request->input('penduduk');

        if ($kartuKeluarga->wasRecentlyCreated) {
            foreach ($penduduk as &$data) {
                $data['status_keluarga'] = 1;
            }
            unset($data);
        }

        foreach ($penduduk as $data) {
            Penduduk::create([
                'no_kk' => $request->input('no_kk'),
                'agama' => $data['agama'],
                'golongan_darah' => $data['golongan_darah'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'keterangan' => $data['keterangan'],
                'nama' => $data['nama'],
                'nik' => $data['nik'],
                'pekerjaan' => $data['pekerjaan'],
                'status_keluarga' => $data['status_keluarga'],
                'status_perkawinan' => $data['status_perkawinan'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'tempat_lahir' => $data['tempat_lahir'],
                'id_sosial' => $data['id_sosial'],
            ]);
        }
        
        $import_kk = $request->input('import_kk');
        if($import_kk) {
            list($rt, $rw) = explode('/', $request->input('rt_rw'));
            KartuKeluarga::updateOrCreate(
                ['no_kk' => $request->input('no_kk')],
                [
                    'alamat' => $request->input('alamat'),
                    'kabupaten' => $request->input('kabupaten'),
                    'kecamatan' => $request->input('kecamatan'),
                    'kelurahan' => $request->input('kelurahan'),
                    'kode_pos' => $request->input('kode_pos'),
                    'provinsi' => $request->input('provinsi'),
                    'rt' => ltrim($rt, '0'),
                    'rw' => ltrim($rw, '0'),
                ]
            );

            $anggotaKeluarga = array_map(function ($data) {
                return [
                    'agama' => $data['agama'],
                    'golongan_darah' => $data['golongan_darah'],
                    'jenis_kelamin' => match ($data['jenis_kelamin']) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                        default => $data['jenis_kelamin'],
                    },
                    'keterangan' => $data['keterangan'],
                    'nama' => $data['nama'],
                    'nik' => $data['nik'],
                    'pekerjaan' => $data['pekerjaan'],
                    'status_keluarga' => match ($data['status_keluarga']) {
                        '1' => 'Kepala Keluarga',
                        '2' => 'Istri',
                        '3' => 'Anak',
                        default => $data['status_keluarga'],
                    },
                    'status_perkawinan' => $data['status_perkawinan'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'tempat_lahir' => $data['tempat_lahir'],
                ];
            }, $penduduk);            
    
            $ocr_result = Session::get('ocr_result');
            $ground_truth = [
                'anggota_keluarga' => $anggotaKeluarga,
                'alamat' => $request->input('alamat'),
                'kabupaten' => $request->input('kabupaten'),
                'kecamatan' => $request->input('kecamatan'),
                'kelurahan' => $request->input('kelurahan'),
                'kode_pos' => $request->input('kode_pos'),
                'nomor_kk' => $request->input('no_kk'),
                'provinsi' => $request->input('provinsi'),
                'rt' => ltrim($rt, '0'),
                'rw' => ltrim($rw, '0'),
            ];
    
            $duration = $this->duration();
            $accuracy = $this->accuracy($ocr_result, $ground_truth);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
            if ($duration !== null || $accuracy !== null) {
                OCR::create([
                    'no_kk' => $request->input('no_kk'),
                    'accuracy' => $accuracy,
                    'duration' => $duration,
                ]);
                Session::forget('ocr_result');
            }
        }
        
        // dd($ocr_result, $ground_truth, $duration, $accuracy);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan');
    }

    public function duration()
    {
        $process_time = Cache::get('timer');
        if ($process_time) {
            $duration = now()->diffInSeconds($process_time);
            Cache::forget('timer');
            return $duration;
        }
        return null;
    }

    public function accuracy($ocr_result, $ground_truth): int
    {
        // Inisialisasi variabel
        $totalKarakter = 0;
        $karakterSalah = 0;

        // Bandingkan field pada level root
        $rootFields = [
            'alamat',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'kode_pos',
            'nomor_kk',
            'provinsi',
            'rt',
            'rw',
        ];

        foreach ($rootFields as $field) {
            if (isset($ocr_result[$field]) && isset($ground_truth[$field])) {
                // Hitung total karakter
                $totalKarakter += strlen($ground_truth[$field]);

                // Hitung karakter yang salah menggunakan Levenshtein
                $karakterSalah += levenshtein($ocr_result[$field], $ground_truth[$field]);
            }
        }

        // Bandingkan field pada anggota_keluarga
        if (isset($ocr_result['anggota_keluarga']) && isset($ground_truth['anggota_keluarga'])) {
            $ocrAnggota = $ocr_result['anggota_keluarga'];
            $groundTruthAnggota = $ground_truth['anggota_keluarga'];

            // Pastikan kedua array memiliki panjang yang sama
            if (count($ocrAnggota) === count($groundTruthAnggota)) {
                $anggotaFields = [
                    'agama',
                    'golongan_darah',
                    'jenis_kelamin',
                    'keterangan',
                    'nama',
                    'nik',
                    'pekerjaan',
                    'status_keluarga',
                    'status_perkawinan',
                    'tanggal_lahir',
                    'tempat_lahir',
                ];

                foreach ($ocrAnggota as $index => $ocrData) {
                    foreach ($anggotaFields as $field) {
                        if (isset($ocrData[$field]) && isset($groundTruthAnggota[$index][$field])) {
                            // Hitung total karakter
                            $totalKarakter += strlen($groundTruthAnggota[$index][$field]);

                            // Hitung karakter yang salah menggunakan Levenshtein
                            $karakterSalah += levenshtein($ocrData[$field], $groundTruthAnggota[$index][$field]);
                        }
                    }
                }
            }
        }

        // Hitung Character Error Rate (CER)
        if ($totalKarakter === 0) {
            return 0; // Hindari pembagian oleh nol
        }

        // Hitung akurasi sebagai 100% - CER
        $cer = ($karakterSalah / $totalKarakter) * 100;
        $akurasi = 100 - $cer;

        return (int) $akurasi;
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
            SELECT p.*, DATE_FORMAT(p.tanggal_lahir, "%d-%m-%Y") AS tanggal_lahir,
                CASE
                    WHEN p.jenis_kelamin = "L" THEN "Laki-laki"
                    WHEN p.jenis_kelamin = "P" THEN "Perempuan"
                    ELSE p.jenis_kelamin
                END AS jenis_kelamin,
                CASE
                    WHEN p.status_keluarga = "1" THEN "Kepala Keluarga"
                    WHEN p.status_keluarga = "2" THEN "Istri"
                    WHEN p.status_keluarga = "3" THEN "Anak"
                    ELSE "-"
                END AS status_keluarga,
                (SELECT nama FROM penduduk WHERE no_kk = p.no_kk AND status_keluarga = 1 LIMIT 1) AS kepala_keluarga
            FROM penduduk p
            WHERE p.no_kk = ?
            ORDER BY CAST(p.status_keluarga AS UNSIGNED), YEAR(p.tanggal_lahir)
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

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diupdate');
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

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus');
    }

    public function import()
    {
        Excel::import(new pendudukImport, request()->file('file'));

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diimport');
    }

    public function import_kk(Request $request)
    {
        Cache::put('timer', now());

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $file = $request->file('file');
        $image = base64_encode(file_get_contents($file));
        Session::put('image', $image);

        $tempPath = $file->store('ocr');
        $fullTempPath = storage_path('app/' . $tempPath);

        $command = "python3 ocr/app.py" . escapeshellarg($fullTempPath) . " 2>&1";
        $output = shell_exec($command);
        $result = json_decode($output, true);

        unlink($fullTempPath);
        Session::put('ocr_result', $result['data']);

        return view('admin.penduduk.create_kk', ['data' => $result['data']]);
    }

    public function export()
    {
        return Excel::download(new pendudukExport, 'penduduk.xlsx');
    }
}
