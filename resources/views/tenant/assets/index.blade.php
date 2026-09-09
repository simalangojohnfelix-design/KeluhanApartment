@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-200 pb-6" data-aos="fade-down">
    <div>
        <a href="{{ route('tenant.dashboard') }}" class="text-xs font-medium text-gray-400 uppercase tracking-wider hover:text-gray-900 transition mb-2 inline-block">&larr; Back to Dashboard</a>
        <h2 class="font-playfair text-3xl font-bold text-gray-900 mt-1">Residence Inventory</h2>
    </div>
    @if($unit)
    <p class="text-sm text-gray-500 mt-3 md:mt-0 font-light">Unit <strong class="text-gray-900">{{ $unit->unit_number }}</strong></p>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($assets as $index => $asset)
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 p-6 flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
        <div class="mb-auto">
            <span class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2 block">{{ $asset->category ?: 'General' }}</span>
            <h3 class="font-playfair font-semibold text-lg text-gray-900 leading-snug">{{ $asset->name }}</h3>
        </div>
        <div class="mt-6 pt-4 border-t border-gray-50">
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500">Condition</span>
                <span class="text-xs font-medium {{ $asset->condition == 'Good' ? 'text-green-600' : 'text-amber-600' }}">{{ $asset->condition }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center" data-aos="fade-up">
        <p class="text-gray-400 font-light">No assets have been inventoried for this residence yet.</p>
    </div>
    @endforelse
</div>
@endsection