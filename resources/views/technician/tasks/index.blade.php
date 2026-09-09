@extends('layouts.app')
@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Tugas Perbaikan (Work Orders)</h2>
<div class="space-y-4">
    @forelse($tasks as $task)
    @php $urgency = optional($task->complaint)->urgency; @endphp
    <div class="bg-white rounded-lg shadow p-5 border-l-4 {{ $urgency == 'high' ? 'border-red-500' : ($urgency == 'medium' ? 'border-yellow-500' : 'border-green-500') }}">
        <div class="flex justify-between items-start">
            <div>
                <span class="font-bold text-gray-800">WO-{{ $task->id }}</span>
                <span class="ml-2 text-xs font-bold uppercase text-{{ $urgency=='high'?'red':($urgency=='medium'?'yellow':'green') }}-700 bg-{{ $urgency=='high'?'red':($urgency=='medium'?'yellow':'green') }}-100 px-2 py-0.5 rounded">{{ $urgency }}</span>
                <h3 class="text-lg font-semibold mt-1">{{ optional($task->complaint)->title }}</h3>
                <p class="text-sm text-gray-500">Unit: {{ optional(optional($task->complaint)->propertyUnit)->unit_number }} &bull; {{ optional(optional($task->complaint)->tenant)->name }}</p>
            </div>
            <x-status-badge :status="$task->status" />
        </div>
        <p class="text-gray-600 text-sm mt-2">{{ Str::limit(optional($task->complaint)->description, 120) }}</p>
        <div class="mt-3 flex gap-3">
            <a href="{{ route('technician.tasks.show', $task->id) }}" class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-700">Detail & Update</a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded shadow p-10 text-center text-gray-400">Tidak ada tugas yang ditetapkan saat ini.</div>
    @endforelse
</div>
@endsection
