<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kerusakan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color:#111; }
        .kop { text-align:center; margin-bottom:6px; }
        .kop h2 { margin:0; font-size:18px; }
        .kop p { margin:0; font-size:11px; }
        hr { border:0; border-top:2px solid #333; margin:8px 0 12px 0; }
        table { width:100%; border-collapse:collapse; font-size:11px; }
        th, td { border:1px solid #333; padding:6px; text-align:left; vertical-align:top; }
        th { background:#f2f2f2; }
        .ttd { margin-top:30px; width:100%; }
        .ttd .right { float:right; text-align:center; width:300px; }
    </style>
</head>
<body>

<div class="kop">
    <h2>SMK NEGERI 1 CONTOH</h2>
    <p>Jl. Pendidikan No. 123, Kota Contoh — Telp: (021) 556677</p>
</div>
<hr>

<h3 style="text-align:center; margin-top:4px;">Laporan Kerusakan</h3>

<table>
    <thead>
        <tr>
            <th style="width:40px">No</th>
            <th>Tanggal</th>
            <th>Pelapor</th>
            <th>Lokasi</th>
            <th>Jenis Kerusakan</th>
            <th>Deskripsi</th>
            <th style="width:90px">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $row->pengguna->nama_pengguna ?? '-' }}</td>
            <td>{{ $row->lokasi }}</td>
            <td>{{ $row->jenis_kerusakan }}</td>
            <td>{{ $row->deskripsi_kerusakan }}</td>
            <td>{{ ucfirst($row->status_laporan) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="ttd">
    <div class="right">
        <p>Kota Contoh, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>(Kepala Tata Usaha)</strong></p>
    </div>
</div>

</body>
</html>
