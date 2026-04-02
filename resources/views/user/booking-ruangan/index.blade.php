@extends('layouts.user')

@section('content')
<h1>Booking Ruangan Saya</h1>

<a href="{{ route('user.booking-ruangan.create') }}" class="btn btn-primary mb-3">
    + Booking Ruangan
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Ruangan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $i => $b)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $b->ruangan->nama_ruangan }}</td>
            <td>{{ $b->tanggal }}</td>
            <td>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
            <td>
                @if($b->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($b->status == 'disetujui')
                    <span class="badge bg-success">Disetujui</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </td>
            <td>
                <a href="{{ route('user.booking-ruangan.show',$b->id) }}" class="btn btn-info btn-sm">Detail</a>

                @if($b->status == 'pending')
                <a href="{{ route('user.booking-ruangan.edit',$b->id) }}" class="btn btn-warning btn-sm">Edit</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
