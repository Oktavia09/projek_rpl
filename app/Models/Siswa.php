<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'siswa';

    // Tidak memakai timestamps (created_at & updated_at)
    public $timestamps = true;

    // Primary key bukan 'id', tapi 'siswa_id'
    protected $primaryKey = 'siswa_id';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'alamat',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'nomor_telepon',
        'asal_sekolah',
        'nisn',
        'status_ppdb',
        'dokumen_rapor',
        'nilai_matematika',
        'nilai_ipa',
        'nilai_ips',
        'nilai_bahasa_indonesia',
        'nilai_bahasa_inggris',
    ];

    // Format konversi otomatis untuk kolom tertentu
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function presensi()
    {
        return $this->hasMany(PresensiSiswa::class, 'siswa_id');
    }

    public function nilaiTugas()
    {
        return $this->hasMany(NilaiTugasSiswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
