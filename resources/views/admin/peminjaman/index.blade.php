@extends('layouts.backend')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">📘 Data Peminjaman</h3>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">
            + Tambah
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Pengguna</th>
                        <th>Alat</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->pengguna->nama_pengguna }}</td>
                        <td>
@if($p->tipe == 'alat')
    @foreach($p->details as $d)
        {{ $d->alat->nama_alat }} ({{ $d->qty }})<br>
    @endforeach
@else
    @foreach($p->details as $d)
        {{ $d->ruangan->nama_ruangan ?? '-' }}
    @endforeach
@endif
</td>
                        <td>
                            {{ $p->tanggal_mulai }} s/d {{ $p->tanggal_selesai }} <br>
                            {{ $p->jam_mulai }} - {{ $p->jam_selesai }}
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $p->status_peminjaman }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.peminjaman.show',$p->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.peminjaman.edit',$p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.peminjaman.destroy',$p->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
