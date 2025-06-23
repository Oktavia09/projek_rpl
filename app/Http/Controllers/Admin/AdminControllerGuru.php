<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\User;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminControllerGuru extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "role:admin"]);
    }

    public function index()
    {
        try {
            $guru = Guru::with(['user', 'mataPelajaran.kelas'])->get();
            $mapel = MataPelajaran::with('kelas')->get();
            $kelas = Kelas::all(); // ✅ Tambahan

            return view('admin.guru.AdminGuru', compact('guru', 'mapel', 'kelas'));
        } catch (Exception $e) {
            Log::error('Error in AdminControllerGuru index: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat data guru: ' . $e->getMessage());
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        // Log untuk debugging
        Log::info('Store request received', $request->all());

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30|unique:guru,nip',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'mapel' => 'nullable|array',
            'mapel.*' => 'exists:mata_pelajaran,id',
            'kelas' => 'nullable|array', // ✅ Tambahan
            'kelas.*' => 'exists:kelas,id', // ✅ Tambahan
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'nip.unique' => 'NIP sudah digunakan.',
            'mapel.*.exists' => 'Mata pelajaran tidak valid.',
            'kelas.*.exists' => 'Kelas tidak valid.', // ✅ Tambahan
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat akun user
            $user = User::create([
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // 2. Assign role guru jika menggunakan Spatie
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('guru');
            }

            // 3. Buat data guru
            $guru = Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?? null,
                'nama_lengkap' => $validated['nama_lengkap'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);

            // 4. Hubungkan dengan mata pelajaran (jika ada)
            if (!empty($validated['mapel'])) {
                $guru->mataPelajaran()->attach($validated['mapel']);
            }

            // ✅ 5. Hubungkan dengan kelas (jika ada)
            if (!empty($validated['kelas'])) {
                $guru->kelas()->attach($validated['kelas']);
            }

            DB::commit();

            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan data guru', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data guru. Silakan periksa kembali.');
        }
    }


    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {
        Log::info('Update request:', ['id' => $id, 'data' => $request->all()]);

        try {
            $guru = Guru::with('user')->findOrFail($id);

            if (!$guru->user) {
                return redirect()->back()->with('error', 'Data user tidak ditemukan.');
            }

            // Validasi
            $request->validate([
                'nama_lengkap' => 'required|string|max:100',
                'nip' => 'nullable|string|max:30|unique:guru,nip,' . $guru->id,
                'no_hp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string|max:500',
                'email' => 'required|email|max:255|unique:users,email,' . $guru->user->id,
                'password' => 'nullable|string|min:6',
                'mapel' => 'nullable|array',
                'mapel.*' => 'exists:mata_pelajaran,id',
            ], [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'password.min' => 'Password minimal 6 karakter',
                'nip.unique' => 'NIP sudah digunakan',
                'mapel.*.exists' => 'Mata pelajaran tidak valid',
            ]);

            DB::beginTransaction();

            // Update data Guru
            $guru->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            // Update data User
            $userData = [
                'name' => $request->nama_lengkap,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $guru->user->update($userData);

            // Sync mata pelajaran
            if ($request->has('mapel')) {
                $guru->mataPelajaran()->sync($request->mapel ?? []);
                Log::info('Mata pelajaran synced:', $request->mapel ?? []);
            }

            DB::commit();

            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Update validation failed:', $e->errors());

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update failed:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        Log::info('Delete request:', ['id' => $id]);

        try {
            DB::beginTransaction();

            $guru = Guru::with('user')->findOrFail($id);

            // Detach semua mata pelajaran
            $guru->mataPelajaran()->detach();

            // Simpan user untuk dihapus
            $user = $guru->user;

            // Hapus guru
            $guru->delete();

            // Hapus user jika ada
            if ($user) {
                $user->delete();
            }

            DB::commit();

            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil dihapus');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Delete failed:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }
}
