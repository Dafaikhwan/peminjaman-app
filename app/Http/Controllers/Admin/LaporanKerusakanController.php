<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;

class LaporanKerusakanController extends Controller
{
    public function index(Request $request)
    {
        $laporans = LaporanKerusakan::orderBy('created_at', 'desc')

            // SEARCH
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('lokasi', 'like', '%' . $request->search . '%')
                      ->orWhere('jenis_kerusakan', 'like', '%' . $request->search . '%');
                });
            })

            // FILTER STATUS
            ->when($request->status, function ($query) use ($request) {
                $query->where('status_laporan', $request->status);
            })

            ->paginate(10)        // PAGINATION
            ->withQueryString();  // agar search + filter tidak hilang

        return view('admin.laporan.index', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        return view('admin.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);

        $request->validate([
            'status_laporan' => 'required|in:diajukan,diproses,selesai,ditolak',
        ]);

        $laporan->update([
            'status_laporan' => $request->status_laporan
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = LaporanKerusakan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
