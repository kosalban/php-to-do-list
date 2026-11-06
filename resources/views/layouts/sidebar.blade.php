<aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-check2-square fs-5"></i>
            </div>
            <div>
                <span class="fs-5 fw-bold text-body">Todo<span class="text-primary">App</span></span>
                <span class="badge bg-primary-subtle text-primary ms-1" style="font-size: 0.65rem;">v1.0</span>
            </div>
        </a>
    </div>

    <div class="sidebar-nav">
        <div class="nav-heading">Main Menu</div>
        <ul class="nav flex-column mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tasks.index') && !request()->has('status') && !request()->has('overdue') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                    <i class="bi bi-list-check"></i>
                    <span>All Tasks</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" href="{{ route('tasks.create') }}">
                    <i class="bi bi-plus-circle-fill text-success"></i>
                    <span>New Task</span>
                </a>
            </li>
        </ul>

        <div class="nav-heading">Filters</div>
        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->query('status') === 'pending' ? 'active' : '' }}" href="{{ route('tasks.index', ['status' => 'pending']) }}">
                    <i class="bi bi-hourglass-split text-warning"></i>
                    <span>Pending Tasks</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->query('status') === 'in_progress' ? 'active' : '' }}" href="{{ route('tasks.index', ['status' => 'in_progress']) }}">
                    <i class="bi bi-arrow-repeat text-info"></i>
                    <span>In Progress</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->query('status') === 'completed' ? 'active' : '' }}" href="{{ route('tasks.index', ['status' => 'completed']) }}">
                    <i class="bi bi-check2-circle text-success"></i>
                    <span>Completed</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->query('overdue') === '1' ? 'active' : '' }}" href="{{ route('tasks.index', ['overdue' => '1']) }}">
                    <i class="bi bi-calendar-x text-danger"></i>
                    <span>Overdue Tasks</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Bottom user info & logout --}}
    <div class="p-3 border-top border-light-subtle">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 overflow-hidden">
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; flex-shrink: 0;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="fw-semibold text-truncate small text-body">{{ auth()->user()->name }}</div>
                    <div class="text-muted text-truncate" style="font-size: 0.75rem;">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger p-1 rounded-circle" title="Log Out" style="width: 30px; height: 30px;">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

