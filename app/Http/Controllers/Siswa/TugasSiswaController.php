<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\NilaiTugasSiswa;
use App\Models\UploadTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = auth()->user()->siswa; // relasi ke model Siswa

        // Ambil semua tugas untuk kelas siswa, type "tugas"
        $tugas = UploadTugas::with('mapel', 'guru')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('type', 'tugas')
            ->orderByDesc('deadline')
            ->get();

        // Ambil daftar mata pelajaran unik dari tugas
        $mapels = $tugas->pluck('mapel')->unique('id');

        // Ambil semua tugas yang sudah dikumpulkan siswa ini
        $jawabanTerkirim = \DB::table('siswa_tugas')
            ->where('siswa_id', $siswa->siswa_id) // pakai primary key yang benar
            ->pluck('tugas_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        return view('siswa.tugas', compact('tugas', 'mapels', 'jawabanTerkirim'));
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
        $validated = $request->validate([
            'tugas_id' => 'required|exists:tugas_guru,id',
            'file_jawaban' => 'nullable|file|mimes:pdf,docx,zip|max:2048',
            'jawaban_teks' => 'nullable|string',
        ]);

        $filePath = null;

        if ($request->hasFile('file_jawaban')) {
            $filePath = $request->file('file_jawaban')->store('jawaban_tugas', 'public');
        }

        NilaiTugasSiswa::updateOrCreate(
            [
                'siswa_id' => auth()->user()->siswa->siswa_id,
                'tugas_id' => $validated['tugas_id'],
            ],
            [
                'file_jawaban' => $filePath,
                'jawaban_teks' => $validated['jawaban_teks'],
                'tanggal_pengumpulan' => now(),
                'status' => 'dikumpulkan',
            ]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dikumpulkan.',
            ]);
        }

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

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
