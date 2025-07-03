<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();

        return view('admin.home', [
            'agenda' => $data['agenda'],
            'organisasi' => $data['organisasi'],
            'countSosial' => $data['countSosial'],
            'countPenduduk' => $data['countPenduduk'],
            'countL' => $data['countL'],
            'countP' => $data['countP'],
            'countKK' => $data['countKK'],
            'labelPekerjaan' => $data['labelPekerjaan'],
            'dataPekerjaan' => $data['dataPekerjaan'],
            'labelDarah' => $data['labelDarah'],
            'dataDarah' => $data['dataDarah'],
            'labelAgama' => $data['labelAgama'],
            'dataAgama' => $data['dataAgama'],
            'labelUmurL' => $data['labelUmurL'],
            'dataUmurL' => $data['dataUmurL'],
            'labelUmurP' => $data['labelUmurP'],
            'dataUmurP' => $data['dataUmurP'],
            'jumlahRt1' => $data['jumlahRt1'],
            'jumlahRt2' => $data['jumlahRt2'],
            'jumlahRt3' => $data['jumlahRt3'],
            'jumlahRt4' => $data['jumlahRt4'],
            'jumlahRt5' => $data['jumlahRt5'],
            'persenRt1' => $data['persenRt1'],
            'persenRt2' => $data['persenRt2'],
            'persenRt3' => $data['persenRt3'],
            'persenRt4' => $data['persenRt4'],
            'persenRt5' => $data['persenRt5'],
            'dataStunting' => $data['dataStunting'],
            'labelStunting' => $data['labelStunting'],
            'stuntingPerMonth' => $data['stuntingPerMonth'],
            'stuntingByAgeLabels' => $data['stuntingByAgeLabels'],
            'stuntingByAgeData' => $data['stuntingByAgeData'],
        ]);
    }

    public function getStuntingChartData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $data = $this->dashboardService->getStuntingPerMonth($year);

        return response()->json([
            'months' => $data->pluck('month'),
            'totals' => $data->pluck('total'),
            'years' => range(2024, date('Y'))
        ]);
    }
}
