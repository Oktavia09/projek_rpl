<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
class KelasSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('admin.KelasSiswa.kelas', compact('siswa', 'kelas'));
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
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = Siswa::findOrFail($id);
        $kelasBaru = Kelas::findOrFail($request->kelas_id);
        $kelasLama = $siswa->kelas_id ? Kelas::find($siswa->kelas_id) : null;

        // Cek apakah kelas baru masih punya kuota
        if ($kelasBaru->kuota <= 0) {
            return back()->with('error', 'Kelas ' . $kelasBaru->nama . ' sudah penuh.');
        }

        // Update kuota kelas lama (jika ada)
        if ($kelasLama && $kelasLama->id != $kelasBaru->id) {
            $kelasLama->kuota += 1;
            $kelasLama->save();
        }

        // Kurangi kuota kelas baru
        if ($kelasBaru->id != $siswa->kelas_id) {
            $kelasBaru->kuota -= 1;
            $kelasBaru->save();
        }

        // Update kelas siswa
        $siswa->kelas_id = $kelasBaru->id;
        $siswa->save();

        return back()->with('success', 'Kelas siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
