```blade
@extends('layouts.user')

@section('content')

<div class="container">
    <h2>Detail Laporan Kerusakan</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>ID Laporan:</strong> {{ $laporan->id }}</p>

            <p><strong>Lokasi:</strong> {{ $laporan->lokasi }}</p>

            <p><strong>Jenis Kerusakan:</strong> 
                @if($laporan->jenis_kerusakan == 'alat')
                    Alat
                @elseif($laporan->jenis_kerusakan == 'ruangan')
                    Ruangan
                @else
                    Lainnya
                @endif
            </p>

            <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi_kerusakan }}</p>

            <p><strong>Gambar:</strong><br>
                @if($laporan->url_gambar)
                    <img src="{{ asset('storage/'.$laporan->url_gambar) }}" alt="Gambar Kerusakan" class="img-fluid mt-2" style="max-width:300px;">
                @else
                    <em>Tidak ada gambar</em>
                @endif
            </p>

            <p><strong>Status:</strong> 
                @if($laporan->status_laporan == 'diajukan')
                    <span class="badge bg-warning text-dark">Diajukan</span>
                @elseif($laporan->status_laporan == 'diproses')
                    <span class="badge bg-info">Diproses</span>
                @elseif($laporan->status_laporan == 'selesai')
                    <span class="badge bg-success">Selesai</span>
                @elseif($laporan->status_laporan == 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif($laporan->status_laporan == 'dibatalkan')
                    <span class="badge bg-secondary">Dibatalkan</span>
                @endif
            </p>

            <p><strong>Dibuat Pada:</strong> 
                {{ $laporan->created_at ? $laporan->created_at->format('d M Y H:i') : '-' }}
            </p>

            {{-- Tombol aksi jika masih diajukan --}}
            @if($laporan->status_laporan == 'diajukan')
                <div class="mt-3">
                    <a href="{{ route('user.laporan.edit', $laporan->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('user.laporan.batal', $laporan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin batalkan laporan ini?')">
                            Batalkan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('user.laporan.index') }}" class="btn btn-secondary mt-3">Kembali</a>

</div>
@endsection