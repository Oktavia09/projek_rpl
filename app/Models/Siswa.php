<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    public $timestamps = false;
    protected $primaryKey = 'siswa_id';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'alamat',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'nomor_telepon',
        'nama_orang_tua',
        'pekerjaan_orang_tua',
        'asal_sekolah',
        'status_ppdb',
        'dokumen_rapor',
        'dokumen_akta',
        'dokumen_foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'datetime',
        'tanggal_update' => 'datetime',
    ];
}
