<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\PengurusWilayah;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengurusWilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengurus = PengurusWilayah::with('penduduk', 'user')->paginate(25);
        return view('admin.pengurus_wilayah.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if ($request->has('q')) {
            // Ini dipakai untuk pencarian AJAX dari Select2
            $search = $request->q;

            $penduduk = Penduduk::where('tanggal_lahir', '<=', Carbon::now()->subYears(17)->toDateString())
                ->where('nama', 'like', '%' . $search . '%')
                ->where('keterangan', '!=', 'Meninggal')
                ->whereDoesntHave(relation: 'pengurus')
                ->select('id', 'nama')
                ->limit(10)
                ->get();

            return response()->json($penduduk);
        }

        $penduduk = Penduduk::where('tanggal_lahir', '<=', Carbon::now()->subYears(17)->toDateString())
            ->where('keterangan', '!=', 'Meninggal')
            ->whereDoesntHave(relation: 'pengurus')
            ->get();

        return view('admin.pengurus_wilayah.create', compact('penduduk'));
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
            'email' => 'required|unique:users,email|email',
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan' => 'required',
            'rt' => 'nullable|integer',
            'rw' => 'nullable|integer',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'name' => Penduduk::findOrFail($request->input('penduduk_id'))->nama,
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => now(),
        ]);

        if ($request->hasFile(key: 'foto')) {
            $file = $request->file('foto');
            $fileName = 'ttd_' . $user->name . '.' . $file->getClientOriginalExtension();
            $path = 'assets/img/ttd/';
            $file = $file->move($path, $fileName);
        } else if (!empty($request->input('signature'))) {
            $signature = $request->input('signature');
            $signature = str_replace('data:image/png;base64,', '', $signature);
            $signature = str_replace(' ', '+', $signature);

            $imageData = base64_decode($signature);

            $fileName = 'ttd_' . $user->name . '.png';
            $filePath = public_path('assets/img/ttd_pengurus/' . $fileName);
            file_put_contents($filePath, $imageData);
        }

        $user->assignRole($request->input('jabatan'));

        PengurusWilayah::create([
            'penduduk_id' => $request->input('penduduk_id'),
            'user_id' => $user->id,
            'jabatan' => $request->input('jabatan'),
            'wilayah_rt' => $request->input('rt') ?? null,
            'wilayah_rw' => $request->input('rw') ?? null,
            'ttd_path' => $fileName ?? null
        ]);

        return redirect()->route('pengurus-wilayah.index')
            ->with('success', 'Pengurus berhasil ditambahkan');
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
    public function edit($id)
    {
        //
        $pengurus = PengurusWilayah::with('penduduk', 'user')->findOrFail($id);
        return view('admin.pengurus_wilayah.edit', compact('pengurus'));
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
        //
        $pengurus = PengurusWilayah::findOrFail($id);
        $user = User::findOrFail($pengurus->user_id);

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan' => 'required',
            'rt' => 'nullable|integer',
            'rw' => 'nullable|integer',
            'password' => 'nullable|min:8|confirmed'
        ]);

        $dataUser = [
            'email' => $request->input('email'),
            'name' => Penduduk::findOrFail($request->input('penduduk_id'))->nama,
            'email_verified_at' => now(),
        ];

        if ($request->filled('password')) {
            $dataUser['password'] = Hash::make($request->input('password'));
        }

        $user->update(attributes: $dataUser);

        // replace role
        $user->syncRoles([$request->input('jabatan')]);

        if ($request->hasFile(key: 'foto')) {
            // hapus file
            $filePath = public_path('assets/img/ttd_pengurus/' . $pengurus->ttd_path);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $file = $request->file('foto');
            $fileName = 'ttd_' . $user->name . '.' . $file->getClientOriginalExtension();
            $path = 'assets/img/ttd_pengurus/';
            $file = $file->move($path, $fileName);
        }

        $pengurus->update([
            'penduduk_id' => $request->input('penduduk_id'),
            'user_id' => $user->id,
            'jabatan' => $request->input('jabatan'),
            'wilayah_rt' => $request->input('rt') ?? null,
            'wilayah_rw' => $request->input('rw') ?? null,
            'ttd_path' => $fileName ?? $pengurus->ttd_path
        ]);

        return redirect()->route('pengurus-wilayah.index')
            ->with('success', 'Pengurus berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengurus = PengurusWilayah::findOrFail($id);
        $user = User::findOrFail($pengurus->user_id);

        $filePath = public_path('assets/img/ttd_pengurus/' . $pengurus->ttd_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $pengurus->delete();
        $user->delete();
        return redirect()->route('pengurus-wilayah.index')
            ->with('success', 'Pengurus berhasil dihapus');
    }
}
