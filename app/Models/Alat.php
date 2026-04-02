<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Peminjaman;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'nama_alat',
        'deskripsi_alat',
        'jumlah',
        'status_alat',
    ];

    public function peminjamanDetails()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }
}
