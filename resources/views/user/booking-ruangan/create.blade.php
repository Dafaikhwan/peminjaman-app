@extends('layouts.user')

@section('content')
<h1>Booking Ruangan</h1>

<form action="{{ route('user.booking-ruangan.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Ruangan</label>
    <select name="ruangan_id" class="form-control" required>
        @foreach($ruangans as $r)
        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Tanggal</label>
    <input type="date" name="tanggal" class="form-control" required>
</div>

<div class="mb-3">
    <label>Jam Mulai</label>
    <input type="time" name="jam_mulai" class="form-control" required>
</div>

<div class="mb-3">
    <label>Jam Selesai</label>
    <input type="time" name="jam_selesai" class="form-control" required>
</div>

<button class="btn btn-success">Simpan</button>
<a href="{{ route('user.booking-ruangan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
