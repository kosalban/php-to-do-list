@extends('layouts.app')

@section('title', 'Dashboard')
@section('header_title', 'Todo Dashboard')

@section('content')
<div class="container-fluid p-0">
    {{-- Header Banner / Welcome --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="h4 fw-bold mb-1">Welcome back, {{ auth()->user()->name }} 👋</h2>
            <p class="text-muted mb-0 small">Here is a snapshot of your tasks, progress, and upcoming deadlines.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Create New Task</span>
            </a>
        </div>
    </div>

    {{-- Statistics Cards (5 Cards) --}}
    <div class="row g-3 mb-4">
        {{-- Total Tasks --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card stat-card border-0 bg-primary bg-opacity-10 text-primary h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <div class="text-uppercase fw-semibold small text-primary-emphasis">Total Tasks</div>
                        <div class="fs-3 fw-bold my-1 text-primary">{{ $stats['total'] }}</div>
                        <a href="{{ route('tasks.index') }}" class="text-decoration-none small text-primary d-inline-flex align-items-center gap-1">
                            <span>View all</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="stat-icon bg-primary text-white shadow-sm">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Tasks --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card stat-card border-0 bg-warning bg-opacity-10 text-warning-emphasis h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <div class="text-uppercase fw-semibold small text-warning-emphasis">Pending</div>
                        <div class="fs-3 fw-bold my-1 text-warning-emphasis">{{ $stats['pending'] }}</div>
                        <a href="{{ route('dashboard', ['status' => 'pending']) }}" class="text-decoration-none small text-warning-emphasis d-inline-flex align-items-center gap-1">
                            <span>Filter pending</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="stat-icon bg-warning text-dark shadow-sm">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- In Progress Tasks --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card stat-card border-0 bg-info bg-opacity-10 text-info-emphasis h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <div class="text-uppercase fw-semibold small text-info-emphasis">In Progress</div>
                        <div class="fs-3 fw-bold my-1 text-info-emphasis">{{ $stats['in_progress'] }}</div>
                        <a href="{{ route('dashboard', ['status' => 'in_progress']) }}" class="text-decoration-none small text-info-emphasis d-inline-flex align-items-center gap-1">
                            <span>Filter active</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="stat-icon bg-info text-dark shadow-sm">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed Tasks --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card stat-card border-0 bg-success bg-opacity-10 text-success-emphasis h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <div class="text-uppercase fw-semibold small text-success-emphasis">Completed</div>
                        <div class="fs-3 fw-bold my-1 text-success">{{ $stats['completed'] }}</div>
                        <a href="{{ route('dashboard', ['status' => 'completed']) }}" class="text-decoration-none small text-success d-inline-flex align-items-center gap-1">
                            <span>Filter done</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="stat-icon bg-success text-white shadow-sm">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Overdue Tasks --}}
        <div class="col-12 col-sm-6 col-xl">
            <div class="card stat-card border-0 bg-danger bg-opacity-10 text-danger-emphasis h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <div class="text-uppercase fw-semibold small text-danger-emphasis">Overdue</div>
                        <div class="fs-3 fw-bold my-1 text-danger">{{ $stats['overdue'] }}</div>
                        <a href="{{ route('dashboard', ['overdue' => '1']) }}" class="text-decoration-none small text-danger d-inline-flex align-items-center gap-1">
                            <span>Filter overdue</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="stat-icon bg-danger text-white shadow-sm">
                        <i class="bi bi-calendar-x-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters Card --}}
    <div class="card border-0 mb-4 shadow-sm">
        <div class="card-body p-3">
            <form action="{{ route('dashboard') }}" method="GET" class="row g-2 align-items-center">
                {{-- Search by Title / Keyword --}}
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-body border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search tasks by title..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Filter by Status --}}
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                {{-- Filter by Priority --}}
                <div class="col-6 col-md-2">
                    <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High Priority</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium Priority</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low Priority</option>
                    </select>
                </div>

                {{-- Sort By Field --}}
                <div class="col-6 col-md-2">
                    <select name="sort_by" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="created_at" {{ ($sortBy ?? '') === 'created_at' ? 'selected' : '' }}>Sort: Created Date</option>
                        <option value="due_date" {{ ($sortBy ?? '') === 'due_date' ? 'selected' : '' }}>Sort: Due Date</option>
                        <option value="priority" {{ ($sortBy ?? '') === 'priority' ? 'selected' : '' }}>Sort: Priority</option>
                        <option value="title" {{ ($sortBy ?? '') === 'title' ? 'selected' : '' }}>Sort: Title</option>
                    </select>
                </div>

                {{-- Sort Direction --}}
                <div class="col-4 col-md-1">
                    <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="desc" {{ ($sortDir ?? '') === 'desc' ? 'selected' : '' }}>Desc</option>
                        <option value="asc" {{ ($sortDir ?? '') === 'asc' ? 'selected' : '' }}>Asc</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="col-2 col-md-1 text-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary w-100" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Task Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-list-task text-primary fs-5"></i>
                <span class="fw-bold">Tasks List</span>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill">{{ $tasks->total() }}</span>
            </div>
            @if(request()->anyFilled(['search', 'status', 'priority', 'overdue']))
                <div class="small text-muted">
                    <span>Filtering active</span> &bull; <a href="{{ route('dashboard') }}" class="text-decoration-none">Clear</a>
                </div>
            @endif
        </div>

        <div class="card-body p-0">
            @if($tasks->isEmpty())
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="bi bi-clipboard2-check display-4 opacity-50"></i>
                    </div>
                    <h5 class="fw-semibold">No tasks found</h5>
                    <p class="text-muted small mb-3">
                        @if(request()->anyFilled(['search', 'status', 'priority', 'overdue']))
                            No tasks match your current filter criteria. Try adjusting or clearing filters.
                        @else
                            You haven't created any tasks yet. Get started by creating your first task!
                        @endif
                    </p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Create First Task
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 48px;" class="text-center">Status</th>
                                <th>Task Title</th>
                                <th style="width: 130px;">Priority</th>
                                <th style="width: 140px;">Due Date</th>
                                <th style="width: 130px;">Created</th>
                                <th style="width: 140px;" class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    {{-- Quick Status Toggle Button --}}
                                    <td class="text-center">
                                        <form action="{{ route('tasks.toggle-status', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm p-0 border-0 text-decoration-none" title="{{ $task->status === 'completed' ? 'Mark as Pending' : 'Mark as Completed' }}">
                                                @if($task->status === 'completed')
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @elseif($task->status === 'in_progress')
                                                    <i class="bi bi-arrow-repeat text-info fs-5"></i>
                                                @else
                                                    <i class="bi bi-circle text-muted fs-5"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Title & Snippet --}}
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-decoration-none text-body {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                                {{ $task->title }}
                                            </a>
                                            @if($task->description)
                                                <small class="text-muted text-truncate" style="max-width: 380px;">
                                                    {{ Str::limit($task->description, 60) }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Priority Badge --}}
                                    <td>
                                        <x-task-priority-badge :priority="$task->priority" />
                                    </td>

                                    {{-- Due Date & Overdue Indicator --}}
                                    <td>
                                        @if($task->due_date)
                                            <div class="d-flex align-items-center gap-1 {{ $task->is_overdue ? 'text-danger fw-semibold' : 'text-body-secondary' }}" style="font-size: 0.875rem;">
                                                <i class="bi {{ $task->is_overdue ? 'bi-exclamation-circle-fill' : 'bi-calendar3' }}"></i>
                                                <span>{{ $task->due_date->format('M d, Y') }}</span>
                                            </div>
                                            @if($task->is_overdue)
                                                <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Overdue</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    {{-- Created At --}}
                                    <td class="small text-muted">
                                        {{ $task->created_at->diffForHumans() }}
                                    </td>

                                    {{-- Actions (View, Edit, Delete Modal) --}}
                                    <td class="text-end pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary" title="Edit Task">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Delete Task" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" data-action-url="{{ route('tasks.destroy', $task) }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted">
                        Showing {{ $tasks->firstItem() ?? 0 }} to {{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
                    </div>
                    <div>
                        {{ $tasks->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

