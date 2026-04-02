<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $alats = Alat::when($search, function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('deskripsi_alat', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alat.index', compact('alats', 'search'));
    }

    public function create()
    {
        return view('admin.alat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'deskripsi_alat' => 'nullable|string',
            'status_alat' => 'nullable|in:tersedia,dipinjam,rusak',
        ]);

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'jumlah' => $request->jumlah,
            'deskripsi_alat' => $request->deskripsi_alat,
            'status_alat' => $request->status_alat ?? 'tersedia',
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function show(Alat $alat)
    {
        return view('admin.alat.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        return view('admin.alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'deskripsi_alat' => 'nullable|string',
            'status_alat' => 'required|in:tersedia,dipinjam,rusak',
        ]);

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'jumlah' => $request->jumlah,
            'deskripsi_alat' => $request->deskripsi_alat,
            'status_alat' => $request->status_alat,
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diupdate.');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
