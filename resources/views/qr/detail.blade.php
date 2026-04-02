@extends('layouts.backend')

@section('content')
<div class="card shadow p-4">
    <h4>Detail Peminjaman (Scan QR)</h4>

    <ul class="list-group mt-3">

        <li class="list-group-item">
            <b>ID:</b> {{ $data->id }}
        </li>

        <li class="list-group-item">
            <b>Alat / Ruangan:</b> 
            {{ $data->alat->nama_alat ?? $data->ruangan->nama_ruangan ?? '-' }}
        </li>

        <li class="list-group-item">
            <b>Peminjam:</b> 
            {{ $data->pengguna->nama_pengguna ?? '-' }}
        </li>

        <li class="list-group-item">
            <b>Tanggal Pinjam:</b> 
            {{ $data->tanggal_mulai }}
        </li>

        <li class="list-group-item">
            <b>Tanggal Kembali:</b> 
            {{ $data->tanggal_selesai }}
        </li>

        <li class="list-group-item">
            <b>Status:</b> 
            {{ ucfirst($data->status_peminjaman) }}
        </li>

    </ul>
</div>
@endsection
