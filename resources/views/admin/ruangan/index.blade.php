@extends('layouts.backend')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Daftar Ruangan</h2>
    <a href="{{ route('admin.ruangan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Ruangan
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Ruangan</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th width="160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ruangans as $index => $ruangan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $ruangan->nama_ruangan }}</td>
                        <td>{{ $ruangan->kapasitas ?? '-' }}</td>
                        <td>
                            @if($ruangan->status_ruangan == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @elseif($ruangan->status_ruangan == 'dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-danger">Perbaikan</span>
                            @endif
                        </td>
                        <td>{{ $ruangan->deskripsi_ruangan ?: '-' }}</td>
                        <td>
                            <a href="{{ route('admin.ruangan.show', $ruangan->id) }}" class="btn btn-info btn-sm">
                                Detail
                            </a>

                            <a href="{{ route('admin.ruangan.edit', $ruangan->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.ruangan.destroy', $ruangan->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus ruangan ini?')">Hapus</button>
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
