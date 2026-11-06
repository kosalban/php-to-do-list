@extends('layouts.app')

@section('title', 'Edit Task: ' . $task->title)
@section('header_title', 'Edit Task')

@section('content')
<div class="container-fluid p-0" style="max-width: 800px;">
    {{-- Breadcrumb Navigation --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">{{ Str::limit($task->title, 25) }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-primary fs-5"></i>
                <h2 class="h5 mb-0 fw-bold">Edit Task</h2>
            </div>
            <div class="d-flex gap-2">
                <x-task-status-badge :status="$task->status" />
                <x-task-priority-badge :priority="$task->priority" />
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Task Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $task->title) }}"
                           required
                           autofocus>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Task Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description <span class="text-muted fw-normal">(Optional)</span></label>
                    <textarea name="description"
                              id="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-4">
                    {{-- Priority --}}
                    <div class="col-12 col-md-4">
                        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                        <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                            <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Low Priority</option>
                            <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium Priority</option>
                            <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>High Priority</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-12 col-md-4">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="col-12 col-md-4">
                        <label for="due_date" class="form-label fw-semibold">Due Date <span class="text-muted fw-normal">(Optional)</span></label>
                        <input type="date"
                               name="due_date"
                               id="due_date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" data-action-url="{{ route('tasks.destroy', $task) }}">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
                            <i class="bi bi-save"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

