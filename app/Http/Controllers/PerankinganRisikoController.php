<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Log;
use Storage;

class PerankinganRisikoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $columns = array(
                    0 => 'rank',
                    1 => 'id',
                    2 => 'nama',
                    3 => 'jenis_kelamin',
                    4 => 'tanggal_lahir',
                    5 => 'usia',
                    6 => 'alamat',
                    7 => 'status_gizi',
                    8 => 'nilai_topsis',
                    9 => 'kategori_risiko',
                );

                $posyandu = Posyandu::with('penduduk')->get();

                if ($posyandu->isEmpty()) {
                    return response()->json([
                        "draw" => intval($request->input('draw')),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => [],
                    ]);
                }

                // Kriteria awal Anda dipertahankan dengan penyesuaian minor
                $kriteria = collect([
                    ['kode' => 'usia', 'nama' => 'Usia (bulan)', 'bobot' => 0.22, 'tipe' => 'cost'],
                    ['kode' => 'tinggi_badan', 'nama' => 'Tinggi Badan (cm)', 'bobot' => 0.17, 'tipe' => 'benefit'],
                    ['kode' => 'berat_badan', 'nama' => 'Berat Badan (kg)', 'bobot' => 0.16, 'tipe' => 'benefit'],
                    ['kode' => 'lingkar_lengan_atas', 'nama' => 'Lingkar Lengan Atas (cm)', 'bobot' => 0.13, 'tipe' => 'benefit'],
                    ['kode' => 'lingkar_lengan_bawah', 'nama' => 'Lingkar Lengan Bawah (cm)', 'bobot' => 0.1, 'tipe' => 'benefit'],
                    ['kode' => 'lingkar_dada', 'nama' => 'Lingkar Dada (cm)', 'bobot' => 0.08, 'tipe' => 'benefit'],
                    ['kode' => 'lingkar_perut', 'nama' => 'Lingkar Perut (cm)', 'bobot' => 0.06, 'tipe' => 'benefit'],
                    ['kode' => 'lingkar_kepala', 'nama' => 'Lingkar Kepala (cm)', 'bobot' => 0.05, 'tipe' => 'benefit'],
                    ['kode' => 'status_gizi', 'nama' => 'Status Gizi (Rasio Z-Score)', 'bobot' => 0.4, 'tipe' => 'benefit'],
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
                    return response()->json([
                        "draw" => intval($request->input('draw')),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => [],
                    ]);
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

                // 5. Hitung D+ dan D- serta Nilai Preferensi
                $ranking = [];
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
                    $kategoriRisiko = $this->kategoriRisikoStunting($nilai, $alternatif[$i]);

                    $ranking[] = [
                        'id' => $alternatif[$i]['id'],
                        'nama' => $alternatif[$i]['nama'],
                        'jenis_kelamin' => $alternatif[$i]['jenis_kelamin'],
                        'tanggal_lahir' => $alternatif[$i]['tanggal_lahir'],
                        'usia' => $alternatif[$i]['usia'] . ' bulan',
                        'alamat' => $alternatif[$i]['alamat'],
                        'tinggi_badan' => $alternatif[$i]['tinggi_badan'] . ' cm',
                        'berat_badan' => $alternatif[$i]['berat_badan'] . ' kg',
                        'status_gizi' => $alternatif[$i]['status_gizi'],
                        'zscore_tb_u' => $alternatif[$i]['zscore_tb_u'],
                        'zscore_bb_u' => $alternatif[$i]['zscore_bb_u'],
                        'nilai_topsis' => round($nilai, 4),
                        'kategori_risiko' => $kategoriRisiko,
                        'd_plus' => round($dPlus, 4),
                        'd_minus' => round($dMinus, 4),
                        // FIX: Ensure all data is serializable
                        'detail_antropometri' => [
                            'lingkar_lengan_atas' => $alternatif[$i]['lingkar_lengan_atas'],
                            'lingkar_lengan_bawah' => $alternatif[$i]['lingkar_lengan_bawah'],
                            'lingkar_dada' => $alternatif[$i]['lingkar_dada'],
                            'lingkar_perut' => $alternatif[$i]['lingkar_perut'],
                            'lingkar_kepala' => $alternatif[$i]['lingkar_kepala'],
                        ]
                    ];
                }

                // Urutkan berdasarkan nilai TOPSIS (asc)
                // Nilai rendah = kondisi buruk (risiko stunting tinggi)
                usort($ranking, fn($a, $b) => $a['nilai_topsis'] <=> $b['nilai_topsis']);
                foreach ($ranking as $index => &$item) {
                    $item['rank'] = $index + 1;
                }

                $totalData = count($ranking);
                $totalFiltered = $totalData;

                $limit = $request->input('length', 10);
                $start = $request->input('start', 0);
                $order = $columns[$request->input('order.0.column', 'id')];
                $dir = $request->input('order.0.dir', 'asc');

                if (!empty($request->input('search.value'))) {
                    $rankingFiltered = array_filter($ranking, function ($item) use ($request) {
                        $searchLower = strtolower($request->input('search.value'));

                        return (
                            strpos(strtolower($item['nama']), $searchLower) !== false ||
                            strpos(strtolower($item['jenis_kelamin']), $searchLower) !== false ||
                            strpos(strtolower($item['alamat']), $searchLower) !== false ||
                            strpos(strtolower($item['kategori_risiko']), $searchLower) !== false ||
                            strpos($item['usia'], $searchLower) !== false
                        );
                    });

                    $rankingFiltered = array_values($rankingFiltered);
                    $totalFiltered = count($rankingFiltered);
                } else {
                    $rankingFiltered = $ranking;
                }

                $ranking_paginated = array_slice($rankingFiltered, $start, $limit);

                // Data untuk debugging dan analisis
                $debug_info = [
                    'total_data' => count($ranking),
                    'kriteria_used' => $kriteria->toArray(),
                    'ideal_plus' => $idealPlus,
                    'ideal_minus' => $idealMinus,
                    'statistik_risiko' => [
                        'risiko_tinggi' => count(array_filter($ranking, fn($r) => $r['kategori_risiko'] === 'Risiko Tinggi')),
                        'risiko_sedang' => count(array_filter($ranking, fn($r) => $r['kategori_risiko'] === 'Risiko Sedang')),
                        'risiko_rendah' => count(array_filter($ranking, fn($r) => $r['kategori_risiko'] === 'Risiko Rendah')),
                        'normal' => count(array_filter($ranking, fn($r) => $r['kategori_risiko'] === 'Normal')),
                    ],
                    'range_nilai_topsis' => [
                        'max' => count($ranking) > 0 ? max(array_column($ranking, 'nilai_topsis')) : 0,
                        'min' => count($ranking) > 0 ? min(array_column($ranking, 'nilai_topsis')) : 0,
                        'rata_rata' => count($ranking) > 0 ? round(array_sum(array_column($ranking, 'nilai_topsis')) / count($ranking), 4) : 0
                    ]
                ];

            } catch (Exception $e) {
                Log::error('Error in perankingan function: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());

                // FIX: Return proper JSON error response
                return response()->json([
                    'error' => true,
                    'message' => 'Terjadi kesalahan dalam perhitungan ranking: ' . $e->getMessage()
                ], 500);
            }

            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                'data' => $ranking_paginated,
                'debuging' => $debug_info
            ]);
        }

        return view('admin.posyandu.perankingan-risiko');
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
    private function kategoriRisikoStunting($nilaiTopsis, $data)
    {
        $zscoreTB = $data['zscore_tb_u'];

        // Prioritas utama: Standar WHO berdasarkan Z-score TB/U
        // if ($zscoreTB < -3) {
        //     return 'Risiko Sangat Tinggi'; // Severe stunting
        // } elseif ($zscoreTB < -2) {
        //     return 'Risiko Tinggi'; // Stunting
        // } elseif ($zscoreTB < -1) {
        //     return 'Risiko Sedang'; // At risk
        // } else {
        //     // Untuk kategori normal, gunakan nilai TOPSIS sebagai pembeda
        //     if ($nilaiTopsis >= 0.7) {
        //         return 'Normal'; // Kondisi sangat baik
        //     } elseif ($nilaiTopsis >= 0.5) {
        //         return 'Risiko Rendah'; // Kondisi baik
        //     } else {
        //         return 'Risiko Sedang'; // Perlu perhatian
        //     }
        // }

        if ($nilaiTopsis < 0.29) {
            return 'Gizi buruk/stunting';
        } else if ($nilaiTopsis > 0.6) {
            return 'Gizi lebih/obesitas';
        } else {
            return 'Gizi baik/normal';
        }
    }
}
