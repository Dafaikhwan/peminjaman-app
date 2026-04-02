@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Detail Peminjaman</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>ID Peminjaman:</strong> {{ $peminjaman->id }}</p>

            <p><strong>Daftar Alat:</strong></p>
            <ul>
                @foreach($peminjaman->details as $d)
                    <li>
                        {{ $d->alat->nama_alat }} 
                        (Qty: {{ $d->qty }})
                    </li>
                @endforeach
            </ul>

            <p><strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->format('d M Y') }}
                s/d
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->format('d M Y') }}
            </p>

            <p><strong>Jam:</strong>
                {{ $peminjaman->jam_mulai }} - {{ $peminjaman->jam_selesai }}
            </p>

            <p><strong>Status:</strong>
                @if($peminjaman->status_peminjaman == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @elseif($peminjaman->status_peminjaman == 'diterima')
                    <span class="badge bg-success">Diterima</span>
                @elseif($peminjaman->status_peminjaman == 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif($peminjaman->status_peminjaman == 'dibatalkan')
                    <span class="badge bg-secondary">Dibatalkan</span>
                @else
                    <span class="badge bg-info">Selesai</span>
                @endif
            </p>

            <p><strong>Dibuat:</strong>
                {{ $peminjaman->created_at->format('d M Y H:i') }}
            </p>

            @if($peminjaman->status_peminjaman == 'pending')
                <div class="mt-3">
                    <a href="{{ route('user.peminjaman.edit', $peminjaman->id) }}" 
                       class="btn btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('user.peminjaman.batal', $peminjaman->id) }}" 
                          method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" 
                                class="btn btn-danger"
                                onclick="return confirm('Yakin batalkan peminjaman ini?')">
                            Batalkan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('user.peminjaman.index') }}" 
       class="btn btn-secondary mt-3">
        Kembali
    </a>
</div>
@endsection
