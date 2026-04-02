@extends('layouts.user')

@section('content')
<h1>Daftar Laporan Kerusakan Saya</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('user.laporan.create') }}" class="btn btn-primary mb-3">Buat Laporan Baru</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Lokasi</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Gambar</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporans as $laporan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $laporan->lokasi }}</td>
            <td>{{ ucfirst($laporan->jenis_kerusakan) }}</td>
            <td>
                @if($laporan->status_laporan=='diajukan')
                    <span class="badge bg-warning text-dark">Diajukan</span>
                @elseif($laporan->status_laporan=='diproses')
                    <span class="badge bg-primary">Diproses</span>
                @elseif($laporan->status_laporan=='selesai')
                    <span class="badge bg-success">Selesai</span>
                @elseif($laporan->status_laporan=='ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif($laporan->status_laporan=='dibatalkan')
                    <span class="badge bg-secondary">Dibatalkan</span>
                @endif
            </td>
            <td>
                @if($laporan->url_gambar)
                    <img src="{{ asset('storage/' . $laporan->url_gambar) }}" alt="Gambar" class="img-thumbnail" style="max-height: 80px;">
                @else
                    -
                @endif
            </td>
            <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
            <td>
                <a href="{{ route('user.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>

                @if($laporan->status_laporan == 'diajukan')
                    <a href="{{ route('user.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('user.laporan.batal', $laporan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin batalkan laporan ini?')">Batalkan</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection