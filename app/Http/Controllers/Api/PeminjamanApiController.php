<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Support\Facades\Auth;

class PeminjamanApiController extends Controller
{
    // 🔹 LIST PEMINJAMAN USER
    public function index()
    {
        $data = Peminjaman::with('details.alat')
            ->where('pengguna_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // 🔹 STORE PEMINJAMAN
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|array',
            'alat_id.*' => 'exists:alats,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $peminjaman = Peminjaman::create([
            'pengguna_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status_peminjaman' => 'pending'
        ]);

        foreach ($request->alat_id as $i => $alatId) {
            PeminjamanDetail::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id' => $alatId,
                'qty' => $request->qty[$i]
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil',
            'data' => $peminjaman
        ], 201);
    }

    // 🔹 DETAIL
    public function show($id)
    {
        $data = Peminjaman::with('details.alat')
            ->where('pengguna_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}