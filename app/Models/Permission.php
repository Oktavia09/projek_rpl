<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'guard_name',
    ];

    public $timestamps = true;

    // Relasi ke roles (jika menggunakan package seperti Spatie)
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
