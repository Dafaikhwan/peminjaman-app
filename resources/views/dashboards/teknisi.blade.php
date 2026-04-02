@extends('layouts.backend')

@section('title','Dashboard Teknisi')

@section('content')
<div data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Dashboard Teknisi</h3>
            <div class="muted">Daftar laporan yang perlu ditangani</div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Tabel Laporan --}}
        <div class="col-lg-8">
            <div class="glass table-glass">
                <div class="p-3">
                    <h6>Laporan Kerusakan</h6>
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>Jenis</th>
                                    <th>Pelapor</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $i => $lap)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $lap->lokasi }}</td>
                                    <td>{{ ucfirst($lap->jenis_kerusakan) }}</td>
                                    <td>{{ $lap->pengguna->nama_pengguna ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($lap->status_laporan);
                                            $badge = match($status) {
                                                'selesai' => 'success',
                                                'diproses' => 'primary',
                                                'diajukan' => 'warning text-dark',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">
                                            {{ ucfirst($lap->status_laporan) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('teknisi.laporan.show', $lap->id) }}" class="btn btn-sm btn-outline-info">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center muted">Belum ada laporan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="col-lg-4">
            <div class="glass p-3">
                <h6>Ringkasan</h6>
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="muted">Total Laporan</div>
                        <div class="fw-bold">{{ $totalLaporan ?? 0 }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="muted">Diajukan</div>
                        <div class="fw-bold text-warning">{{ $laporanDiajukan ?? 0 }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="muted">Diproses</div>
                        <div class="fw-bold text-primary">{{ $laporanDiproses ?? 0 }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="muted">Selesai</div>
                        <div class="fw-bold text-success">{{ $laporanSelesai ?? 0 }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="muted">Lainnya</div>
                        <div class="fw-bold text-secondary">{{ $laporanLainnya ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
