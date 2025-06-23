<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi)
    protected $table = 'kelas';

    // Kolom yang bisa diisi massal (mass assignment)
    protected $fillable = [
        'nama',           // ex: "7A"
        'kuota',          // jumlah maksimum siswa
        'tingkat',        // ex: 7
        'tahun_ajaran',   // ex: "2025/2026"
        'guru_id',        // wali kelas
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    // Relasi ke user sebagai wali kelas
    // public function wali()
    // {
    //     return $this->belongsTo(Guru::class, 'guru_id'); // guru_id relasi ke Guru
    // }

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_kelas', 'kelas_id', 'guru_id');
    }
}
