<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Auth')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      margin:0; height:100vh;
      display:flex; align-items:center; justify-content:center;
      background:linear-gradient(-45deg,#1a1a2e,#16213e,#0f3460,#53354a);
      background-size:400% 400%; animation:gradientBG 15s ease infinite;
      overflow:hidden; font-family:'Poppins',sans-serif; color:#fff;
    }
    @keyframes gradientBG {0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
    .wave {position:absolute; bottom:0; left:0; width:200%; height:150px; background:url("https://i.ibb.co/F7vC7mH/wave.png"); background-size:1000px 150px; animation:wave 10s linear infinite; opacity:.4;}
    @keyframes wave {0%{background-position-x:0;}100%{background-position-x:1000px;}}
    .auth-card {width:400px; padding:2rem; border-radius:20px; backdrop-filter:blur(15px); background:rgba(255,255,255,0.08); box-shadow:0 8px 32px rgba(0,0,0,0.3); border:2px solid rgba(255,255,255,0.2); position:relative; text-align:center; overflow:hidden;}
    .auth-card::before {content:""; position:absolute; inset:-2px; border-radius:20px; background:linear-gradient(270deg,#00f2ff,#7d2ae8,#00ffcc); background-size:600% 600%; animation:neonBorder 8s ease infinite; z-index:-1;}
    @keyframes neonBorder {0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
    .form-control {background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:10px; padding-left:40px;}
    .form-control:focus {border-color:#00f2ff; box-shadow:0 0 10px #00f2ff;}
    .btn-custom {width:100%; padding:0.7rem; border-radius:10px; background:linear-gradient(90deg,#00f2ff,#7d2ae8); border:none; color:#fff; font-weight:bold; transition:0.3s;}
    .btn-custom:hover {box-shadow:0 0 20px #00f2ff; transform:scale(1.05);}
    .toggle-link {color:#ffeb3b; cursor:pointer; font-weight:500;}
    .splash {position:fixed; inset:0; display:flex; align-items:center; justify-content:center; background:rgba(10,10,25,0.9); z-index:9999; transition:opacity .6s ease, visibility .6s;}
    .splash.hidden {opacity:0; visibility:hidden;}
  </style>
</head>
<body>
  <div class="splash" id="splash">
    <div class="text-center">
      <div class="fs-3 fw-bold text-info">@yield('title','AP')</div>
      <div class="spinner-border text-info" role="status"></div>
    </div>
  </div>

  @yield('content')

  <script>
    setTimeout(()=>document.getElementById('splash').classList.add('hidden'),2000);
  </script>
</body>
</html>
