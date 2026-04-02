<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // Tampilkan semua pengguna
    public function index()
    {
        $users = Pengguna::all();
        return view('admin.pengguna.index', compact('users'));
    }

    // Form tambah pengguna
    public function create()
    {
        return view('admin.pengguna.create');
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email',
            'password' => 'required|string|min:6|confirmed',
            'peran' => 'required|in:admin,user,teknisi',
        ]);

        Pengguna::create([
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
        ]);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Tampilkan detail pengguna
    public function show(Pengguna $pengguna)
    {
        return view('admin.pengguna.show', compact('pengguna'));
    }

    // Form edit pengguna
    public function edit(Pengguna $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    // Update pengguna
    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,'.$pengguna->id,
            'password' => 'nullable|string|min:6|confirmed',
            'peran' => 'required|in:admin,user,teknisi',
        ]);

        $data = [
            'nama_pengguna' => $request->nama_pengguna,
            'email' => $request->email,
            'peran' => $request->peran,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Pengguna berhasil diupdate.');
    }

    // Hapus pengguna
    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }
}
