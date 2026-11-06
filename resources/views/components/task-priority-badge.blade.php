@props(['priority'])

@php
    $config = match($priority) {
        'high' => ['class' => 'badge-priority-high', 'icon' => 'bi-exclamation-triangle-fill', 'label' => 'High'],
        'medium' => ['class' => 'badge-priority-medium', 'icon' => 'bi-dash-circle-fill', 'label' => 'Medium'],
        'low' => ['class' => 'badge-priority-low', 'icon' => 'bi-arrow-down-circle-fill', 'label' => 'Low'],
        default => ['class' => 'badge-priority-low', 'icon' => 'bi-circle', 'label' => ucfirst($priority ?? 'Normal')],
    };
@endphp

<span class="badge {{ $config['class'] }} d-inline-flex align-items-center gap-1 px-2 py-1">
    <i class="bi {{ $config['icon'] }}"></i>
    <span>{{ $config['label'] }}</span>
</span>

