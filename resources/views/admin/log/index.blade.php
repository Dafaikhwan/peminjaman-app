@extends('layouts.backend')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-activity text-primary me-2"></i> Log Aktivitas Sistem
        </h4>
        <span class="text-muted small">
            Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
        </span>
    </div>

    {{-- FILTER CARD --}}
    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">
                <i class="bi bi-funnel text-primary me-2"></i> Filter Aktivitas
            </h5>

            <form action="{{ route('admin.log') }}" method="GET" class="row g-3">

                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control shadow-sm">
                </div>

                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold">Pengguna</label>
                    <select name="user_id" class="form-select shadow-sm">
                        <option value="">Semua User</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->nama_pengguna }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold">Jenis Aksi</label>
                    <select name="jenis" class="form-select shadow-sm">
                        <option value="">Semua</option>
                        <option value="login" {{ request('jenis')=='login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('jenis')=='logout' ? 'selected' : '' }}>Logout</option>
                        <option value="tambah" {{ request('jenis')=='tambah' ? 'selected' : '' }}>Tambah</option>
                        <option value="update" {{ request('jenis')=='update' ? 'selected' : '' }}>Update</option>
                        <option value="hapus" {{ request('jenis')=='hapus' ? 'selected' : '' }}>Hapus</option>
                    </select>
                </div>

                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-semibold">Pencarian</label>
                    <input type="text" name="search" placeholder="Cari aktivitas..." value="{{ request('search') }}" class="form-control shadow-sm">
                </div>

                <div class="col-12 text-end mt-3">
                    <button class="btn btn-primary px-4 shadow">
                        <i class="bi bi-search me-1"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.log') }}" class="btn btn-secondary px-4 shadow-sm ms-2">
                        <i class="bi bi-arrow-repeat me-1"></i> Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">

                    {{-- STICKY HEADER --}}
                    <thead class="table-primary" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th width="50">No</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Jenis</th>
                            <th>IP Address</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                        <tr class="table-row-hover">
                            <td class="fw-semibold">
                                {{ $loop->iteration + $logs->firstItem() - 1 }}
                            </td>

                            <td class="fw-semibold">
                                <i class="bi bi-person-circle text-primary me-1"></i>
                                {{ $log->user->nama_pengguna ?? 'User Terhapus' }}
                            </td>

                            <td>{{ $log->aktivitas }}</td>

                            <td>
                                @php
                                    $color = match($log->jenis_aksi) {
                                        'login' => 'success',
                                        'logout' => 'secondary',
                                        'tambah' => 'primary',
                                        'update' => 'warning',
                                        'hapus' => 'danger',
                                        default => 'info',
                                    };
                                @endphp

                                <span class="badge bg-{{ $color }} px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-dot"></i> {{ ucfirst($log->jenis_aksi) }}
                                </span>
                            </td>

                            <td>
                                <span class="text-dark" title="User Agent: {{ $log->user_agent }}">
                                    <i class="bi bi-wifi text-primary me-1"></i>
                                    {{ $log->ip_address }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                <i class="bi bi-clock-history text-secondary me-1"></i>
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4 fs-6">
                                <i class="bi bi-info-circle me-2"></i> Tidak ada data aktivitas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="p-3 d-flex justify-content-end">
                {{ $logs->links() }}
            </div>

        </div>
    </div>

</div>

{{-- STYLE PREMIUM --}}
<style>
    .table-row-hover:hover {
        background-color: #eef6ff !important;
        transition: .3s;
    }
</style>

@endsection
