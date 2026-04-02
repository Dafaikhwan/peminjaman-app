@extends('layouts.user')

@section('content')
<h1>Detail Booking</h1>

<table class="table">
<tr>
    <th>Ruangan</th>
    <td>{{ $booking->ruangan->nama_ruangan }}</td>
</tr>
<tr>
    <th>Tanggal</th>
    <td>{{ $booking->tanggal }}</td>
</tr>
<tr>
    <th>Jam</th>
    <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
</tr>
<tr>
    <th>Status</th>
    <td>{{ $booking->status }}</td>
</tr>
</table>

<a href="{{ route('user.booking-ruangan.index') }}" class="btn btn-secondary">
    Kembali
</a>
@endsection
