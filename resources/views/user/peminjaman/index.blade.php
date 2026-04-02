@extends('layouts.user')

@section('content')

<h1>Peminjaman Saya</h1>

<a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary mb-2">
    Ajukan Peminjaman
</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Detail Peminjaman</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjamans as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>
                @foreach($p->details as $d)
                    @if($d->alat)
                        🧰 {{ $d->alat->nama_alat }} ({{ $d->qty }}) <br>
                    @endif

                    @if($d->ruangan)
                        🏢 {{ $d->ruangan->nama_ruangan }} <br>
                    @endif
                @endforeach
            </td>

            <td>
                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }} 
                s/d 
                {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
            </td>

            <td>
                {{ $p->jam_mulai }} - {{ $p->jam_selesai }}
            </td>

            <td>
                @if($p->status_peminjaman == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @elseif($p->status_peminjaman == 'diterima')
                    <span class="badge bg-success">Diterima</span>
                @elseif($p->status_peminjaman == 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif($p->status_peminjaman == 'dibatalkan')
                    <span class="badge bg-secondary">Dibatalkan</span>
                @else
                    <span class="badge bg-info">Selesai</span>
                @endif
            </td>

            <td>
                <a href="{{ route('user.peminjaman.show', $p->id) }}" 
                   class="btn btn-sm btn-info">Detail</a>

                @if($p->status_peminjaman == 'pending')
                    <a href="{{ route('user.peminjaman.edit', $p->id) }}" 
                       class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('user.peminjaman.batal', $p->id) }}" 
                          method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" 
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin batalkan peminjaman ini?')">
                            Batalkan
                        </button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
