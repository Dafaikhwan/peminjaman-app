<form action="{{ route('admin.peminjaman.store.ruangan') }}" method="POST">
@csrf

<select name="pengguna_id" class="form-control">
@foreach($users as $u)
<option value="{{ $u->id }}">{{ $u->nama_pengguna }}</option>
@endforeach
</select>

<select name="ruangan_id[]" class="form-control mt-2" multiple>
@foreach($ruangans as $r)
<option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
@endforeach
</select>

<input type="date" name="tanggal_mulai">
<input type="date" name="tanggal_selesai">
<input type="time" name="jam_mulai">
<input type="time" name="jam_selesai">

<button class="btn btn-primary mt-3">Simpan</button>
</form>
