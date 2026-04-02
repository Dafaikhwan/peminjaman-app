<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanKerusakan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kerusakans';

    protected $fillable = [
        'pengguna_id',
        'lokasi',
        'deskripsi_kerusakan',
        'jenis_kerusakan',
        'url_gambar',
        'status_laporan',
    ];

    // Relasi ke Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
