<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Alat;
use App\Models\Ruangan;
use App\Models\Pengguna;
use App\Notifications\StatusPeminjamanNotification;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index()
{
    $peminjamans = Peminjaman::with('details.alat')
        ->where('pengguna_id', Auth::id())
        ->where('tipe', 'alat')
        ->latest()
        ->get();

    return view('user.peminjaman.index', compact('peminjamans'));
}


    public function create()
{
    $alats = Alat::where('status_alat','tersedia')->get();
    return view('user.peminjaman.create', compact('alats'));
}


    public function store(Request $request)
{
    $request->validate([
        'alat_id' => 'required|array',
        'alat_id.*' => 'exists:alats,id',
        'qty' => 'required|array',
        'qty.*' => 'integer|min:1',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after_or_equal:jam_mulai',
    ]);

    $peminjaman = Peminjaman::create([
    'pengguna_id' => Auth::id(),
    'tanggal' => $request->tanggal_mulai, // 🔥 INI WAJIB TAMBAH
    'tanggal_mulai' => $request->tanggal_mulai,
    'tanggal_selesai' => $request->tanggal_selesai,
    'jam_mulai' => $request->jam_mulai,
    'jam_selesai' => $request->jam_selesai,
    'status_peminjaman' => 'pending',
    'tipe' => 'alat'
]);   
    foreach ($request->alat_id as $i => $alatId) {
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $alatId,
            'qty' => $request->qty[$i]
        ]);
    }

    return redirect()->route('user.peminjaman.index')
        ->with('success','Peminjaman alat berhasil diajukan');
}


    public function show(Peminjaman $peminjaman)
    {
        if ($peminjaman->pengguna_id != Auth::id()) abort(403);

        $peminjaman->load('details.alat');
        return view('user.peminjaman.show', compact('peminjaman'));
    }

    public function batal(Peminjaman $peminjaman)
    {
        if ($peminjaman->pengguna_id != Auth::id()) abort(403);

        $peminjaman->update(['status_peminjaman' => 'dibatalkan']);

        $admins = Pengguna::where('peran','admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(
                new StatusPeminjamanNotification(
                    "Peminjaman Dibatalkan",
                    auth()->user()->nama_pengguna . " membatalkan peminjaman."
                )
            );
        }

        return redirect()->route('user.peminjaman.index')
            ->with('success','Peminjaman dibatalkan.');
    }

    public function riwayat()
{
    $riwayats = Peminjaman::with('details.alat','details.ruangan')
        ->where('pengguna_id', Auth::id())
        ->whereIn('status_peminjaman',['diterima','ditolak','dibatalkan','selesai'])
        ->latest()
        ->get();

    return view('user.peminjaman.riwayat', compact('riwayats'));
}

    public function exportPdf()
    {
        $peminjamans = Peminjaman::with(['pengguna','details.alat'])->get();
        $pdf = Pdf::loadView('admin.peminjaman.pdf', compact('peminjamans'));
        return $pdf->download('laporan_peminjaman.pdf');
    }

    public function edit(Peminjaman $peminjaman)
{
    if ($peminjaman->pengguna_id != Auth::id()) abort(403);

    $alats = Alat::where('status_alat','tersedia')->get();
    $peminjaman->load('details.alat');

    return view('user.peminjaman.edit', compact('peminjaman','alats'));
}

public function update(Request $request, Peminjaman $peminjaman)
{
    if ($peminjaman->pengguna_id != Auth::id()) abort(403);

    $request->validate([
        'alat_id' => 'required|array',
        'alat_id.*' => 'exists:alats,id',
        'qty' => 'required|array',
        'qty.*' => 'integer|min:1',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after_or_equal:jam_mulai',
    ]);

    // update peminjaman utama
    $peminjaman->update([
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
    ]);

    // hapus detail lama
    $peminjaman->details()->delete();

    // insert ulang detail
    foreach ($request->alat_id as $i => $alatId) {
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $alatId,
            'qty' => $request->qty[$i]
        ]);
    }

    return redirect()->route('user.peminjaman.index')
        ->with('success','Peminjaman berhasil diperbarui');
}

}
