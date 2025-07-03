<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\Stunting;
use DateTime;
use DB;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Log;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class PerankinganRisikoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $stuntingCount = Stunting::count();

                if ($stuntingCount == 0) {
                    $this->hitungRanking();
                }

                $query = DB::table('stuntings')
                    ->join('posyandu', 'stuntings.posyandu_id', '=', 'posyandu.id')
                    ->join('penduduk', 'posyandu.id_penduduk', '=', 'penduduk.id')
                    ->join('kartu_keluarga', 'penduduk.no_kk', '=', 'kartu_keluarga.no_kk')
                    ->select(
                        'stuntings.id',
                        'penduduk.id as penduduk_id',
                        'penduduk.nama',
                        'penduduk.jenis_kelamin',
                        'penduduk.tanggal_lahir',
                        'posyandu.usia',
                        'kartu_keluarga.alamat',
                        'stuntings.status_gizi',
                        'stuntings.nilai',
                        'stuntings.kategori',
                        'posyandu.tinggi_badan',
                        'posyandu.berat_badan'
                    )
                    ->orderBy('stuntings.nilai', 'asc');

                return DataTables::of($query)
                    ->addIndexColumn() // This will add DT_RowIndex starting from 1
                    ->filter(function ($query) use ($request) {
                        if ($request->has('jenisKelamin') && $request->jenisKelamin != '') {
                            $query->where('penduduk.jenis_kelamin', $request->jenisKelamin);
                        }
                    })
                    ->editColumn('nama', function ($row) {
                        return $row->nama ?? 'N/A';
                    })
                    ->editColumn('jenis_kelamin', function ($row) {
                        return $row->jenis_kelamin ?? 'N/A';
                    })
                    ->editColumn('tanggal_lahir', function ($row) {
                        return $row->tanggal_lahir ?? 'N/A';
                    })
                    ->addColumn('usia', function ($row) {
                        return $row->usia;
                    })
                    ->editColumn('alamat', function ($row) {
                        return $row->alamat ?? 'Alamat tidak tersedia';
                    })
                    ->editColumn('status_gizi', function ($row) {
                        return number_format($row->status_gizi, 4);
                    })
                    ->editColumn('nilai_topsis', function ($row) {
                        return number_format($row->nilai, 4);
                    })
                    ->addColumn('tinggi_badan', function ($row) {
                        return ($row->tinggi_badan ?? 0) . ' cm';
                    })
                    ->addColumn('berat_badan', function ($row) {
                        return ($row->berat_badan ?? 0) . ' kg';
                    })
                    ->addColumn('kategori_risiko', function ($row) {
                        $badge = $this->getBadgeClass($row->kategori);
                        return [
                            'text' => $row->kategori,
                            'class' => $badge
                        ];
                    })
                    ->filterColumn('nama', function ($query, $keyword) {
                        $query->where('penduduk.nama', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('jenis_kelamin', function ($query, $keyword) {
                        $query->where('penduduk.jenis_kelamin', 'like', "%{$keyword}%");
                    })
                    ->filterColumn('alamat', function ($query, $keyword) {
                        $query->where('kartu_keluarga.alamat', 'like', "%{$keyword}%");
                    })
                    ->with([
                        'stuntingStats' => $this->getStuntingStatisticsFromQuery($request)
                    ])
                    ->make(true);

            } catch (Exception $e) {
                Log::error('Error in perankingan function: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());

                return response()->json([
                    'error' => true,
                    'message' => 'Terjadi kesalahan dalam perhitungan ranking: ' . $e->getMessage()
                ], 500);
            }
        }

        return view('admin.posyandu.perankingan-risiko');
    }

    /**
     * Hitung ranking dan simpan ke tabel stuntings
     */
    public function hitungRanking()
    {
        try {
            DB::beginTransaction();
            // Clear existing data
            Stunting::truncate();

            $posyandu = Posyandu::with('penduduk.kartuKeluarga')->get();

            if ($posyandu->isEmpty()) {
                return;
            }

            // Kriteria awal Anda dipertahankan dengan penyesuaian minor
            $kriteria = collect([
                ['kode' => 'usia', 'nama' => 'Usia (bulan)', 'bobot' => 0.22, 'tipe' => 'cost'],
                ['kode' => 'tinggi_badan', 'nama' => 'Tinggi Badan (cm)', 'bobot' => 0.17, 'tipe' => 'benefit'],
                ['kode' => 'berat_badan', 'nama' => 'Berat Badan (kg)', 'bobot' => 0.16, 'tipe' => 'benefit'],
                ['kode' => 'lingkar_lengan_atas', 'nama' => 'Lingkar Lengan Atas (cm)', 'bobot' => 0.12, 'tipe' => 'benefit'],
                ['kode' => 'lingkar_lengan_bawah', 'nama' => 'Lingkar Lengan Bawah (cm)', 'bobot' => 0.1, 'tipe' => 'benefit'],
                ['kode' => 'lingkar_dada', 'nama' => 'Lingkar Dada (cm)', 'bobot' => 0.08, 'tipe' => 'benefit'],
                ['kode' => 'lingkar_perut', 'nama' => 'Lingkar Perut (cm)', 'bobot' => 0.06, 'tipe' => 'benefit'],
                ['kode' => 'lingkar_kepala', 'nama' => 'Lingkar Kepala (cm)', 'bobot' => 0.05, 'tipe' => 'benefit'],
                ['kode' => 'status_gizi', 'nama' => 'Status Gizi (Rasio Z-Score)', 'bobot' => 0.03, 'tipe' => 'benefit'],
            ]);

            // Persiapan data alternatif dengan perhitungan yang diperbaiki
            $alternatif = $posyandu->map(function ($item) {
                if (!$item->penduduk || !$item->penduduk->tanggal_lahir) {
                    return null;
                }

                $usia = $this->hitungUsiaDalamBulan($item->penduduk->tanggal_lahir);
                $gender = strtolower($item->penduduk->jenis_kelamin);

                // Validasi usia (0-60 bulan untuk balita)
                if ($usia < 0 || $usia > 60) {
                    return null; // Skip data tidak valid
                }

                try {
                    $tbFile = "growth/growth_{$gender}_lhfa.json";
                    $bbFile = "growth/growth_{$gender}_wfa.json";

                    if (!Storage::exists($tbFile) || !Storage::exists($bbFile)) {
                        Log::warning("Growth chart files not found for gender: {$gender}");
                        return null;
                    }

                    // Hitung Z-Score TB/U (Tinggi Badan menurut Usia)
                    $lms_tb = json_decode(Storage::get($tbFile), true);
                    $tb = (float) $item->tinggi_badan;

                    if (!isset($lms_tb[$usia])) {
                        Log::warning("LMS data not found for age: {$usia} months");
                        return null;
                    }

                    $zscore_tb_u = $this->hitungZScoreWHO($tb, $lms_tb[$usia]['L'], $lms_tb[$usia]['M'], $lms_tb[$usia]['S']);

                    $lms_bb = json_decode(Storage::get($bbFile), true);
                    $bb = (float) $item->berat_badan;

                    if (!isset($lms_bb[$usia])) {
                        Log::warning("LMS BB data not found for age: {$usia} months");
                        return null;
                    }

                    $zscore_bb_u = $this->hitungZScoreWHO($bb, $lms_bb[$usia]['L'], $lms_bb[$usia]['M'], $lms_bb[$usia]['S']);

                    $status_gizi = ($zscore_tb_u != 0) ? abs($zscore_bb_u / $zscore_tb_u) : 1;

                    return [
                        'id' => $item->id,
                        'nama' => $item->penduduk->nama,
                        'jenis_kelamin' => $item->penduduk->jenis_kelamin,
                        'tanggal_lahir' => $item->penduduk->tanggal_lahir,
                        'usia' => $usia,
                        'alamat' => $item->penduduk->kartuKeluarga->alamat ?? 'Alamat tidak tersedia',
                        'tinggi_badan' => $tb,
                        'berat_badan' => $bb,
                        'lingkar_lengan_atas' => (float) ($item->lingkar_lengan_atas ?? 0),
                        'lingkar_lengan_bawah' => (float) ($item->lingkar_lengan_bawah ?? 0),
                        'lingkar_dada' => (float) ($item->lingkar_dada ?? 0),
                        'lingkar_perut' => (float) ($item->lingkar_perut ?? 0),
                        'lingkar_kepala' => (float) ($item->lingkar_kepala ?? 0),
                        'status_gizi' => round($status_gizi, 4),
                        // Data tambahan untuk analisis
                        'zscore_tb_u' => round($zscore_tb_u, 2),
                        'zscore_bb_u' => round($zscore_bb_u, 2),
                    ];
                } catch (Exception $e) {
                    Log::error("Error calculating data for {$item->penduduk->nama}: " . $e->getMessage());
                    return null;
                }
            })->filter()->values();

            if ($alternatif->isEmpty()) {
                return;
            }

            // 1. Buat matriks keputusan
            $matriks = $alternatif->map(function ($alt) use ($kriteria) {
                return $kriteria->pluck('kode')->mapWithKeys(function ($kode) use ($alt) {
                    return [$kode => $alt[$kode] ?? 0];
                })->toArray();
            })->toArray();

            // 2. Normalisasi Matriks (Vector Normalization - metode standar TOPSIS)
            $normal = [];
            foreach ($kriteria as $i => $k) {
                $kolom = array_column($matriks, $k['kode']);

                // Hitung akar jumlah kuadrat
                $sumSquares = array_sum(array_map(fn($v) => $v ** 2, $kolom));
                $pembagi = $sumSquares > 0 ? sqrt($sumSquares) : 1;

                foreach ($matriks as $j => $baris) {
                    $normal[$j][$i] = $baris[$k['kode']] / $pembagi;
                }
            }

            // 3. Matriks Normalisasi Terbobot
            $terbobot = [];
            foreach ($normal as $i => $baris) {
                foreach ($baris as $j => $value) {
                    $terbobot[$i][$j] = $value * $kriteria[$j]['bobot'];
                }
            }

            // 4. Hitung Solusi Ideal Positif & Negatif
            $idealPlus = [];
            $idealMinus = [];

            foreach ($kriteria as $j => $k) {
                $kolom = array_column($terbobot, $j);

                if ($k['tipe'] === 'benefit') {
                    $idealPlus[$j] = max($kolom);
                    $idealMinus[$j] = min($kolom);
                } else { // cost
                    $idealPlus[$j] = min($kolom);
                    $idealMinus[$j] = max($kolom);
                }
            }

            $bulkData = [];

            // 5. Hitung D+ dan D- serta Nilai Preferensi dan simpan ke database
            foreach ($terbobot as $i => $baris) {
                // Jarak ke solusi ideal positif (D+)
                $dPlus = sqrt(array_sum(array_map(function ($v, $ideal) {
                    return pow($v - $ideal, 2);
                }, $baris, $idealPlus)));

                // Jarak ke solusi ideal negatif (D-)
                $dMinus = sqrt(array_sum(array_map(function ($v, $ideal) {
                    return pow($v - $ideal, 2);
                }, $baris, $idealMinus)));

                // Nilai preferensi (Closeness Coefficient)
                $totalDistance = $dPlus + $dMinus;
                $nilai = $totalDistance > 0 ? $dMinus / $totalDistance : 0;

                // Kategorisasi risiko berdasarkan nilai preferensi dan Z-Score
                $kategoriRisiko = $this->kategoriRisikoStunting($nilai);

                $bulkData[] = [
                    'posyandu_id' => $alternatif[$i]['id'],
                    'status_gizi' => $alternatif[$i]['status_gizi'],
                    'nilai' => round($nilai, 4),
                    'kategori' => $kategoriRisiko['text'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($bulkData)) {
                Stunting::insert($bulkData);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in hitungRanking function: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Force recalculation of ranking
     */
    public function recalculate()
    {
        try {
            $this->hitungRanking();
            return response()->json([
                'success' => true,
                'message' => 'Perhitungan ranking berhasil diperbarui',
            ]);
        } catch (Exception $e) {
            Log::error('Error in recalculate function: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan dalam perhitungan ulang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hitung usia dalam bulan dengan validasi
     */
    private function hitungUsiaDalamBulan($tanggalLahir)
    {
        try {
            $lahir = new DateTime($tanggalLahir);
            $sekarang = new DateTime();

            // Validasi tanggal lahir tidak boleh di masa depan
            if ($lahir > $sekarang) {
                throw new InvalidArgumentException('Tanggal lahir tidak boleh di masa depan');
            }

            $interval = $lahir->diff($sekarang);
            $usiaBulan = ($interval->y * 12) + $interval->m;

            // Jika sudah lewat tanggal dalam bulan tersebut, tambah 1 bulan
            if ($interval->d > 0) {
                $usiaBulan++;
            }

            return $usiaBulan;

        } catch (Exception $e) {
            Log::error("Error calculating age: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Hitung Z-Score berdasarkan standar WHO dengan validasi
     */
    private function hitungZScoreWHO($x, $l, $m, $s)
    {
        try {
            // Validasi input
            if ($x <= 0 || $m <= 0 || $s <= 0) {
                return 0;
            }

            // Rumus Z-Score WHO (LMS method)
            if (abs($l) < 0.01) { // L mendekati 0
                return log($x / $m) / $s;
            } else {
                return (pow($x / $m, $l) - 1) / ($l * $s);
            }

        } catch (Exception $e) {
            Log::error("Error calculating Z-Score: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Kategorisasi risiko stunting berdasarkan kombinasi nilai TOPSIS dan Z-Score
     */
    private function kategoriRisikoStunting($nilaiTopsis)
    {
        if ($nilaiTopsis < 0.29) {
            return [
                'text' => 'Gizi buruk/stunting',
                'class' => 'badge-danger'
            ];
        } elseif ($nilaiTopsis > 0.6) {
            return [
                'text' => 'Gizi lebih/obesitas',
                'class' => 'badge-warning'
            ];
        }

        return [
            'text' => 'Gizi baik/normal',
            'class' => 'badge-success'
        ];
    }

    private function getStuntingStatistics($ranking, $jenisKelamin = null)
    {
        // Filter by gender if specified
        if ($jenisKelamin) {
            $ranking = array_filter($ranking, function($data) use ($jenisKelamin) {
                return ($data['jenis_kelamin'] ?? '') === $jenisKelamin;
            });
        }

        // Use array_column and array_count_values for optimal performance
        $kategoris = array_column($ranking, 'kategori_risiko');
        $kategoriTexts = array_map(function($kategori) {
            return is_array($kategori) ? ($kategori['text'] ?? '') : (string)$kategori;
        }, $kategoris);

        $kategoriCounts = array_count_values($kategoriTexts);

        // Map to the expected format with default values
        return [
            'labels' => ['Gizi Buruk/Stunting', 'Gizi Normal', 'Gizi Lebih/Obesitas'],
            'data' => [
                $kategoriCounts['Gizi buruk/stunting'] ?? 0,
                $kategoriCounts['Gizi baik/normal'] ?? 0,
                $kategoriCounts['Gizi lebih/obesitas'] ?? 0
            ],
            'colors' => ['#dc3545', '#28a745', '#ffc107']
        ];
    }

    private function getStuntingStatisticsFromQuery(Request $request)
    {
        // Get the data in array format to use optimized array processing
        $query = DB::table('stuntings')
            ->join('posyandu', 'stuntings.posyandu_id', '=', 'posyandu.id')
            ->join('penduduk', 'posyandu.id_penduduk', '=', 'penduduk.id')
            ->select(
                'penduduk.jenis_kelamin',
                'stuntings.kategori'
            );

        // Apply gender filter if specified
        if ($request->has('jenisKelamin') && $request->jenisKelamin != '') {
            $query->where('penduduk.jenis_kelamin', $request->jenisKelamin);
        }

        $data = $query->get()->map(function($row) {
            return [
                'jenis_kelamin' => $row->jenis_kelamin,
                'kategori_risiko' => ['text' => $row->kategori]
            ];
        })->toArray();

        // Use the optimized array-based statistics method
        return $this->getStuntingStatistics($data);
    }

    private function getBadgeClass($kategori)
    {
        switch ($kategori) {
            case 'Gizi buruk/stunting':
                return 'badge-danger';
            case 'Gizi lebih/obesitas':
                return 'badge-warning';
            case 'Gizi baik/normal':
            default:
                return 'badge-success';
        }
    }
}
