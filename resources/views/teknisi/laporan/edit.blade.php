@extends('layouts.backend')

@section('content')
<div class="card shadow p-4">

    <h3 class="mb-3">Edit Laporan Kerusakan</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teknisi.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">Status Laporan</label>
            <select name="status_laporan" class="form-select" required>
                <option value="diproses" {{ $laporan->status_laporan=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ $laporan->status_laporan=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ $laporan->status_laporan=='ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <!-- Upload Gambar -->
        <div class="mb-3">
            <label class="form-label">Upload Gambar (Opsional)</label>
            <input type="file" name="url_gambar" class="form-control" accept="image/*">

            @if($laporan->url_gambar)
                <p class="mt-2 mb-1">Gambar saat ini:</p>
                <img src="{{ asset('storage/'.$laporan->url_gambar) }}" 
                     class="img-thumbnail" style="max-height:150px;">
            @endif
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('teknisi.laporan.show', $laporan->id) }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection
