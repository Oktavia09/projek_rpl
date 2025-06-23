<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\kelas;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class AdminJadwalMengajar extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::all();
        $mapel = MataPelajaran::all();
        $kelas = kelas::all();
        $jadwal = JadwalMengajar::with('guru.user', 'mataPelajaran', 'kelas')->get();
        return view('admin.JadwalMengajar.AdminJadwal', compact('jadwal', 'guru', 'mapel', 'kelas'));
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
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id', // Perubahan dari 'kelas' menjadi 'kelas_id'
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalMengajar::create([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id, // Simpan kelas sebagai foreign key
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->back()->with('success', 'Jadwal mengajar berhasil ditambahkan.');
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Log untuk debugging
        \Log::info('Update attempt:', [
            'id' => $id,
            'data' => $request->all()
        ]);

        // Validasi input
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id', // ubah dari 'kelas'
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Temukan jadwal dan perbarui
        $jadwal = JadwalMengajar::findOrFail($id);

        $jadwal->guru_id = $request->guru_id;
        $jadwal->mapel_id = $request->mapel_id;
        $jadwal->kelas_id = $request->kelas_id; // update ke foreign key
        $jadwal->hari = $request->hari;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;

        $jadwal->save();

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal mengajar berhasil dihapus.');
    }
}
