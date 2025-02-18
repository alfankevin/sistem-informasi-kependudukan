<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Agenda;
use App\Models\Organisasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $cacheKey = 'dashboard_query';
        // $durationInMinutes = 1440;

        $data = Cache::remember($cacheKey, 300, function () {
            $countPenduduk = Penduduk::where('keterangan', 'Hidup')->count();
            $countL = Penduduk::where('jenis_kelamin', 'L')->where('keterangan', 'Hidup')->count();
            $countP = Penduduk::where('jenis_kelamin', 'P')->where('keterangan', 'Hidup')->count();
            $countKK = Penduduk::where('status_keluarga', true)->where('keterangan', 'Hidup')->count();

            $agenda = Agenda::orderByDesc('id')->get()->map(function ($item) {
                $item->tanggal_agenda = date('d-m-Y', strtotime($item->tanggal_agenda));
                return $item;
            });
            $organisasi = Organisasi::orderByDesc('id')->get();
            $countSosial = Penduduk::where('id_sosial', '<>', '1')->count();

            $pekerjaan = DB::table('penduduk')
                ->select('pekerjaan', DB::raw('count(*) as total'))
                ->where('pekerjaan', 'NOT LIKE', '%tidak%')
                ->where('pekerjaan', 'NOT LIKE', '%belum%')
                ->where('pekerjaan', 'NOT LIKE', '%bekerja%')
                ->where('pekerjaan', 'NOT LIKE', '%pelajar%')
                ->where('pekerjaan', 'NOT LIKE', '%mahasiswa%')
                ->where('pekerjaan', 'NOT LIKE', '%pensiunan%')
                ->where('pekerjaan', 'NOT LIKE', '%purnawirawan%')
                ->where('keterangan', 'Hidup')
                ->groupBy('pekerjaan')
                ->get();

            $darah = DB::table('penduduk')
                ->select(
                    DB::raw('CASE
                            WHEN golongan_darah = "A+" THEN "A"
                            WHEN golongan_darah = "B+" THEN "B"
                            WHEN golongan_darah = "Ab" THEN "AB"
                            WHEN golongan_darah = "O+" THEN "O"
                            ELSE golongan_darah
                        END AS golongan_darah'),
                    DB::raw('COUNT(*) AS total')
                )
                ->where('golongan_darah', '<>', '-')
                ->where('keterangan', 'Hidup')
                ->groupBy(
                    DB::raw('CASE
                            WHEN golongan_darah = "A+" THEN "A"
                            WHEN golongan_darah = "B+" THEN "B"
                            WHEN golongan_darah = "Ab" THEN "AB"
                            WHEN golongan_darah = "O+" THEN "O"
                            ELSE golongan_darah
                        END')
                )
                ->get();

            $agama = DB::table('penduduk')
                ->select('agama', DB::raw('count(*) as total'))
                ->where('keterangan', 'Hidup')
                ->groupBy('agama')
                ->get();

            $query = "
                SELECT kartu_keluarga.rt, 
                    COUNT(penduduk.id) AS jumlah, 
                    (COUNT(penduduk.id) / total.total_penduduk) * 300 AS persen
                FROM penduduk
                JOIN kartu_keluarga ON penduduk.no_kk = kartu_keluarga.no_kk
                JOIN (SELECT COUNT(*) AS total_penduduk FROM penduduk WHERE keterangan = 'Hidup') AS total
                ON 1 = 1
                WHERE penduduk.keterangan = 'Hidup'
                GROUP BY kartu_keluarga.rt, total.total_penduduk;
            ";

            $labelPekerjaan = $pekerjaan->pluck('pekerjaan');
            $dataPekerjaan = $pekerjaan->pluck('total');
            $labelDarah = $darah->where('golongan_darah', '<>', '-')->pluck('golongan_darah');
            $dataDarah = $darah->pluck('total');
            $labelAgama = $agama->pluck('agama');
            $dataAgama = $agama->pluck('total');

            $results = DB::select(DB::raw($query));
            $jumlahRt1 = collect($results)->where('rt', 1)->pluck('jumlah')->first();
            $jumlahRt2 = collect($results)->where('rt', 2)->pluck('jumlah')->first();
            $jumlahRt3 = collect($results)->where('rt', 3)->pluck('jumlah')->first();
            $jumlahRt4 = collect($results)->where('rt', 4)->pluck('jumlah')->first();
            $jumlahRt5 = collect($results)->where('rt', 5)->pluck('jumlah')->first();
            $persenRt1 = collect($results)->where('rt', 1)->pluck('persen')->first();
            $persenRt2 = collect($results)->where('rt', 2)->pluck('persen')->first();
            $persenRt3 = collect($results)->where('rt', 3)->pluck('persen')->first();
            $persenRt4 = collect($results)->where('rt', 4)->pluck('persen')->first();
            $persenRt5 = collect($results)->where('rt', 5)->pluck('persen')->first();

            $umurL = Penduduk::select(DB::raw('CASE
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 0 AND 5 THEN "0-5"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 6 AND 10 THEN "06-10"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 11 AND 15 THEN "11-15"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 16 AND 20 THEN "16-20"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 21 AND 25 THEN "21-25"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 26 AND 30 THEN "26-30"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 31 AND 35 THEN "31-35"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 36 AND 40 THEN "36-40"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 41 AND 45 THEN "41-45"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 46 AND 50 THEN "46-50"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 51 AND 55 THEN "51-55"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 56 AND 60 THEN "56-60"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 61 AND 65 THEN "61-65"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 66 AND 70 THEN "66-70"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 71 AND 75 THEN "71-75"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 76 AND 80 THEN "76-80"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 81 AND 85 THEN "81-85"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 86 AND 90 THEN "86-90"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 91 AND 95 THEN "91-95"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 96 AND 100 THEN "96-100"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) >100 THEN "100+"
                    END AS age_group, COUNT(*) as total'))
                ->groupBy('age_group')
                ->where('jenis_kelamin', 'L')
                ->where('keterangan', 'Hidup')
                ->orderBy('age_group', 'asc')
                ->get();

            $umurP = Penduduk::select(DB::raw('CASE
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 0 AND 5 THEN "0-5"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 6 AND 10 THEN "06-10"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 11 AND 15 THEN "11-15"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 16 AND 20 THEN "16-20"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 21 AND 25 THEN "21-25"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 26 AND 30 THEN "26-30"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 31 AND 35 THEN "31-35"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 36 AND 40 THEN "36-40"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 41 AND 45 THEN "41-45"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 46 AND 50 THEN "46-50"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 51 AND 55 THEN "51-55"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 56 AND 60 THEN "56-60"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 61 AND 65 THEN "61-65"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 66 AND 70 THEN "66-70"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 71 AND 75 THEN "71-75"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 76 AND 80 THEN "76-80"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 81 AND 85 THEN "81-85"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 86 AND 90 THEN "86-90"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 91 AND 95 THEN "91-95"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) BETWEEN 96 AND 100 THEN "96-100"
                WHEN FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) >100 THEN "100+"
                END AS age_group, COUNT(*) as total'))
                ->groupBy('age_group')
                ->where('jenis_kelamin', 'P')
                ->where('keterangan', 'Hidup')
                ->orderBy('age_group', 'asc')
                ->get();

            $labelUmurL = $umurL->pluck('age_group');
            $dataUmurL = $umurL->pluck('total');
            $labelUmurP = $umurP->pluck('age_group');
            $dataUmurP = $umurP->pluck('total');

            return [
                'countPenduduk' => $countPenduduk,
                'countL' => $countL,
                'countP' => $countP,
                'countKK' => $countKK,
                'agenda' => $agenda,
                'organisasi' => $organisasi,
                'countSosial' => $countSosial,
                'labelPekerjaan' => $labelPekerjaan,
                'dataPekerjaan' => $dataPekerjaan,
                'labelDarah' => $labelDarah,
                'labelAgama' => $labelAgama,
                'dataDarah' => $dataDarah,
                'dataAgama' => $dataAgama,
                'jumlahRt1' => $jumlahRt1,
                'jumlahRt2' => $jumlahRt2,
                'jumlahRt3' => $jumlahRt3,
                'jumlahRt4' => $jumlahRt4,
                'jumlahRt5' => $jumlahRt5,
                'persenRt1' => $persenRt1,
                'persenRt2' => $persenRt2,
                'persenRt3' => $persenRt3,
                'persenRt4' => $persenRt4,
                'persenRt5' => $persenRt5,
                'dataUmurL' => $dataUmurL,
                'dataUmurP' => $dataUmurP,
                'labelUmurL' => $labelUmurL,
                'labelUmurP' => $labelUmurP,
            ];
        });

        $countPenduduk = $data['countPenduduk'];
        $countL = $data['countL'];
        $countP = $data['countP'];
        $countKK = $data['countKK'];
        $agenda = $data['agenda'];
        $organisasi = $data['organisasi'];
        $countSosial = $data['countSosial'];
        $labelPekerjaan = $data['labelPekerjaan'];
        $dataPekerjaan = $data['dataPekerjaan'];
        $labelDarah = $data['labelDarah'];
        $labelAgama = $data['labelAgama'];
        $dataDarah = $data['dataDarah'];
        $dataAgama = $data['dataAgama'];
        $jumlahRt1 = $data['jumlahRt1'];
        $jumlahRt2 = $data['jumlahRt2'];
        $jumlahRt3 = $data['jumlahRt3'];
        $jumlahRt4 = $data['jumlahRt4'];
        $jumlahRt5 = $data['jumlahRt5'];
        $persenRt1 = $data['persenRt1'];
        $persenRt2 = $data['persenRt2'];
        $persenRt3 = $data['persenRt3'];
        $persenRt4 = $data['persenRt4'];
        $persenRt5 = $data['persenRt5'];
        $dataUmurL = $data['dataUmurL'];
        $dataUmurP = $data['dataUmurP'];
        $labelUmurL = $data['labelUmurL'];
        $labelUmurP = $data['labelUmurP'];

        return view('admin.home', compact('agenda', 'organisasi', 'countSosial', 'countPenduduk', 'countL', 'countP', 'countKK', 'labelPekerjaan', 'dataPekerjaan', 'labelDarah', 'dataDarah', 'labelAgama', 'dataAgama', 'labelUmurL', 'dataUmurL', 'labelUmurP', 'dataUmurP', 'jumlahRt1', 'jumlahRt2', 'jumlahRt3', 'jumlahRt4', 'jumlahRt5', 'persenRt1', 'persenRt2', 'persenRt3', 'persenRt4', 'persenRt5'));
    }
}
