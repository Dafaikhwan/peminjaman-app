@extends('layouts.backend')

@section('content')
<h2 class="fw-bold mb-4">Edit Ruangan</h2>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.ruangan.update', $ruangan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Ruangan</label>
                <input type="text" class="form-control" name="nama_ruangan"
                    value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kapasitas</label>
                <input type="number" class="form-control" name="kapasitas"
                    value="{{ old('kapasitas', $ruangan->kapasitas) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control"
                    name="deskripsi_ruangan">{{ old('deskripsi_ruangan', $ruangan->deskripsi_ruangan) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select class="form-select" name="status_ruangan" required>
                    <option value="tersedia" {{ $ruangan->status_ruangan=='tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ $ruangan->status_ruangan=='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="perbaikan" {{ $ruangan->status_ruangan=='perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning text-white">Update</button>
            <a href="{{ route('admin.ruangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>

    </div>
</div>
@endsection
