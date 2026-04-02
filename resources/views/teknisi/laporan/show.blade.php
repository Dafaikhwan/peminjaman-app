@extends('layouts.backend')

@section('content')

<h3>Detail Laporan Kerusakan</h3>

<div class="card shadow mt-3">
    <div class="card-body">

        <p><strong>ID:</strong> {{ $laporan->id }}</p>
        <p><strong>Lokasi:</strong> {{ $laporan->lokasi }}</p>
        <p><strong>Jenis Kerusakan:</strong> {{ ucfirst($laporan->jenis_kerusakan) }}</p>
        <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi_kerusakan }}</p>

        <p><strong>Status:</strong>
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
        </p>

        @if($laporan->url_gambar)
            <p><strong>Bukti Foto:</strong></p>
            <img src="{{ asset('storage/'.$laporan->url_gambar) }}" 
                class="img-fluid rounded shadow mb-3" style="max-height:250px;">
        @endif

        <hr>

        <form action="{{ route('teknisi.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="form-label">Ubah Status</label>
            <select name="status_laporan" class="form-select" required>
                <option value="diproses" {{ $laporan->status_laporan=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ $laporan->status_laporan=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ $laporan->status_laporan=='ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <div class="mt-3">
                <label class="form-label">Upload Gambar (Opsional)</label>
                <input type="file" name="url_gambar" class="form-control" accept="image/*">
            </div>

            <button class="btn btn-primary mt-3">Update Status</button>
        </form>

    </div>
</div>

<a href="{{ route('teknisi.laporan.index') }}" class="btn btn-secondary mt-3">Kembali</a>

@endsection
