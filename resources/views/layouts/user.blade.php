<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User - @yield('title', 'Dashboard')</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; display: flex; min-height: 100vh; margin: 0; background: #f6f8fb; color: #1a1a1a; overflow-x: hidden; }
.sidebar { width: 260px; flex-shrink: 0; display: flex; flex-direction: column; background: linear-gradient(180deg, #1e3c72, #2a5298); box-shadow: 4px 0 20px rgba(0,0,0,0.15); transition: transform 0.4s ease-in-out; }
.sidebar-header { text-align: center; padding: 25px 10px; border-bottom: 1px solid rgba(255,255,255,0.15); }
.sidebar-header img { width: 70px; height: 70px; border-radius: 50%; border: 2px solid #fff; margin-bottom: 10px; }
.sidebar-header h5 { color: #fff; font-weight: 700; margin: 0; }
.sidebar-header small { color: rgba(255,255,255,0.8); font-size: 13px; }
.sidebar-menu .nav-link { color: rgba(255,255,255,0.85); padding: 12px 25px; font-weight: 500; display: flex; align-items: center; transition: all 0.3s ease; border-radius: 10px; margin: 3px 10px; }
.sidebar-menu .nav-link i { margin-right: 10px; font-size: 18px; transition: 0.3s ease; }
.sidebar-menu .nav-link:hover { background: rgba(255,255,255,0.25); color: #fff; transform: translateX(6px); box-shadow: 0 4px 15px rgba(255,255,255,0.2); }
.sidebar-menu .nav-link.active { background: linear-gradient(90deg,#ffffff33,#ffffff22); color: #fff !important; font-weight:700; border-left: 4px solid #fff; transform: translateX(6px); }
.logout-btn { background: rgba(255,255,255,0.15); border: none; color: #fff; font-weight: 600; width: 90%; padding: 10px; border-radius: 10px; margin: 20px auto; display: block; transition: all 0.3s; }
.logout-btn:hover { background: #fff; color: #1e3c72; box-shadow: 0 0 15px rgba(255,255,255,0.4); transform: translateY(-3px); }
@media(max-width:768px){.sidebar{transform:translateX(-100%);position:fixed;top:0;left:0;height:100vh;z-index:1050}.sidebar.show{transform:translateX(0);}}
.content-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
.navbar { background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.1); padding: 15px 30px; display:flex; justify-content:space-between; align-items:center; }
.navbar-text { font-weight:600; color:#1a1a1a; }
.content { flex-grow: 1; padding: 30px; }
.card-modern { background: #fff; border: none; border-radius: 15px; box-shadow:0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card-modern:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
.toast { transition: transform 0.4s cubic-bezier(.65,.05,.36,1), opacity 0.4s; }
.toast-slide-in { transform: translateX(100%); opacity: 0; animation: slideIn 0.5s forwards; }
@keyframes slideIn { to { transform: translateX(0); opacity:1; } }
.badge-blink { animation: blinkBadge 0.6s ease 0s 2; }
@keyframes blinkBadge { 0%,100%{opacity:1} 50%{opacity:0.2} }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('img/sandi.jpg') }}" alt="User">
        <h5>{{ auth()->user()->nama_pengguna ?? 'User' }}</h5>
        <small>Aplikasi Peminjaman</small>
    </div>

    <ul class="nav flex-column mt-3 sidebar-menu">
        <li class="nav-item">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.peminjaman.index') }}" class="nav-link {{ request()->routeIs('user.peminjaman.index') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Peminjaman
            </a>
        </li>
        <li class="nav-item">
    <a href="{{ route('user.booking-ruangan.index') }}" 
       class="nav-link {{ request()->routeIs('user.booking-ruangan.*') ? 'active' : '' }}">
        <i class="bi bi-door-open"></i> Booking Ruangan
    </a>
</li>
        <li class="nav-item">
            <a href="{{ route('user.laporan.index') }}" class="nav-link {{ request()->routeIs('user.laporan.index') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle"></i> Laporan Kerusakan
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.peminjaman.riwayat') }}" class="nav-link {{ request()->routeIs('user.peminjaman.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Peminjaman
            </a>
        </li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
    </form>
</div>

<!-- Content -->
<div class="content-wrapper">
    <nav class="navbar">
        <button class="btn text-dark d-md-none" id="sidebarToggle">
            <i class="bi bi-list" style="font-size:28px;"></i>
        </button>
        <span class="navbar-text">
            Halo, <strong>{{ auth()->user()->nama_pengguna }}</strong>
        </span>
        <div class="position-relative d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-outline-primary" id="markAllRead">Mark All as Read</button>
            <div class="position-relative">
                <button class="btn btn-light position-relative" id="notifBtn">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" id="notifCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                </button>
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
    </nav>

    <main class="content">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/8.0/pusher.min.js"></script>
<script>
const sidebar = document.querySelector('.sidebar');
document.getElementById('sidebarToggle')?.addEventListener('click',()=>{sidebar.classList.toggle('show');});

const notifBtn = document.getElementById('notifBtn');
const notifList = document.getElementById('notifList');
notifBtn.addEventListener('click',()=>{notifList.classList.toggle('d-none');});

// Mark notification as read
notifList.addEventListener('click', async (e)=>{
    const li = e.target.closest('li');
    if(!li || li.classList.contains('text-muted')) return;
    const id = li.dataset.id;

    await fetch("{{ route('notifications.read.ajax') }}", {
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body: JSON.stringify({id})
    });

    li.classList.remove('fw-bold');
    let badge = document.getElementById('notifCount');
    let count = parseInt(badge.textContent)||0;
    badge.textContent = Math.max(count-1,0);
});

// Mark All as Read
document.getElementById('markAllRead').addEventListener('click', async ()=>{
    await fetch("{{ route('notifications.read.all') }}", {method:'GET'});
    document.querySelectorAll('#notifList li').forEach(li=>li.classList.remove('fw-bold'));
    document.getElementById('notifCount').textContent=0;
});

// Pusher Realtime
Pusher.logToConsole = false;
const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    encrypted: true
});
const channel = pusher.subscribe('user.{{ auth()->id() }}');
channel.bind('App\\Events\\NewNotification', function(data) {
    let badge = document.getElementById('notifCount');
    badge.textContent = (parseInt(badge.textContent)||0) + 1;
    badge.classList.add('badge-blink');
    setTimeout(()=>badge.classList.remove('badge-blink'),1200);

    let li = document.createElement('li');
    li.className = 'list-group-item fw-bold';
    li.dataset.id = data.id;
    li.innerHTML = `<a href="${data.link || '#'}">${data.message}</a><small class="d-block text-muted">Baru saja</small>`;
    notifList.prepend(li);

    const toastEl = document.createElement('div');
    toastEl.className='toast toast-slide-in align-items-center text-white bg-primary border-0';
    toastEl.setAttribute('role','alert');
    toastEl.setAttribute('aria-live','assertive');
    toastEl.setAttribute('aria-atomic','true');
    toastEl.innerHTML=`<div class="d-flex"><div class="toast-body">${data.message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    document.body.appendChild(toastEl);
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
});
</script>


@stack('scripts')
</body>
</html>
