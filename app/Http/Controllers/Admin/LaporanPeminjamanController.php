<?php

namespace App\Http\Controllers\Admin;
use App\Models\BookingRuangan; // tambahin di atas
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Ruangan;
use App\Models\Pengguna;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

class LaporanPeminjamanController extends Controller
{
    public function index(Request $request)
{
    // ================= PEMINJAMAN ALAT =================
    $queryAlat = Peminjaman::with(['details.alat','pengguna']);

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
        $queryAlat->whereBetween('tanggal', [
            $request->tanggal_mulai,
            $request->tanggal_selesai
        ]);
    }

    if ($request->filled('status_peminjaman')) {
        $queryAlat->where('status_peminjaman', $request->status_peminjaman);
    }

    if ($request->filled('alat_id')) {
        $queryAlat->whereHas('details', function($q) use ($request){
            $q->where('alat_id', $request->alat_id);
        });
    }

    if ($request->filled('pengguna_id')) {
        $queryAlat->where('pengguna_id', $request->pengguna_id);
    }

    $peminjamanAlat = $queryAlat->get()->map(function ($item) {
        return [
            'pengguna' => $item->pengguna->nama_pengguna ?? '-',
            'items' => $item->details->map(fn($d) => $d->alat->nama_alat ?? '-')->toArray(),
            'tanggal_mulai' => $item->tanggal,
            'tanggal_selesai' => $item->tanggal,
            'jam' => $item->jam_mulai.' - '.$item->jam_selesai,
            'status' => $item->status_peminjaman,
            'tipe' => 'alat'
        ];
    });

    // ================= BOOKING RUANGAN =================
    $queryRuangan = BookingRuangan::with(['ruangan','pengguna']);

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
        $queryRuangan->whereBetween('tanggal', [
            $request->tanggal_mulai,
            $request->tanggal_selesai
        ]);
    }

    if ($request->filled('status_peminjaman')) {
        $queryRuangan->where('status', $request->status_peminjaman);
    }

    if ($request->filled('ruangan_id')) {
        $queryRuangan->where('ruangan_id', $request->ruangan_id);
    }

    if ($request->filled('pengguna_id')) {
        $queryRuangan->where('pengguna_id', $request->pengguna_id);
    }

    $bookingRuangan = $queryRuangan->get()->map(function ($item) {
        return [
            'pengguna' => $item->pengguna->nama_pengguna ?? '-',
            'items' => [$item->ruangan->nama_ruangan ?? '-'],
            'tanggal_mulai' => $item->tanggal,
            'tanggal_selesai' => $item->tanggal,
            'jam' => $item->jam_mulai.' - '.$item->jam_selesai,
            'status' => $item->status,
            'tipe' => 'ruangan'
        ];
    });

    // ================= GABUNG =================
    $data = $peminjamanAlat->concat($bookingRuangan)->sortByDesc('tanggal_mulai');

    return view('admin.laporan_peminjaman.index', [
        'data' => $data,
        'alats' => Alat::all(),
        'ruangans' => Ruangan::all(),
        'penggunas' => Pengguna::all(),
    ]);
}
    // Chart.js data
    public function chart()
    {
        return response()->json([
            'pending'    => Peminjaman::where('status_peminjaman','pending')->count(),
            'disetujui'  => Peminjaman::where('status_peminjaman','disetujui')->count(),
            'ditolak'    => Peminjaman::where('status_peminjaman','ditolak')->count(),
            'selesai'    => Peminjaman::where('status_peminjaman','selesai')->count(),
            'dibatalkan' => Peminjaman::where('status_peminjaman','dibatalkan')->count(),
        ]);
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $peminjamans = $this->getFilteredData($request);

        $pdf = PDF::loadView('admin.laporan_peminjaman.pdf', compact('peminjamans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_peminjaman_'.now()->format('Ymd_His').'.pdf');
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new PeminjamanExport($request), 'laporan_peminjaman_'.now()->format('Ymd_His').'.xlsx');
    }

    // helper utk PDF & Excel
    private function getFilteredData(Request $request)
    {
        $query = Peminjaman::with(['details.alat','details.ruangan','pengguna']);



        if($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')){
            $query->whereBetween('tanggal_mulai', [
                $request->tanggal_mulai.' 00:00:00',
                $request->tanggal_selesai.' 23:59:59'
            ]);
        }
        if($request->filled('status_peminjaman')){
            $query->where('status_peminjaman', $request->status_peminjaman);
        }
        if($request->filled('alat_id')){
    $query->whereHas('details', function($q) use ($request){
        $q->where('alat_id', $request->alat_id);
    });
}
if($request->filled('ruangan_id')){
    $query->whereHas('details', function($q) use ($request){
        $q->where('ruangan_id', $request->ruangan_id);
    });
}

        if($request->filled('pengguna_id')){
            $query->where('pengguna_id', $request->pengguna_id);
        }

        return $query->orderBy('created_at','desc')->get();
    }
}
