<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = Pengguna::where('email', $request->email)->first();

        if (!$user) return back()->withErrors(['email'=>'Email tidak ditemukan']);
        if (!Hash::check($request->password,$user->password)) return back()->withErrors(['password'=>'Password salah']);

        Auth::login($user);
        $request->session()->regenerate();

        return match($user->peran){
            'admin' => redirect()->route('admin.dashboard'),
            'teknisi' => redirect()->route('teknisi.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => abort(403)
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
