<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function create()
    {
        return view('Login');
    }

    /**
     * Proses data login.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login menggunakan Auth
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login berhasil
            $request->session()->regenerate();

            // Dapatkan user yang sedang login
            $user = Auth::user();

            // Arahkan berdasarkan role menggunakan Spatie
            if ($user->hasRole('siswa')) {
                return redirect()->route('siswa.dashboard')->with('success', 'Login berhasil sebagai siswa!');
            } elseif ($user->hasRole('guru')) {
                return redirect()->route('guru.dashboard')->with('success', 'Login berhasil sebagai guru!');
            } else {
                // Default redirect jika role tidak dikenali
                return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
            }
        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }


    // Fungsi lainnya (bisa dibiarkan kosong atau ditambahkan sesuai kebutuhan)
    public function index()
    {
    }
    public function show(string $id)
    {
    }
    public function edit(string $id)
    {
    }
    public function update(Request $request, string $id)
    {
    }
    public function destroy(string $id)
    {
    }
}
