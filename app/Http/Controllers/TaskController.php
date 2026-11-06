<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks.
     */
    public function index(Request $request): View
    {
        $sortBy = in_array($request->query('sort_by'), ['created_at', 'due_date', 'title', 'priority'], true)
            ? $request->query('sort_by')
            : 'created_at';

        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $tasks = $request->user()->tasks()
            ->search($request->query('search'))
            ->filterStatus($request->query('status'))
            ->filterPriority($request->query('priority'))
            ->when($request->query('overdue') === '1', function ($query) {
                $query->overdue();
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'sortBy', 'sortDir'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = $request->user()->tasks()->create($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', "Task \"{$task->title}\" was successfully created!");
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task): View
    {
        $this->authorizeOwner($task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        $this->authorizeOwner($task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorizeOwner($task);

        $task->update($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', "Task \"{$task->title}\" was updated successfully!");
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorizeOwner($task);

        $title = $task->title;
        $task->delete();

        return back()->with('success', "Task \"{$title}\" has been deleted.");
    }

    /**
     * Toggle status between completed and pending (or update status directly).
     */
    public function toggleStatus(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeOwner($task);

        if ($request->filled('status') && in_array($request->input('status'), Task::STATUSES, true)) {
            $task->status = $request->input('status');
        } else {
            // Toggle completed <-> pending
            $task->status = ($task->status === 'completed') ? 'pending' : 'completed';
        }

        $task->save();

        $message = $task->status === 'completed'
            ? "Task \"{$task->title}\" marked as completed!"
            : "Task \"{$task->title}\" status updated to {$task->status_label}.";

        return back()->with('success', $message);
    }

    /**
     * Ensure the authenticated user owns this task.
     */
    protected function authorizeOwner(Task $task): void
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action. You can only access your own tasks.');
        }
    }
}

