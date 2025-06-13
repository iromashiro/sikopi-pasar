<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Informasi Koperasi Pasar - Login Portal">
    <meta name="keywords" content="sikopi, pasar, retribusi, login">
    <meta name="author" content="SIKOPI PASAR">

    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'SIKOPI PASAR') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
            z-index: -1;
            animation: backgroundMove 20s ease-in-out infinite;
        }

        @keyframes backgroundMove {

            0%,
            100% {
                transform: translateX(0) translateY(0);
            }

            25% {
                transform: translateX(-20px) translateY(-10px);
            }

            50% {
                transform: translateX(20px) translateY(10px);
            }

            75% {
                transform: translateX(-10px) translateY(20px);
            }
        }

        /* Floating Shapes */
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
            z-index: -1;
        }

        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Auth Container */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
            max-width: 450px;
            width: 100%;
            animation: slideInUp 0.6s ease-out;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 12px 40px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.3);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Section */
        .auth-header {
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            padding: 2rem 1.5rem 1.5rem;
            position: relative;
        }

        .auth-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: white;
            border-radius: 20px 20px 0 0;
        }

        .auth-header .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .auth-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* Form Section */
        .auth-body {
            padding: 2rem 1.5rem 1.5rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(248, 249, 250, 0.8);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }

        .form-floating>label {
            color: #6c757d;
            font-weight: 500;
        }

        .btn-auth {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        /* Links */
        .auth-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
        }

        .auth-link:hover {
            color: #5a6fd8;
        }

        .auth-link:hover::after {
            width: 100%;
        }

        /* Demo Section */
        .demo-accounts {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1.5rem;
            border-left: 4px solid #667eea;
        }

        .demo-accounts h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .demo-account {
            background: white;
            border-radius: 8px;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .demo-account:hover {
            border-color: #667eea;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .demo-account strong {
            color: #495057;
            font-size: 0.9rem;
        }

        .demo-account small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e9ecef;
            background: rgba(248, 249, 250, 0.5);
        }

        .auth-footer p {
            margin: 0;
            color: #6c757d;
            font-size: 0.85rem;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1rem;
            animation: slideInDown 0.4s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading State */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .auth-container {
                padding: 10px;
            }

            .auth-card {
                margin: 10px;
                border-radius: 16px;
            }

            .auth-header {
                padding: 1.5rem 1rem 1rem;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }

            .auth-body {
                padding: 1.5rem 1rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .auth-card {
                background: rgba(33, 37, 41, 0.95);
                color: #f8f9fa;
            }

            .form-control {
                background: rgba(52, 58, 64, 0.8);
                border-color: #495057;
                color: #f8f9fa;
            }

            .form-control:focus {
                background: #495057;
                color: #f8f9fa;
            }

            .form-floating>label {
                color: #adb5bd;
            }
        }

        /* Accessibility */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus indicators */
        .form-control:focus,
        .btn:focus,
        .auth-link:focus {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Floating Shapes -->
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>

    <!-- Main Container -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="logo">
                    <i class="bi bi-building"></i>
                </div>
                <h1>SIKOPI PASAR</h1>
                <p>Sistem Informasi Koperasi Pasar</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Session Status -->
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}

                <!-- Demo Accounts -->
                <div class="demo-accounts">
                    <h6>
                        <i class="bi bi-info-circle"></i>
                        Demo Accounts
                    </h6>

                    <div class="demo-account" onclick="fillDemoAccount('admin@sikopi.go.id', 'password')">
                        <strong>Administrator</strong><br>
                        <small>admin@sikopi.go.id / password</small>
                    </div>

                    <div class="demo-account" onclick="fillDemoAccount('collector1@sikopi.go.id', 'password')">
                        <strong>Petugas Kolektor</strong><br>
                        <small>collector1@sikopi.go.id / password</small>
                    </div>

                    <div class="demo-account"
                        onclick="fillDemoAccount('ahmad.wijaya@trader.sikopi.local', 'trader123')">
                        <strong>Pedagang</strong><br>
                        <small>ahmad.wijaya@trader.sikopi.local / trader123</small>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p>
                    &copy; {{ date('Y') }} SIKOPI PASAR.
                    <span class="d-none d-sm-inline">Semua hak dilindungi.</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Demo account filler
        function fillDemoAccount(email, password) {
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;

                // Trigger events for proper form handling
                emailInput.dispatchEvent(new Event('input', { bubbles: true }));
                passwordInput.dispatchEvent(new Event('input', { bubbles: true }));

                // Focus on submit button
                const submitBtn = document.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.focus();
                }
            }
        }

        // Form submission loading state
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;
                    }
                });
            });
        });

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Keyboard navigation for demo accounts
        document.addEventListener('keydown', function(e) {
            if (e.altKey && e.key >= '1' && e.key <= '3') {
                e.preventDefault();
                const accounts = [
                    ['admin@sikopi.go.id', 'password'],
                    ['collector1@sikopi.go.id', 'password'],
                    ['ahmad.wijaya@trader.sikopi.local', 'trader123']
                ];

                const index = parseInt(e.key) - 1;
                if (accounts[index]) {
                    fillDemoAccount(accounts[index][0], accounts[index][1]);
                }
            }
        });

        // Password visibility toggle
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Smooth scroll for anchor links
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
    </script>

    @stack('scripts')
</body>

</html>