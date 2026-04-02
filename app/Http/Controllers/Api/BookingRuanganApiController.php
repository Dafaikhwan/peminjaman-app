<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingRuangan;
use Illuminate\Support\Facades\Auth;

class BookingRuanganApiController extends Controller
{
    /**
     * List semua booking user yang login
     */
    public function index()
    {
        $user = Auth::user();

        $bookings = BookingRuangan::with('ruangan')
            ->where('pengguna_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    /**
     * Simpan booking baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai'
        ]);

        $user = Auth::user();

        // Cek bentrok jam
        $bentrok = BookingRuangan::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->where(function($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('jam_mulai', '<=', $request->jam_mulai)
                         ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($bentrok) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan sudah dibooking di jam tersebut'
            ], 409);
        }

        // Simpan booking
        $booking = BookingRuangan::create([
            'pengguna_id' => $user->id,
            'ruangan_id' => $request->ruangan_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ], 201);
    }

    /**
     * Detail satu booking
     */
    public function show($id)
    {
        $user = Auth::user();

        $booking = BookingRuangan::with('ruangan')
            ->where('id', $id)
            ->where('pengguna_id', $user->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    /**
     * Update booking (selama masih pending)
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $booking = BookingRuangan::where('id', $id)
            ->where('pengguna_id', $user->id)
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak bisa diubah'
            ], 403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai'
        ]);

        $booking->update([
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil diperbarui',
            'data' => $booking
        ]);
    }

    /**
     * Hapus booking
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $booking = BookingRuangan::where('id', $id)
            ->where('pengguna_id', $user->id)
            ->firstOrFail();

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dihapus'
        ]);
    }

    /**
     * Riwayat booking user
     */
    public function riwayat()
    {
        $user = Auth::user();

        $bookings = BookingRuangan::with('ruangan')
            ->where('pengguna_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }
}
