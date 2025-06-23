<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
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

        $tugas = UploadTugas::with('mapel')
            ->where('guru_id', $guru->id)
            ->latest()
            ->get();

        $mapels = $guru->mataPelajaran; // relasi guru ke mapel

        return view("guru.UploadTugas.upload", compact('tugas', 'mapels'));
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx',
            'deadline' => 'nullable|date',
            'type' => 'required|in:tugas,materi',

        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // cek apakah mapel_id milik guru
        if (!$guru->mataPelajaran->contains('id', $request->mapel_id)) {
            abort(403, 'Mapel tidak tersedia untuk guru ini.');
        }

        $path = null;
        if ($request->hasFile('file_tugas')) {
            $path = $request->file('file_tugas')->store('tugas', 'public');
        }

        UploadTugas::create([
            'guru_id' => $guru->id,
            'mapel_id' => $request->mapel_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_tugas' => $path,
            'deadline' => $request->deadline,
            'type' => $request->type,
        ]);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diunggah!');
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx',
            'deadline' => 'nullable|date',
        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tugas = UploadTugas::where('id', $id)->where('guru_id', $guru->id)->firstOrFail();

        // hapus file lama jika ada dan upload file baru
        if ($request->hasFile('file_tugas')) {
            if ($tugas->file_tugas) {
                Storage::disk('public')->delete($tugas->file_tugas);
            }
            $tugas->file_tugas = $request->file('file_tugas')->store('tugas', 'public');
        }

        $tugas->update([
            'mapel_id' => $request->mapel_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tugas = UploadTugas::where('id', $id)->where('guru_id', $guru->id)->firstOrFail();

        if ($tugas->file_tugas) {
            Storage::disk('public')->delete($tugas->file_tugas);
        }

        $tugas->delete();

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }
}
