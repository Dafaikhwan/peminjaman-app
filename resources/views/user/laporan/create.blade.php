@extends('layouts.user')

@section('content')
<h1>Buat Laporan Kerusakan Baru</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('user.laporan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
    </div>

    <div class="mb-3">
        <label>Jenis Kerusakan</label>
        <select name="jenis_kerusakan" class="form-select" required>
            <option value="">-- Pilih Jenis Kerusakan --</option>
            <option value="alat" {{ old('jenis_kerusakan')=='alat' ? 'selected' : '' }}>Alat</option>
            <option value="ruangan" {{ old('jenis_kerusakan')=='ruangan' ? 'selected' : '' }}>Ruangan</option>
            <option value="lainnya" {{ old('jenis_kerusakan')=='lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Deskripsi Kerusakan</label>
        <textarea name="deskripsi_kerusakan" class="form-control" rows="4" required>{{ old('deskripsi_kerusakan') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Upload Gambar (Opsional)</label>
        <input type="file" name="url_gambar" class="form-control" accept="image/*" id="gambarInput">
        <div class="mt-2">
            <img id="previewGambar" src="#" alt="Preview Gambar" class="img-fluid rounded" style="display:none; max-width:200px;">
        </div>
    </div>

    <button type="submit" class="btn btn-success">Kirim Laporan</button>
    <a href="{{ route('user.laporan.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection

@section('scripts')
<script>
document.getElementById('gambarInput').addEventListener('change', function(event){
    const preview = document.getElementById('previewGambar');
    const file = event.target.files[0];

    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>
@endsection
