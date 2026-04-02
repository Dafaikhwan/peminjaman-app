<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';
    // Hapus baris berikut karena default Laravel = 'id'
    // protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'deskripsi_ruangan',
        'status_ruangan',
    ];

    // Relasi: Ruangan bisa dipinjam banyak kali
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'ruangan_id', 'id');
        // 'id' = primary key di tabel ruangans
    }
}
