<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi form
        $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'email' => 'required|email|unique:penggunas,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Simpan user baru dengan role otomatis "user"
        $user = Pengguna::create([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => 'user', // 🔥 otomatis user
        ]);

        // Login otomatis setelah register
        auth()->login($user);

        // Arahkan langsung ke dashboard user
        return redirect()->route('user.dashboard');
    }
}
