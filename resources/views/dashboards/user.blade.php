@extends('layouts.user')

@section('content')
<div class="container-fluid">

    <!-- Sambutan -->
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-gradient mb-1">
            Selamat Datang, {{ auth()->user()->nama_pengguna ?? 'Pengguna' }} 👋
        </h2>
        <p class="text-muted fs-6">Ringkasan aktivitas dan peminjaman terkini kamu</p>
    </div>

    <!-- Kartu Statistik -->
    <div class="row g-4">
        @php
            $stats = [
                ['icon' => 'bi-box-seam', 'label' => 'Total Alat', 'value' => $totalAlat ?? 0, 'color' => 'primary'],
                ['icon' => 'bi-building', 'label' => 'Total Ruangan', 'value' => $totalRuangan ?? 0, 'color' => 'info'],
                ['icon' => 'bi-calendar-check', 'label' => 'Peminjaman Aktif', 'value' => $totalPeminjaman ?? 0, 'color' => 'success'],
                ['icon' => 'bi-exclamation-triangle', 'label' => 'Laporan Kerusakan', 'value' => $totalLaporan ?? 0, 'color' => 'danger'],
            ];
        @endphp

        @foreach ($stats as $s)
        <div class="col-md-3 col-sm-6">
            <div class="card-modern p-4 text-center animate-card">
                <div class="icon-circle mb-3 bg-{{ $s['color'] }} bg-opacity-10 text-{{ $s['color'] }}">
                    <i class="bi {{ $s['icon'] }} display-6"></i>
                </div>
                <h6 class="fw-semibold text-secondary">{{ $s['label'] }}</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $s['value'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Grafik Tren -->
    <div class="card-modern mt-5 p-4 animate-fade">
        <h5 class="fw-bold mb-3 text-gradient">
            <i class="bi bi-graph-up-arrow me-2"></i> Tren Peminjaman Minggu Ini
        </h5>
        <canvas id="chartPeminjaman" height="120"></canvas>
    </div>

    <!-- Tabel Peminjaman -->
    <div class="card-modern mt-5 p-4 animate-fade">
        <h5 class="fw-bold mb-3 text-gradient">
            <i class="bi bi-clock-history me-2"></i> Peminjaman Terbaru
        </h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-borderless">
                <thead class="table-gradient text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Nama Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanTerbaru ?? [] as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
    @foreach($p->details as $d)
        {{ $d->alat->nama_alat ?? '-' }}<br>
    @endforeach
</td>
<td>
    @foreach($p->details as $d)
        {{ $d->ruangan->nama_ruangan ?? '-' }}<br>
    @endforeach
</td>
                            <td>{{ $p->tanggal_mulai ? \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') : '-' }}</td>
                            <td>
                                <span class="badge 
        @if($p->status_peminjaman == 'pending') bg-warning text-dark
        @elseif($p->status_peminjaman == 'ditolak') bg-danger
        @elseif($p->status_peminjaman == 'diterima') bg-success
        @endif
    ">
        {{ ucfirst($p->status_peminjaman) }}
    </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Style tambahan -->
<style>
.text-gradient {
    background: linear-gradient(90deg, #1e3c72, #2a5298);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.card-modern {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

.icon-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.table-gradient {
    background: linear-gradient(90deg, #1e3c72, #2a5298);
}

.animate-card {
    opacity: 0;
    transform: translateY(30px);
    animation: slideUp 0.6s forwards;
}
.animate-fade {
    opacity: 0;
    animation: fadeIn 0.8s forwards;
}
@keyframes slideUp {
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    to { opacity: 1; }
}
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPeminjaman');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
        datasets: [{
            label: 'Jumlah Peminjaman',
            data: {!! json_encode($chartData ?? [3, 5, 2, 8, 4, 6, 3]) !!},
            borderColor: '#2a5298',
            backgroundColor: 'rgba(42, 82, 152, 0.2)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 4,
            pointBackgroundColor: '#1e3c72'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});
</script>
@endsection
