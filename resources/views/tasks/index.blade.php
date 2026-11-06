@extends('layouts.app')

@section('title', 'All Tasks')
@section('header_title', 'All Tasks')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="h4 fw-bold mb-1">Task Management</h2>
            <p class="text-muted mb-0 small">Organize, filter, and track all your tasks in one unified view.</p>
        </div>
        <div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Create Task</span>
            </a>
        </div>
    </div>

    {{-- Filter and Search Card --}}
    <div class="card border-0 mb-4 shadow-sm">
        <div class="card-body p-3">
            <form action="{{ route('tasks.index') }}" method="GET" class="row g-2 align-items-center">
                {{-- Search Input --}}
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-body border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search tasks by title or description..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Status: All</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                {{-- Priority Filter --}}
                <div class="col-6 col-md-2">
                    <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Priority: All</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High Priority</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium Priority</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low Priority</option>
                    </select>
                </div>

                {{-- Sort By Field --}}
                <div class="col-6 col-md-2">
                    <select name="sort_by" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="created_at" {{ ($sortBy ?? '') === 'created_at' ? 'selected' : '' }}>Sort: Created</option>
                        <option value="due_date" {{ ($sortBy ?? '') === 'due_date' ? 'selected' : '' }}>Sort: Due Date</option>
                        <option value="priority" {{ ($sortBy ?? '') === 'priority' ? 'selected' : '' }}>Sort: Priority</option>
                        <option value="title" {{ ($sortBy ?? '') === 'title' ? 'selected' : '' }}>Sort: Title</option>
                    </select>
                </div>

                {{-- Sort Order --}}
                <div class="col-4 col-md-1">
                    <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="desc" {{ ($sortDir ?? '') === 'desc' ? 'selected' : '' }}>Desc</option>
                        <option value="asc" {{ ($sortDir ?? '') === 'asc' ? 'selected' : '' }}>Asc</option>
                    </select>
                </div>

                {{-- Reset Filter Button --}}
                <div class="col-2 col-md-1 text-end">
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary w-100" title="Clear Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tasks Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check2-all text-primary fs-5"></i>
                <span class="fw-bold">Tasks</span>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill">{{ $tasks->total() }}</span>
            </div>
            @if(request()->anyFilled(['search', 'status', 'priority', 'overdue']))
                <a href="{{ route('tasks.index') }}" class="small text-decoration-none">
                    <i class="bi bi-x-circle me-1"></i>Clear all filters
                </a>
            @endif
        </div>

        <div class="card-body p-0">
            @if($tasks->isEmpty())
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="bi bi-journal-x display-4 opacity-50"></i>
                    </div>
                    <h5 class="fw-semibold">No tasks available</h5>
                    <p class="text-muted small mb-3">No tasks match your criteria or none have been created yet.</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Add New Task
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 48px;" class="text-center">Status</th>
                                <th>Task Details</th>
                                <th style="width: 130px;">Priority</th>
                                <th style="width: 140px;">Status Badge</th>
                                <th style="width: 140px;">Due Date</th>
                                <th style="width: 140px;" class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    {{-- Status Quick Toggle --}}
                                    <td class="text-center">
                                        <form action="{{ route('tasks.toggle-status', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm p-0 border-0" title="Toggle status">
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

                                    {{-- Title & Details --}}
                                    <td>
                                        <a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-decoration-none text-body {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                                            {{ $task->title }}
                                        </a>
                                        @if($task->description)
                                            <div class="small text-muted text-truncate" style="max-width: 400px;">
                                                {{ Str::limit($task->description, 70) }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Priority Badge --}}
                                    <td>
                                        <x-task-priority-badge :priority="$task->priority" />
                                    </td>

                                    {{-- Status Badge --}}
                                    <td>
                                        <x-task-status-badge :status="$task->status" />
                                    </td>

                                    {{-- Due Date --}}
                                    <td>
                                        @if($task->due_date)
                                            <div class="small d-flex align-items-center gap-1 {{ $task->is_overdue ? 'text-danger fw-semibold' : 'text-muted' }}">
                                                <i class="bi {{ $task->is_overdue ? 'bi-exclamation-triangle-fill' : 'bi-calendar' }}"></i>
                                                <span>{{ $task->due_date->format('M d, Y') }}</span>
                                            </div>
                                            @if($task->is_overdue)
                                                <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Overdue</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-end pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" data-action-url="{{ route('tasks.destroy', $task) }}">
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

