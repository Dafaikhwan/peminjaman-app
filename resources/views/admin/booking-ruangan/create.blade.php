@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Booking Ruangan</h4>

    <form action="{{ route('admin.booking-ruangan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="ruangan_id" class="form-control" required>
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangans as $r)
                    <option value="{{ $r->id }}">
                        {{ $r->nama_ruangan }}
                    </option>
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

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.booking-ruangan.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
