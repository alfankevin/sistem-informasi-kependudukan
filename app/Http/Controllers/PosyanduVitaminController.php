<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduVitaminStoreRequest;
use App\Http\Requests\PosyanduVitaminUpdateRequest;
use App\Models\PosyanduVitamin;
use Illuminate\Http\Request;

class PosyanduVitaminController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posyanduVitamins = PosyanduVitamin::all();

        return view('posyanduVitamin.index', compact('posyanduVitamins'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('posyanduVitamin.create');
    }

    /**
     * @param \App\Http\Requests\PosyanduVitaminStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PosyanduVitaminStoreRequest $request)
    {
        $posyanduVitamin = PosyanduVitamin::create($request->validated());

        return response()->json([
            'no' => $posyanduVitamin->id,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PosyanduVitamin $posyanduVitamin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PosyanduVitamin $posyanduVitamin)
    {
        return view('posyanduVitamin.show', compact('posyanduVitamin'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PosyanduVitamin $posyanduVitamin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PosyanduVitamin $posyanduVitamin)
    {
        return view('posyanduVitamin.edit', compact('posyanduVitamin'));
    }

    /**
     * @param \App\Http\Requests\PosyanduVitaminUpdateRequest $request
     * @param \App\Models\PosyanduVitamin $posyanduVitamin
     * @return \Illuminate\Http\Response
     */
    public function update(PosyanduVitaminUpdateRequest $request, PosyanduVitamin $posyanduVitamin)
    {
        $posyanduVitamin->update($request->validated());

        $request->session()->flash('posyanduVitamin.id', $posyanduVitamin->id);

        return redirect()->route('posyanduVitamin.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PosyanduVitamin $posyanduVitamin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vitamin = PosyanduVitamin::find($id);

        $vitamin->delete();

        return response()->json(['success' => true]);
    }
}
