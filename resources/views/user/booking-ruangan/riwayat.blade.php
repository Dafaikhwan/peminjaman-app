@extends('layouts.user')

@section('content')
<h1>Riwayat Booking Ruangan</h1>

<table class="table table-bordered">
<thead>
<tr>
    <th>No</th>
    <th>Ruangan</th>
    <th>Tanggal</th>
    <th>Jam</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
@foreach($riwayats as $i => $r)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $r->ruangan->nama_ruangan }}</td>
    <td>{{ $r->tanggal }}</td>
    <td>{{ $r->jam_mulai }} - {{ $r->jam_selesai }}</td>
    <td>{{ $r->status }}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
