<?php

namespace App\Http\Controllers;

use App\Http\Requests\VitaminStoreRequest;
use App\Http\Requests\VitaminUpdateRequest;
use App\Models\Vitamin;
use Illuminate\Http\Request;

class VitaminController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vitamins = Vitamin::all();

        return view('vitamin.index', compact('vitamins'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('vitamin.create');
    }

    /**
     * @param \App\Http\Requests\VitaminStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VitaminStoreRequest $request)
    {
        $vitamin = Vitamin::create($request->validated());

        $request->session()->flash('vitamin.id', $vitamin->id);

        return redirect()->route('vitamin.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vitamin $vitamin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vitamin $vitamin)
    {
        return view('vitamin.show', compact('vitamin'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vitamin $vitamin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Vitamin $vitamin)
    {
        return view('vitamin.edit', compact('vitamin'));
    }

    /**
     * @param \App\Http\Requests\VitaminUpdateRequest $request
     * @param \App\Models\Vitamin $vitamin
     * @return \Illuminate\Http\Response
     */
    public function update(VitaminUpdateRequest $request, Vitamin $vitamin)
    {
        $vitamin->update($request->validated());

        $request->session()->flash('vitamin.id', $vitamin->id);

        return redirect()->route('vitamin.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vitamin $vitamin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Vitamin $vitamin)
    {
        $vitamin->delete();

        return redirect()->route('vitamin.index');
    }
}
