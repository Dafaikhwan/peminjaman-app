<!-- Modal Auth Max Premium (Final) -->
<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

      <!-- Header -->
      <div class="modal-header border-0 justify-content-center bg-gradient p-3" style="background: linear-gradient(135deg, #0dcaf0, #198754);">
        <h5 class="modal-title text-white fw-bold display-6 text-center" id="authModalLabel">
          <span id="authTitle"></span>
        </h5>
        <button type="button" class="btn-close btn-close-white position-absolute end-3 top-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(16px);">

        <!-- Tabs -->
        <ul class="nav nav-tabs nav-justified mb-4" id="authTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="tab-login-tab" data-bs-toggle="tab" data-bs-target="#tab-login" type="button" role="tab">Masuk</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-register-tab" data-bs-toggle="tab" data-bs-target="#tab-register" type="button" role="tab">Daftar</button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">

          <!-- LOGIN -->
          <div class="tab-pane fade show active" id="tab-login" role="tabpanel">
            <form method="POST" action="{{ route('login.post') }}">
              @csrf
              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="loginEmail" placeholder="Email" required>
                <label for="loginEmail"><i class="fas fa-envelope me-2"></i>Email</label>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword" placeholder="Password" required>
                <label for="loginPassword"><i class="fas fa-lock me-2"></i>Password</label>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-gradient btn-lg ripple shadow-sm">Masuk</button>
              </div>
            </form>
          </div>

          <!-- REGISTER -->
          <div class="tab-pane fade" id="tab-register" role="tabpanel">
            <form method="POST" action="{{ route('register.post') }}">
              @csrf

              <div class="form-floating mb-3">
                <input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror" id="registerName" placeholder="Nama Lengkap" required>
                <label for="registerName"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                @error('nama_pengguna')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="registerEmail" placeholder="Email" required>
                <label for="registerEmail"><i class="fas fa-envelope me-2"></i>Email</label>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="row gx-2">
                <div class="col">
                  <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="registerPassword" placeholder="Password" required>
                    <label for="registerPassword"><i class="fas fa-lock me-2"></i>Password</label>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                </div>
                <div class="col">
                  <div class="form-floating mb-3">
                    <input type="password" name="password_confirmation" class="form-control" id="registerPasswordConfirm" placeholder="Konfirmasi Password" required>
                    <label for="registerPasswordConfirm"><i class="fas fa-lock me-2"></i>Konfirmasi</label>
                  </div>
                </div>
              </div>

              <div class="d-grid mt-3">
                <button type="submit" class="btn btn-gradient btn-lg ripple shadow-sm">Daftar</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Styles & Ripple -->
<style>
  .btn-gradient {
    background: linear-gradient(135deg, #0dcaf0, #0d6efd);
    color: #fff;
    border: none;
    transition: all 0.3s ease;
  }
  .btn-gradient:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(13, 202, 240, 0.6);
  }
  .ripple {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
  }
  .ripple:after {
    content: "";
    position: absolute;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    transform: scale(0);
    width: 100%;
    height: 100%;
    top: 0; left: 0;
    opacity: 0;
    transition: transform 0.5s, opacity 1s;
  }
  .ripple:active:after {
    transform: scale(2);
    opacity: 1;
    transition: 0s;
  }
  .form-floating input:focus ~ label,
  .form-floating input:not(:placeholder-shown) ~ label {
    transform: translateY(-1.5rem) scale(0.85);
    color: #0dcaf0;
  }
  .nav-tabs .nav-link.active {
    color: #0dcaf0;
    font-weight: 600;
    border-bottom: 3px solid #0dcaf0;
  }
  .nav-tabs .nav-link {
    color: #6c757d;
    font-weight: 500;
  }
</style>

<script>
  // Typewriter animation
  const titleEl = document.getElementById('authTitle');
  const text = "Selamat Datang!";
  let i = 0;
  function typeWriter() {
    if(i < text.length){
      titleEl.innerHTML += text.charAt(i);
      i++;
      setTimeout(typeWriter, 80);
    }
  }
  typeWriter();
</script>
