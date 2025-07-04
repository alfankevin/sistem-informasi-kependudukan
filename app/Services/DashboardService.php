<?php

namespace App\Services;

use App\Models\Penduduk;
use App\Models\Agenda;
use App\Models\Organisasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function getDashboardData($year = null)
    {
        $cacheKey = 'dashboard_query';

        $stuntingPerMonth = Cache::remember("dashboard_year_data_{$year}", 300, function () use ($year) {
            return [
                'stuntingPerMonth' => $this->getStuntingPerMonth($year),
            ];
        });

        $data = Cache::remember($cacheKey, 300, function () {
            return [
                'countPenduduk' => $this->getCountPenduduk(),
                'countL' => $this->getCountL(),
                'countP' => $this->getCountP(),
                'countKK' => $this->getCountKK(),
                'agenda' => $this->getAgenda(),
                'organisasi' => $this->getOrganisasi(),
                'countSosial' => $this->getCountSosial(),
                'labelPekerjaan' => $this->getPekerjaanLabels(),
                'dataPekerjaan' => $this->getPekerjaanData(),
                'labelDarah' => $this->getDarahLabels(),
                'labelAgama' => $this->getAgamaLabels(),
                'dataDarah' => $this->getDarahData(),
                'dataAgama' => $this->getAgamaData(),
                'jumlahRt1' => $this->getJumlahRt(1),
                'jumlahRt2' => $this->getJumlahRt(2),
                'jumlahRt3' => $this->getJumlahRt(3),
                'jumlahRt4' => $this->getJumlahRt(4),
                'jumlahRt5' => $this->getJumlahRt(5),
                'persenRt1' => $this->getPersenRt(1),
                'persenRt2' => $this->getPersenRt(2),
                'persenRt3' => $this->getPersenRt(3),
                'persenRt4' => $this->getPersenRt(4),
                'persenRt5' => $this->getPersenRt(5),
                'dataUmurL' => $this->getDataUmurL(),
                'dataUmurP' => $this->getDataUmurP(),
                'labelUmurL' => $this->getLabelUmurL(),
                'labelUmurP' => $this->getLabelUmurP(),
                'dataStunting' => $this->getStuntingData(),
                'labelStunting' => $this->getStuntingLabels(),
                'stuntingByAgeLabels' => $this->getStuntingAgeLabels(),
                'stuntingByAgeData' => $this->getStuntingAgeData(),
            ];
        });

        return array_merge($data, $stuntingPerMonth);
    }

    public function getStatistikData()
    {
        $cacheKey = 'statistik_query';

        return Cache::remember($cacheKey, 300, function () {
            return [
                'labelPekerjaan' => $this->getPekerjaanLabels(),
                'dataPekerjaan' => $this->getPekerjaanData(),
                'labelDarah' => $this->getDarahLabels(),
                'labelAgama' => $this->getAgamaLabels(),
                'dataDarah' => $this->getDarahData(),
                'dataAgama' => $this->getAgamaData(),
                'dataUmurL' => $this->getDataUmurL(),
                'dataUmurP' => $this->getDataUmurP(),
                'labelUmurL' => $this->getLabelUmurL(),
                'labelUmurP' => $this->getLabelUmurP(),
                'dataStunting' => $this->getStuntingData(),
                'labelStunting' => $this->getStuntingLabels(),
            ];
        });
    }

    private function getCountPenduduk()
    {
        return Penduduk::where('keterangan', 'Hidup')->count();
    }

    private function getCountL()
    {
        return Penduduk::where('jenis_kelamin', 'L')->where('keterangan', 'Hidup')->count();
    }

    private function getCountP()
    {
        return Penduduk::where('jenis_kelamin', 'P')->where('keterangan', 'Hidup')->count();
    }

    private function getCountKK()
    {
        return Penduduk::where('status_keluarga', true)->where('keterangan', 'Hidup')->count();
    }

    private function getAgenda()
    {
        return Agenda::orderByDesc('id')->get()->map(function ($item) {
            $item->tanggal_agenda = date('d-m-Y', strtotime($item->tanggal_agenda));
            return $item;
        });
    }

    private function getOrganisasi()
    {
        return Organisasi::orderByDesc('id')->get();
    }

    private function getCountSosial()
    {
        return Penduduk::where('id_sosial', '<>', '1')->count();
    }

    private function getPekerjaanData()
    {
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

        return $pekerjaan->pluck('total');
    }

    private function getPekerjaanLabels()
    {
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

        return $pekerjaan->pluck('pekerjaan');
    }

    private function getDarahData()
    {
        $darah = $this->getDarahQuery();
        return $darah->pluck('total');
    }

    private function getDarahLabels()
    {
        $darah = $this->getDarahQuery();
        return $darah->where('golongan_darah', '<>', '-')->pluck('golongan_darah');
    }

    private function getDarahQuery()
    {
        return DB::table('penduduk')
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
    }

    private function getAgamaData()
    {
        $agama = $this->getAgamaQuery();
        return $agama->pluck('total');
    }

    private function getAgamaLabels()
    {
        $agama = $this->getAgamaQuery();
        return $agama->pluck('agama');
    }

    private function getAgamaQuery()
    {
        return DB::table('penduduk')
            ->select('agama', DB::raw('count(*) as total'))
            ->where('keterangan', 'Hidup')
            ->groupBy('agama')
            ->get();
    }

    private function getRtResults()
    {
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

        return DB::select(DB::raw($query));
    }

    private function getJumlahRt($rt)
    {
        $results = $this->getRtResults();
        return collect($results)->where('rt', $rt)->pluck('jumlah')->first();
    }

    private function getPersenRt($rt)
    {
        $results = $this->getRtResults();
        return collect($results)->where('rt', $rt)->pluck('persen')->first();
    }

    private function getDataUmurL()
    {
        $umurL = $this->getUmurQuery('L');
        return $umurL->pluck('total');
    }

    private function getDataUmurP()
    {
        $umurP = $this->getUmurQuery('P');
        return $umurP->pluck('total');
    }

    private function getLabelUmurL()
    {
        $umurL = $this->getUmurQuery('L');
        return $umurL->pluck('age_group');
    }

    private function getLabelUmurP()
    {
        $umurP = $this->getUmurQuery('P');
        return $umurP->pluck('age_group');
    }

    private function getUmurQuery($gender)
    {
        return Penduduk::select(DB::raw('CASE
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
            ->where('jenis_kelamin', $gender)
            ->where('keterangan', 'Hidup')
            ->orderBy('age_group', 'asc')
            ->get();
    }

    private function getStuntingData()
    {
        $stunting = $this->getStuntingQuery();
        return $stunting->pluck('total');
    }

    private function getStuntingLabels()
    {
        $stunting = $this->getStuntingQuery();
        return $stunting->pluck('kategori');
    }

    private function getStuntingQuery()
    {
        return DB::table('stuntings')
            ->select('kategori', DB::raw('COUNT(*) AS total'))
            ->groupBy('kategori')
            ->get();
    }

    public function getStuntingPerMonth($year = null)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $currentYear = $year ?: date('Y');

        $query = DB::table('stuntings')
            ->join('posyandu', 'stuntings.posyandu_id', '=', 'posyandu.id')
            ->select(
            DB::raw('MONTH(posyandu.updated_at) as month_number'),
            DB::raw('COUNT(*) as total')
            )
            ->where('stuntings.kategori', 'Gizi buruk/stunting')
            ->whereYear('posyandu.updated_at', $currentYear)
            ->groupBy('month_number')
            ->pluck('total', 'month_number');

        $result = collect();

        foreach ($months as $monthNumber => $monthName) {
            $result->push([
            'month' => $monthName,
            'month_number' => $monthNumber,
            'total' => $query->get($monthNumber, 0),
            'year' => $currentYear
            ]);
        }

        return $result;
    }

    public function getStuntingByAge()
    {
        return DB::table('stuntings')
            ->join('posyandu', 'stuntings.posyandu_id', '=', 'posyandu.id')
            ->select(
                DB::raw('CASE
                    WHEN posyandu.usia BETWEEN 0 AND 12 THEN "0-12 bulan"
                    WHEN posyandu.usia BETWEEN 13 AND 24 THEN "13-24 bulan"
                    WHEN posyandu.usia BETWEEN 25 AND 36 THEN "25-36 bulan"
                    WHEN posyandu.usia BETWEEN 37 AND 48 THEN "37-48 bulan"
                    WHEN posyandu.usia BETWEEN 49 AND 60 THEN "49-60 bulan"
                    WHEN posyandu.usia > 60 THEN "Diatas 60 bulan"
                END AS age_group'),
                DB::raw('COUNT(*) as total')
            )
            ->where('stuntings.kategori', 'Gizi buruk/stunting')
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();

        // return DB::table('stuntings')
        //     ->join('posyandu', 'stuntings.posyandu_id', '=', 'posyandu.id')
        //     ->join('penduduk', 'posyandu.penduduk_id', '=', 'penduduk.id')
        //     ->select(
        //         DB::raw('CASE
        //             WHEN FLOOR(DATEDIFF(CURRENT_DATE, penduduk.tanggal_lahir) / 365) BETWEEN 0 AND 1 THEN "0-1 tahun"
        //             WHEN FLOOR(DATEDIFF(CURRENT_DATE, penduduk.tanggal_lahir) / 365) BETWEEN 2 AND 3 THEN "2-3 tahun"
        //             WHEN FLOOR(DATEDIFF(CURRENT_DATE, penduduk.tanggal_lahir) / 365) BETWEEN 4 AND 5 THEN "4-5 tahun"
        //             WHEN FLOOR(DATEDIFF(CURRENT_DATE, penduduk.tanggal_lahir) / 365) > 5 THEN "Diatas 5 tahun"
        //         END AS age_group'),
        //         DB::raw('COUNT(*) as total')
        //     )
        //     ->where('stuntings.kategori', 'Gizi buruk/stunting')
        //     ->groupBy('age_group')
        //     ->orderBy('age_group')
        //     ->get();
    }

    public function getStuntingAgeLabels()
    {
        $data = $this->getStuntingByAge();
        return $data->pluck('age_group');
    }

    public function getStuntingAgeData()
    {
        $data = $this->getStuntingByAge();
        return $data->pluck('total');
    }
}
