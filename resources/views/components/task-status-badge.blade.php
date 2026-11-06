@props(['status'])

@php
    $config = match($status) {
        'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'bi-hourglass-split', 'label' => 'Pending'],
        'in_progress' => ['class' => 'bg-info text-dark', 'icon' => 'bi-arrow-repeat', 'label' => 'In Progress'],
        'completed' => ['class' => 'bg-success text-white', 'icon' => 'bi-check2-circle', 'label' => 'Completed'],
        default => ['class' => 'bg-secondary text-white', 'icon' => 'bi-question-circle', 'label' => ucfirst($status ?? 'Unknown')],
    };
@endphp

<span class="badge {{ $config['class'] }} d-inline-flex align-items-center gap-1 px-2 py-1">
    <i class="bi {{ $config['icon'] }}"></i>
    <span>{{ $config['label'] }}</span>
</span>

