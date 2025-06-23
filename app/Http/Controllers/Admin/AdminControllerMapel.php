<?php

namespace App\Http\Controllers\Admin;
use App\models\MataPelajaran;
use App\models\Kelas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminControllerMapel extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(["auth", "role:admin"]);
    }
    public function index()
    {
        $mapel = MataPelajaran::with('kelas')->get();
        $kelas = Kelas::all();
        return view('admin.mapel.AdminMapel', compact('mapel', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:mata_pelajaran,kode',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        try {
            MataPelajaran::create([
                'nama' => $request->nama,
                'kode' => $request->kode,
                'kelas_id' => $request->kelas_id,
            ]);

            return redirect()->back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan mata pelajaran: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:mata_pelajaran,kode,' . $mapel->id,
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $mapel->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        MataPelajaran::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
