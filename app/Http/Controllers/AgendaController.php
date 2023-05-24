<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use File;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')) {
            $agenda = Agenda::where('judul_agenda','like','%'.$request->search.'%')->paginate(15);
        } else {
            $agenda = Agenda::all();
            $agenda = Agenda::orderBy('id', 'asc')->paginate(15);
        }

        return view('admin.agenda.index', compact('agenda'));
        with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_agenda'=>'required',
            'tanggal_agenda'=>'required',
            'deskripsi_agenda'=>'required',
            'gambar_agenda'=>'required',
        ]);

        if($request->hasFile('gambar_agenda')) {
            $file = $request->file('gambar_agenda');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/agenda/';
            $file = $file->move($path, $fileName);
        }

        $agenda = new Agenda(array(
            'judul_agenda' => $request->get('judul_agenda'),
            'tanggal_agenda' => $request->get('tanggal_agenda'),
            'deskripsi_agenda' => $request->get('deskripsi_agenda'),
            'gambar_agenda' => $fileName,
        ));

        $agenda->save();

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $agenda = Agenda::find($id);
        return view('admin.agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_agenda'=>'required',
            'tanggal_agenda'=>'required',
            'deskripsi_agenda'=>'required',
        ]);

        $agenda = Agenda::findorfail($id);

        $agenda->update($request->all());

        if($request->hasFile('gambar_agenda')) {

            $destination = 'assets/img/agenda/'.$agenda->gambar_agenda;
            if (file_exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('gambar_agenda');
            $fileName = $file->getClientOriginalName();
            $path = 'assets/img/agenda/';
            $file = $file->move($path, $fileName);
            $agenda->gambar_agenda = $fileName;
        }

        $agenda->update();

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil dihapus');
    }

    public function prioritas($id)
    {
        $row = Agenda::findorfail($id);

        if ($row->prioritas) {
            $row->prioritas = false;
        } else {
            $rowCount = Agenda::where('prioritas', true)->count();
            if ($rowCount >= 3) {
                return response()->json(['message' => 'Hanya 3 agenda yang dapat diprioritaskan'], 422);
            }
            $row->prioritas = true;
        }

        $row->save();

        return response()->json(['message' => 'Agenda berhasil diprioritaskan']);
    }
}
