<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str; // <--- Tambahkan ini di atas controller
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\LaporanKerusakan;
use App\Models\Alat;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ===== DASHBOARD ADMIN =====
    public function dashboard(Request $request)
    {
        // Ambil peminjaman & laporan
        $peminjamanQuery = Peminjaman::with(['pengguna','details.alat']);
        if ($request->has('status_peminjaman') && $request->status_peminjaman != '') {
            $peminjamanQuery->where('status_peminjaman', $request->status_peminjaman);
        }
        $peminjamans = $peminjamanQuery->latest()->take(10)->get(); // 10 terbaru

        $laporanQuery = LaporanKerusakan::with('pengguna');
        if ($request->has('status_laporan') && $request->status_laporan != '') {
            $laporanQuery->where('status_laporan', $request->status_laporan);
        }
        $laporans = $laporanQuery->get();

        // ===== KPI =====
        $jumlahAlat = Alat::count();
        $jumlahRuangan = Ruangan::count();
        $jumlahPeminjaman = Peminjaman::whereIn('status_peminjaman', ['pending','disetujui'])->count();
        $jumlahLaporan = LaporanKerusakan::count();

        // ===== Tren Peminjaman per bulan (Line Chart) =====
        $currentYear = Carbon::now()->year;
        $trenData = Peminjaman::select(
    DB::raw('MONTH(tanggal) as bulan'),
    DB::raw('COUNT(*) as total')
)
->whereYear('tanggal', $currentYear)
->groupBy('bulan')
->orderBy('bulan')
->pluck('total','bulan')
->toArray();

        $trenLabels = [];
        $trenValues = [];
        for($m=1; $m<=12; $m++){
            $trenLabels[] = Carbon::create()->month($m)->format('M');
            $trenValues[] = $trenData[$m] ?? 0;
        }

        // ===== Pie Chart Status Peminjaman =====
        $pieValues = [
            Peminjaman::where('status_peminjaman','disetujui')->count(),
            Peminjaman::where('status_peminjaman','pending')->count(),
            Peminjaman::where('status_peminjaman','ditolak')->count(),
        ];

        return view('dashboards.admin', compact(
            'peminjamans','laporans',
            'jumlahAlat','jumlahRuangan','jumlahPeminjaman','jumlahLaporan',
            'trenLabels','trenValues','pieValues'
        ));
    }

    public function dashboardTeknisi()
{
    $laporans = LaporanKerusakan::with('pengguna')->latest()->get();

    // Ringkasan status case-insensitive
    $laporanDiajukan = $laporans->filter(fn($lap) => Str::lower($lap->status_laporan) === 'diajukan')->count();
    $laporanDiproses = $laporans->filter(fn($lap) => Str::lower($lap->status_laporan) === 'diproses')->count();
    $laporanSelesai = $laporans->filter(fn($lap) => Str::lower($lap->status_laporan) === 'selesai')->count();
    $laporanLainnya = $laporans->count() - ($laporanDiajukan + $laporanDiproses + $laporanSelesai);
    $totalLaporan = $laporans->count();

    return view('dashboards.teknisi', compact(
        'laporans',
        'totalLaporan',
        'laporanDiajukan',
        'laporanDiproses',
        'laporanSelesai',
        'laporanLainnya'
    ));
}


    // ===== DASHBOARD USER =====
    public function dashboardUser(Request $request)
    {
        $peminjamanQuery = Peminjaman::with(['pengguna','details.alat']);
        if ($request->has('status_peminjaman') && $request->status_peminjaman != '') {
            $peminjamanQuery->where('status_peminjaman', $request->status_peminjaman);
        }
        $peminjamans = $peminjamanQuery->get();

        $laporanQuery = LaporanKerusakan::with('pengguna');
        if ($request->has('status_laporan') && $request->status_laporan != '') {
            $laporanQuery->where('status_laporan', $request->status_laporan);
        }
        $laporans = $laporanQuery->get();

        return view('dashboards.user', compact('peminjamans','laporans'));
    }

    // ===== DETAIL PEMINJAMAN =====
    public function showPeminjaman($id)
    {
        $peminjaman = Peminjaman::with(['pengguna','details.alat'])->findOrFail($id);
        return view('dashboards.admin.peminjaman.show', compact('peminjaman'));
    }

    // ===== DETAIL LAPORAN =====
    public function showLaporan($id)
    {
        $laporan = LaporanKerusakan::with('pengguna')->findOrFail($id);
        return view('dashboards.admin.laporan.show', compact('laporan'));
    }
}
