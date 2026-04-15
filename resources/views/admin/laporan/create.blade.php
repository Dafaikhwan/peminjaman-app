@extends('layouts.backend')

@section('content')
<div class="container mt-4">

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Laporan Kerusakan</h5>
        </div>

        <div class="card-body">

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- LOKASI --}}
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
                </div>

                {{-- JENIS KERUSAKAN --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Kerusakan</label>
                    <select name="jenis_kerusakan" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="alat">Alat</option>
                        <option value="ruangan">Ruangan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi Kerusakan</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                </div>

                {{-- UPLOAD GAMBAR --}}
                <div class="mb-3">
                    <label class="form-label">Upload Gambar (opsional)</label>
                    <input type="file" name="url_gambar" class="form-control">
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection