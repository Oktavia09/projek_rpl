<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTugasSiswa extends Model
{
    protected $table = 'siswa_tugas';

    protected $fillable = [
        'siswa_id',
        'tugas_id',
        'tanggal_pengumpulan',
        'file_jawaban',
        'jawaban_teks',
        'nilai',
        'tanggal_dinilai',
        'status',
    ];

    /**
     * Relasi ke model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke model TugasGuru (tugas_guru)
     */
    public function tugas()
    {
        return $this->belongsTo(UploadTugas::class, 'tugas_id');
    }

}
