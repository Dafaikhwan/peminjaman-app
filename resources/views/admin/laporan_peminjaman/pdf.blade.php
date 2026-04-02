<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; font-size:12px; color:#111; }
        .kop { text-align:center; margin-bottom:6px; }
        .kop h2 { margin:0; font-size:16px; }
        .kop p { margin:0; font-size:11px; }
        hr { border:0; border-top:2px solid #333; margin:8px 0 12px 0; }
        table { width:100%; border-collapse:collapse; font-size:11px; }
        th, td { border:1px solid #333; padding:6px; text-align:center; vertical-align:top; }
        th { background:#f2f2f2; }
        .ttd { margin-top:30px; width:100%; }
        .ttd .right { float:right; text-align:center; width:300px; }
    </style>
</head>
<body>

<div class="kop">
    <h2>SMK NEGERI 1 CONTOH</h2>
    <p>Jl. Pendidikan No.123 — Telp: (021) 556677</p>
</div>
<hr>

<h3 style="text-align:center; margin-top:4px;">Laporan Peminjaman Alat & Ruangan</h3>
<p style="text-align:center; margin:0; font-size:11px;">Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Pengguna</th>
            <th>Alat / Ruangan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($peminjamans as $pinjam)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pinjam->pengguna->nama_pengguna ?? '-' }}</td>
                <td>{{ $pinjam->alat->nama_alat ?? $pinjam->ruangan->nama_ruangan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                <td>{{ $pinjam->jam_mulai }} - {{ $pinjam->jam_selesai }}</td>
                <td>{{ ucfirst($pinjam->status_peminjaman) }}</td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">Tidak ada data</td></tr>
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
