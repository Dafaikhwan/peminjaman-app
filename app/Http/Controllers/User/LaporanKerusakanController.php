<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        $laporans = LaporanKerusakan::where('pengguna_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('user.laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_kerusakan' => 'required|in:alat,ruangan,lainnya',
            'deskripsi_kerusakan' => 'required|string',
            'url_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['lokasi','jenis_kerusakan','deskripsi_kerusakan']);
        $data['pengguna_id'] = Auth::id();

        if($request->hasFile('url_gambar')){
            $data['url_gambar'] = $request->file('url_gambar')->store('laporan_kerusakan','public');
        }

        LaporanKerusakan::create($data);

        return redirect()->route('user.laporan.index')
            ->with('success', 'Laporan kerusakan berhasil dikirim.');
    }

    public function show(LaporanKerusakan $laporan)
    {
        if($laporan->pengguna_id !== Auth::id()){
            abort(403, 'Akses ditolak.');
        }

        return view('user.laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        if ($laporan->pengguna_id !== Auth::id() || !in_array($laporan->status_laporan, ['diajukan'])) {
            return redirect()->back()->with('error', 'Laporan tidak bisa diubah.');
        }

        return view('user.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        if ($laporan->pengguna_id !== Auth::id() || !in_array($laporan->status_laporan, ['diajukan'])) {
            return redirect()->back()->with('error', 'Laporan tidak bisa diubah.');
        }

        $request->validate([
            'lokasi' => 'required|string|max:255',
            'jenis_kerusakan' => 'required|in:alat,ruangan,lainnya',
            'deskripsi_kerusakan' => 'required|string',
            'url_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['lokasi','jenis_kerusakan','deskripsi_kerusakan']);

        if($request->hasFile('url_gambar')){
            $data['url_gambar'] = $request->file('url_gambar')->store('laporan_kerusakan','public');
        }

        $laporan->update($data);

        return redirect()->route('user.laporan.index')->with('success','Laporan berhasil diperbarui.');
    }

    public function batal($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        if ($laporan->pengguna_id !== Auth::id() || !in_array($laporan->status_laporan, ['diajukan'])) {
            return redirect()->back()->with('error', 'Laporan tidak bisa dibatalkan.');
        }

        $laporan->status_laporan = 'dibatalkan';
        $laporan->save();

        return redirect()->route('user.laporan.index')->with('success','Laporan berhasil dibatalkan.');
    }
}
