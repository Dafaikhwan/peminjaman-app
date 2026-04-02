@extends('layouts.backend')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">✏️ Edit Pengguna</h2>

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


        <form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Pengguna</label>
                    <input type="text" name="nama_pengguna"
                           class="form-control"
                           value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email"
                           class="form-control"
                           value="{{ old('email', $pengguna->email) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Peran</label>
                    <select name="peran" class="form-select">
                        <option value="admin"   {{ $pengguna->peran=='admin' ? 'selected':'' }}>Admin</option>
                        <option value="user"    {{ $pengguna->peran=='user' ? 'selected':'' }}>User</option>
                        <option value="teknisi" {{ $pengguna->peran=='teknisi' ? 'selected':'' }}>Teknisi</option>
                    </select>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-success px-4 shadow-sm">Update</button>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary px-4">Batal</a>
            </div>

        </form>

    </div>
</div>
@endsection
