<?php

namespace App\Http\Controllers\Admin;
use App\Notifications\StatusPeminjamanNotification;
use App\Http\Controllers\Controller;
use App\Models\BookingRuangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BookingRuanganController extends Controller
{   
    public function index()
    {
        $bookings = BookingRuangan::with('ruangan')->latest()->paginate(10);
        return view('admin.booking-ruangan.index', compact('bookings'));
    }

    public function create()
    {
        $ruangans = Ruangan::where('status_ruangan', 'tersedia')->get();
        return view('admin.booking-ruangan.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        BookingRuangan::create([
            'pengguna_id' => auth()->id(),
            'ruangan_id' => $request->ruangan_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'pending'
        ]);

        return redirect()->route('admin.booking-ruangan.index')
            ->with('success', 'Booking ruangan berhasil dibuat');
    }

    public function show($id)
    {
        $booking = BookingRuangan::with('ruangan')->findOrFail($id);
        return view('admin.booking-ruangan.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = BookingRuangan::findOrFail($id);
        $ruangans = Ruangan::all();
        return view('admin.booking-ruangan.edit', compact('booking', 'ruangans'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'ruangan_id' => 'required',
        'status' => 'required|in:pending,disetujui,ditolak'
    ]);

    $booking = BookingRuangan::findOrFail($id);

    $booking->update([
        'ruangan_id' => $request->ruangan_id,
        'status' => $request->status,
    ]);

    // KIRIM NOTIF KE USER
    $booking->pengguna->notify(
        new StatusPeminjamanNotification(
            'Status Booking Ruangan',
            'Booking ruangan kamu sekarang: ' . ucfirst($request->status),
            '/riwayat-booking'
        )
    );

    return redirect()->route('admin.booking-ruangan.index')
        ->with('success', 'Booking berhasil diupdate');
}


    public function destroy($id)
    {
        BookingRuangan::destroy($id);

        return redirect()->route('admin.booking-ruangan.index')
            ->with('success', 'Booking berhasil dihapus');
    }
}
