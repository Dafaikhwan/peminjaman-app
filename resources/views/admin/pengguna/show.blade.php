@extends('layouts.backend')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">📌 Detail Pengguna</h2>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            <p class="mb-2"><strong>Nama:</strong> {{ $pengguna->nama_pengguna }}</p>
            <p class="mb-2"><strong>Email:</strong> {{ $pengguna->email }}</p>
            <p class="mb-2"><strong>Peran:</strong> <span class="badge bg-info">{{ ucfirst($pengguna->peran) }}</span></p>
            <p class="mb-2"><strong>Dibuat:</strong> {{ $pengguna->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Terakhir Diupdate:</strong> {{ $pengguna->updated_at->format('d/m/Y H:i') }}</p>

        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('admin.pengguna.edit', $pengguna->id) }}" class="btn btn-warning">Edit</a>
    </div>

</div>
@endsection
