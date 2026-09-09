@extends('layouts.app')

@section('content')
<div class="mb-10" data-aos="fade-right">
    <h1 class="font-playfair text-4xl font-bold text-gray-900">Management Overview</h1>
    <p class="text-gray-500 mt-2 font-light">Daily operational summary for Palazzo Palace</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-8" data-aos="fade-up" data-aos-delay="100">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Monthly Requests</p>
        <p class="font-playfair text-4xl font-bold text-gray-900">{{ $totalComplaints }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-8" data-aos="fade-up" data-aos-delay="200">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Pending Actions</p>
        <p class="font-playfair text-4xl font-bold text-amber-600">{{ $pendingComplaints }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 p-8" data-aos="fade-up" data-aos-delay="300">
        <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Total Repair Cost</p>
        <p class="font-playfair text-3xl font-bold text-gray-900">Rp {{ number_format($totalRepairCost, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-10">
    <div class="bg-gray-900 rounded-2xl shadow-lg p-8 text-white flex flex-col md:flex-row md:items-center justify-between" data-aos="fade-up">
        <div>
            <p class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2">Registered Assets</p>
            <p class="font-playfair text-4xl font-bold mt-1">{{ $totalAssets }}</p>
        </div>
        <div class="mt-4 md:mt-0 text-left md:text-right">
            @if($badAssets > 0)
                <p class="text-sm text-red-400 font-light">⚠️ {{ $badAssets }} assets require attention</p>
            @else
                <p class="text-sm text-gray-300 font-light">✨ All assets in pristine condition</p>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <a href="{{ route('admin.complaints.index') }}" class="group block bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
        <span class="block text-2xl mb-3 group-hover:scale-110 transition-transform">📋</span>
        <span class="font-medium text-gray-900 text-sm">Requests</span>
    </a>
    <a href="{{ route('admin.units.index') }}" class="group block bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
        <span class="block text-2xl mb-3 group-hover:scale-110 transition-transform">🚪</span>
        <span class="font-medium text-gray-900 text-sm">Units</span>
    </a>
    <a href="{{ route('admin.assets.index') }}" class="group block bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
        <span class="block text-2xl mb-3 group-hover:scale-110 transition-transform">🛋️</span>
        <span class="font-medium text-gray-900 text-sm">Assets</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="group block bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
        <span class="block text-2xl mb-3 group-hover:scale-110 transition-transform">👥</span>
        <span class="font-medium text-gray-900 text-sm">Users</span>
    </a>
</div>
@endsection