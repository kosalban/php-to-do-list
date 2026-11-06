<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = $this->route('task');
        return auth()->check() && $task && $this->user()->id === $task->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'priority' => ['required', Rule::in(Task::PRIORITIES)],
            'status' => ['required', Rule::in(Task::STATUSES)],
            'due_date' => ['nullable', 'date'],
        ];
    }

    /**
     * Custom error messages for attributes.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A task title is required.',
            'title.max' => 'The task title cannot exceed 255 characters.',
            'priority.in' => 'Selected priority is invalid.',
            'status.in' => 'Selected status is invalid.',
            'due_date.date' => 'Please provide a valid date format (YYYY-MM-DD).',
        ];
    }
}

