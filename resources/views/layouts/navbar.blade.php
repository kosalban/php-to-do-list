<header class="app-navbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" id="sidebarToggleBtn" aria-label="Toggle navigation">
            <i class="bi bi-list fs-5"></i>
        </button>
        <h1 class="h5 mb-0 fw-bold text-body">
            @yield('header_title', 'Dashboard')
        </h1>
    </div>

    <div class="d-flex align-items-center gap-2">
        {{-- Quick Create Task Button --}}
        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary d-none d-sm-inline-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-plus-lg"></i>
            <span>New Task</span>
        </a>

        {{-- Dark Mode Toggle Button --}}
        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-inline-flex align-items-center gap-2" id="themeToggleBtn" type="button" title="Toggle theme">
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
            <span class="d-none d-md-inline small">Theme</span>
        </button>

        {{-- User Dropdown --}}
        <div class="dropdown">
            <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 26px; height: 26px; font-size: 0.75rem;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="d-none d-md-inline fw-semibold small">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold small">{{ auth()->user()->name }}</div>
                    <div class="text-muted small text-truncate" style="max-width: 180px;">{{ auth()->user()->email }}</div>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 text-primary"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('tasks.index') }}">
                        <i class="bi bi-list-task text-primary"></i>
                        <span>All Tasks</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

