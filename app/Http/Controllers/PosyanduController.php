<?php

namespace App\Http\Controllers;

use App\Exports\PosyanduExport;
use App\Models\Penduduk;
use App\Models\Posyandu;
use App\Models\Vaksin;
use App\Models\Vitamin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\PosyanduImport;
use App\Models\Stunting;
use Exception;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
Carbon::setLocale('id');

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

                $bulanTerakhir = Posyandu::max('bulan_posyandu');

                if (!$bulanTerakhir) {
                    return response()->json([
                        "draw" => intval($request->input('draw')),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => [],
                        "bulan_terakhir" => null,
                        "message" => 'Data bulan posyandu belum tersedia.'
                    ]);
                }

                $parsedMonth = Carbon::parse($bulanTerakhir);

                $totalData = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                    ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                    ->where('penduduk.tanggal_lahir', '>=', Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                    ->whereYear('posyandu.bulan_posyandu', $parsedMonth->year)
                    ->whereMonth('posyandu.bulan_posyandu', $parsedMonth->month)
                    ->count();

                $totalFiltered = $totalData;

                $limit = $request->input('length', 10);
                $start = $request->input('start', 0);
                $order = $columns[$request->input('order.0.column', 'id')];
                $dir = $request->input('order.0.dir', 'asc');

                $bulanSebelumnya = Carbon::parse($bulanTerakhir)->subMonth();
                $posyanduBulanSebelumnya = Posyandu::select('id_penduduk', 'tinggi_badan', 'berat_badan', 'bulan_posyandu')
                    ->whereYear('bulan_posyandu', Carbon::parse($bulanSebelumnya)->year)
                    ->whereMonth('bulan_posyandu', Carbon::parse($bulanSebelumnya)->month)
                    ->get();

                if (empty($request->input('search.value'))) {
                    $penduduks = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                        ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->select('penduduk.nama', 'penduduk.tanggal_lahir', 'penduduk.jenis_kelamin', 'kartu_keluarga.alamat', 'posyandu.*')
                        ->where('penduduk.tanggal_lahir', '>=', Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                        ->whereYear('posyandu.bulan_posyandu', $parsedMonth->year)
                        ->whereMonth('posyandu.bulan_posyandu', $parsedMonth->month)
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy('posyandu.updated_at', 'desc')
                        ->get();

                    $penduduks = $penduduks->map(function ($item) use ($posyanduBulanSebelumnya) {
                        $bulanSebelumnya = $posyanduBulanSebelumnya->firstWhere('id_penduduk', $item->id_penduduk);

                        if (!$bulanSebelumnya) {
                            $item->keterangan_berat = '-';
                        } elseif ($item->berat_badan > $bulanSebelumnya->berat_badan) {
                            $item->keterangan_berat = 'Naik ' . number_format($item->berat_badan - $bulanSebelumnya->berat_badan, 1) . ' kg';
                        } elseif ($item->berat_badan < $bulanSebelumnya->berat_badan) {
                            $item->keterangan_berat = 'Turun ' . number_format($bulanSebelumnya->berat_badan - $item->berat_badan, 1) . ' kg';
                        } else {
                            $item->keterangan_berat = 'Tetap';
                        }

                        return $item;
                    });

                } else {
                    $search = $request->input('search.value');

                    $penduduks = Posyandu::leftJoin('penduduk', 'penduduk.id', '=', 'posyandu.id_penduduk')
                        ->leftJoin('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                        ->select('penduduk.*', 'kartu_keluarga.alamat', 'posyandu.*')
                        ->where('penduduk.tanggal_lahir', '>=', Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                        ->whereYear('posyandu.bulan_posyandu', $parsedMonth->year)
                        ->whereMonth('posyandu.bulan_posyandu', $parsedMonth->month)
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
                        ->where('penduduk.tanggal_lahir', '>=', Carbon::now()->subYears(3)->toDateString()) // Tambahkan ini
                        ->where(function ($query) use ($search) {
                            $query->where('penduduk.nama', 'LIKE', "%{$search}%")
                                ->orWhere('penduduk.jenis_kelamin', 'LIKE', "%{$search}%")
                                ->orWhere('kartu_keluarga.alamat', 'LIKE', "%{$search}%");
                        })
                        ->count();
                }

                $penduduks = $penduduks->map(function ($penduduk) use ($posyanduBulanSebelumnya) {
                    $bulanSebelumnya = $posyanduBulanSebelumnya->firstWhere('id_penduduk', $penduduk->id_penduduk);

                    $penduduk->berat_badan_str = $penduduk->berat_badan . ' kg';
                    $penduduk->tinggi_badan_str = $penduduk->tinggi_badan . ' cm';
                    $penduduk->usia_str = $penduduk->usia . ' bln';
                    $penduduk->status_vaksin = ($penduduk->status_vaksin == 1)
                        ? '<span class="badge rounded-pill bg-success text-white text-nowrap"><small class="font-weight-bold">Sudah Vaksin</small></span>'
                        : '-';

                    if (!$bulanSebelumnya) {
                        $keterangan_berat = '-';
                    } elseif ($penduduk->berat_badan > $bulanSebelumnya->berat_badan) {
                        $keterangan_berat = 'Naik ' . number_format($penduduk->berat_badan - $bulanSebelumnya->berat_badan, 1) . ' kg';
                    } elseif ($penduduk->berat_badan < $bulanSebelumnya->berat_badan) {
                        $keterangan_berat = 'Turun ' . number_format($bulanSebelumnya->berat_badan - $penduduk->berat_badan, 1) . ' kg';
                    } else {
                        $keterangan_berat = 'Tetap';
                    }

                    if (!$bulanSebelumnya) {
                        $keterangan_tinggi = '-';
                    } elseif ($penduduk->tinggi_badan > $bulanSebelumnya->tinggi_badan) {
                        $keterangan_tinggi = 'Naik ' . number_format($penduduk->tinggi_badan - $bulanSebelumnya->tinggi_badan, 1) . ' cm';
                    } elseif ($penduduk->tinggi_badan < $bulanSebelumnya->tinggi_badan) {
                        $keterangan_tinggi = 'Turun ' . number_format($bulanSebelumnya->tinggi_badan - $penduduk->tinggi_badan, 1) . ' cm';
                    } else {
                        $keterangan_tinggi = 'Tetap';
                    }

                    $penduduk->keterangan = 'Berat Badan <b>' . $keterangan_berat . '</b><br>Tinggi Badan <b>' . $keterangan_tinggi . '</b>';
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
                "data" => $penduduks,
                'bulan_terakhir' => $bulanTerakhir ? $parsedMonth->translatedFormat('F Y') : ''
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

            $penduduk = Penduduk::where('tanggal_lahir', '>=', Carbon::now()->subYears(3)->toDateString())
                ->where('nama', 'like', '%' . $search . '%')
                ->where('keterangan', '!=', 'Meninggal')
                // ->whereDoesntHave('posyandu')
                ->select('id', 'nama')
                ->limit(10)
                ->get();

            return response()->json($penduduk);
        }

        $penduduk = Penduduk::where('tanggal_lahir', '>=', Carbon::now()->subYears(3)->toDateString())
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
        $bulan = Carbon::createFromFormat('Y-m', $request->bulan_posyandu)->startOfMonth()->toDateString();
        Posyandu::updateOrCreate(
            [
                'id_penduduk' => $penduduk->id,
                'bulan_posyandu' => $bulan
            ],
            [
                'usia' => $request->input('usia'),
                'berat_badan' => (float) $request->input('berat_badan'),
                'tinggi_badan' => (float) $request->input('tinggi_badan'),
                'lingkar_lengan_atas' => (float) $request->input('lingkar_lengan_atas'),
                'lingkar_lengan_bawah' => (float) $request->input('lingkar_lengan_bawah'),
                'lingkar_dada' => (float) $request->input('lingkar_dada'),
                'lingkar_perut' => (float) $request->input('lingkar_perut'),
                'lingkar_kepala' => (float) $request->input('lingkar_kepala'),
                'gizi' => 0,
                'bulan_posyandu' => $bulan,
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
    public function show(Request $request)
    {
        //
        $statusGizi = Stunting::findOrFail($request->input('id_posyandu'))->kategori;
        $idPenduduk = Posyandu::findOrFail($request->input('id_posyandu'))->id_penduduk;

        $datas = Posyandu::select('posyandu.*', 'penduduk.tanggal_lahir')
            ->join('penduduk', 'penduduk.id', 'posyandu.id_penduduk')
            ->where('id_penduduk', $idPenduduk)
            ->get();

        $dataBeratBadan = $datas->map(function ($data) {
            $bulanLahir = Carbon::parse($data->tanggal_lahir);
            $bulanPosyandu = Carbon::parse($data->bulan_posyandu);
            $usia = $bulanLahir->diffInMonths($bulanPosyandu);

            return [$usia => $data->berat_badan];
        });

        $dataTinggiBadan = $datas->map(function ($data) {
            $bulanLahir = Carbon::parse($data->tanggal_lahir);
            $bulanPosyandu = Carbon::parse($data->bulan_posyandu);
            $usia = $bulanLahir->diffInMonths($bulanPosyandu);

            return [$usia => $data->tinggi_badan];
        });

        return response()->json([
            'status_gizi' => $statusGizi,
            'data_berat_badan' => $dataBeratBadan,
            'data_tinggi_badan' => $dataTinggiBadan
        ]);
    }

    public function imunisasi($id)
    {
        $posyandu = Posyandu::with('penduduk.kartuKeluarga', 'posyanduVaksin.vaksin', 'posyanduVitamin.vitamin', 'posyanduPemeriksaan')->findOrFail($id);
        $vaksins = Vaksin::all();
        $vitamins = Vitamin::all();
        return view('admin.imunisasi.imunisasi', compact('posyandu', 'vaksins', 'vitamins'));
    }

    public function riwayat($id)
    {
        try {
            // 1. Get semua data posyandu berdasarkan id penduduk
            $posyanduList = DB::table('posyandu')
                ->join('penduduk', 'posyandu.id_penduduk', '=', 'penduduk.id')
                ->where('penduduk.id', $id)
                ->select('posyandu.*', 'penduduk.nama as nama_penduduk')
                ->orderByDesc('posyandu.created_at')
                ->get();

            if ($posyanduList->isEmpty()) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                    'data' => []
                ], 404);
            }

            $result = [];

            // 2. Loop melalui setiap data posyandu
            foreach ($posyanduList as $posyandu) {
                // 3. Get data vaksin untuk posyandu ini
                $vaksins = DB::table('posyandu_vaksins')
                    ->join('vaksins', 'posyandu_vaksins.vaksin_id', '=', 'vaksins.id')
                    ->where('posyandu_vaksins.posyandu_id', $posyandu->id)
                    ->select('vaksins.*', 'posyandu_vaksins.dosis_ke')
                    ->get();

                // 4. Get data vitamin untuk posyandu ini
                $vitamins = DB::table('posyandu_vitamins')
                    ->join('vitamins', 'posyandu_vitamins.vitamin_id', '=', 'vitamins.id')
                    ->where('posyandu_vitamins.posyandu_id', $posyandu->id)
                    ->select('vitamins.*', 'posyandu_vitamins.catatan')
                    ->get();

                // 5. Get data pemeriksaan untuk posyandu ini
                $pemeriksaans = DB::table('posyandu_pemeriksaans')
                    ->where('posyandu_id', $posyandu->id)
                    ->get();

                // 6. Format data untuk setiap posyandu
                $result[] = [
                    'posyandu' => $posyandu,
                    'data_vaksin' => $vaksins,
                    'data_vitamin' => $vitamins,
                    'data_pemeriksaan' => $pemeriksaans
                ];
            }

            return response()->json([
                'message' => 'Data berhasil diambil',
                'nama_batita' => $posyandu->nama_penduduk,
                'total_kunjungan' => count($result),
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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

        if ($request->input('imunisasi') == 1) {
            return back()->with('success', 'Data pertumbuhan berhasil diupdate');
        }
        
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

        $validate = $request->validate([
            'file' => 'required',
            'bulan_posyandu' => 'required',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'csv') {
            Excel::import(new PosyanduImport($request->input('bulan_posyandu')), $file);
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

    public function export(Request $request)
    {
        $bulan = Carbon::parse($request->input("bulan_posyandu"));
        return Excel::download(new PosyanduExport($bulan), ('posyandu_' . $bulan->format('F') . $bulan->year . '.xls'));
    }
}
