@extends('layouts.app')

@section('title', 'Create New Task')
@section('header_title', 'Create Task')

@section('content')
<div class="container-fluid p-0" style="max-width: 800px;">
    {{-- Breadcrumb Navigation --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill text-primary fs-5"></i>
                <h2 class="h5 mb-0 fw-bold">New Task Details</h2>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                {{-- Task Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="e.g., Set up MySQL database backups"
                           value="{{ old('title') }}"
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
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Add details, notes, or subtasks...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text small">Provide any relevant context or links for this task.</div>
                </div>

                <div class="row g-3 mb-4">
                    {{-- Priority --}}
                    <div class="col-12 col-md-4">
                        <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                        <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low Priority</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium Priority</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High Priority</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-12 col-md-4">
                        <label for="status" class="form-label fw-semibold">Initial Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
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
                               value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
                        <i class="bi bi-check-lg"></i>
                        <span>Create Task</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

