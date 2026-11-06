<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * Allowed priority options.
     */
    public const PRIORITIES = ['low', 'medium', 'high'];

    /**
     * Allowed status options.
     */
    public const STATUSES = ['pending', 'in_progress', 'completed'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relationship: A task belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the task is currently overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'completed' || is_null($this->due_date)) {
            return false;
        }

        return $this->due_date->isPast() && !$this->due_date->isToday();
    }

    /**
     * Get a human-readable priority label.
     */
    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            default => ucfirst($this->priority),
        };
    }

    /**
     * Get CSS badge class for priority.
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'bg-secondary',
            'medium' => 'bg-info text-dark',
            'high' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Get a human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    /**
     * Get CSS badge class for status.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'in_progress' => 'bg-primary',
            'completed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Scope: Search task by title or description.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (filled($term)) {
            $query->where(function (Builder $q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        return $query;
    }

    /**
     * Scope: Filter tasks by status.
     */
    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        if (filled($status) && in_array($status, self::STATUSES, true)) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Scope: Filter tasks by priority.
     */
    public function scopeFilterPriority(Builder $query, ?string $priority): Builder
    {
        if (filled($priority) && in_array($priority, self::PRIORITIES, true)) {
            $query->where('priority', $priority);
        }

        return $query;
    }

    /**
     * Scope: Filter tasks that are overdue.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', '!=', 'completed')
                     ->whereNotNull('due_date')
                     ->whereDate('due_date', '<', Carbon::today());
    }
}

