@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-200 pb-6" data-aos="fade-down">
    <div>
        <h2 class="font-playfair text-3xl font-bold text-gray-900">Work Orders</h2>
        <p class="text-gray-500 mt-2 font-light">Assigned maintenance tasks</p>
    </div>
</div>

<div class="space-y-6">
    @forelse($tasks as $index => $task)
    @php $urgency = optional($task->complaint)->urgency; @endphp
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-8 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
        <div class="absolute top-0 left-0 w-full h-1 {{ $urgency == 'high' ? 'bg-red-500' : ($urgency == 'medium' ? 'bg-amber-500' : 'bg-gray-900') }}"></div>
        
        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4 gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="font-playfair font-bold text-gray-400">WO-{{ $task->id }}</span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span class="text-[10px] font-semibold tracking-widest uppercase {{ $urgency=='high' ? 'text-red-500' : ($urgency=='medium' ? 'text-amber-500' : 'text-gray-500') }}">{{ $urgency }} Priority</span>
                </div>
                <h3 class="font-playfair text-2xl font-semibold text-gray-900">{{ optional($task->complaint)->title }}</h3>
                <p class="text-sm text-gray-500 mt-1 font-light">Unit <strong class="text-gray-900">{{ optional(optional($task->complaint)->propertyUnit)->unit_number }}</strong> &mdash; {{ optional(optional($task->complaint)->tenant)->name }}</p>
            </div>
            <x-status-badge :status="$task->status" />
        </div>
        
        <p class="text-gray-500 text-sm font-light leading-relaxed mb-6">{{ Str::limit(optional($task->complaint)->description, 120) }}</p>
        
        <div class="pt-4 border-t border-gray-50">
            <a href="{{ route('technician.tasks.show', $task->id) }}" class="text-sm font-medium text-gray-900 border-b border-gray-900 pb-0.5 hover:text-gray-500 hover:border-gray-500 transition">View & Update Details</a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center" data-aos="fade-up">
        <p class="text-gray-400 font-light">No tasks are currently assigned to you.</p>
    </div>
    @endforelse
</div>
@endsection