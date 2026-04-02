@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Data Booking Ruangan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.booking-ruangan.create') }}" class="btn btn-primary mb-3">
        + Booking Ruangan
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pengguna</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $i => $b)
            <tr>
                <td>{{ $i + $bookings->firstItem() }}</td>
                <td>{{ $b->pengguna->nama_pengguna ?? '-' }}</td>
                <td>{{ $b->ruangan->nama_ruangan ?? '-' }}</td>
                <td>{{ $b->tanggal }}</td>
                <td>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                <td>
                    <span class="badge bg-warning">{{ $b->status }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.booking-ruangan.show',$b->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.booking-ruangan.edit',$b->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.booking-ruangan.destroy',$b->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bookings->links() }}
</div>
@endsection
