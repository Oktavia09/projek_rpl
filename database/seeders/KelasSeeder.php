<?php

namespace Database\Seeders;

use App\Models\kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $kelasList = [
            ['nama' => '7A', 'kuota' => 30, 'tingkat' => 7, 'tahun_ajaran' => '2025/2026'],
            ['nama' => '7B', 'kuota' => 30, 'tingkat' => 7, 'tahun_ajaran' => '2025/2026'],
            ['nama' => '7C', 'kuota' => 30, 'tingkat' => 7, 'tahun_ajaran' => '2025/2026'],
            ['nama' => '8A', 'kuota' => 30, 'tingkat' => 8, 'tahun_ajaran' => '2025/2026'],
            ['nama' => '9A', 'kuota' => 30, 'tingkat' => 9, 'tahun_ajaran' => '2025/2026'],
        ];

        foreach ($kelasList as $data) {
            kelas::create($data);
        }
    }
}
