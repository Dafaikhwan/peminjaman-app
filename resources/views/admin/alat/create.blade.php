@extends('layouts.backend')

@section('title', 'Tambah Alat')

@push('styles')
<style>
.form-card { max-width:820px; margin:0 auto; }
</style>
@endpush

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.alat.index') }}">Alat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm rounded-4 form-card">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-3">➕ Tambah Alat</h3>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.alat.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Alat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded-3" name="nama_alat" value="{{ old('nama_alat') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Alat</label>
                    <textarea class="form-control rounded-3" name="deskripsi_alat" rows="4">{{ old('deskripsi_alat') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control rounded-3" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select rounded-3" name="status_alat">
                            <option value="tersedia" {{ old('status_alat') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('status_alat') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="rusak" {{ old('status_alat') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.alat.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
