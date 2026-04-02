@extends('layouts.user')

@section('content')
<h1>Edit Booking Ruangan</h1>

<form action="{{ route('user.booking-ruangan.update', $booking->id) }}" method="POST">
@csrf
@method('PUT')


<div class="mb-3">
    <label>Ruangan</label>
    <select name="ruangan_id" class="form-control">
        @foreach($ruangans as $r)
        <option value="{{ $r->id }}" 
            {{ $booking->ruangan_id == $r->id ? 'selected' : '' }}>
            {{ $r->nama_ruangan }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Tanggal</label>
    <input type="date" name="tanggal" 
           value="{{ $booking->tanggal }}" class="form-control">
</div>

<div class="mb-3">
    <label>Jam Mulai</label>
    <input type="time" name="jam_mulai" 
           value="{{ $booking->jam_mulai }}" class="form-control">
</div>

<div class="mb-3">
    <label>Jam Selesai</label>
    <input type="time" name="jam_selesai" 
           value="{{ $booking->jam_selesai }}" class="form-control">
</div>

<button class="btn btn-success">Update</button>
<a href="{{ route('user.booking-ruangan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
