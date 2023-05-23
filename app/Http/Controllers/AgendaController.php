<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.agenda.index')->with([
            'agenda' => Agenda::paginate(10),
        ]);
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul_agenda'=>'required',
            'tanggal_agenda'=>'required',
            'deskripsi_agenda'=>'required',
            'gambar_agenda'=>'required',
        ]);

        Agenda::find($id)->update($request->all());

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
}
