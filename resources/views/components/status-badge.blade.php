@props(['status'])
@php
    $color = match($status) {
        'pending' => 'bg-yellow-100 text-yellow-800',
        'in_progress', 'working' => 'bg-blue-100 text-blue-800',
        'resolved', 'completed', 'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800'
    };
@endphp
<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
    {{ ucfirst($status) }}
</span>
