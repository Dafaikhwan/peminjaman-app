@extends('layouts.backend')

@section('title', 'Data Alat')

@push('styles')
<style>
.table-premium thead th { background: rgba(59,130,246,0.06); }
.badge-status { font-weight:700; }
.btn-outline-blue-premium { border-color: rgba(59,130,246,0.18); color:var(--accent); }
.btn-blue-premium { background: linear-gradient(90deg,#3b82f6,#60a5fa); color:white; border:0; }
.search-premium .form-control { background: transparent; }
.card-premium { border-radius:14px; overflow:hidden; }
</style>
@endpush

@section('content')
<div class="container py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alat</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary mb-0">📦 Data Alat</h3>
        <a href="{{ route('admin.alat.create') }}" class="btn btn-blue-premium px-4">
            <i class="bi bi-plus-lg me-2"></i>Tambah Alat
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search -->
    <form class="mb-3" method="GET" action="{{ route('admin.alat.index') }}">
        <div class="input-group shadow-sm search-premium">
            <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control border-0" placeholder="Cari alat..."
                   value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="card card-premium rounded-4 border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="small text-muted">
                        <tr>
                            <th class="px-4">Nama Alat</th>
                            <th style="width:120px">Jumlah</th>
                            <th style="width:150px">Status</th>
                            <th class="text-end px-4" style="width:170px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($alats as $alat)
                        <tr>
                            <td class="px-4">
                                <div class="fw-semibold">{{ $alat->nama_alat }}</div>
                                <small class="text-muted d-block">{{ Str::limit($alat->deskripsi_alat, 80) }}</small>
                            </td>

                            <td>{{ $alat->jumlah }}</td>

                            <td>
                                @if($alat->status_alat == 'tersedia')
                                    <span class="badge bg-success rounded-pill badge-status">Tersedia</span>
                                @elseif($alat->status_alat == 'dipinjam')
                                    <span class="badge bg-warning text-dark rounded-pill badge-status">Dipinjam</span>
                                @else
                                    <span class="badge bg-danger rounded-pill badge-status">Rusak</span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <a href="{{ route('admin.alat.show', $alat->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill me-2" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.alat.edit', $alat->id) }}" 
                                   class="btn btn-sm btn-outline-secondary rounded-pill me-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button class="btn btn-sm btn-outline-danger rounded-pill"
                                        onclick="showDeleteModal({{ $alat->id }}, '{{ addslashes($alat->nama_alat) }}')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <div class="mb-2"><i class="bi bi-box-seam fs-1"></i></div>
                                <div class="fw-semibold">Belum ada data alat.</div>
                                <div class="small">Silakan tambahkan alat baru untuk mulai mengelola inventaris.</div>
                                <div class="mt-3">
                                    <a href="{{ route('admin.alat.create') }}" class="btn btn-blue-premium btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Alat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $alats->links() }}
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title"><i class="bi bi-trash me-2 text-danger"></i>Hapus Alat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p id="modalDeleteBody">Yakin ingin menghapus data ini? Tindakan ini tidak dapat dikembalikan.</p>
      </div>
      <div class="modal-footer">
        <form id="formDelete" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showDeleteModal(id, name) {
    const modal = new bootstrap.Modal(document.getElementById('modalDelete'));
    const form = document.getElementById('formDelete');
    form.action = '/admin/alat/' + id;
    document.getElementById('modalDeleteBody').textContent = `Yakin ingin menghapus alat "${name}"? Data yang dihapus tidak dapat dikembalikan.`;
    modal.show();
}
</script>
@endpush
@endsection
