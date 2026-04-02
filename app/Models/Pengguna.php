<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;


class Pengguna extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'penggunas';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_pengguna', 'email', 'password', 'peran'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'pengguna_id');
    }

    public function laporanKerusakans()
    {
        return $this->hasMany(LaporanKerusakan::class, 'pengguna_id');
    }
}
