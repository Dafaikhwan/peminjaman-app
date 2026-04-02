@extends('layouts.backend')

@section('content')

<!-- BREADCRUMB -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light p-3 shadow-sm rounded">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.laporan.index') }}">Laporan Kerusakan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
</nav>

<div class="card shadow-lg border-0 mt-3">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Detail Laporan Kerusakan</h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <strong>ID:</strong> {{ $laporan->id }}
        </div>

        <div class="mb-3">
            <strong>Lokasi:</strong> {{ $laporan->lokasi }}
        </div>

        <div class="mb-3">
            <strong>Jenis Kerusakan:</strong> {{ ucfirst($laporan->jenis_kerusakan) }}
        </div>

        <div class="mb-3">
            <strong>Deskripsi:</strong>
            <p class="text-muted">{{ $laporan->deskripsi_kerusakan }}</p>
        </div>

        <div class="mb-3">
            <strong>Status:</strong>
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
        </div>

        <!-- UPDATE STATUS -->
        <hr>

        <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <label for="status_laporan" class="form-label">Ubah Status Laporan</label>

            <select name="status_laporan" id="status_laporan" class="form-select" required>
                <option value="diajukan" {{ $laporan->status_laporan=='diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="diproses" {{ $laporan->status_laporan=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ $laporan->status_laporan=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ $laporan->status_laporan=='ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-save"></i> Update Status
            </button>
        </form>

    </div>
</div>

<a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary mt-3">
    <i class="bi bi-arrow-left"></i> Kembali
</a>

@endsection
