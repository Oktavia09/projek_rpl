<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalMengajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LihatJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(["auth", "role:siswa"]);
    }
    public function index()
    {
        $user = Auth::user();

        // Ambil jadwal lengkap dengan relasi guru, mapel, dan kelas
        $jadwal = JadwalMengajar::with(['guru', 'mataPelajaran', 'kelas'])
            ->orderBy('jam_mulai') // Urutkan berdasarkan jam mulai agar tersusun rapi
            ->get();

        return view('siswa.LihatJadwal', compact('jadwal', 'user'));
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
