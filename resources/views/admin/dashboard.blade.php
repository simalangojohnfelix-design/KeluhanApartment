@extends('layouts.app')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Admin Dashboard</h1>
    <p class="text-gray-500 text-sm">Ringkasan operasional harian</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-yellow-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Keluhan Bulan Ini</p>
        <p class="text-3xl font-bold mt-1">{{ $totalComplaints }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-red-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Menunggu Tindakan</p>
        <p class="text-3xl font-bold mt-1">{{ $pendingComplaints }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-green-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Total Biaya Perbaikan</p>
        <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalRepairCost, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-xs text-gray-500 uppercase font-medium">Total Aset Terdaftar</p>
        <p class="text-3xl font-bold mt-1">{{ $totalAssets }}</p>
        @if($badAssets > 0)
            <p class="text-sm text-red-600 mt-1">? {{ $badAssets }} aset butuh perhatian</p>
        @else
            <p class="text-sm text-green-600 mt-1">? Semua aset dalam kondisi baik</p>
        @endif
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="{{ route('admin.complaints.index') }}" class="block bg-blue-600 text-white rounded-lg p-4 text-center font-bold hover:bg-blue-700 transition">
       <div class="mt-1">Kelola Keluhan</div>
    </a>
    <a href="{{ route('admin.units.index') }}" class="block bg-green-600 text-white rounded-lg p-4 text-center font-bold hover:bg-green-700 transition">
       <div class="mt-1">Kelola Unit</div>
    </a>
    <a href="{{ route('admin.assets.index') }}" class="block bg-yellow-600 text-white rounded-lg p-4 text-center font-bold hover:bg-yellow-700 transition">
       <div class="mt-1">Kelola Aset</div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="block bg-gray-600 text-white rounded-lg p-4 text-center font-bold hover:bg-gray-700 transition">
       <div class="mt-1">Kelola Pengguna</div>
    </a>
</div>
@endsection
