@extends('layouts.backend')

@section('content')
<div class="container mt-4">
<h3 class="fw-bold mb-3">📄 Detail Peminjaman</h3>

<div class="card p-4">
    <p><b>Pengguna:</b> {{ $peminjaman->pengguna->nama_pengguna }}</p>
    <p><b>Periode:</b> {{ $peminjaman->tanggal_mulai }} s/d {{ $peminjaman->tanggal_selesai }}</p>
    <p><b>Jam:</b> {{ $peminjaman->jam_mulai }} - {{ $peminjaman->jam_selesai }}</p>
    <p><b>Status:</b> {{ $peminjaman->status_peminjaman }}</p>

    <hr>
    <h5>Daftar Alat</h5>
    <ul>
        @foreach($peminjaman->details as $d)
        <li>{{ $d->alat->nama_alat }} ({{ $d->qty }})</li>
        @endforeach
    </ul>
</div>

<a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
