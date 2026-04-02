<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Storage;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        $laporans = LaporanKerusakan::latest()->get();
        return view('teknisi.laporan.index', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return view('teknisi.laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return view('teknisi.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        // Teknisi hanya boleh: diproses, selesai, ditolak
        $request->validate([
            'status_laporan' => 'required|in:diproses,selesai,ditolak',
            'url_gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $laporan->status_laporan = $request->status_laporan;

        // Jika ada gambar baru
        if ($request->hasFile('url_gambar')) {
            if ($laporan->url_gambar && Storage::disk('public')->exists($laporan->url_gambar)) {
                Storage::disk('public')->delete($laporan->url_gambar);
            }
            $laporan->url_gambar = $request->file('url_gambar')->store('laporan', 'public');
        }

        $laporan->save();

        return redirect()->route('teknisi.laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}
