<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index()
    {
        return view('kalender.index');
    }

    public function getData(Request $req)
    {
        $query = Peminjaman::with(['alat', 'ruangan']);

        // filter
        if ($req->tipe == 'alat') {
            $query->whereNotNull('alat_id');
        }

        if ($req->tipe == 'ruangan') {
            $query->whereNotNull('ruangan_id');
        }

        $events = $query->get()->map(function ($item) {
            $isAlat = $item->alat_id != null;

            return [
                'id'    => $item->id,
                'title' => $isAlat 
                    ? 'Alat: ' . ($item->alat->nama_alat ?? 'Tidak diketahui')
                    : 'Ruangan: ' . ($item->ruangan->nama_ruangan ?? 'Tidak diketahui'),
                'start' => $item->tanggal_pinjam,
                'end'   => $item->tanggal_kembali,
                'color' => $isAlat ? '#2583F8' : '#27AE60',
            ];
        });

        return response()->json($events);
    }

    public function updateTanggal(Request $req)
    {
        $req->validate([
            'id' => 'required',
            'start' => 'required|date',
            'end' => 'nullable|date'
        ]);

        $p = Peminjaman::findOrFail($req->id);
        $p->tanggal_pinjam = $req->start;
        $p->tanggal_kembali = $req->end ?? $req->start;
        $p->save();

        return response()->json(['success' => true]);
    }
}
