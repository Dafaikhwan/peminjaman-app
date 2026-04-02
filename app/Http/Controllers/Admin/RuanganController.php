<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    // Tampilkan semua ruangan
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('admin.ruangan.index', compact('ruangans'));
    }

    // Tampilkan form tambah ruangan
    public function create()
    {
        return view('admin.ruangan.create');
    }

    // Simpan ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'deskripsi_ruangan' => 'nullable|string',
            'status_ruangan' => 'required|in:tersedia,dipinjam,perbaikan',
        ]);

        Ruangan::create($request->all());

        return redirect()->route('admin.ruangan.index')
                         ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // Tampilkan detail ruangan
    public function show(Ruangan $ruangan)
    {
        return view('admin.ruangan.show', compact('ruangan'));
    }

    // Tampilkan form edit ruangan
    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    // Update ruangan
    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'deskripsi_ruangan' => 'nullable|string',
            'status_ruangan' => 'required|in:tersedia,dipinjam,perbaikan',
        ]);

        $ruangan->update($request->all());

        return redirect()->route('admin.ruangan.index')
                         ->with('success', 'Ruangan berhasil diupdate.');
    }

    // Hapus ruangan
    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')
                         ->with('success', 'Ruangan berhasil dihapus.');
    }
}
