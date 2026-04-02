<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{

protected $table = 'peminjamans';

    protected $fillable = [
        'pengguna_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status_peminjaman'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function details()
{
    return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
}
}



