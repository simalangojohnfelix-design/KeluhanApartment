@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Riwayat Keluhan Saya</h2>
    <a href="{{ route('tenant.complaints.create') }}" class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">+ Buat Keluhan Baru</a>
</div>
@if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>@endif
<div class="space-y-4">
    @forelse($complaints as $c)
    <div class="bg-white rounded-lg shadow p-5 border-l-4 {{ $c->urgency == 'high' ? 'border-red-500' : ($c->urgency == 'medium' ? 'border-yellow-500' : 'border-green-500') }}">
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs font-medium bg-gray-100 px-2 py-1 rounded mr-2">{{ $c->category }}</span>
                <span class="text-xs font-medium text-{{ $c->urgency=='high'?'red':($c->urgency=='medium'?'yellow':'green') }}-700 bg-{{ $c->urgency=='high'?'red':($c->urgency=='medium'?'yellow':'green') }}-100 px-2 py-1 rounded">{{ strtoupper($c->urgency) }}</span>
                <h3 class="font-bold text-lg mt-2">{{ $c->title }}</h3>
            </div>
            <x-status-badge :status="$c->status" />
        </div>
        <p class="text-gray-600 text-sm mt-2">{{ Str::limit($c->description, 100) }}</p>
        @if($c->workOrder && $c->workOrder->technician)
        <div class="mt-3 bg-blue-50 rounded p-3 text-sm">
            <strong>Teknisi:</strong> {{ $c->workOrder->technician->name }}
        </div>
        @endif
        <div class="mt-3 flex gap-2">
            <a href="{{ route('tenant.complaints.show', $c->id) }}" class="text-sm text-blue-600 hover:underline">Lihat Detail & Timeline</a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded shadow p-10 text-center text-gray-400">Belum ada keluhan yang dibuat.</div>
    @endforelse
</div>
@endsection
