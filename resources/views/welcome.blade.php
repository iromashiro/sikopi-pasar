<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIKOPI PASAR') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .feature-card {
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SIKOPI PASAR</a>
            <div class="navbar-nav ms-auto">
                @auth
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Sistem Informasi Koperasi Pasar</h1>
                    <p class="lead mb-4">
                        Kelola retribusi pasar dengan mudah, transparan, dan efisien.
                        Sistem terintegrasi untuk pedagang, petugas, dan administrator.
                    </p>
                    <div class="d-flex gap-3">
                        @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk Sistem
                        </a>
                        @endauth
                        <a href="#features" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-info-circle"></i> Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-building display-1"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold">Fitur Unggulan</h2>
                    <p class="text-muted">Solusi lengkap untuk manajemen retribusi pasar</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
                            <h5 class="card-title">Manajemen Pedagang</h5>
                            <p class="card-text">Kelola data pedagang, penugasan kios, dan informasi lengkap dengan
                                sistem yang terintegrasi dan
                                mudah digunakan.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-receipt fs-1 text-success mb-3"></i>
                            <h5 class="card-title">Retribusi Otomatis</h5>
                            <p class="card-text">Generate retribusi bulanan secara otomatis dengan formula yang dapat
                                disesuaikan dan
                                perhitungan yang akurat.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-credit-card fs-1 text-info mb-3"></i>
                            <h5 class="card-title">Pembayaran Digital</h5>
                            <p class="card-text">Catat pembayaran dengan berbagai metode, generate receipt otomatis, dan
                                tracking status
                                pembayaran real-time.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-graph-up fs-1 text-warning mb-3"></i>
                            <h5 class="card-title">Laporan & Analytics</h5>
                            <p class="card-text">Dashboard interaktif dengan grafik real-time, laporan harian/bulanan,
                                dan export data
                                dalam format Excel/CSV.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-shield-check fs-1 text-danger mb-3"></i>
                            <h5 class="card-title">Keamanan Data</h5>
                            <p class="card-text">Sistem keamanan berlapis dengan audit trail lengkap, role-based access
                                control, dan
                                enkripsi data sensitif.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-phone fs-1 text-secondary mb-3"></i>
                            <h5 class="card-title">Responsive Design</h5>
                            <p class="card-text">Akses dari desktop, tablet, atau smartphone dengan tampilan yang
                                optimal dan user
                                experience yang konsisten.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 fw-bold text-primary">{{ \App\Models\Market::count() }}</h2>
                            <p class="text-muted">Pasar Terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 fw-bold text-success">{{ \App\Models\Kiosk::count() }}</h2>
                            <p class="text-muted">Total Kios</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 fw-bold text-info">
                                {{ \App\Models\Trader::where('status', 'active')->count() }}</h2>
                            <p class="text-muted">Pedagang Aktif</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 fw-bold text-warning">{{ \App\Models\Payment::count() }}</h2>
                            <p class="text-muted">Transaksi Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold">Cara Kerja Sistem</h2>
                    <p class="text-muted">Proses sederhana dalam 4 langkah</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <span class="fs-3 fw-bold">1</span>
                        </div>
                    </div>
                    <h5>Registrasi Pedagang</h5>
                    <p class="text-muted">Admin mendaftarkan pedagang dan menugaskan kios sesuai kategori usaha.</p>
                </div>

                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <span class="fs-3 fw-bold">2</span>
                        </div>
                    </div>
                    <h5>Generate Retribusi</h5>
                    <p class="text-muted">Sistem otomatis menghitung retribusi bulanan berdasarkan formula yang telah
                        ditetapkan.</p>
                </div>

                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <span class="fs-3 fw-bold">3</span>
                        </div>
                    </div>
                    <h5>Catat Pembayaran</h5>
                    <p class="text-muted">Petugas mencatat pembayaran dan sistem generate receipt secara otomatis.</p>
                </div>

                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <span class="fs-3 fw-bold">4</span>
                        </div>
                    </div>
                    <h5>Monitoring & Laporan</h5>
                    <p class="text-muted">Dashboard real-time dan laporan komprehensif untuk monitoring kinerja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-4">Hubungi Kami</h3>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-geo-alt-fill fs-5 me-3"></i>
                        <div>
                            <strong>Alamat:</strong><br>
                            Jl. Merdeka No. 123, Kota Bandung<br>
                            Jawa Barat 40111
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone-fill fs-5 me-3"></i>
                        <div>
                            <strong>Telepon:</strong><br>
                            (022) 1234-5678
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-envelope-fill fs-5 me-3"></i>
                        <div>
                            <strong>Email:</strong><br>
                            info@sikopi.go.id
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3 class="fw-bold mb-4">Jam Operasional</h3>
                    <div class="row">
                        <div class="col-6">
                            <strong>Senin - Jumat:</strong><br>
                            08:00 - 16:00 WIB
                        </div>
                        <div class="col-6">
                            <strong>Sabtu:</strong><br>
                            08:00 - 12:00 WIB
                        </div>
                    </div>
                    <div class="mt-3">
                        <strong>Minggu & Hari Libur:</strong><br>
                        Tutup
                    </div>

                    <div class="mt-4">
                        <h5>Ikuti Kami</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="text-white fs-4"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-secondary text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-2">&copy; {{ date('Y') }} SIKOPI PASAR. Semua hak dilindungi.</p>
                    <p class="mb-0">
                        <small>
                            Dikembangkan dengan <i class="bi bi-heart-fill text-danger"></i>
                            menggunakan Laravel {{ app()->version() }}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Smooth Scrolling -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                                        anchor.addEventListener('click', function (e) {
                                            e.preventDefault();
                                            const target = document.querySelector(this.getAttribute('href'));
                                            if (target) {
                                                target.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                            }
                                        });
                                    });

                                    // Add scroll effect to navbar
                                    window.addEventListener('scroll', function() {
                                        const navbar = document.querySelector('.navbar');
                                        if (window.scrollY > 50) {
                                            navbar.classList.add('bg-dark');
                                            navbar.classList.remove('bg-transparent');
                                        } else {
                                            navbar.classList.add('bg-transparent');
                                            navbar.classList.remove('bg-dark');
                                        }
                                    });
    </script>
</body>

</html>