@extends('layouts.backend')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2 class="fw-bold">👥 Daftar Pengguna</h2>
        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary shadow-sm px-4">
            + Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $i => $u)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $u->nama_pengguna }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($u->peran) }}</span></td>

                            <td>
                                <a href="{{ route('admin.pengguna.show', $u->id) }}"
                                   class="btn btn-sm btn-info">Detail</a>

                                <a href="{{ route('admin.pengguna.edit', $u->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.pengguna.destroy', $u->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf @method('DELETE')

                                    <button onclick="return confirm('Yakin ingin menghapus pengguna ini?')"
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted py-4">Belum ada pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
@endsection
