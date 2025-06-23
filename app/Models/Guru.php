<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru'; // jika nama tabel bukan jamak dari model

    // Jika kamu tidak punya kolom created_at dan updated_at di database:
    // public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'no_hp',
        'alamat',
    ];

    // Relasi ke user (akun login)

    // Relasi ke akun login
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke mata pelajaran (pivot guru_mapel)
    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mapel', 'guru_id', 'mapel_id');
    }

    // Relasi ke jadwal mengajar
    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalMengajar::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_kelas', 'guru_id', 'kelas_id');
    }

}

