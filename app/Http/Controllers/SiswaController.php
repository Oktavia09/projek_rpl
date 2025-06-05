<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
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

        return view('siswa.dashboard', compact('siswa'));
    }
}
