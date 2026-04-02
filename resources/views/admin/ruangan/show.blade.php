@extends('layouts.backend')

@section('content')
<h2 class="fw-bold mb-4">Detail Ruangan</h2>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">

        <p><strong>Nama Ruangan:</strong> {{ $ruangan->nama_ruangan }}</p>
        <p><strong>Kapasitas:</strong> {{ $ruangan->kapasitas ?? '-' }}</p>

        <p><strong>Status:</strong>
            @if($ruangan->status_ruangan == 'tersedia')
                <span class="badge bg-success">Tersedia</span>
            @elseif($ruangan->status_ruangan == 'dipinjam')
                <span class="badge bg-warning text-dark">Dipinjam</span>
            @else
                <span class="badge bg-danger">Perbaikan</span>
            @endif
        </p>

        <p><strong>Deskripsi:</strong> {{ $ruangan->deskripsi_ruangan ?? '-' }}</p>

        <p><strong>Dibuat:</strong> {{ $ruangan->created_at->format('d-m-Y H:i') }}</p>
        <p><strong>Diperbarui:</strong> {{ $ruangan->updated_at->format('d-m-Y H:i') }}</p>

        <a href="{{ route('admin.ruangan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        <a href="{{ route('admin.ruangan.edit', $ruangan->id) }}" class="btn btn-warning text-white mt-3">Edit</a>

    </div>
</div>
@endsection
