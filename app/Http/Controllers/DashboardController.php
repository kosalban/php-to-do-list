<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with stats, filters, and paginated tasks.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // 1. Calculate summary statistics for the user
        $stats = [
            'total' => $user->tasks()->count(),
            'pending' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress' => $user->tasks()->where('status', 'in_progress')->count(),
            'completed' => $user->tasks()->where('status', 'completed')->count(),
            'overdue' => $user->tasks()->overdue()->count(),
        ];

        // 2. Query filtered and sorted tasks
        $sortBy = in_array($request->query('sort_by'), ['created_at', 'due_date', 'title', 'priority'], true)
            ? $request->query('sort_by')
            : 'created_at';

        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $tasks = $user->tasks()
            ->search($request->query('search'))
            ->filterStatus($request->query('status'))
            ->filterPriority($request->query('priority'))
            ->when($request->query('overdue') === '1', function ($query) {
                $query->overdue();
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.index', compact('stats', 'tasks', 'sortBy', 'sortDir'));
    }
}

