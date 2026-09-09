@extends('layouts.app')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Executive Dashboard</h1>
    <p class="text-gray-500 text-sm">Ringkasan performa operasional properti</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-blue-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Biaya Bulan Ini</p>
        <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalCostMonth, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-indigo-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Biaya Tahun Ini</p>
        <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalCostYear, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-green-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Kondisi Aset Baik</p>
        <p class="text-2xl font-bold mt-1">{{ $assetHealthPct }}%</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-yellow-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Keluhan Selesai</p>
        <p class="text-2xl font-bold mt-1">{{ $resolvedComplaints }} / {{ $totalComplaints }}</p>
    </div>
</div>

@if($pendingApprovals > 0)
<div class="bg-red-50 border border-red-200 rounded-lg p-5 mb-6">
    <h3 class="font-bold text-red-700">? {{ $pendingApprovals }} Pengajuan Biaya Menunggu Persetujuan Anda</h3>
    <a href="{{ route('owner.approvals.index') }}" class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">Review Sekarang</a>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Volume Keluhan per Kategori</h3>
        @forelse($complaintsByCategory as $item)
        @php $pct = $totalComplaints > 0 ? round(($item->total / $totalComplaints) * 100) : 0; @endphp
        <div class="mb-3">
            <div class="flex justify-between text-sm mb-1">
                <span>{{ $item->category 'Tidak Dikategorikan' }}</span>
                <span class="font-semibold">{{ $item->total }}</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $pct }}%"></div>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm">Belum ada data keluhan.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-3">
        <h3 class="font-bold text-lg mb-4">Navigasi Cepat</h3>
        <a href="{{ route('owner.approvals.index') }}" class="flex items-center justify-between bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded p-4 transition">
            <span class="font-medium text-blue-800">Persetujuan Perbaikan</span>
            <span class="bg-{{ $pendingApprovals > 0 ? 'red' : 'blue' }}-600 text-white px-3 py-1 rounded-full text-xs">{{ $pendingApprovals }} pending</span>
        </a>
        <a href="{{ route('owner.cost-log.index') }}" class="flex items-center justify-between bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded p-4 transition">
            <span class="font-medium text-gray-800">Riwayat Biaya (Cost Log)</span>
            <span class="text-gray-400 text-sm">&rarr;</span>
        </a>
    </div>
</div>
@endsection
