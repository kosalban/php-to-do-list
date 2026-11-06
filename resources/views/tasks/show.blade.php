@extends('layouts.app')

@section('title', $task->title)
@section('header_title', 'Task Details')

@section('content')
<div class="container-fluid p-0" style="max-width: 800px;">
    {{-- Breadcrumb Navigation --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Tasks</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($task->title, 25) }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mb-4">
        {{-- Card Header with Badges --}}
        <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <x-task-status-badge :status="$task->status" />
                <x-task-priority-badge :priority="$task->priority" />
            </div>
            <div class="small text-muted">
                Created {{ $task->created_at->format('M d, Y') }} ({{ $task->created_at->diffForHumans() }})
            </div>
        </div>

        <div class="card-body p-4">
            {{-- Title --}}
            <h1 class="h3 fw-bold mb-3 {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->title }}
            </h1>

            {{-- Description Section --}}
            <div class="mb-4">
                <h6 class="text-uppercase fw-semibold text-muted small">Description</h6>
                @if($task->description)
                    <div class="p-3 bg-body-tertiary rounded-3 border text-body" style="white-space: pre-wrap; font-size: 0.95rem;">{{ $task->description }}</div>
                @else
                    <p class="text-muted fst-italic small">No description provided for this task.</p>
                @endif
            </div>

            {{-- Metadata Row --}}
            <div class="row g-3 p-3 bg-body-tertiary rounded-3 border mb-4">
                <div class="col-6 col-md-4">
                    <span class="text-muted small d-block">Due Date:</span>
                    @if($task->due_date)
                        <span class="fw-semibold {{ $task->is_overdue ? 'text-danger' : '' }}">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $task->due_date->format('M d, Y') }}
                        </span>
                        @if($task->is_overdue)
                            <div class="badge bg-danger-subtle text-danger small mt-1">Overdue</div>
                        @endif
                    @else
                        <span class="text-muted small">No deadline set</span>
                    @endif
                </div>

                <div class="col-6 col-md-4">
                    <span class="text-muted small d-block">Last Updated:</span>
                    <span class="fw-semibold text-body">
                        <i class="bi bi-clock-history me-1"></i>
                        {{ $task->updated_at->diffForHumans() }}
                    </span>
                </div>

                <div class="col-12 col-md-4">
                    <span class="text-muted small d-block">Assigned Owner:</span>
                    <span class="fw-semibold text-body">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ $task->user->name }}
                    </span>
                </div>
            </div>

            {{-- Action Controls --}}
            <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-3 pt-3 border-top">
                {{-- Quick Status Toggle Button --}}
                <form action="{{ route('tasks.toggle-status', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @if($task->status === 'completed')
                        <button type="submit" class="btn btn-outline-warning w-100 d-inline-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span>Mark as Pending</span>
                        </button>
                    @else
                        <button type="submit" class="btn btn-outline-success w-100 d-inline-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Mark as Completed</span>
                        </button>
                    @endif
                </form>

                {{-- Edit & Delete Controls --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-pencil"></i>
                        <span>Edit Task</span>
                    </a>
                    <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-task-id="{{ $task->id }}" data-task-title="{{ $task->title }}" data-action-url="{{ route('tasks.destroy', $task) }}">
                        <i class="bi bi-trash"></i>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

