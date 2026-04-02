@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Booking Ruangan</h4>

    <form action="{{ route('admin.booking-ruangan.update',$booking->id) }}" method="POST">
        @csrf @method('PUT')

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
            <input type="date" name="tanggal" class="form-control"
                   value="{{ $booking->tanggal }}">
        </div>

        <div class="mb-3">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control"
                   value="{{ $booking->jam_mulai }}">
        </div>

        <div class="mb-3">
            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control"
                   value="{{ $booking->jam_selesai }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
    <option value="pending" {{ $booking->status=='pending'?'selected':'' }}>Pending</option>
    <option value="disetujui" {{ $booking->status=='disetujui'?'selected':'' }}>Disetujui</option>
    <option value="ditolak" {{ $booking->status=='ditolak'?'selected':'' }}>Ditolak</option>
</select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.booking-ruangan.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
