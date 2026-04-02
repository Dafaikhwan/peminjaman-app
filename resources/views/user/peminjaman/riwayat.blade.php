@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Riwayat Peminjaman</h2>

    <div class="card shadow-sm rounded-3">
        <div class="card-body">

            @if($riwayats->isEmpty())
                <p class="text-center text-muted">
                    Tidak ada riwayat peminjaman.
                </p>
            @else

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th>No</th>
                            <th>Daftar Alat</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayats as $r)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>
                                @foreach($r->details as $d)
                                    {{ $d->alat->nama_alat }} 
                                    ({{ $d->qty }}) <br>
                                @endforeach
                            </td>

                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d M Y') }}
                                <br>s/d<br>
                                {{ \Carbon\Carbon::parse($r->tanggal_selesai)->format('d M Y') }}
                            </td>

                            <td class="text-center">
                                {{ $r->jam_mulai }} - {{ $r->jam_selesai }}
                            </td>

                            <td class="text-center">
                                @if($r->status_peminjaman == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($r->status_peminjaman == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($r->status_peminjaman == 'dibatalkan')
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @else
                                    <span class="badge bg-info">Selesai</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('user.peminjaman.show', $r->id) }}"
                                   class="btn btn-sm btn-info">
                                   Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @endif
        </div>
    </div>
</div>
@endsection
