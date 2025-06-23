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
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Ambil kredensial
        $credentials = $request->only('email', 'password');

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Arahkan sesuai peran/role
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.siswa.index')->with('success', 'Login berhasil sebagai Admin!');
            } elseif ($user->hasRole('siswa')) {
                return redirect()->route('siswa.home')->with('success', 'Login berhasil sebagai Siswa!');
            } elseif ($user->hasRole('guru')) {
                return redirect()->route('guru.dashboard')->with('success', 'Login berhasil sebagai Guru!');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Role pengguna tidak dikenali.',
                ]);
            }
        }

        // Jika gagal login
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
