<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->latest();

        // Filter user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter jenis aksi (tambah, update, hapus, login, logout)
        if ($request->jenis) {
            $query->where('jenis_aksi', $request->jenis);
        }

        // Filter tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Pencarian
        if ($request->search) {
            $query->where('aktivitas', 'like', "%{$request->search}%");
        }

        return view('admin.log.index', [
            'logs' => $query->paginate(10),
            'users' => User::all()
        ]);
    }
}
