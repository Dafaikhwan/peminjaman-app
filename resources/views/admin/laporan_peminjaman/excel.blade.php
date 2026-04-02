<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Pengguna</th>
            <th>Alat / Ruangan</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjamans as $i => $pinjam)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $pinjam->tanggal_mulai }}</td>
            <td>{{ $pinjam->tanggal_selesai }}</td>
            <td>{{ $pinjam->pengguna->nama_pengguna ?? '-' }}</td>
            <td>{{ $pinjam->alat->nama_alat ?? $pinjam->ruangan->nama_ruangan ?? '-' }}</td>
            <td>{{ $pinjam->jam_mulai }} - {{ $pinjam->jam_selesai }}</td>
            <td>{{ ucfirst($pinjam->status_peminjaman) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
