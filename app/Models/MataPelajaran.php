<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama',
        'kode',
        'kelas_id',
    ];

    // Relasi ke guru (many-to-many)
    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id');
    }

    // Relasi ke jadwal mengajar
    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalMengajar::class, 'mapel_id');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiSiswa::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id')->withDefault([
        'nama' => '-',
    ]);
    }
}
