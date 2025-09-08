<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaksinStoreRequest;
use App\Http\Requests\VaksinUpdateRequest;
use App\Models\Vaksin;
use Illuminate\Http\Request;

class VaksinController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vaksins = Vaksin::all();

        return view('vaksin.index', compact('vaksins'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('vaksin.create');
    }

    /**
     * @param \App\Http\Requests\VaksinStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VaksinStoreRequest $request)
    {
        $vaksin = Vaksin::create($request->validated());

        $request->session()->flash('vaksin.id', $vaksin->id);

        return redirect()->route('vaksin.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vaksin $vaksin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vaksin $vaksin)
    {
        return view('vaksin.show', compact('vaksin'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vaksin $vaksin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Vaksin $vaksin)
    {
        return view('vaksin.edit', compact('vaksin'));
    }

    /**
     * @param \App\Http\Requests\VaksinUpdateRequest $request
     * @param \App\Models\Vaksin $vaksin
     * @return \Illuminate\Http\Response
     */
    public function update(VaksinUpdateRequest $request, Vaksin $vaksin)
    {
        $vaksin->update($request->validated());

        $request->session()->flash('vaksin.id', $vaksin->id);

        return redirect()->route('vaksin.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vaksin $vaksin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Vaksin $vaksin)
    {
        $vaksin->delete();

        return redirect()->route('vaksin.index');
    }
}
