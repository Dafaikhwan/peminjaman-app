@extends('layouts.backend')

@section('content')
<div class="container mt-4">
<h3 class="fw-bold mb-3">✏️ Edit Peminjaman</h3>

<form action="{{ route('admin.peminjaman.update',$peminjaman->id) }}" method="POST">
@csrf @method('PUT')

<div class="mb-3">
    <label>Pengguna</label>
    <select name="pengguna_id" class="form-control">
        @foreach($users as $u)
        <option value="{{ $u->id }}" {{ $peminjaman->pengguna_id==$u->id?'selected':'' }}>
            {{ $u->nama_pengguna }}
        </option>
        @endforeach
    </select>
</div>

<h5>Daftar Alat</h5>
@foreach($peminjaman->details as $i => $d)
<div class="row mb-2">
    <div class="col-md-6">
        <select name="alat_id[]" class="form-control">
            @foreach($alats as $a)
            <option value="{{ $a->id }}" {{ $d->alat_id==$a->id?'selected':'' }}>
                {{ $a->nama_alat }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="number" name="qty[]" value="{{ $d->qty }}" class="form-control" min="1">
    </div>
</div>
@endforeach

<hr>

<div class="row">
    <div class="col-md-3">
        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" value="{{ $peminjaman->tanggal_mulai }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" value="{{ $peminjaman->tanggal_selesai }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" value="{{ $peminjaman->jam_mulai }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" value="{{ $peminjaman->jam_selesai }}" class="form-control">
    </div>
</div>

<div class="mt-3">
    <label>Status</label>
    <select name="status_peminjaman" class="form-control">
        <option value="pending" {{ $peminjaman->status_peminjaman=='pending'?'selected':'' }}>Pending</option>
        <option value="diterima" {{ $peminjaman->status_peminjaman=='diterima'?'selected':'' }}>Diterima</option>
        <option value="ditolak" {{ $peminjaman->status_peminjaman=='ditolak'?'selected':'' }}>Ditolak</option>
        <option value="dibatalkan" {{ $peminjaman->status_peminjaman=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
    </select>
</div>

<button class="btn btn-success mt-4">Update</button>
<a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary mt-4">Kembali</a>
</form>
</div>
@endsection
