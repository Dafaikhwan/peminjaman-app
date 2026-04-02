@extends('layouts.user')

@section('content')
<h1>Edit Laporan Kerusakan</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('user.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $laporan->lokasi) }}" required>
    </div>

    <div class="mb-3">
        <label>Jenis Kerusakan</label>
        <select name="jenis_kerusakan" class="form-select" required>
            <option value="alat" {{ $laporan->jenis_kerusakan=='alat' ? 'selected' : '' }}>Alat</option>
            <option value="ruangan" {{ $laporan->jenis_kerusakan=='ruangan' ? 'selected' : '' }}>Ruangan</option>
            <option value="lainnya" {{ $laporan->jenis_kerusakan=='lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Deskripsi Kerusakan</label>
        <textarea name="deskripsi_kerusakan" class="form-control" rows="4" required>{{ old('deskripsi_kerusakan', $laporan->deskripsi_kerusakan) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Upload Gambar (Opsional)</label>
        <input type="file" name="url_gambar" class="form-control" accept="image/*">
        @if($laporan->url_gambar)
            <p class="mt-2">Gambar saat ini:</p>
            <img src="{{ asset('storage/'.$laporan->url_gambar) }}" class="img-thumbnail" style="max-height:150px;">
        @endif
    </div>

    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('user.laporan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
