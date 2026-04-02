@extends('layouts.frontend')

@section('title','Beranda')

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center gx-5">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold hero-title" data-aos="fade-up">
                    Sistem Peminjaman Modern untuk Kampus & Instansi
                </h1>
                <p class="lead hero-sub mt-3" data-aos="fade-up" data-aos-delay="100">
                    Atur peminjaman alat & ruangan, pantau status, dan laporkan kerusakan — semua dalam satu platform yang mudah digunakan.
                </p>

                <div class="mt-4 cta-group" data-aos="fade-up" data-aos-delay="200">
                    <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#authModal">
                        Daftar Sekarang
                    </a>
                    <a href="#" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#authModal">
                        Masuk
                    </a>
                </div>

                <!-- small stats cards -->
                <div class="row mt-5 gx-3">
                    <div class="col-6 col-sm-4" data-aos="fade-right" data-aos-delay="300">
                        <div class="card card-glass p-3 text-center">
                            <h4 class="mb-0">120+</h4>
                            <small class="text-muted">Alat Tersedia</small>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4" data-aos="fade-up" data-aos-delay="350">
                        <div class="card card-glass p-3 text-center">
                            <h4 class="mb-0">1.2k</h4>
                            <small class="text-muted">Peminjaman / bulan</small>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mt-3 mt-sm-0" data-aos="fade-left" data-aos-delay="400">
                        <div class="card card-glass p-3 text-center">
                            <h4 class="mb-0">99%</h4>
                            <small class="text-muted">Kepuasan Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Illustration -->
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="hero-illus">
                    <!-- simple SVG modern scene (customize if needed) -->
                    <svg width="100%" height="380" viewBox="0 0 800 380" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi sistem peminjaman">
                        <defs>
                            <linearGradient id="g1" x1="0" x2="1">
                                <stop offset="0" stop-color="#60a5fa"/>
                                <stop offset="1" stop-color="#06b6d4"/>
                            </linearGradient>
                        </defs>
                        <rect x="30" y="70" width="540" height="220" rx="14" fill="#fff" stroke="#e6edf8" stroke-width="1.5" />
                        <g transform="translate(60,100)">
                            <rect width="160" height="24" rx="6" fill="url(#g1)" opacity="0.95"></rect>
                            <rect x="180" y="0" width="220" height="24" rx="6" fill="#f3f6fb"></rect>
                            <rect y="40" width="380" height="14" rx="6" fill="#f8fafc"></rect>

                            <g transform="translate(0,70)">
                                <rect width="80" height="80" rx="10" fill="#eff6ff"></rect>
                                <rect x="96" width="240" height="80" rx="10" fill="#fff" stroke="#edf2ff" stroke-width="1"></rect>
                            </g>

                            <g transform="translate(320,70)">
                                <rect width="100" height="120" rx="12" fill="#fff" stroke="#eef2ff" stroke-width="1"></rect>
                                <circle cx="32" cy="36" r="12" fill="#60a5fa"></circle>
                                <rect x="56" y="28" width="36" height="12" rx="6" fill="#f3f6fb"></rect>
                            </g>
                        </g>

                        <!-- floating phones/icons -->
                        <circle cx="660" cy="60" r="36" fill="#fff" stroke="#e8f1ff"></circle>
                        <path d="M648 60h24" stroke="#60a5fa" stroke-width="6" stroke-linecap="round"/>

                        <g transform="translate(620,250)">
                            <rect x="-14" y="-40" width="120" height="80" rx="12" fill="#fff" stroke="#e6eefc"></rect>
                            <path d="M0 0h40" stroke="#06b6d4" stroke-width="6" stroke-linecap="round"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="fitur" class="py-6">
    <div class="container">
        <div class="text-center mb-5">
            <h2 data-aos="fade-up">Fitur Unggulan</h2>
            <p class="text-muted">Dirancang untuk memudahkan alur kerja admin, teknisi, dan pengguna.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="zoom-in">
                <div class="p-4 text-center bg-white rounded-3">
                    <div class="mb-3 feature-icon">📦</div>
                    <h5>Peminjaman Alat</h5>
                    <p class="text-muted">Katalog alat, status real-time, dan laporan otomatis.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="p-4 text-center bg-white rounded-3">
                    <div class="mb-3 feature-icon">🏫</div>
                    <h5>Peminjaman Ruangan</h5>
                    <p class="text-muted">Jadwal terintegrasi, persetujuan, dan notifikasi.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="p-4 text-center bg-white rounded-3">
                    <div class="mb-3 feature-icon">🛠️</div>
                    <h5>Manajemen Laporan</h5>
                    <p class="text-muted">Pelaporan kerusakan dengan upload foto & histori tindakan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICING / CTA -->
<section id="harga" class="py-6 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h3 data-aos="fade-up">Pilih Paket</h3>
            <p class="text-muted">Cocok untuk laboratorium kecil sampai skala besar.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4" data-aos="flip-left">
                <div class="card p-4 text-center">
                    <h5 class="mb-3">Basic</h5>
                    <h2 class="fw-bold">Gratis</h2>
                    <p class="text-muted">Cocok untuk percobaan & demo</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary mt-3">Mulai</a>
                </div>
            </div>

            <div class="col-md-4" data-aos="flip-up">
                <div class="card p-4 text-center border-primary">
                    <div class="badge bg-primary text-white mb-2">Paling Populer</div>
                    <h5 class="mb-3">Pro</h5>
                    <h2 class="fw-bold">Rp 500k / tahun</h2>
                    <p class="text-muted">Full fitur untuk institusi sedang</p>
                    <a href="{{ route('register') }}" class="btn btn-cta mt-3">Daftar Pro</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section id="testi" class="py-6">
    <div class="container">
        <div class="text-center mb-5">
            <h3 data-aos="fade-down">Pengguna Kami</h3>
            <p class="text-muted">Mereka sudah merasakan manfaatnya</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="testimonial p-3">
                    <p class="mb-2">"Sistem ini mempermudah koordinasi laboratorium kami - jauh lebih cepat."</p>
                    <div class="small text-muted">— Dosen, Universitas A</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial p-3">
                    <p class="mb-2">"Notifikasi dan approvalnya rapi. Tracking laporan juga jelas."</p>
                    <div class="small text-muted">— Teknisi, SMK B</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial p-3">
                    <p class="mb-2">"UI bagus, mudah dimengerti mahasiswa. Highly recommended."</p>
                    <div class="small text-muted">— Koordinator Lab</div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Extra GSAP micro-interactions for CTA buttons and pricing highlight
    gsap.registerPlugin(ScrollTrigger);

    gsap.from(".feature-icon", {
        scale: 0.9,
        opacity: 0,
        stagger: 0.12,
        duration: 0.6,
        ease: "back.out(1.7)",
        scrollTrigger: { trigger: "#fitur", start: "top 80%" }
    });

    // subtle pulse on popular card
    gsap.to(".card.border-primary", {
        scale: 1.02,
        repeat: -1,
        yoyo: true,
        duration: 2,
        ease: "power1.inOut",
        opacity: 0.99
    });
</script>
@endpush
