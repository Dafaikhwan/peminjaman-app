@extends('layouts.backend')

@section('title', 'Detail Alat')

@push('styles')
<style>.detail-card{max-width:820px;margin:0 auto;}</style>
@endpush

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.alat.index') }}">Alat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm rounded-4 detail-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="fw-bold">{{ $alat->nama_alat }}</h4>
                    <div class="text-muted small mb-2">ID: #{{ $alat->id }} • Dibuat {{ $alat->created_at->diffForHumans() }}</div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="showDeleteModal({{ $alat->id }}, '{{ addslashes($alat->nama_alat) }}')">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </div>

            <hr>

            <p><strong>Deskripsi:</strong><br>{!! nl2br(e($alat->deskripsi_alat ?? '-')) !!}</p>

            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Jumlah</p>
                    <h5 class="fw-semibold">{{ $alat->jumlah }}</h5>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Status</p>
                    @if($alat->status_alat == 'tersedia')
                        <span class="badge bg-success rounded-pill">Tersedia</span>
                    @elseif($alat->status_alat == 'dipinjam')
                        <span class="badge bg-warning text-dark rounded-pill">Dipinjam</span>
                    @else
                        <span class="badge bg-danger rounded-pill">Rusak</span>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary px-4">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
