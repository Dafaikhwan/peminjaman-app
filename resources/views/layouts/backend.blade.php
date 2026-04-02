<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title', 'Dashboard') - SIM PERU</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root{--sidebar-w:260px;--bg-1:#f5f9ff;--accent:#3b82f6;--accent-2:#60a5fa;--muted:#6b7280;}
*{box-sizing:border-box;}
body{font-family:'Poppins',system-ui,Arial;margin:0;min-height:100vh;background:linear-gradient(180deg,#f8fbff 0%,#eef6ff 100%);color:#0f172a;display:flex;}
.sidebar{width:var(--sidebar-w);min-height:100vh;background:linear-gradient(180deg, rgba(59,130,246,0.95), rgba(96,165,250,0.95));color:#fff;padding:22px 16px;display:flex;flex-direction:column;gap:12px;box-shadow:8px 16px 40px rgba(59,130,246,0.08);border-radius:16px 0 0 16px;position:relative;transition:all .3s;}
.brand{display:flex;gap:12px;align-items:center;margin-bottom:8px;}
.brand .logo{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#fff,#dbeafe);display:inline-grid;place-items:center;color:var(--accent);font-weight:700;}
.brand .title{font-weight:700;font-size:1.05rem;line-height:1;}
.brand .sub{font-size:0.82rem;opacity:0.9;}
.nav-simple{margin-top:8px}
.nav-simple .nav-link{color: rgba(255,255,255,0.95);padding:10px 12px;border-radius:10px;display:flex;gap:10px;align-items:center;transition:all .18s ease;}
.nav-simple .nav-link i{font-size:1.05rem}
.nav-simple .nav-link:hover,.nav-simple .nav-link.active{background: rgba(255,255,255,0.08);transform: translateX(6px);box-shadow: 0 8px 24px rgba(2,6,23,0.06);}
.sidebar .logout{margin-top:auto;}
.btn-logout{width:100%;border-radius:10px;background:linear-gradient(90deg,#e6f0ff,#dbeafe);color:#0f172a;font-weight:600;border:none;padding:10px;}
.content-wrapper{flex:1;display:flex;flex-direction:column;min-height:100vh}
.topbar{height:72px;display:flex;align-items:center;gap:16px;padding:12px 28px;background: rgba(255,255,255,0.85);border-bottom:1px solid rgba(15,23,42,0.04);box-shadow:0 6px 20px rgba(2,6,23,0.03);backdrop-filter: blur(6px);}
.topbar .welcome{font-weight:600;color:#0f172a}
.main-content{padding:28px;}
.glass{background:#ffffff;border-radius:12px;padding:18px;box-shadow:0 10px 30px rgba(15,23,42,0.06);border:1px solid rgba(15,23,42,0.03);}
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.kpi .value{font-size:1.6rem;font-weight:700;color:var(--accent)}
.chart-wrap{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-top:12px}
.table-glass{border-radius:12px;overflow:hidden;border:1px solid rgba(15,23,42,0.04);}
@media(max-width:1100px){.kpi-grid{grid-template-columns:repeat(2,1fr)}.chart-wrap{grid-template-columns:1fr}}
@media(max-width:900px){.sidebar{position:fixed;left:-320px;top:0;z-index:1200}.sidebar.show{left:0}.content-wrapper{margin-left:0}}
.muted{color:var(--muted)}
.badge-status{padding:.35rem .6rem;border-radius:999px;font-weight:600}
.toast-premium{animation: slideBounce 0.6s ease forwards;}
@keyframes slideBounce{
    0%{opacity:0;transform:translateX(100%);}
    60%{opacity:1;transform:translateX(-10px);}
    100%{transform:translateX(0);}
}
@keyframes badgeBlink{
    0%,100%{opacity:1}
    50%{opacity:0.3}
}
</style>

@stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="logo"><i class="bi bi-lightning-fill"></i></div>
        <div>
            <div class="title">SIM PERU</div>
            <div class="sub">Sistem Peminjaman & Ruangan</div>
        </div>
    </div>

    <nav class="nav-simple">
        @if(auth()->user()->peran === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-house-fill"></i> Dashboard</a>
            <a href="{{ route('admin.alat.index') }}" class="nav-link {{ request()->is('admin/alat*') ? 'active' : '' }}"><i class="bi bi-tools"></i> Alat</a>
            <a href="{{ route('admin.ruangan.index') }}" class="nav-link {{ request()->is('admin/ruangan*') ? 'active' : '' }}"><i class="bi bi-building"></i> Ruangan</a>
            <a href="{{ route('admin.pengguna.index') }}" class="nav-link {{ request()->is('admin/pengguna*') ? 'active' : '' }}"><i class="bi bi-people"></i> Pengguna</a>
            <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->is('admin/peminjaman*') ? 'active' : '' }}"><i class="bi bi-card-checklist"></i> Peminjaman</a>
            <a href="{{ route('admin.booking-ruangan.index') }}" class="nav-link {{ request()->is('admin/booking-ruangan*') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Booking Ruangan</a>
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> Laporan</a>
            <a href="{{ url('/admin/laporan-peminjaman') }}" class="nav-link {{ request()->is('admin/laporan-peminjaman') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Laporan Peminjaman</a>
            <a href="{{ url('/admin/laporan-kerusakan') }}" class="nav-link {{ request()->is('admin/laporan-kerusakan') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Laporan Kerusakan</a>
            <a href="{{ url('/admin/log-aktivitas') }}" class="nav-link {{ request()->is('admin/log-aktivitas') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Log Aktivitas</a>
        @elseif(auth()->user()->peran === 'teknisi')
            <a href="{{ route('teknisi.dashboard') }}" class="nav-link {{ request()->is('teknisi/dashboard') ? 'active' : '' }}"><i class="bi bi-house-fill"></i> Dashboard</a>
            <a href="{{ route('teknisi.laporan.index') }}" class="nav-link {{ request()->is('teknisi/laporan*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> Laporan</a>
        @endif
    </nav>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-logout" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
        </form>
    </div>
</aside>

<!-- content -->
<div class="content-wrapper">
    <header class="topbar">
        <button class="btn btn-light d-md-none me-2" id="btnToggle"><i class="bi bi-list"></i></button>
        <div class="welcome">Selamat datang, <strong>{{ auth()->user()->nama_pengguna ?? auth()->user()->name }}</strong></div>
        <div class="ms-auto d-flex align-items-center gap-3">
            <div class="muted small d-none d-md-block">Sistem Peminjaman & Pelaporan</div>
            <div class="position-relative">
                <button class="btn btn-light position-relative" id="notifBtn">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" id="notifCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                </button>
                <button class="btn btn-sm btn-outline-primary ms-2" id="markAllReadBtn">Mark All as Read</button>
                <ul class="list-group position-absolute bg-white shadow p-2 d-none" id="notifList" style="width:300px;max-height:400px;overflow-y:auto;right:0;z-index:1050;">
                    @forelse(auth()->user()->notifications()->latest()->get() as $notification)
                        <li class="list-group-item {{ $notification->read_at ? 'text-muted' : 'fw-bold' }}" data-id="{{ $notification->id }}">
                            <a href="{{ $notification->data['link'] ?? '#' }}">{{ $notification->data['message'] ?? 'Tidak ada pesan' }}</a>
                            <small class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada notifikasi</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container-fluid">@yield('content')</div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/8.0/pusher.min.js"></script>
<script>
const sidebar = document.getElementById('sidebar');
document.getElementById('btnToggle')?.addEventListener('click', ()=>{sidebar.classList.toggle('show');});

const notifBtn = document.getElementById('notifBtn');
const notifList = document.getElementById('notifList');
notifBtn.addEventListener('click',()=>{notifList.classList.toggle('d-none');});

// Mark all read
document.getElementById('markAllReadBtn')?.addEventListener('click', async ()=> {
    await fetch("{{ route('notifications.read.all') }}");
    document.querySelectorAll('#notifList li').forEach(li=>li.classList.remove('fw-bold'));
    document.getElementById('notifCount').textContent = 0;
});

w

// Pusher realtime
Pusher.logToConsole = false;
const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    encrypted: true
});
const channel = pusher.subscribe('private-notifications.{{ auth()->id() }}');
channel.bind('App\\Events\\NewNotification', function(data) {
    const badge = document.getElementById('notifCount');
    badge.textContent = (parseInt(badge.textContent)||0) + 1;
    badge.style.animation = 'badgeBlink 0.6s';
    setTimeout(()=>{badge.style.animation='';},600);

    const li = document.createElement('li');
    li.className = 'list-group-item fw-bold';
    li.dataset.id = data.id;
    li.innerHTML = `<a href="${data.link || '#'}">${data.message}</a><small class="d-block text-muted">Baru saja</small>`;
    notifList.prepend(li);

    const toastEl = document.createElement('div');
    toastEl.className = 'toast align-items-center text-white bg-primary border-0 toast-premium';
    toastEl.setAttribute('role','alert');
    toastEl.setAttribute('aria-live','assertive');
    toastEl.setAttribute('aria-atomic','true');
    toastEl.innerHTML = `<div class="d-flex"><div class="toast-body">${data.message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    document.body.appendChild(toastEl);
    new bootstrap.Toast(toastEl).show();
});
</script>

@stack('scripts')
</body>
</html>
