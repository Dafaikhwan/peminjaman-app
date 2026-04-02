<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\LaporanKerusakan;
use App\Models\Alat;
use App\Models\Ruangan;

class UserController extends Controller
{
    public function dashboard(Request $request)
{
    $userId = auth()->id();

    // Statistik
    $totalAlat = Alat::count();
    $totalRuangan = Ruangan::count();
    $totalPeminjaman = Peminjaman::where('pengguna_id', $userId)->count();
    $totalLaporan = LaporanKerusakan::where('pengguna_id', $userId)->count();

    // Peminjaman Terbaru
    $peminjamanTerbaru = Peminjaman::with('details.alat', 'details.ruangan')
    ->where('pengguna_id', $userId)
    ->latest()
    ->take(5)
    ->get();

    // Grafik 7 hari terakhir
    $chartLabels = [];
    $chartData = [];

    for ($i = 6; $i >= 0; $i--) {
        $chartLabels[] = now()->subDays($i)->format('D');
        $chartData[] = Peminjaman::where('pengguna_id', $userId)
                        ->whereDate('created_at', today()->subDays($i))
                        ->count();
    }

    // Return ke BLADE yang benar
    return view('dashboards.user', compact(
        'totalAlat',
        'totalRuangan',
        'totalPeminjaman',
        'totalLaporan',
        'peminjamanTerbaru',
        'chartLabels',
        'chartData'
    ));
}

}
