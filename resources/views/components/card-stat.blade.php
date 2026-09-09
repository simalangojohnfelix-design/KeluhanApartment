@props(['title', 'value', 'icon' => ''])
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="flex-1">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">{{ $title }}</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $value }}</p>
        </div>
        @if($icon)
        <div class="text-gray-400 text-3xl">
            {{ $icon }}
        </div>
        @endif
    </div>
</div>
