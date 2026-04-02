<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use App\Models\Pengguna;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKerusakanExport;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanKerusakanExportController extends Controller
{
    // Halaman utama laporan + filter + cards + chart
    public function index(Request $request)
    {
        $query = LaporanKerusakan::with('pengguna');

        // === Filter ===
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            // include entire day for tanggal_selesai
            $start = $request->tanggal_mulai . ' 00:00:00';
            $end = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($request->filled('status_laporan')) {
            $query->where('status_laporan', $request->status_laporan);
        }

        if ($request->filled('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }

        // ambil data (collection) — untuk export dan tabel penuh
        $laporan = $query->latest()->get();
        $penggunas = Pengguna::all();

        // counts untuk statistik card
        $count_diajukan = LaporanKerusakan::where('status_laporan','diajukan')->count();
        $count_diproses = LaporanKerusakan::where('status_laporan','diproses')->count();
        $count_selesai  = LaporanKerusakan::where('status_laporan','selesai')->count();
        $count_dibatalkan= LaporanKerusakan::where('status_laporan','dibatalkan')->count();

        return view('admin.laporan_kerusakan.index', compact(
            'laporan',
            'penggunas',
            'count_diajukan',
            'count_diproses',
            'count_selesai',
            'count_dibatalkan'
        ));
    }

    // Chart API untuk Chart.js (json)
    public function chart()
    {
        return response()->json([
            'diajukan'   => LaporanKerusakan::where('status_laporan','diajukan')->count(),
            'diproses'   => LaporanKerusakan::where('status_laporan','diproses')->count(),
            'selesai'    => LaporanKerusakan::where('status_laporan','selesai')->count(),
            'dibatalkan' => LaporanKerusakan::where('status_laporan','dibatalkan')->count(),
        ]);
    }

    // === Export PDF ===
    public function exportPdf(Request $request)
    {
        $laporan = $this->getFilteredData($request);
        $pdf = PDF::loadView('admin.laporan_kerusakan.pdf', compact('laporan'))
                 ->setPaper('a4', 'landscape');
        return $pdf->download('laporan_kerusakan.pdf');
    }

    // === Export Excel ===
    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanKerusakanExport($request), 'laporan_kerusakan.xlsx');
    }

    // === Export CSV (streamed, tidak menyimpan file di server) ===
    public function exportCsv(Request $request)
    {
        $data = $this->getFilteredData($request);

        $response = new StreamedResponse(function() use ($data) {
            $handle = fopen('php://output', 'w');
            // header kolom
            fputcsv($handle, ['No','Tanggal','Pelapor','Lokasi','Jenis Kerusakan','Deskripsi','Status']);
            foreach ($data as $i => $row) {
                fputcsv($handle, [
                    $i + 1,
                    $row->created_at->format('d/m/Y H:i'),
                    $row->pengguna->nama_pengguna ?? '-',
                    $row->lokasi,
                    $row->jenis_kerusakan,
                    strip_tags($row->deskripsi_kerusakan),
                    ucfirst($row->status_laporan),
                ]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="laporan_kerusakan.csv"',
        ]);

        return $response;
    }

    // === Helper ambil data dengan filter ===
    private function getFilteredData($request)
    {
        $query = LaporanKerusakan::with('pengguna');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $start = $request->tanggal_mulai . ' 00:00:00';
            $end = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($request->filled('status_laporan')) {
            $query->where('status_laporan', $request->status_laporan);
        }

        if ($request->filled('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }

        return $query->latest()->get();
    }
}
