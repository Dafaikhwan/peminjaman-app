@extends('layouts.backend')

@section('title','Dashboard Admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.css" rel="stylesheet">
@endpush

@section('content')
<div data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="mb-0">Dashboard</h3>
            <div class="muted">Ringkasan aktivitas peminjaman dan laporan</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">Buat Peminjaman</a>
            <a href="{{ route('admin.laporan.create') }}" class="btn btn-outline-secondary">Laporkan Kerusakan</a>
        </div>
    </div>

    <!-- KPI -->
    <div class="kpi mb-3">
        <div class="kpi-grid">
            <div class="glass">
                <div class="small muted">Jumlah Alat</div>
                <div class="value">{{ $jumlahAlat ?? 0 }}</div>
                <div class="muted small mt-2">Total alat terdaftar</div>
            </div>

            <div class="glass">
                <div class="small muted">Jumlah Ruangan</div>
                <div class="value">{{ $jumlahRuangan ?? 0 }}</div>
                <div class="muted small mt-2">Total ruangan</div>
            </div>

            <div class="glass">
                <div class="small muted">Jumlah Peminjaman</div>
                <div class="value">{{ $jumlahPeminjaman ?? 0 }}</div>
                <div class="muted small mt-2">Peminjaman aktif</div>
            </div>

            <div class="glass">
                <div class="small muted">Jumlah Laporan Kerusakan</div>
                <div class="value">{{ $jumlahLaporan ?? 0 }}</div>
                <div class="muted small mt-2">Laporan terbaru</div>
            </div>
        </div>

        <div class="chart-wrap mt-3">
            <div class="glass">
                <h6>Tren Peminjaman</h6>
                <canvas id="lineChart" style="height:220px"></canvas>
            </div>

            <div class="glass">
                <h6>Status Peminjaman</h6>
                <canvas id="pieChart" style="height:220px"></canvas>
                <div class="mt-3 small muted">
                    <div><span class="badge bg-success me-2">&nbsp;</span> Disetujui</div>
                    <div><span class="badge bg-warning text-dark me-2">&nbsp;</span> Pending</div>
                    <div><span class="badge bg-danger me-2">&nbsp;</span> Ditolak</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent table -->
    <div class="glass table-glass mt-3">
        <div class="p-3">
            <h6 class="mb-3">Peminjaman Terbaru</h6>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>No</th><th>Alat</th><th>Pengguna</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans ?? [] as $i => $p)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
    @foreach($p->details as $detail)
        {{ $detail->alat->nama_alat ?? '-' }}
    @endforeach
</td>
                            <td>{{ $p->pengguna->nama_pengguna ?? '-' }}</td>
                            <td>{{ $p->tanggal_mulai }} s/d {{ $p->tanggal_selesai }}</td>
                            <td>
                                @if($p->status_peminjaman == 'pending')
                                    <span class="badge bg-warning text-dark badge-status">Pending</span>
                                @elseif($p->status_peminjaman == 'disetujui')
                                    <span class="badge bg-success badge-status">Disetujui</span>
                                @else
                                    <span class="badge bg-danger badge-status">Ditolak</span>
                                @endif
                            </td>
                            <td><a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center muted">Belum ada data peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{
    // sample data — ganti dengan data real dari controller via blade variables
    const months = {!! json_encode($trenLabels ?? ['Jan','Feb','Mar','Apr','May','Jun']) !!};
    const values = {!! json_encode($trenValues ?? [20,40,60,36,48,62]) !!};
    const ctxL = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxL, {
        type:'line',
        data:{labels:months,datasets:[{label:'Peminjaman',data:values,borderColor:'rgba(59,130,246,1)',backgroundColor:'rgba(59,130,246,0.12)',tension:0.35,fill:true,pointRadius:4}]},
        options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
    });

    const pie = document.getElementById('pieChart').getContext('2d');
    new Chart(pie, {
        type:'doughnut',
        data:{labels:['Disetujui','Pending','Ditolak'],datasets:[{data:{!! json_encode($pieValues ?? [60,25,15]) !!},backgroundColor:['#16a34a','#f59e0b','#ef4444']}]},
        options:{plugins:{legend:{position:'bottom'}}}
    });
});
</script>
@endpush
