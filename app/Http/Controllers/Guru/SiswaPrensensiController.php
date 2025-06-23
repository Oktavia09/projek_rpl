<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\PresensiSiswa;
// use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;

class SiswaPrensensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = MataPelajaran::all();
        return view('guru.PresensiSiswa.presensi', compact('mapel'));
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
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $siswa = Siswa::where('kelas', $request->kelas)->get();

        if ($siswa->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa ditemukan untuk kelas ini.');
        }

        foreach ($siswa as $s) {
            PresensiSiswa::firstOrCreate(
                [
                    'siswa_id' => $s->siswa_id, // pastikan primaryKey sudah diatur
                    'mapel_id' => $request->mapel_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'guru_id' => Auth::id(),
                    'status' => null,
                    'keterangan' => null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Presensi berhasil dibuka untuk siswa.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
