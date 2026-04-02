@extends('layouts.frontend')

@section('title','Beranda')

@section('content')
<section class="hero">
  <div class="container">
    <div class="row align-items-center gx-5">
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold hero-title" data-aos="fade-up">
          Sistem Peminjaman Modern untuk Universitas
        </h1>
        <p class="lead hero-sub mt-3" data-aos="fade-up" data-aos-delay="100">
          Atur peminjaman alat & ruangan, pantau status, dan laporkan kerusakan — semua dalam satu platform yang aman untuk lingkungan kampus.
        </p>

        

        <div class="row mt-5 gx-3">
          <div class="col-4" data-aos="fade-right">
            <div class="card card-glass p-3 text-center">
              <h4 class="mb-0">{{ $totalAlat ?? '—' }}</h4>
              <small class="text-muted">Alat Tersedia</small>
            </div>
          </div>
          <div class="col-4" data-aos="fade-up">
            <div class="card card-glass p-3 text-center">
              <h4 class="mb-0">{{ $peminjamanPerBulan ?? '—' }}</h4>
              <small class="text-muted">Peminjaman / bulan</small>
            </div>
          </div>
          <div class="col-4" data-aos="fade-left">
            <div class="card card-glass p-3 text-center">
              <h4 class="mb-0">{{ $kepuasan ?? '—' }}%</h4>
              <small class="text-muted">Kepuasan Pengguna</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 text-center" data-aos="fade-left">
        <div class="hero-illus">
          <!-- simple SVG -->
          <svg width="100%" height="320" viewBox="0 0 800 380" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi sistem">
            <defs><linearGradient id="g1" x1="0" x2="1"><stop offset="0" stop-color="#60a5fa"/><stop offset="1" stop-color="#06b6d4"/></linearGradient></defs>
            <rect x="30" y="70" width="540" height="220" rx="14" fill="#fff" stroke="#e6edf8" stroke-width="1.5" />
            <g transform="translate(60,100)">
                <rect width="160" height="24" rx="6" fill="url(#g1)" opacity="0.95"></rect>
                <rect x="180" y="0" width="220" height="24" rx="6" fill="#f3f6fb"></rect>
                <rect y="40" width="380" height="14" rx="6" fill="#f8fafc"></rect>
                <g transform="translate(0,70)">
                    <rect width="80" height="80" rx="10" fill="#eff6ff"></rect>
                    <rect x="96" width="240" height="80" rx="10" fill="#fff" stroke="#edf2ff" stroke-width="1"></rect>
                </g>
            </g>
          </svg>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="fitur" class="py-6">
  <div class="container">
    <div class="text-center mb-5">
      <h2 data-aos="fade-up">Fitur Unggulan</h2>
      <p class="text-muted">Dirancang untuk kebutuhan civitas universitas (mahasiswa, dosen, staff).</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="zoom-in">
        <div class="p-4 text-center bg-white rounded-3">
          <div class="mb-3 feature-icon"><i class="fa-solid fa-toolbox"></i></div>
          <h5>Peminjaman Alat</h5>
          <p class="text-muted">Katalog alat, status real-time, dan laporan otomatis.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="p-4 text-center bg-white rounded-3">
          <div class="mb-3 feature-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
          <h5>Peminjaman Ruangan</h5>
          <p class="text-muted">Pesan ruangan untuk praktikum, seminar, dan acara kampus.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="p-4 text-center bg-white rounded-3">
          <div class="mb-3 feature-icon"><i class="fa-solid fa-wrench"></i></div>
          <h5>Manajemen Laporan</h5>
          <p class="text-muted">Laporkan kerusakan dengan foto & histori perbaikan.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="testi" class="py-6">
  <div class="container">
    <div class="text-center mb-5">
      <h3 data-aos="fade-down">Pengguna Kami</h3>
      <p class="text-muted">Testimonial dari civitas yang sudah memakai sistem</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up"><div class="testimonial p-3">"Mudah dipakai & membantu manajemen peralatan." <div class="small text-muted mt-2">— Dosen</div></div></div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100"><div class="testimonial p-3">"Tracking permintaan jadi rapi." <div class="small text-muted mt-2">— Kepala Lab</div></div></div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200"><div class="testimonial p-3">"Sangat membantu koordinasi event kampus." <div class="small text-muted mt-2">— Staff</div></div></div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  // connect CTA buttons to modal
  document.getElementById('cta-login').addEventListener('click', () => document.getElementById('btn-login').click());
  document.getElementById('cta-register').addEventListener('click', () => document.getElementById('btn-register').click());
</script>
@endpush
