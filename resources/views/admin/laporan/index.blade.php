@extends('layouts.backend')

@section('content')

<!-- BREADCRUMB -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light p-3 shadow-sm rounded">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan Kerusakan</li>
    </ol>
</nav>

<div class="card shadow-lg border-0 mt-3">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Daftar Laporan Kerusakan</h5>

        <form method="GET" action="" class="d-flex gap-2">
            <!-- Search -->
            <input type="text" name="search" class="form-control" placeholder="Cari lokasi / jenis..."
                value="{{ request('search') }}">

            <!-- Filter Status -->
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status')=='diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="dibatalkan" {{ request('status')=='dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <!-- Tombol Filter -->
            <button class="btn btn-light"><i class="bi bi-funnel"></i></button>

            <!-- Reset -->
            @if(request('search') || request('status'))
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-repeat"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @if($laporans->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada laporan kerusakan.
                        </td>
                    </tr>
                @endif

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
                        <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $laporans->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
