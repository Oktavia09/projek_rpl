<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\kelas;
use App\Models\PresensiSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\UploadTugas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class UploadTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware(["auth", "role:guru"]);
    }
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        $kelasList = kelas::all();

        $tugas = UploadTugas::with('mapel')
            ->where('guru_id', $guru->id)
            ->latest()
            ->get();

        $mapels = $guru->mataPelajaran; // relasi guru ke mapel

        return view("guru.UploadTugas.upload", compact('tugas', 'mapels', 'kelasList'));
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
            'tanggal' => 'required|date',
        ]);

        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->firstOrFail();
        $mapel = MataPelajaran::with('kelas')->findOrFail($request->mapel_id);

        $siswaList = Siswa::where('kelas_id', $mapel->kelas_id)->get();

        if ($siswaList->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa di kelas ini.');
        }

        foreach ($siswaList as $siswa) {
            PresensiSiswa::firstOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel->id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'guru_id' => $guru->id,
                    'status' => null,
                    'keterangan' => null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Presensi berhasil dibuat.');
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
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx',
            'deadline' => 'nullable|date',
        ]);

        // Ambil guru berdasarkan user login
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Cari tugas yang dimiliki oleh guru tersebut
        $tugas = UploadTugas::where('id', $id)->where('guru_id', $guru->id)->firstOrFail();

        // Validasi bahwa mapel tersebut milik guru
        if (!$guru->mataPelajaran->contains('id', $request->mapel_id)) {
            abort(403, 'Mapel tidak tersedia untuk guru ini.');
        }

        // Hapus file lama jika ada file baru
        if ($request->hasFile('file_tugas')) {
            if ($tugas->file_tugas) {
                Storage::disk('public')->delete($tugas->file_tugas);
            }

            $filePath = $request->file('file_tugas')->store('tugas', 'public');
            $tugas->file_tugas = $filePath;
        }

        // Update data lainnya
        $tugas->update([
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'file_tugas' => $tugas->file_tugas, // tetapkan ulang agar tidak hilang saat update
        ]);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil data guru dari user login
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Cari tugas milik guru
        $tugas = UploadTugas::where('id', $id)->where('guru_id', $guru->id)->firstOrFail();

        // Hapus file jika ada dan file tersebut benar-benar ada di storage
        if ($tugas->file_tugas && Storage::disk('public')->exists($tugas->file_tugas)) {
            Storage::disk('public')->delete($tugas->file_tugas);
        }

        // Hapus data tugas
        $tugas->delete();

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }

}
