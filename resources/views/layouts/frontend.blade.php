<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Beranda') - PeminjamanApp</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --accent: linear-gradient(135deg, #a0c4ff, #bdb2ff);
    --text-dark: #1a1a1a;
    --text-light: #ffffff;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #f8faff;
    color: var(--text-dark);
    overflow-x: hidden;
}

/* Navbar */
.navbar {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.navbar-brand {
    font-weight: 700;
    background: var(--accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.nav-link {
    color: #333;
    font-weight: 500;
    position: relative;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    background: var(--accent);
    transition: all 0.3s ease;
}

.nav-link:hover::after {
    width: 100%;
    left: 0;
}

.nav-link:hover { color: #4a47a3; }

/* Hero Section */
header.hero {
    position: relative;
    background: linear-gradient(120deg, #a0c4ff 0%, #bdb2ff 100%);
    color: #fff;
    padding: 100px 20px;
    text-align: center;
    overflow: hidden;
}

/* Bubble */
.bubble {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(2px);
    box-shadow: 0 0 10px rgba(255,255,255,0.5);
}

/* Hero Text */
header.hero h1 {
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 15px;
}

header.hero p {
    font-weight: 400;
    font-size: 1.25rem;
    min-height: 30px;
}

/* Typing Cursor */
.cursor {
    display: inline-block;
    width: 3px;
    background: #fff;
    margin-left: 2px;
    animation: blink 0.7s infinite;
    vertical-align: bottom;
}

@keyframes blink {
    0%, 50%, 100% { opacity: 1; }
    25%, 75% { opacity: 0; }
}

/* Hero Buttons */
.hero-buttons {
    margin-top: 25px;
}

.hero-buttons .btn {
    margin: 0 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary {
    background: #4a47a3;
    border: none;
    color: #fff;
}

.btn-primary::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0; left: -100%;
    background: linear-gradient(120deg,#5b52c5,#7f7aff);
    transition: all 0.5s ease;
}

.btn-primary:hover::before {
    left: 0;
}

.btn-primary:hover {
    transform: translateY(-3px);
}

.btn-outline-light {
    border-color: #fff;
    color: #fff;
}

.btn-outline-light:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-3px);
}

/* Footer */
footer {
    background: linear-gradient(135deg, #4a47a3, #bdb2ff);
    color: #fff;
    text-align: center;
    padding: 50px 20px;
}

footer h5 {
    font-weight: 700;
    margin-bottom: 15px;
}

footer a {
    color: #fff;
    margin: 0 10px;
    font-size: 1.3rem;
    transition: all 0.3s ease;
}

footer a:hover { transform: scale(1.2); }

footer input[type="email"] {
    border-radius: 50px;
    border: none;
    padding: 10px 20px;
    margin-right: 10px;
    max-width: 300px;
}

footer button { border-radius: 50px; }

/* Responsive */
@media (max-width: 768px) {
    header.hero { padding: 80px 15px; }
    header.hero h1 { font-size: 2rem; }
    header.hero p { font-size: 1rem; }
    .hero-buttons { flex-direction: column; gap: 15px; }
    footer input[type="email"] { margin-bottom: 10px; width: 100%; }
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">PeminjamanApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="bi bi-list"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navMenu">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<header class="hero" data-aos="fade-down">
    <div class="container position-relative">
        <h1 data-aos="fade-up" data-aos-delay="200">Selamat Datang di PeminjamanApp</h1>
        <p id="hero-typing" data-aos="fade-up" data-aos-delay="400"></p>
        <div class="hero-buttons d-flex justify-content-center" data-aos="fade-up" data-aos-delay="600">
                    <a href="#" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#authModal">
                        Masuk
                    </a>
                    <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#authModal">
                        Daftar Sekarang
                    </a>
        </div>
        <p id="hero-subtyping" class="mt-3" data-aos="fade-up" data-aos-delay="800"></p>
    </div>
    <div id="bubble-container"></div>
</header>

<!-- Main Content -->
<main>
    <div class="container">
        @yield('content')
    </div>
</main>

<!-- Footer -->
<footer data-aos="fade-up">
    <div class="container">
        <h5>PeminjamanApp</h5>
        <div class="mb-3">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-envelope"></i></a>
        </div>
        <form class="d-flex justify-content-center flex-wrap" onsubmit="return false;">
            <input type="email" placeholder="Masukkan email">
            <button class="btn btn-light">Subscribe</button>
        </form>
        <small class="d-block mt-3">&copy; {{ date('Y') }} PeminjamanApp. Semua hak dilindungi.</small>
    </div>
</footer>

<!-- Modal Auth -->
@include('auth.partials.modal-auth')

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

<script>
AOS.init({ duration: 800, easing: 'ease-in-out', once: true });

// Typing Effect Ganda
const texts = [
    "Kelola peminjaman alat & ruangan dengan mudah.",
    "Cepat, praktis, dan terorganisir untuk semua kebutuhan sekolahmu."
];
let idx = 0, charIdx = 0;
const heroTyping = document.getElementById("hero-typing");
const heroSubtyping = document.getElementById("hero-subtyping");

function typeWriter() {
    if(idx < texts.length){
        const target = idx === 0 ? heroTyping : heroSubtyping;
        if(charIdx < texts[idx].length){
            target.innerHTML = texts[idx].substring(0,charIdx+1) + '<span class="cursor"></span>';
            charIdx++;
            setTimeout(typeWriter, 40);
        } else {
            charIdx = 0;
            idx++;
            setTimeout(typeWriter, 600);
        }
    }
}
window.onload = typeWriter;

// Bubble Cinematic Ultra Premium
const bubbleContainer = document.getElementById('bubble-container');
const bubbleLayers = [
    {count: 10, size: [40,50,60], speed: 12}, // far
    {count: 12, size: [25,35,45], speed: 8},  // middle
    {count: 6, size: [15,20,25], speed: 5}    // near
];

bubbleLayers.forEach(layer => {
    for(let i=0;i<layer.count;i++){
        const bubble = document.createElement('div');
        bubble.classList.add('bubble');
        const size = layer.size[Math.floor(Math.random()*layer.size.length)];
        bubble.style.width = size+'px';
        bubble.style.height = size+'px';
        bubble.style.left = Math.random()*100+'%';
        bubble.style.top = Math.random()*100+'%';
        bubble.style.opacity = Math.random()*0.5 + 0.2;
        bubble.style.background = `radial-gradient(circle, rgba(255,255,255,0.5), rgba(173,216,230,0.2))`;
        bubbleContainer.appendChild(bubble);

        gsap.to(bubble, {
            y: 'random(-50,50)',
            x: 'random(-30,30)',
            duration: Math.random()*6 + layer.speed,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            delay: Math.random()*2,
            onUpdate: function() {
                bubble.style.filter = `blur(${Math.random()*2 + 1}px)`;
            }
        });
    }
});

// Bubble Parallax Scroll
window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    bubbleContainer.style.transform = `translateY(${scrollY * 0.1}px)`;
});
</script>

</body>
</html>
