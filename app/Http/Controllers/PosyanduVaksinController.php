<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduVaksinStoreRequest;
use App\Http\Requests\PosyanduVaksinUpdateRequest;
use App\Models\PosyanduVaksin;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class PosyanduVaksinController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posyanduVaksins = PosyanduVaksin::all();

        return view('posyanduVaksin.index', compact('posyanduVaksins'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('posyanduVaksin.create');
    }

    /**
     * @param \App\Http\Requests\PosyanduVaksinStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PosyanduVaksinStoreRequest $request)
    {
        $posyanduVaksin = PosyanduVaksin::create($request->validated());

        Posyandu::where('id', $request->posyandu_id)->update(['status_vaksin' => 1]);

        return response()->json([
            'no' => $posyanduVaksin->id,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PosyanduVaksin $posyanduVaksin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PosyanduVaksin $posyanduVaksin)
    {
        return view('posyanduVaksin.show', compact('posyanduVaksin'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PosyanduVaksin $posyanduVaksin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PosyanduVaksin $posyanduVaksin)
    {
        return view('posyanduVaksin.edit', compact('posyanduVaksin'));
    }

    /**
     * @param \App\Http\Requests\PosyanduVaksinUpdateRequest $request
     * @param \App\Models\PosyanduVaksin $posyanduVaksin
     * @return \Illuminate\Http\Response
     */
    public function update(PosyanduVaksinUpdateRequest $request, PosyanduVaksin $posyanduVaksin)
    {
        $posyanduVaksin->update($request->validated());

        $request->session()->flash('posyanduVaksin.id', $posyanduVaksin->id);

        return redirect()->route('posyanduVaksin.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PosyanduVaksin $posyanduVaksin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vaksin = PosyanduVaksin::find($id);

        $vaksin->delete();

        return response()->json(['success' => true]);
    }
}
