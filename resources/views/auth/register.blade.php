<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account - TodoApp</title>

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

    <div class="container" style="max-width: 480px;">
        {{-- Brand / Header --}}
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-3 p-3 d-inline-flex align-items-center justify-content-center shadow-sm mb-2">
                <i class="bi bi-person-plus-fill fs-2"></i>
            </div>
            <h1 class="h3 fw-bold mb-1">Create an Account</h1>
            <p class="text-muted small">Start managing your personal tasks efficiently today</p>
        </div>

        {{-- Toast / Alerts --}}
        @include('components.toast')

        {{-- Register Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body text-muted"><i class="bi bi-person"></i></span>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Jane Doe"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name"
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email Address --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="jane@example.com"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small">Password (Min. 8 characters)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required
                                   autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold small">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body text-muted"><i class="bi bi-shield-check"></i></span>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="••••••••"
                                   required
                                   autocomplete="new-password">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="bi bi-check-circle"></i>
                        <span>Register & Continue</span>
                    </button>
                </form>
            </div>

            <div class="card-footer bg-body-tertiary text-center py-3 border-top small">
                <span class="text-muted">Already have an account?</span>
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none ms-1">Sign in here</a>
            </div>
        </div>
    </div>

    {{-- Bootstrap 5.3 JS Bundle CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- Application JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

