<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduPemeriksaanStoreRequest;
use App\Models\PosyanduPemeriksaan;
use Illuminate\Http\Request;

class PosyanduPemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PosyanduPemeriksaanStoreRequest $request)
    {
        $posyanduPemeriksaan = PosyanduPemeriksaan::create($request->validated());

        return response()->json([
            'no' => $posyanduPemeriksaan->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosyanduPemeriksaan  $posyanduPemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function show(PosyanduPemeriksaan $posyanduPemeriksaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PosyanduPemeriksaan  $posyanduPemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function edit(PosyanduPemeriksaan $posyanduPemeriksaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PosyanduPemeriksaan  $posyanduPemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosyanduPemeriksaan $posyanduPemeriksaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PosyanduPemeriksaan  $posyanduPemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemeriksaan = PosyanduPemeriksaan::find($id);

        $pemeriksaan->delete();

        return response()->json(['success' => true]);
    }
}
