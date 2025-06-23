<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    /**
     * Menampilkan dashboard guru.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $guru = Auth::user(); // Mendapatkan data guru yang sedang login

        return view('guru.dashboard', compact('guru'));
    }
}

