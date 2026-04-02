<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Register - Futuristik Premium</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0; height: 100vh;
      display: flex; align-items: center; justify-content: center;
      background: linear-gradient(-45deg, #1a1a2e, #16213e, #0f3460, #53354a);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .wave {
      position: absolute; bottom: 0; left: 0;
      width: 200%; height: 150px;
      background: url("https://i.ibb.co/F7vC7mH/wave.png");
      background-size: 1000px 150px;
      animation: wave 10s linear infinite;
      opacity: 0.5;
    }
    @keyframes wave {
      0% {background-position-x: 0;}
      100% {background-position-x: 1000px;}
    }

    .auth-card {
      width: 400px; padding: 2rem;
      border-radius: 20px;
      backdrop-filter: blur(15px);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
      border: 2px solid rgba(255,255,255,0.2);
      position: relative; overflow: hidden;
      color: #fff;
    }

    .auth-card::before {
      content: ""; position: absolute;
      top: -2px; left: -2px; right: -2px; bottom: -2px;
      border-radius: 20px;
      background: linear-gradient(270deg, #ff00cc, #3333ff, #00ffcc);
      background-size: 600% 600%;
      z-index: -1;
      animation: neonBorder 8s ease infinite;
    }
    @keyframes neonBorder {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .form-control {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff; border-radius: 10px;
      padding-left: 40px;
    }
    .form-control:focus {
      box-shadow: 0 0 10px #00f2ff;
      border-color: #00f2ff;
    }
    .input-group-text {
      background: transparent; border: none;
      color: #fff; position: absolute;
      left: 10px; top: 50%; transform: translateY(-50%);
    }

    .btn-custom {
      width: 100%; padding: 0.7rem;
      border-radius: 10px;
      background: linear-gradient(90deg,#00f2ff,#7d2ae8);
      border: none; color: #fff;
      font-weight: bold; transition: 0.3s;
    }
    .btn-custom:hover {
      box-shadow: 0 0 20px #00f2ff;
      transform: scale(1.05);
    }

    .toggle-link { cursor:pointer; color:#ffeb3b; font-weight:500; }
    .invalid-feedback { font-size: 0.8rem; }
  </style>
</head>
<body>

  <div class="wave"></div>

  <div class="auth-card text-center" data-aos="zoom-in" data-tilt>
    <h4 id="typed" class="mb-4 text-light"></h4>

    {{-- LOGIN FORM --}}
    <div id="loginForm">
      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                 placeholder="Email" value="{{ old('email') }}" required autofocus>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                 placeholder="Password" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn-custom">Login</button>
      </form>
      <p class="mt-3">Belum punya akun? <span class="toggle-link" onclick="showRegister()">Daftar</span></p>
    </div>

    {{-- REGISTER FORM --}}
    <div id="registerForm" style="display:none;">
      <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-3">
          <input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror"
                 placeholder="Nama Lengkap" value="{{ old('nama_pengguna') }}" required>
          @error('nama_pengguna') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                 placeholder="Email" value="{{ old('email') }}" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                 placeholder="Kata Sandi" required>
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
          <input type="password" name="password_confirmation" class="form-control"
                 placeholder="Konfirmasi Kata Sandi" required>
        </div>
        <div class="mb-3">
          <select name="peran" class="form-select @error('peran') is-invalid @enderror" required>
            <option value="" disabled selected>-- Pilih Role --</option>
            <option value="admin" {{ old('peran')=='admin' ? 'selected' : '' }}>Admin</option>
            <option value="teknisi" {{ old('peran')=='teknisi' ? 'selected' : '' }}>Teknisi</option>
            <option value="user" {{ old('peran')=='user' ? 'selected' : '' }}>User</option>
          </select>
          @error('peran') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn-custom">Daftar</button>
      </form>
      <p class="mt-3">Sudah punya akun? <span class="toggle-link" onclick="showLogin()">Login</span></p>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script>
    new Typed("#typed", {
      strings: ["Selamat Datang 👋", "Login ke Akun Anda ✨", "Atau Buat Akun Baru 🌈"],
      typeSpeed: 60, backSpeed: 40, loop: true
    });

    AOS.init();
    VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
      max:10,speed:400,glare:true,"max-glare":0.2
    });

    function showRegister() {
      gsap.to("#loginForm", {opacity:0,y:-30,duration:0.4,onComplete:()=>{
        document.getElementById("loginForm").style.display="none";
        document.getElementById("registerForm").style.display="block";
        gsap.fromTo("#registerForm",{opacity:0,y:30},{opacity:1,y:0,duration:0.5});
      }});
    }
    function showLogin() {
      gsap.to("#registerForm", {opacity:0,y:-30,duration:0.4,onComplete:()=>{
        document.getElementById("registerForm").style.display="none";
        document.getElementById("loginForm").style.display="block";
        gsap.fromTo("#loginForm",{opacity:0,y:30},{opacity:1,y:0,duration:0.5});
      }});
    }
  </script>
</body>
</html>
