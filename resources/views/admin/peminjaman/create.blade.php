@extends('layouts.backend')

@section('content')
<div class="container mt-4">
<h3 class="fw-bold mb-3">➕ Tambah Peminjaman</h3>

<form action="{{ route('admin.peminjaman.store') }}" method="POST">
@csrf

<div class="row mb-3">
    <div class="col-md-6">
        <label>Pengguna</label>
        <select name="pengguna_id" class="form-control">
            @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->nama_pengguna }}</option>
            @endforeach
        </select>
    </div>
</div>

<hr>
<h5>Daftar Alat</h5>
<div id="alat-wrapper">
    <div class="row mb-2">
        <div class="col-md-6">
            <select name="alat_id[]" class="form-control">
                @foreach($alats as $a)
                <option value="{{ $a->id }}">{{ $a->nama_alat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="qty[]" class="form-control" placeholder="Qty">
        </div>
    </div>
</div>

<button type="button" onclick="addAlat()" class="btn btn-secondary btn-sm mb-3">
+ Tambah Alat
</button>

<hr>

<div class="row">
    <div class="col-md-3">
        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" class="form-control">
    </div>
    <div class="col-md-3">
        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" class="form-control">
    </div>
</div>

<button class="btn btn-success mt-4">Simpan</button>
<a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary mt-4">Kembali</a>
</form>
</div>

<script>
function addAlat(){
    document.getElementById('alat-wrapper').insertAdjacentHTML('beforeend',`
    <div class="row mb-2">
        <div class="col-md-6">
            <select name="alat_id[]" class="form-control">
                @foreach($alats as $a)
                <option value="{{ $a->id }}">{{ $a->nama_alat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="qty[]" class="form-control" placeholder="Qty">
        </div>
        <div class="col-md-1">
                <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
    </div>
    `);
}
</script>
@endsection
