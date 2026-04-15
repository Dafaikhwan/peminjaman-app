<?php

namespace App\Http\Controllers\Admin;
use App\Notifications\StatusPeminjamanNotification;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Pengguna;
use App\Models\Alat;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['pengguna','details.alat','details.ruangan']);


        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        $peminjamans = $query->latest()->paginate(10);
        $selectedStatus = $request->status;

        return view('admin.peminjaman.index', compact('peminjamans','selectedStatus'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('admin.peminjaman.create', [
            'users' => Pengguna::all(),
            'alats' => Alat::all(),
        ]);
    }

    // ================= STORE =================
    public function store(Request $request)
{
    $request->validate([
    'pengguna_id' => 'required',
    'alat_id' => 'required|array',
    'qty' => 'required|array',
    'tanggal_mulai' => 'required',
    'jam_mulai' => 'required',
    'jam_selesai' => 'required',
]);

    $peminjaman = Peminjaman::create([
    'pengguna_id' => $request->pengguna_id,
    'tanggal' => $request->tanggal_mulai, // ✅ INI YANG BENAR
    'jam_mulai' => $request->jam_mulai,
    'jam_selesai' => $request->jam_selesai,
    'status_peminjaman' => 'pending',
]);

    // PAKAI INDEX
    foreach ($request->alat_id as $i => $alatId) {
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $alatId,
            'qty' => $request->qty[$i]
        ]);
    }

    return redirect()->route('admin.peminjaman.index')
        ->with('success','Peminjaman berhasil ditambahkan');
}


    // ================= SHOW =================
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load('pengguna','details.alat');
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    // ================= EDIT =================
    public function edit(Peminjaman $peminjaman)
    {
        $peminjaman->load('details');

        return view('admin.peminjaman.edit', [
            'peminjaman' => $peminjaman,
            'users' => Pengguna::all(),
            'alats' => Alat::all(),
        ]);
    }

    // ================= UPDATE =================
    public function update(Request $request, Peminjaman $peminjaman)
{
    $request->validate([
        'pengguna_id' => 'required',
        'alat_id' => 'required|array',
        'alat_id.*' => 'exists:alats,id',
        'qty' => 'required|array',
        'qty.*' => 'integer|min:1',
        'tanggal_mulai' => 'required',
        'tanggal_selesai' => 'required',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
        'status_peminjaman' => 'required',
    ]);

    $peminjaman->update([
    'pengguna_id' => $request->pengguna_id,
    'tanggal' => $request->tanggal_mulai, // ✅ FIX
    'jam_mulai' => $request->jam_mulai,
    'jam_selesai' => $request->jam_selesai,
    'status_peminjaman' => $request->status_peminjaman,
]);

    // hapus detail lama
    $peminjaman->details()->delete();

    // simpan ulang
    foreach ($request->alat_id as $i => $alatId) {
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $alatId,
            'qty' => $request->qty[$i]
        ]);
    }

    return redirect()->route('admin.peminjaman.index')
        ->with('success','Peminjaman berhasil diupdate');
}


    // ================= UPDATE STATUS =================
    public function updateStatus(Request $request, Peminjaman $peminjaman)
{
    $request->validate([
        'status_peminjaman' => 'required|in:pending,diterima,ditolak,dibatalkan'
    ]);

    $peminjaman->update([
        'status_peminjaman' => $request->status_peminjaman
    ]);

    // KIRIM NOTIF KE USER
    $peminjaman->pengguna->notify(
        new StatusPeminjamanNotification(
            'Status Peminjaman Diperbarui',
            'Peminjaman kamu sekarang berstatus: ' . ucfirst($request->status_peminjaman),
            '/riwayat-peminjaman'
        )
    );

    return back()->with('success','Status diperbarui');
}

    // ================= DELETE =================
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->details()->delete();
        $peminjaman->delete();

        return back()->with('success','Data dihapus');
    }

    public function createRuangan()
{
    return view('admin.peminjaman.create-ruangan', [
        'users' => Pengguna::all(),
        'ruangans' => Ruangan::all(),
    ]);
}

public function storeRuangan(Request $request)
{
    $request->validate([
    'pengguna_id' => 'required',
    'alat_id' => 'required|array',
    'alat_id.*' => 'exists:alats,id',
    'qty' => 'required|array',
    'qty.*' => 'integer|min:1',
    'tanggal_mulai' => 'required',
    'jam_mulai' => 'required',
    'jam_selesai' => 'required',
]);
    $peminjaman = Peminjaman::create([
    'pengguna_id' => $request->pengguna_id,
    'tanggal' => $request->tanggal_mulai, // ✅ FIX DI SINI
    'jam_mulai' => $request->jam_mulai,
    'jam_selesai' => $request->jam_selesai,
    'status_peminjaman' => 'pending',
]);
    foreach ($request->ruangan_id as $ruangan) {
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'ruangan_id' => $ruangan,
            'qty' => 1
        ]);
    }

    return redirect()->route('admin.peminjaman.index')
        ->with('success','Booking ruangan berhasil');
}


}
