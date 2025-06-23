<?php

namespace App\Http\Controllers\Admin;
use App\Models\siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class adminControllerSiswa extends Controller
{


    public function __construct(){
        $this->middleware(["auth","role:admin"]);
    }
    public function index()
    {
        $data = Siswa::all();
        return view('admin.siswa.AdminSiswa', compact('data'));
    }

    // Tidak perlu show() dan edit() karena sudah pakai modal

    public function update(Request $request, $siswa_id)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nomor_telepon' => 'nullable|string|max:20',
            'nama_orang_tua' => 'nullable|string|max:255',
            'pekerjaan_orang_tua' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'status_ppdb' => 'nullable|in:menunggu,diterima,ditolak',
        ]);

        $siswa = Siswa::where('siswa_id', $siswa_id)->firstOrFail();

        // Hapus field kosong agar tidak overwrite
        foreach ($validatedData as $key => $value) {
            if ($value === null || $value === '') {
                unset($validatedData[$key]);
            }
        }

        $siswa->update($validatedData);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($siswa_id)
    {
        $siswa = Siswa::where('siswa_id', $siswa_id)->firstOrFail();
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
