<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Aplikasi Peminjaman</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      height: 100vh;
      overflow: hidden;
      background: #020202;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      color: #fff;
    }

    /* 🌌 3 Layer Neon Parallax */
    .bg-layer {
      position: absolute;
      width: 120%;
      height: 120%;
      top: -10%;
      left: -10%;
      background: radial-gradient(circle at center, #00eaff22, #00151a 70%);
      animation: float 12s infinite ease-in-out alternate;
      z-index: -3;
    }

    .bg-layer2 {
      position: absolute;
      width: 130%;
      height: 130%;
      top: -15%;
      left: -15%;
      background: radial-gradient(circle at 30% 70%, #00bfff15, transparent 70%);
      animation: float2 10s infinite ease-in-out alternate;
      z-index: -4;
    }

    .bg-layer3 {
      position: absolute;
      width: 140%;
      height: 140%;
      top: -20%;
      left: -20%;
      background: radial-gradient(circle at 70% 20%, #00ffff10, transparent 80%);
      animation: float3 14s infinite ease-in-out alternate;
      z-index: -5;
    }

    @keyframes float {
      from { transform: translate(0, 0); }
      to { transform: translate(30px, -40px); }
    }
    @keyframes float2 {
      from { transform: translate(-20px, 10px); }
      to { transform: translate(40px, -20px); }
    }
    @keyframes float3 {
      from { transform: translate(10px, -30px); }
      to { transform: translate(-40px, 30px); }
    }

    /* ✨ Particles */
    canvas {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: -2;
    }

    /* 🧊 Glass Card 3D */
    .auth-card {
      width: 380px;
      padding: 2.7rem;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 22px;
      backdrop-filter: blur(22px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 35px rgba(0, 255, 255, .25);
      animation: fadeUp 1s ease forwards;
      position: relative;
      overflow: hidden;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(40px) scale(.95); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* 🔥 Border Glow Follow Mouse */
    .border-glow {
      position: absolute;
      width: 180px;
      height: 180px;
      background: rgba(0, 255, 255, .12);
      filter: blur(60px);
      border-radius: 50%;
      pointer-events: none;
      z-index: -1;
      transition: .15s ease-out;
    }

    /* ⭐ Floating Label */
    .floating {
      position: relative;
      margin-bottom: 1.3rem;
    }

    .floating label {
      position: absolute;
      left: 12px;
      top: 11px;
      color: #99faff;
      font-size: 14px;
      opacity: .7;
      pointer-events: none;
      transition: .3s ease;
    }

    .floating input:focus ~ label,
    .floating input:not(:placeholder-shown) ~ label {
      top: -11px;
      left: 8px;
      font-size: 12px;
      background: #020202;
      padding: 0 6px;
      border-radius: 4px;
      opacity: 1;
      color: #00eaff;
    }

    .floating input {
      width: 100%;
      height: 48px;
      padding: 14px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,.2);
      background: rgba(255,255,255,.07);
      color: #e7fdff;
    }

    .floating input:focus {
      border-color: #00eaff;
      box-shadow: 0 0 12px #00eaff88;
    }

    /* 🎯 Login Button Dengan Ripple */
    .btn-login {
      width: 100%;
      padding: 0.7rem;
      border: none;
      border-radius: 10px;
      font-weight: 700;
      background: linear-gradient(45deg, #00eaff, #00bcd4);
      color: #000;
      overflow: hidden;
      position: relative;
    }

    .btn-login:active::after {
      content: "";
      position: absolute;
      width: 200%;
      height: 200%;
      background: rgba(255,255,255,0.4);
      border-radius: 50%;
      transform: scale(0);
      animation: ripple .6s linear;
    }

    @keyframes ripple {
      to { transform: scale(1); opacity: 0; }
    }

    .toggle-link {
      color: #00eaff;
      text-decoration: none;
      font-weight: 500;
    }

    .toggle-link:hover {
      text-shadow: 0 0 12px #00eaff;
    }

  </style>
</head>

<body>

  <div class="bg-layer"></div>
  <div class="bg-layer2"></div>
  <div class="bg-layer3"></div>

  <canvas id="particles"></canvas>
  <div class="border-glow" id="glow"></div>

  <div class="auth-card" id="card">
    <h4 class="mb-4" style="color:#00eaff;text-shadow:0 0 22px #00eaffaa;">Masuk ke Akun</h4>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="floating">
        <input type="email" name="email" required placeholder=" ">
        <label>Email</label>
      </div>

      <div class="floating">
        <input type="password" name="password" required placeholder=" ">
        <label>Kata Sandi</label>
      </div>

      <button type="submit" class="btn-login mb-3">LOGIN</button>
    </form>

    <p>Belum punya akun?
      <a href="{{ route('register') }}" class="toggle-link">Daftar Sekarang</a>
    </p>
  </div>

<script>
/* 🟣 Border Glow Follow Mouse */
const glow = document.getElementById('glow');
document.addEventListener('mousemove', e => {
  glow.style.left = `${e.clientX - 90}px`;
  glow.style.top  = `${e.clientY - 90}px`;
});

/* ✨ Particle Engine */
const canvas = document.getElementById("particles");
const ctx = canvas.getContext("2d");
canvas.width = innerWidth;
canvas.height = innerHeight;

let particles = [];
for (let i = 0; i < 60; i++) {
  particles.push({
    x: Math.random()*canvas.width,
    y: Math.random()*canvas.height,
    size: Math.random()*2+1,
    speedX: (Math.random()*1)-0.5,
    speedY: (Math.random()*1)-0.5
  });
}

function animate() {
  ctx.clearRect(0,0,canvas.width,canvas.height);
  particles.forEach(p => {
    p.x += p.speedX;
    p.y += p.speedY;
    if(p.x<0||p.x>canvas.width) p.speedX*=-1;
    if(p.y<0||p.y>canvas.height) p.speedY*=-1;

    ctx.fillStyle = "#00eaff";
    ctx.beginPath();
    ctx.arc(p.x,p.y,p.size,0,Math.PI*2);
    ctx.fill();
  });
  requestAnimationFrame(animate);
}
animate();
</script>

</body>
</html>
