<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadTugas extends Model
{
    use HasFactory;

    protected $table = 'tugas_guru';

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'judul',
        'deskripsi',
        'file_tugas',
        'deadline',
        'type',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function nilaiTugas()
    {
        return $this->hasMany(NilaiTugasSiswa::class, 'tugas_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
