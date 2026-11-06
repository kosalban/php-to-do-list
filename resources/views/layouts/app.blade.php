<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Todo List Application') - Laravel</title>

    {{-- Bootstrap 5.3 CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Bootstrap Icons CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Custom Application CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>
    {{-- Mobile sidebar backdrop --}}
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="app-wrapper">
        {{-- Sidebar Component --}}
        @include('layouts.sidebar')

        {{-- Main Content Area --}}
        <div class="app-main">
            {{-- Top Navbar --}}
            @include('layouts.navbar')

            {{-- Main Page Content --}}
            <main class="p-3 p-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Toast Notifications Container --}}
    @include('components.toast')

    {{-- Universal Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title d-flex align-items-center gap-2 text-danger" id="deleteConfirmModalLabel">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Confirm Task Deletion</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-1 text-body">Are you sure you want to permanently delete this task?</p>
                    <div class="alert alert-secondary py-2 px-3 my-2 text-truncate fw-semibold" id="deleteModalTaskTitle">
                        Task Title
                    </div>
                    <p class="small text-muted mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top bg-body-tertiary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteTaskForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger d-inline-flex align-items-center gap-1">
                            <i class="bi bi-trash-fill"></i>
                            <span>Delete Task</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap 5.3 JS Bundle CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Vanilla JS Application Script --}}
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>

