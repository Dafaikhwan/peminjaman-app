<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelapor</th>
            <th>Lokasi</th>
            <th>Jenis Kerusakan</th>
            <th>Deskripsi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $row->pengguna->nama_pengguna ?? '-' }}</td>
            <td>{{ $row->lokasi }}</td>
            <td>{{ $row->jenis_kerusakan }}</td>
            <td>{{ $row->deskripsi_kerusakan }}</td>
            <td>{{ ucfirst($row->status_laporan) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
