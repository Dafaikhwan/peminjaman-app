@extends('layouts.backend')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">➕ Tambah Pengguna</h2>

    <div class="card shadow-sm rounded-4 p-4">

        @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengguna.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Pengguna</label>
                    <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}"
                           class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Peran</label>
                    <select name="peran" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="teknisi">Teknisi</option>
                    </select>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-success px-4 shadow-sm">Simpan</button>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary px-4">Batal</a>
            </div>

        </form>
    </div>
</div>
@endsection
