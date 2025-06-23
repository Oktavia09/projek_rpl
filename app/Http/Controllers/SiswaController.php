<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:siswa')->except(['logout']);
        // $this->middleware('permission:isi formulir ppdb')->only(['store', 'edit', 'update']);
    }

    /**
     * Tampilkan halaman utama siswa dengan data PPDB.
     *      */
    public function dashboard_siswa(){
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        return view('siswa.dashboard', compact('siswa'));
    }
    public function dashboard()
    {
        $siswa = Auth::user();
        $dataPpdb = Siswa::where('user_id', $siswa->id)->first();
        return view('siswa.home', compact('siswa', 'dataPpdb'));
    }

    /**
     * Simpan data pendaftaran PPDB.
     */
    public function store(Request $request)
    {
        // Cek apakah sudah pernah mendaftar
        if (Siswa::where('user_id', Auth::id())->exists()) {
            return redirect()->route('siswa.home')
                ->with('error', 'Anda sudah pernah mendaftar PPDB.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_telepon' => 'required|string|max:15|regex:/^[0-9+\-\s]+$/',
            'asal_sekolah' => 'required|string|max:100',
            'nisn' => 'required|string|max:20',
            'nilai_matematika' => 'required|numeric|min:0|max:100',
            'nilai_ipa' => 'required|numeric|min:0|max:100',
            'nilai_ips' => 'required|numeric|min:0|max:100',
            'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_bahasa_inggris' => 'required|numeric|min:0|max:100',
            'dokumen_rapor' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = $validatedData;
            $data['user_id'] = Auth::id();

            // Upload file rapor
            if ($request->hasFile('dokumen_rapor')) {
                $data['dokumen_rapor'] = $request->file('dokumen_rapor')
                    ->store('dokumen/rapor', 'public');
            }

            // Hitung rata-rata nilai
            $rataRata = (
                $data['nilai_matematika'] +
                $data['nilai_ipa'] +
                $data['nilai_ips'] +
                $data['nilai_bahasa_indonesia'] +
                $data['nilai_bahasa_inggris']
            ) / 5;

            // Tentukan status berdasarkan rata-rata
            $data['status_ppdb'] = $rataRata >= 75 ? 'diterima' : 'ditolak';

            // dd($data);
            // Simpan ke database
            Siswa::create($data);

            return redirect()->route('siswa.home')
                ->with('success', 'Pendaftaran PPDB berhasil! Status Anda: ' . strtoupper($data['status_ppdb']));

        } catch (\Exception $e) {
            // Jika terjadi error, hapus file upload jika ada
            if (isset($data['dokumen_rapor'])) {
                Storage::disk('public')->delete($data['dokumen_rapor']);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan detail data PPDB (jika ada).
     */
    public function show()
    {
        $siswa = Auth::user();
        $dataPpdb = Siswa::where('user_id', $siswa->id)->first();

        return view('siswa.home', compact('siswa', 'dataPpdb'));
    }

    /**
     * Tampilkan form edit data PPDB (belum dibuat).
     */
    public function edit()
    {
        //
    }

    /**
     * Tampilkan form edit data PPDB (jika status pending).
     */

}
