<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['nama_pengguna'=>'Admin Sistem', 'password'=>Hash::make('password123'), 'peran'=>'admin']
        );

        Pengguna::updateOrCreate(
            ['email' => 'teknisi@example.com'],
            ['nama_pengguna'=>'Teknisi Lab', 'password'=>Hash::make('password123'), 'peran'=>'teknisi']
        );

        Pengguna::updateOrCreate(
            ['email' => 'mahasiswa@example.com'],
            ['nama_pengguna'=>'Mahasiswa Uji', 'password'=>Hash::make('password123'), 'peran'=>'user']
        );
    }
}
