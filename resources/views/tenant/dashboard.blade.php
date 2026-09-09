@extends('layouts.app')
@section('content')
@php $unit = auth()->user()->propertyUnit; @endphp
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard Tenant</h1>
    @if($unit)
        <p class="text-gray-600">Unit Anda: <strong>{{ $unit->unit_number }}</strong> &bull; Sewa s.d: {{ $unit->lease_end ? \Carbon\Carbon::parse($unit->lease_end)->format('d M Y') : '-' }}</p>
    @else
        <p class="text-yellow-600">Unit belum ditetapkan. Hubungi Admin.</p>
    @endif
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('tenant.assets.index') }}" class="block bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-blue-500">
        <h3 class="font-bold text-lg text-blue-600">Aset Unit Saya</h3>
        <p class="text-gray-600 text-sm mt-2">Lihat daftar fasilitas & aset di unit Anda.</p>
    </a>
    <a href="{{ route('tenant.complaints.create') }}" class="block bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-red-500">
        <h3 class="font-bold text-lg text-red-600">Laporkan Keluhan</h3>
        <p class="text-gray-600 text-sm mt-2">Buat laporan kerusakan baru dengan foto.</p>
    </a>
    <a href="{{ route('tenant.complaints.index') }}" class="block bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-green-500">
        <h3 class="font-bold text-lg text-green-600">Lacak Perbaikan</h3>
        <p class="text-gray-600 text-sm mt-2">Pantau status & timeline perbaikan Anda.</p>
    </a>
</div>
@endsection
