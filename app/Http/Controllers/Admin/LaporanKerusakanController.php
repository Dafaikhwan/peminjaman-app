<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Storage;

class LaporanKerusakanController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $laporans = LaporanKerusakan::orderBy('created_at', 'desc')

            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('lokasi', 'like', '%' . $request->search . '%')
                      ->orWhere('jenis_kerusakan', 'like', '%' . $request->search . '%')
                      ->orWhere('deskripsi_kerusakan', 'like', '%' . $request->search . '%');
                });
            })

            ->when($request->status, function ($query) use ($request) {
                $query->where('status_laporan', $request->status);
            })

            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.index', compact('laporans'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('admin.laporan.create');
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_kerusakan' => 'required|string',
            'deskripsi' => 'required|string',
            'url_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('url_gambar')) {
            $gambarPath = $request->file('url_gambar')->store('laporan_kerusakan', 'public');
        }

        LaporanKerusakan::create([
            'pengguna_id' => auth()->id(), // 🔥 FIX UTAMA
            'lokasi' => $request->lokasi,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi_kerusakan' => $request->deskripsi,
            'url_gambar' => $gambarPath,
            'status_laporan' => 'diajukan',
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    // ================= SHOW =================
    public function show($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return view('admin.laporan.edit', compact('laporan'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_kerusakan' => 'required|string',
            'deskripsi' => 'required|string',
            'status_laporan' => 'required|in:diajukan,diproses,selesai,ditolak',
            'url_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = $laporan->url_gambar;

        if ($request->hasFile('url_gambar')) {
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }

            $gambarPath = $request->file('url_gambar')->store('laporan_kerusakan', 'public');
        }

        $laporan->update([
            'lokasi' => $request->lokasi,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi_kerusakan' => $request->deskripsi,
            'url_gambar' => $gambarPath,
            'status_laporan' => $request->status_laporan,
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        if ($laporan->url_gambar) {
            Storage::disk('public')->delete($laporan->url_gambar);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}