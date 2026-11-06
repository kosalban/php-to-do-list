<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - TodoApp</title>

    {{-- Bootstrap 5.3 CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Bootstrap Icons CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Application CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center py-5 min-vh-100">
    {{-- Top corner theme toggle --}}
    <div class="position-absolute top-0 end-0 p-3">
        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-inline-flex align-items-center gap-2" id="themeToggleBtn" type="button" title="Toggle theme">
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
            <span class="small">Theme</span>
        </button>
    </div>

    <div class="container" style="max-width: 440px;">
        {{-- Brand / Header --}}
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-3 p-3 d-inline-flex align-items-center justify-content-center shadow-sm mb-2">
                <i class="bi bi-check2-square fs-2"></i>
            </div>
            <h1 class="h3 fw-bold mb-1">Sign in to TodoApp</h1>
            <p class="text-muted small">Manage your daily tasks and boost your productivity</p>
        </div>

        {{-- Toast / Alerts --}}
        @include('components.toast')

        {{-- Login Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    {{-- Email Input --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="name@example.com"
                                   value="{{ old('email', 'user@example.com') }}"
                                   required
                                   autocomplete="email"
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   value="password"
                                   required
                                   autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember Me Checkbox --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">Remember me on this device</label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Sign In</span>
                    </button>
                </form>

                {{-- Quick Demo Credentials Box --}}
                <div class="mt-4 p-3 bg-body-tertiary rounded-3 border small">
                    <div class="fw-semibold d-flex align-items-center gap-1 text-primary mb-1">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Demo Account Pre-filled:</span>
                    </div>
                    <div class="text-muted">
                        Email: <code>user@example.com</code><br>
                        Password: <code>password</code>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-body-tertiary text-center py-3 border-top small">
                <span class="text-muted">Don't have an account yet?</span>
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none ms-1">Create an account</a>
            </div>
        </div>
    </div>

    {{-- Bootstrap 5.3 JS Bundle CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- Application JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

