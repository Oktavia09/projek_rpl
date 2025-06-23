<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTugasSiswa extends Model
{
    use HasFactory;
    protected $table = 'nilai_tugas';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'file_pengumpulan',
        'nilai',
        'tanggal_pengumpulan',
    ];

    // Relasi ke tugas guru
    public function tugas()
    {
        return $this->belongsTo(UploadTugas::class, 'tugas_id');
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
