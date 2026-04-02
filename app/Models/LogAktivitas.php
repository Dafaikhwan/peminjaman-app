<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id'); 
    }

    // Accessor untuk Blade
    public function getAktivitasAttribute()
    {
        return $this->deskripsi;
    }

    public function getJenisAksiAttribute()
    {
        return $this->aksi;
    }
}
