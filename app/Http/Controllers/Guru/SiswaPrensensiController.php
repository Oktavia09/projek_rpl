<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SiswaPrensensiController extends Controller
{
    /**
     * Tampilkan form presensi.
     */

    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    public function index()
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Ambil semua mata pelajaran yang diampu guru beserta kelas-nya
        $mapel = $guru->mataPelajaran()->with('kelas')->get();

        if ($mapel->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada mata pelajaran yang diampu.');
        }

        // Ambil daftar kelas unik dari mapel
        $kelasIds = $mapel->pluck('kelas_id')->unique()->filter();
        $kelasList = Kelas::whereIn('id', $kelasIds)->get();

        return view('guru.PresensiSiswa.presensi', compact('guru', 'mapel', 'kelasList'));
    }

    /**
     * Simpan presensi berdasarkan mapel dan kelas
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
        ]);

        $guru = Guru::where('user_id', Auth::id())->first();
        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Ambil mapel yang diampu guru
        $mapel = $guru->mataPelajaran()->where('id', $validated['mapel_id'])->first();
        if (!$mapel) {
            return back()->with('error', 'Mata pelajaran bukan milik Anda.');
        }

        // Cek apakah kelas sesuai dengan mapel
        if ($mapel->kelas_id != $validated['kelas_id']) {
            return back()->with('error', 'Kelas tidak cocok dengan mata pelajaran yang dipilih.');
        }

        // Ambil siswa dari kelas
        $siswaList = Siswa::where('kelas_id', $validated['kelas_id'])->get();
        if ($siswaList->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa di kelas ini.');
        }

        $inserted = 0;

        foreach ($siswaList as $siswa) {
            if (!$siswa || !$siswa->id)
                continue;

            $presensi = PresensiSiswa::firstOrCreate([
                'siswa_id' => $siswa->id,
                'mapel_id' => $mapel->id,
                'tanggal' => $validated['tanggal'],
            ], [
                'guru_id' => $guru->id,
                'status' => null,
                'keterangan' => null,
            ]);

            if ($presensi->wasRecentlyCreated) {
                $inserted++;
            }
        }

        return back()->with('success', "Presensi berhasil dibuka untuk $inserted siswa.");
    }



    /**
     * (Opsional) Tampilkan presensi tertentu.
     */
    public function show(string $id)
    {
        // $presensi = PresensiSiswa::findOrFail($id);
        // return view('guru.PresensiSiswa.show', compact('presensi'));
    }

    /**
     * (Opsional) Form edit status presensi.
     */
    public function edit(string $id)
    {
        // $presensi = PresensiSiswa::findOrFail($id);
        // return view('guru.PresensiSiswa.edit', compact('presensi'));
    }

    /**
     * (Opsional) Update status presensi.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $presensi = PresensiSiswa::findOrFail($id);
        $presensi->update($request->only('status', 'keterangan'));

        return redirect()->back()->with('success', 'Presensi berhasil diperbarui.');
    }

    /**
     * (Opsional) Hapus data presensi.
     */
    public function destroy(string $id)
    {
        $presensi = PresensiSiswa::findOrFail($id);
        $presensi->delete();

        return redirect()->back()->with('success', 'Presensi berhasil dihapus.');
    }
}
