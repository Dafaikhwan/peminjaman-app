@extends('layouts.backend')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Laporan Kerusakan</h3>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body p-0">

        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Lokasi</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($laporans as $laporan)
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
                    <td>{{ $laporan->created_at->format('d-m-Y') }}</td>

                    <td>
                        <a href="{{ route('teknisi.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('teknisi.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-3">Belum ada laporan kerusakan</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection
