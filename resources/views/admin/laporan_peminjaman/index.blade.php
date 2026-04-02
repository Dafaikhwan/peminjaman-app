@extends('layouts.backend')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Laporan Peminjaman</h4>
        <div>
            <a href="{{ route('admin.laporan.peminjaman.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
                <i class="bi bi-filetype-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.laporan.peminjaman.excel', request()->all()) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.peminjaman') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status_peminjaman" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="pending" {{ request('status_peminjaman') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status_peminjaman') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status_peminjaman') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai" {{ request('status_peminjaman') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status_peminjaman') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Alat</label>
                    <select name="alat_id" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach($alats as $alat)
                            <option value="{{ $alat->id }}" {{ request('alat_id') == $alat->id ? 'selected' : '' }}>
                                {{ $alat->nama_alat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ruangan</label>
                    <select name="ruangan_id" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach($ruangans as $ruangan)
                            <option value="{{ $ruangan->id }}" {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pengguna</label>
                    <select name="pengguna_id" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach($penggunas as $pengguna)
                            <option value="{{ $pengguna->id }}" {{ request('pengguna_id') == $pengguna->id ? 'selected' : '' }}>
                                {{ $pengguna->nama_pengguna }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.laporan.peminjaman') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary text-center">
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
@forelse ($data as $pinjam)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $pinjam['pengguna'] }}</td>

    <td>
        @foreach($pinjam['items'] as $item)
            @if($pinjam['tipe'] == 'alat')
                <span class="badge bg-info">{{ $item }}</span>
            @else
                <span class="badge bg-success">{{ $item }}</span>
            @endif
        @endforeach
    </td>

    <td>{{ $pinjam['tanggal_mulai'] }}</td>
    <td>{{ $pinjam['tanggal_selesai'] }}</td>
    <td>{{ $pinjam['jam'] }}</td>

    <td>
        @php
            $statusClass = [
                'pending' => 'warning',
                'disetujui' => 'primary',
                'ditolak' => 'danger',
                'selesai' => 'success',
                'dibatalkan' => 'secondary',
            ][$pinjam['status']] ?? 'secondary';
        @endphp

        <span class="badge bg-{{ $statusClass }}">
            {{ ucfirst($pinjam['status']) }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">Tidak ada data</td>
</tr>
@endforelse
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection
