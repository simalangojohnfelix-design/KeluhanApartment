@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b border-gray-200 pb-6" data-aos="fade-down">
    <div>
        <a href="{{ route('tenant.dashboard') }}" class="text-xs font-medium text-gray-400 uppercase tracking-wider hover:text-gray-900 transition mb-2 inline-block">&larr; Back to Dashboard</a>
        <h2 class="font-playfair text-3xl font-bold text-gray-900 mt-1">Maintenance Requests</h2>
    </div>
    <a href="{{ route('tenant.complaints.create') }}" class="mt-4 md:mt-0 bg-gray-900 text-white px-6 py-2.5 rounded-full text-sm font-medium hover:bg-black transition shadow-sm inline-flex items-center">
        + New Request
    </a>
</div>

@if(session('success'))
<div class="bg-gray-900 text-white p-4 rounded-xl mb-8 text-sm font-light text-center" data-aos="fade-in">{{ session('success') }}</div>
@endif

<div class="space-y-4">
    @forelse($complaints as $index => $c)
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-6 flex flex-col md:flex-row md:items-center justify-between group hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-[10px] font-semibold tracking-widest uppercase text-gray-400">{{ $c->category }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span class="text-[10px] font-semibold tracking-widest uppercase {{ $c->urgency == 'high' ? 'text-red-500' : ($c->urgency == 'medium' ? 'text-amber-500' : 'text-gray-500') }}">{{ $c->urgency }} Priority</span>
            </div>
            <h3 class="font-playfair text-xl font-semibold text-gray-900 mb-1">{{ $c->title }}</h3>
            <p class="text-gray-500 text-sm font-light line-clamp-1">{{ Str::limit($c->description, 100) }}</p>
        </div>
        
        <div class="mt-4 md:mt-0 md:ml-8 flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-4">
            <x-status-badge :status="$c->status" />
            <a href="{{ route('tenant.complaints.show', $c->id) }}" class="text-sm font-medium text-gray-900 border-b border-gray-900 pb-0.5 hover:text-gray-500 hover:border-gray-500 transition">View Details</a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center" data-aos="fade-up">
        <p class="text-gray-400 font-light">You have no maintenance requests history.</p>
    </div>
    @endforelse
</div>
@endsection