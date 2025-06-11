<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar role dan permission
        $rolesPermissions = [
            'siswa' => [
                'isi formulir ppdb',
                'lihat status ppdb',
                'akses informasi administrasi',
                'bayar administrasi sekolah',
                'lihat jadwal kelas',
                'akses mata pelajaran',
                'lihat tugas dan pengumuman',
                'lihat nilai akademik',
            ],
            'guru' => [
                'atur jadwal mengajar',
                'unggah materi pelajaran',
                'buat tugas siswa',
                'beri nilai tugas siswa',
                'kelola nilai akademik siswa',
                'buat pengumuman kelas',
                'akses forum guru',
            ],
            'admin' => [
                'kelola data siswa',
                'kelola data guru',
                'kelola data kelas',
                'kelola mata pelajaran',
                'pantau ppdb',
                'setujui ppdb',
                'atur pembayaran administrasi',
                'verifikasi pembayaran',
                'atur jadwal akademik',
            ],
        ];

        // Buat permission dan role
        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
