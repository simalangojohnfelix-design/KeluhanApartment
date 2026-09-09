@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between">
            <div>
                <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $complaint->category }}</span>
                <h2 class="text-xl font-bold mt-2">{{ $complaint->title }}</h2>
            </div>
            <x-status-badge :status="$complaint->status" />
        </div>
        <p class="text-gray-600 mt-3">{{ $complaint->description }}</p>
        @if($complaint->photo)
        <div class="mt-4"><img src="{{ asset('storage/' . $complaint->photo) }}" class="rounded-lg max-h-64 w-full object-cover" alt="Foto Keluhan"></div>
        @endif
    </div>

    {{-- TIMELINE --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Timeline Perbaikan</h3>
        <ol class="relative border-l border-gray-200 ml-3 space-y-6">
            @php
                $steps = ['pending' => ['label'=>'Keluhan Masuk','date'=>$complaint->created_at,'done'=>true],
                          'verified' => ['label'=>'Diverifikasi Admin','date'=>$complaint->updated_at,'done'=>in_array($complaint->status,['verified','assigned','in_progress','resolved'])],
                          'assigned' => ['label'=>'Teknisi Ditugaskan','date'=>$complaint->updated_at,'done'=>in_array($complaint->status,['assigned','in_progress','resolved'])],
                          'in_progress' => ['label'=>'Sedang Dikerjakan','date'=>$complaint->updated_at,'done'=>in_array($complaint->status,['in_progress','resolved'])],
                          'resolved' => ['label'=>'Selesai','date'=>$complaint->updated_at,'done'=>$complaint->status=='resolved']];
            @endphp
            @foreach($steps as $step)
            <li class="mb-2 ml-4">
                <div class="absolute w-3 h-3 rounded-full mt-1 -left-1.5 border border-white {{ $step['done'] ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                <p class="text-sm {{ $step['done'] ? 'text-gray-900 font-semibold' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                @if($step['done'])<time class="text-xs text-gray-500">{{ $step['date']->format('d M Y H:i') }}</time>@endif
            </li>
            @endforeach
        </ol>
    </div>

    {{-- TEKNISI INFO --}}
    @if($complaint->workOrder && $complaint->workOrder->technician)
    <div class="bg-blue-50 rounded-lg shadow p-5">
        <h3 class="font-bold mb-2">Teknisi yang Ditugaskan</h3>
        <p><strong>{{ $complaint->workOrder->technician->name }}</strong></p>
        <p class="text-sm text-gray-600">{{ $complaint->workOrder->technician->email }}</p>
        <p class="text-sm mt-1">Status WO: <x-status-badge :status="$complaint->workOrder->status" /></p>
    </div>
    @endif

    {{-- RATING --}}
    @if($complaint->status == 'resolved' && !$complaint->is_confirmed)
    <div class="bg-yellow-50 rounded-lg shadow p-6 border border-yellow-200">
        <h3 class="font-bold text-lg mb-3">? Berikan Penilaian</h3>
        <form action="{{ route('tenant.complaints.rate', $complaint->id) }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium">Rating (1-5 bintang)</label>
                <select name="rating" class="mt-1 w-full border rounded p-2" required>
                    <option value="5"> Sangat Puas</option>
                    <option value="4"> Puas</option>
                    <option value="3"> Cukup</option>
                    <option value="2">Kurang</option>
                    <option value="1">? Sangat Kurang</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Ulasan</label>
                <textarea name="review" rows="3" class="mt-1 w-full border rounded p-2" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>
            <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded font-bold">Kirim Ulasan & Konfirmasi Selesai</button>
        </form>
    </div>
    @elseif($complaint->is_confirmed)
    <div class="bg-green-50 rounded-lg shadow p-5 text-center">
        <p class="font-bold text-green-700">? Perbaikan telah dikonfirmasi!</p>
        <p class="text-2xl mt-2">{{ str_repeat('?', $complaint->rating) }}</p>
        <p class="text-gray-600 mt-1 italic">"{{ $complaint->review }}"</p>
    </div>
    @endif
</div>
@endsection
