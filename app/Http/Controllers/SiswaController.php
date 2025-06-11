<?php

namespace App\Http\Controllers;

use App\Models\Siswa;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:siswa']);
    }

    /**
     * Menampilkan dashboard siswa.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $siswa = Auth::user(); // Mendapatkan data siswa yang sedang login
        $user = User::all();
        return view('siswa.dashboard', compact('siswa' ,'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_telepon' => 'required|string|max:15',
            'nama_orang_tua' => 'required|string|max:100',
            'pekerjaan_orang_tua' => 'required|string|max:50',
            'asal_sekolah' => 'required|string|max:100',
            'dokumen_rapor' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        // dd($request->all());
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status_ppdb'] = 'pending';

        // Handle file uploads
        if ($request->hasFile('dokumen_rapor')) {
            $data['dokumen_rapor'] = $request->file('dokumen_rapor')->store('dokumen/rapor', 'public');
        }

        if ($request->hasFile('dokumen_akta')) {
            $data['dokumen_akta'] = $request->file('dokumen_akta')->store('dokumen/akta', 'public');
        }

        if ($request->hasFile('dokumen_foto')) {
            $data['dokumen_foto'] = $request->file('dokumen_foto')->store('dokumen/foto', 'public');
        }

        // dd($data);
        Siswa::create($data);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/Login'); // arahkan ke halaman login
    }

}
