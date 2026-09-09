@extends('layouts.app')
@section('content')
<h2 class="text-xl font-bold mb-4">Persetujuan Biaya Perbaikan</h2>
@if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>@endif
<div class="space-y-6">
    @forelse($approvals as $a)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="font-bold text-lg">WO-{{ $a->work_order_id }}: {{ optional(optional($a->workOrder)->complaint)->title }}</h3>
                <p class="text-sm text-gray-500">
                    Unit: <strong>{{ optional(optional(optional($a->workOrder)->complaint)->propertyUnit)->unit_number }}</strong> &bull;
                    Teknisi: <strong>{{ optional(optional($a->workOrder)->technician)->name }}</strong>
                </p>
            </div>
            <x-status-badge :status="$a->status" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 bg-gray-50 rounded p-4">
            <div>
                <p class="text-xs text-gray-500 uppercase">Estimasi Biaya</p>
                <p class="font-bold text-xl text-red-600">Rp {{ number_format(optional($a->workOrder)->cost_estimate, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Tindakan Dilakukan</p>
                <p class="text-sm">{{ optional($a->workOrder)->action_details '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Suku Cadang</p>
                <p class="text-sm">{{ optional($a->workOrder)->spare_parts '-' }}</p>
            </div>
        </div>
        @if(optional($a->workOrder)->photo_before)
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Foto Sebelum:</p>
                <img src="{{ asset('storage/'.$a->workOrder->photo_before) }}" class="rounded max-h-32 object-cover w-full">
            </div>
            @if(optional($a->workOrder)->photo_after)
            <div>
                <p class="text-xs text-gray-500 mb-1">Foto Sesudah:</p>
                <img src="{{ asset('storage/'.$a->workOrder->photo_after) }}" class="rounded max-h-32 object-cover w-full">
            </div>
            @endif
        </div>
        @endif
        @if($a->status == 'pending')
        <form action="{{ route('owner.approvals.update', $a->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="text-sm font-medium">Komentar (opsional)</label>
                <textarea name="comment" rows="2" class="mt-1 w-full border rounded p-2 text-sm" placeholder="Alasan persetujuan atau penolakan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button name="status" value="approved" class="flex-1 bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">? Approve</button>
                <button name="status" value="rejected" class="flex-1 bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">? Reject</button>
            </div>
        </form>
        @else
        <div class="bg-gray-50 rounded p-3 text-sm">
            <span class="font-medium">Komentar:</span> {{ $a->comment '-' }}
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded shadow p-10 text-center text-gray-400">Tidak ada pengajuan saat ini.</div>
    @endforelse
</div>
@endsection
