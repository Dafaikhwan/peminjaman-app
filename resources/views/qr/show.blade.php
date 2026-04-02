@extends('layouts.backend')

@section('content')
<div class="card shadow p-4 text-center">

    <h4 class="mb-3">QR Code Peminjaman #{{ $peminjaman->id }}</h4>

    <img src="{{ $qr }}" class="img-fluid" style="max-width: 300px">

    <p class="mt-3 text-muted">
        Scan QR ini untuk melihat detail peminjaman.
    </p>

</div>
@endsection
