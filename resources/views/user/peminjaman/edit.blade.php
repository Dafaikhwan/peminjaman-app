@extends('layouts.user')

@section('content')
<h1>Edit Peminjaman</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('user.peminjaman.update', $peminjaman->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Daftar Alat</label>

        <div id="alat-wrapper">
            @foreach($peminjaman->details as $detail)
            <div class="row mb-2">
                <div class="col-md-8">
                    <select name="alat_id[]" class="form-control" required>
                        @foreach($alats as $alat)
                            <option value="{{ $alat->id }}"
                                {{ $detail->alat_id == $alat->id ? 'selected' : '' }}>
                                {{ $alat->nama_alat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="qty[]" 
                           class="form-control" 
                           value="{{ $detail->qty }}" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger"
                        onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-sm btn-primary" onclick="tambahAlat()">
            + Tambah Alat
        </button>
    </div>

    <div class="mb-3">
        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" 
               class="form-control" 
               value="{{ $peminjaman->tanggal_mulai }}" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" 
               class="form-control" 
               value="{{ $peminjaman->tanggal_selesai }}" required>
    </div>

    <div class="mb-3">
        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" 
               class="form-control" 
               value="{{ $peminjaman->jam_mulai }}" required>
    </div>

    <div class="mb-3">
        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" 
               class="form-control" 
               value="{{ $peminjaman->jam_selesai }}" required>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
function tambahAlat() {
    let wrapper = document.getElementById('alat-wrapper');

    let html = `
        <div class="row mb-2">
            <div class="col-md-8">
                <select name="alat_id[]" class="form-control" required>
                    @foreach($alats as $alat)
                        <option value="{{ $alat->id }}">
                            {{ $alat->nama_alat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="qty[]" 
                       class="form-control" placeholder="Qty" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger"
                    onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        </div>
    `;
    wrapper.insertAdjacentHTML('beforeend', html);
}
</script>
@endsection
