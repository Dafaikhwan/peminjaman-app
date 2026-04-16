@extends('layouts.backend')

@section('title','Laporan Kerusakan')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">📑 Laporan Kerusakan</h4>

    {{-- Form Filter --}}
    <form action="{{ route('admin.laporan-kerusakan.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        </div>

        <div class="col-md-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
        </div>

        <div class="col-md-3">
            <label>Pelapor (Pengguna)</label>
            <select name="pengguna_id" class="form-control">
                <option value="">-- Semua --</option>
                @foreach($penggunas as $pengguna)
                    <option value="{{ $pengguna->id }}" {{ request('pengguna_id')==$pengguna->id ? 'selected':'' }}>
                        {{ $pengguna->nama_pengguna }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Status Laporan</label>
            <select name="status_laporan" class="form-control">
                <option value="">-- Semua --</option>
                <option value="pending" {{ request('status_laporan')=='pending' ? 'selected':'' }}>Pending</option>
                <option value="proses" {{ request('status_laporan')=='proses' ? 'selected':'' }}>Proses</option>
                <option value="selesai" {{ request('status_laporan')=='selesai' ? 'selected':'' }}>Selesai</option>
            </select>
        </div>

        <div class="col-md-12">
            <button class="btn btn-primary">🔍 Filter</button>
            <a href="{{ route('admin.laporan-kerusakan.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Tombol Export --}}
    <div class="mb-3">
        <a href="{{ route('admin.laporan-kerusakan.exportPdf', request()->all()) }}" class="btn btn-danger" target="_blank">
            📄 Export PDF
        </a>
        
    </div>

    {{-- Tabel --}}
    <div class="card border-0 shadow-sm rounded-4 p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Lokasi</th>
                        <th>Jenis Kerusakan</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporan as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->created_at->format('d/m/Y') }}</td>
                            <td>{{ $row->pengguna->nama_pengguna ?? '-' }}</td>
                            <td>{{ $row->lokasi }}</td>
                            <td>{{ $row->jenis_kerusakan }}</td>
                            <td>{{ $row->deskripsi_kerusakan }}</td>

                            <td>
                                @if($row->url_gambar)
                                    <img src="{{ asset('storage/'.$row->url_gambar) }}" width="80" class="rounded shadow-sm">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>

                            <td>
    <span class="badge 
        @if($row->status_laporan == 'diajukan') bg-primary
        @elseif($row->status_laporan == 'diproses') bg-warning text-dark
        @elseif($row->status_laporan == 'selesai') bg-success
        @elseif($row->status_laporan == 'dibatalkan') bg-danger
        @endif
        px-3 py-2 rounded-pill shadow-sm fw-semibold">
        {{ ucfirst($row->status_laporan) }}
    </span>
</td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
