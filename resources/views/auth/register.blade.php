<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Aplikasi Peminjaman</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    *{box-sizing:border-box;margin:0;padding:0;font-family:'Poppins',sans-serif}
    html,body{height:100%}
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

    /* 3-Layer Neon Parallax */
    .bg-layer{position:absolute;width:120%;height:120%;top:-10%;left:-10%;background:radial-gradient(circle at center,#00eaff22,#00151a 70%);animation:float 12s infinite ease-in-out alternate;z-index:-5}
    .bg-layer2{position:absolute;width:130%;height:130%;top:-15%;left:-15%;background:radial-gradient(circle at 30% 70%,#00bfff15,transparent 70%);animation:float2 10s infinite ease-in-out alternate;z-index:-6}
    .bg-layer3{position:absolute;width:140%;height:140%;top:-20%;left:-20%;background:radial-gradient(circle at 70% 20%,#00ffff10,transparent 80%);animation:float3 14s infinite ease-in-out alternate;z-index:-7}
    @keyframes float{from{transform:translate(0,0)}to{transform:translate(30px,-40px)}}
    @keyframes float2{from{transform:translate(-20px,10px)}to{transform:translate(40px,-20px)}}
    @keyframes float3{from{transform:translate(10px,-30px)}to{transform:translate(-40px,30px)}}

    /* Particles canvas */
    canvas{position:absolute;top:0;left:0;width:100%;height:100%;z-index:-4}

    /* Glass Card */
    .auth-card{
      width:420px;
      padding:2.8rem;
      background:rgba(255,255,255,0.04);
      border-radius:22px;
      backdrop-filter:blur(22px);
      border:1px solid rgba(255,255,255,0.12);
      box-shadow:0 0 40px rgba(0,255,255,0.18);
      animation:fadeUp .9s ease forwards;
      position:relative;
      overflow:hidden;
    }
    @keyframes fadeUp{from{opacity:0;transform:translateY(40px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}

    /* Border glow follow mouse */
    .border-glow{position:absolute;width:200px;height:200px;background:rgba(0,255,255,.12);filter:blur(60px);border-radius:50%;pointer-events:none;z-index:-1;transition:.12s ease-out}

    /* Header */
    .auth-card h4{color:#00eaff;text-shadow:0 0 22px #00eaffaa;margin-bottom:1.3rem;font-weight:600;letter-spacing:.6px}

    /* Floating label */
    .floating{position:relative;margin-bottom:1.3rem}
    .floating input{width:100%;height:48px;padding:14px;border-radius:10px;border:1px solid rgba(255,255,255,.18);background:rgba(255,255,255,.05);color:#e7fdff;outline:none}
    .floating label{position:absolute;left:14px;top:12px;color:rgba(160,255,255,0.8);font-size:14px;pointer-events:none;transition:.25s ease}
    .floating input:focus{box-shadow:0 0 12px #00eaff66;border-color:#00eaff;background:rgba(255,255,255,.08)}
    .floating input:focus ~ label,
    .floating input:not(:placeholder-shown) ~ label{
      top:-11px;left:10px;font-size:12px;background:#020202;padding:0 6px;border-radius:4px;color:#00eaff;opacity:1
    }

    /* Button ripple */
    .btn-register{width:100%;padding:.72rem;border-radius:10px;border:none;font-weight:700;background:linear-gradient(45deg,#00eaff,#00bcd4);color:#000;position:relative;overflow:hidden}
    .btn-register:active::after{content:"";position:absolute;width:200%;height:200%;background:rgba(255,255,255,0.38);border-radius:50%;transform:scale(0);animation:ripple .6s linear}
    @keyframes ripple{to{transform:scale(1);opacity:0}}

    /* Links */
    .toggle-link{color:#00eaff;font-weight:500;text-decoration:none}
    .toggle-link:hover{text-shadow:0 0 12px #00eaff}

    /* Placeholder & input */
    ::placeholder{color:rgba(0,240,255,0.7);letter-spacing:.3px;font-weight:500}
    .form-note{color:#bff6ff;font-size:.92rem;margin-top:.9rem;opacity:.9}

    /* Responsive */
    @media(max-width:480px){
      .auth-card{width:92%;padding:2rem}
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
    <h4>Buat Akun Baru</h4>

    <form method="POST" action="{{ route('register.post') }}">
      @csrf

      <div class="floating">
        <input type="text" name="nama_pengguna" required placeholder=" " autocomplete="name" />
        <label>Nama Lengkap</label>
      </div>

      <div class="floating">
        <input type="email" name="email" required placeholder=" " autocomplete="email" />
        <label>Email</label>
      </div>

      <div class="floating">
        <input type="password" name="password" required placeholder=" " autocomplete="new-password" />
        <label>Kata Sandi</label>
      </div>

      <div class="floating">
        <input type="password" name="password_confirmation" required placeholder=" " autocomplete="new-password" />
        <label>Konfirmasi Kata Sandi</label>
      </div>

      <button type="submit" class="btn-register mb-2">DAFTAR</button>

      <div class="form-note text-center">
        Dengan mendaftar, kamu menyetujui Syarat & Ketentuan.
      </div>
    </form>

    <p class="mt-3 text-center">Sudah punya akun?
      <a href="{{ route('login') }}" class="toggle-link">Masuk Sekarang</a>
    </p>
  </div>

  <script>
    /* Border glow follow mouse */
    const glow = document.getElementById('glow');
    document.addEventListener('mousemove', e => {
      glow.style.left = `${e.clientX - 100}px`;
      glow.style.top  = `${e.clientY - 100}px`;
    });

    /* Simple Particle Engine (lightweight & performant) */
    const canvas = document.getElementById("particles");
    const ctx = canvas.getContext("2d");
    let dpr = window.devicePixelRatio || 1;
    function resizeCanvas(){
      canvas.width = innerWidth * dpr;
      canvas.height = innerHeight * dpr;
      canvas.style.width = innerWidth + "px";
      canvas.style.height = innerHeight + "px";
      ctx.scale(dpr,dpr);
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    let particles = [];
    const P_COUNT = 70;
    for (let i = 0; i < P_COUNT; i++){
      particles.push({
        x: Math.random()*innerWidth,
        y: Math.random()*innerHeight,
        r: Math.random()*1.8+0.6,
        vx: (Math.random()-0.5)*0.6,
        vy: (Math.random()-0.5)*0.6,
        alpha: Math.random()*0.6 + 0.15
      });
    }

    // mouse repulse / follow
    const mouse = {x: null, y: null};
    window.addEventListener('mousemove', (e)=>{mouse.x = e.clientX; mouse.y = e.clientY});

    function draw(){
      ctx.clearRect(0,0,innerWidth,innerHeight);
      for (let p of particles){
        // simple attraction to mouse for interactivity (subtle)
        if(mouse.x && mouse.y){
          const dx = mouse.x - p.x;
          const dy = mouse.y - p.y;
          const dist = Math.sqrt(dx*dx+dy*dy);
          if(dist < 140){
            p.x -= dx * 0.002;
            p.y -= dy * 0.002;
          } else {
            p.x += p.vx;
            p.y += p.vy;
          }
        } else {
          p.x += p.vx;
          p.y += p.vy;
        }

        if(p.x < 0) p.x = innerWidth;
        if(p.x > innerWidth) p.x = 0;
        if(p.y < 0) p.y = innerHeight;
        if(p.y > innerHeight) p.y = 0;

        ctx.globalAlpha = p.alpha;
        ctx.fillStyle = "#00eaff";
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
        ctx.fill();
      }
      ctx.globalAlpha = 1;
      requestAnimationFrame(draw);
    }
    draw();

    /* small optimization: clear mouse when leaving window */
    window.addEventListener('mouseleave', ()=> { mouse.x = null; mouse.y = null; });

  </script>

</body>
</html>
