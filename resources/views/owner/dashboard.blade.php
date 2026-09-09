@extends('layouts.app')

@section('content')
<div class="mb-10" data-aos="fade-right">
    <h1 class="font-playfair text-4xl font-bold text-gray-900">Executive Dashboard</h1>
    <p class="text-gray-500 mt-2 font-light">Property operational performance summary</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-6" data-aos="fade-up" data-aos-delay="100">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Cost This Month</p>
        <p class="font-playfair text-2xl font-bold text-gray-900">Rp {{ number_format($totalCostMonth, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-6" data-aos="fade-up" data-aos-delay="200">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Cost This Year</p>
        <p class="font-playfair text-2xl font-bold text-gray-900">Rp {{ number_format($totalCostYear, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-6" data-aos="fade-up" data-aos-delay="300">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Asset Health</p>
        <p class="font-playfair text-2xl font-bold text-green-700">{{ $assetHealthPct }}%</p>
    </div>
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-6" data-aos="fade-up" data-aos-delay="400">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Resolved Requests</p>
        <p class="font-playfair text-2xl font-bold text-gray-900">{{ $resolvedComplaints }} <span class="text-sm font-light text-gray-400">/ {{ $totalComplaints }}</span></p>
    </div>
</div>

@if($pendingApprovals > 0)
<div class="bg-gray-900 text-white rounded-2xl shadow-lg p-8 mb-10 flex flex-col md:flex-row md:items-center justify-between" data-aos="zoom-in">
    <div>
        <h3 class="font-playfair text-2xl font-bold mb-2">Pending Approvals</h3>
        <p class="text-gray-300 font-light text-sm">{{ $pendingApprovals }} cost submissions require your executive review.</p>
    </div>
    <a href="{{ route('owner.approvals.index') }}" class="mt-4 md:mt-0 bg-white text-gray-900 px-6 py-3 rounded-full text-sm font-medium hover:bg-gray-100 transition shadow-sm inline-block">Review Now</a>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-8" data-aos="fade-up">
        <h3 class="font-playfair text-xl font-bold text-gray-900 mb-6">Request Volume by Category</h3>
        @forelse($complaintsByCategory as $item)
        @php $pct = $totalComplaints > 0 ? round(($item->total / $totalComplaints) * 100) : 0; @endphp
        <div class="mb-5">
            <div class="flex justify-between text-sm mb-2">
                <span class="font-medium text-gray-700">{{ $item->category ?? 'Uncategorized' }}</span>
                <span class="text-gray-500">{{ $item->total }}</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-gray-900 h-1.5 rounded-full transition-all duration-1000" style="width: 0%" data-width="{{ $pct }}%"></div>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm font-light">No request data available.</p>
        @endforelse
        <script>
            setTimeout(() => {
                document.querySelectorAll('[data-width]').forEach(el => {
                    el.style.width = el.getAttribute('data-width');
                });
            }, 500);
        </script>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-8 flex flex-col justify-center space-y-4" data-aos="fade-up" data-aos-delay="100">
        <h3 class="font-playfair text-xl font-bold text-gray-900 mb-4">Quick Navigation</h3>
        <a href="{{ route('owner.approvals.index') }}" class="group flex items-center justify-between bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl p-5 transition-all">
            <span class="font-medium text-gray-900 group-hover:pl-2 transition-all duration-300">Repair Approvals</span>
            @if($pendingApprovals > 0)
                <span class="bg-gray-900 text-white px-3 py-1 rounded-full text-xs font-medium">{{ $pendingApprovals }} pending</span>
            @else
                <span class="text-gray-400 text-sm">&rarr;</span>
            @endif
        </a>
        <a href="{{ route('owner.cost-log.index') }}" class="group flex items-center justify-between bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl p-5 transition-all">
            <span class="font-medium text-gray-900 group-hover:pl-2 transition-all duration-300">Cost History Log</span>
            <span class="text-gray-400 text-sm">&rarr;</span>
        </a>
    </div>
</div>
@endsection