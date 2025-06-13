<x-guest-layout>
    <div class="auth-card p-4">
        <form method="POST" action="{{ route('login') }}" x-data="loginForm()">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input :type="showPassword ? 'text' : 'password'"
                        class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                        required>
                    <button type="button" class="btn btn-outline-secondary" @click="showPassword = !showPassword">
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                    </button>
                </div>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </div>

            @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            </div>
            @endif
        </form>

        <!-- Demo Accounts -->
        <div class="mt-4 p-3 bg-light rounded">
            <small class="text-muted">
                <strong>Demo Accounts:</strong><br>
                Admin: admin@sikopi.go.id / password<br>
                Trader: ahmad.wijaya@trader.sikopi.local / trader123
            </small>
        </div>
    </div>

    @push('scripts')
    <script>
        function loginForm() {
            return {
                showPassword: false
            }
        }
    </script>
    @endpush
</x-guest-layout>