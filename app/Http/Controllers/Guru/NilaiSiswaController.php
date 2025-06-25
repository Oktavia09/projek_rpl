<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\NilaiTugasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Auth::user()->guru;

        // Ambil semua tugas yang dikumpulkan oleh siswa untuk guru ini
        $nilaiTugas = NilaiTugasSiswa::with(['siswa.kelas', 'tugas.mapel'])
            ->whereHas('tugas', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            })
            ->latest('tanggal_pengumpulan') // urutkan berdasarkan tanggal terbaru
            ->get();

        return view('guru.NilaiSiswa.SiswaNilai', compact('nilaiTugas'));
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
        //
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
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $nilai = NilaiTugasSiswa::findOrFail($id);
        $nilai->update([
            'nilai' => $request->nilai,
            'tanggal_dinilai' => now(),
            'status' => 'dinilai',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil diperbarui',
            'data' => $nilai // Return the updated model
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
