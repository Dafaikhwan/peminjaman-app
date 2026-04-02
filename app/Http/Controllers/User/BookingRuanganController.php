<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingRuangan;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class BookingRuanganController extends Controller
{
    public function index()
    {
        $bookings = BookingRuangan::with('ruangan')
            ->where('pengguna_id', Auth::id())
            ->latest()
            ->get();

        return view('user.booking-ruangan.index', compact('bookings'));
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        return view('user.booking-ruangan.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        BookingRuangan::create([
            'pengguna_id' => Auth::id(),
            'ruangan_id' => $request->ruangan_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'pending',
        ]);

        return redirect()->route('user.booking-ruangan.index')
            ->with('success','Booking ruangan berhasil diajukan');
    }

    public function show(BookingRuangan $booking_ruangan)
    {
        if ($booking_ruangan->pengguna_id != Auth::id()) abort(403);

        return view('user.booking-ruangan.show', [
            'booking' => $booking_ruangan
        ]);
    }

    public function edit(BookingRuangan $booking_ruangan)
    {
        if ($booking_ruangan->pengguna_id != Auth::id()) abort(403);

        $ruangans = Ruangan::all();
        return view('user.booking-ruangan.edit', [
            'booking' => $booking_ruangan,
            'ruangans' => $ruangans
        ]);
    }

    public function update(Request $request, BookingRuangan $booking_ruangan)
    {
        if ($booking_ruangan->pengguna_id != Auth::id()) abort(403);

        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $booking_ruangan->update($request->all());

        return redirect()->route('user.booking-ruangan.index')
            ->with('success','Booking berhasil diperbarui');
    }

    public function batal(BookingRuangan $booking_ruangan)
    {
        if ($booking_ruangan->pengguna_id != Auth::id()) abort(403);

        $booking_ruangan->update(['status' => 'ditolak']);

        return back()->with('success','Booking dibatalkan');
    }

    public function riwayat()
    {
        $riwayats = BookingRuangan::with('ruangan')
            ->where('pengguna_id', Auth::id())
            ->get();

        return view('user.booking-ruangan.riwayat', compact('riwayats'));
    }
}
