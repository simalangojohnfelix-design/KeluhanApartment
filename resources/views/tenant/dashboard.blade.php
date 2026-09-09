@extends('layouts.app')

@section('content')
<div class="mb-10" data-aos="fade-right">
    <h1 class="font-playfair text-4xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
    @php $unit = auth()->user()->propertyUnit; @endphp
    @if($unit)
        <p class="text-gray-500 mt-2 font-light">Residence: <strong class="text-gray-800">{{ $unit->unit_number }}</strong> &mdash; Lease valid until {{ $unit->lease_end ? \Carbon\Carbon::parse($unit->lease_end)->format('d F Y') : '-' }}</p>
    @else
        <p class="text-red-500 mt-2 font-light">Your residence has not been assigned.</p>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <a href="{{ route('tenant.assets.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
            <span class="text-xl">🛋️</span>
        </div>
        <h3 class="font-playfair font-semibold text-xl text-gray-900">Residence Assets</h3>
        <p class="text-gray-500 text-sm mt-3 font-light leading-relaxed">View the inventory and condition of facilities provided in your space.</p>
    </a>

    <a href="{{ route('tenant.complaints.create') }}" class="group block bg-gray-900 rounded-2xl shadow-sm p-8 hover:shadow-[0_8px_30px_rgb(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
            <span class="text-xl">📝</span>
        </div>
        <h3 class="font-playfair font-semibold text-xl text-white">Report an Issue</h3>
        <p class="text-gray-300 text-sm mt-3 font-light leading-relaxed">Submit a maintenance request or report damages for immediate assistance.</p>
    </a>

    <a href="{{ route('tenant.complaints.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
            <span class="text-xl">⏱️</span>
        </div>
        <h3 class="font-playfair font-semibold text-xl text-gray-900">Track Requests</h3>
        <p class="text-gray-500 text-sm mt-3 font-light leading-relaxed">Monitor the progress and history of your submitted maintenance tickets.</p>
    </a>
</div>
@endsection