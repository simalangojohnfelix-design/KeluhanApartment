@extends('layouts.app')
@section('content')
<h2 class="text-xl font-bold mb-2">Aset di Unit Saya</h2>
@if($unit)<p class="text-gray-600 mb-4">Unit: <strong>{{ $unit->unit_number }}</strong></p>@endif
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @forelse($assets as $asset)
    <div class="bg-white rounded shadow p-5">
        <h3 class="font-bold">{{ $asset->name }}</h3>
        <span class="text-xs text-gray-500">{{ $asset->category 'Umum' }}</span>
        <div class="mt-3"><x-status-badge :status="$asset->status" /></div>
        <p class="text-sm text-gray-600 mt-2">Kondisi: {{ $asset->condition }}</p>
    </div>
    @empty
    <div class="col-span-3 text-center text-gray-400 py-10">Belum ada aset terdaftar di unit ini.</div>
    @endforelse
</div>
@endsection
