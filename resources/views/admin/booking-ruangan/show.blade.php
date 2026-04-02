@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Detail Booking Ruangan</h4>

    <table class="table table-bordered">
        <tr>
            <th>Pengguna</th>
            <td>{{ $booking->pengguna->nama_pengguna ?? '-' }}</td>
        </tr>
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

    <a href="{{ route('admin.booking-ruangan.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>
@endsection
