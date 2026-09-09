@extends('layouts.app')
@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Keluhan (Admin)</h2>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tenant & Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori & Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status & Urgensi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi & Assign Teknisi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($complaints as $c)
            <tr>
                <td class="px-6 py-4">
                    <span class="font-bold">{{ $c->tenant->name '-' }}</span><br>
                    <span class="text-sm text-gray-500">Unit: {{ $c->propertyUnit->unit_number '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs bg-gray-200 px-2 py-1 rounded">{{ $c->category 'Lainnya' }}</span><br>
                    {{ $c->title }}
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$c->status" />
                    <span class="text-xs ml-2 text-{{ $c->urgency == 'high' ? 'red' : ($c->urgency == 'medium' ? 'yellow' : 'green') }}-600">{{ ucfirst($c->urgency) }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($c->rating)
                        ? {{ $c->rating }}/5
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-4 text-sm">
                    <form action="{{ route('admin.complaints.update', $c->id) }}" method="POST" class="flex flex-col space-y-2">
                        @csrf @method('PUT')
                        <select name="status" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                            <option value="pending" {{ $c->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="verified" {{ $c->status=='verified'?'selected':'' }}>Verified</option>
                            <option value="assigned" {{ $c->status=='assigned'?'selected':'' }}>Assigned</option>
                            <option value="in_progress" {{ $c->status=='in_progress'?'selected':'' }}>In Progress</option>
                            <option value="resolved" {{ $c->status=='resolved'?'selected':'' }}>Resolved</option>
                            <option value="rejected" {{ $c->status=='rejected'?'selected':'' }}>Rejected</option>
                        </select>
                        
                        @if(!in_array($c->status, ['resolved', 'rejected']))
                            <select name="technician_id" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                <option value="">-- Assign Teknisi --</option>
                                @foreach($technicians as $t)
                                    <option value="{{ $t->id }}" {{ ($c->workOrder && $c->workOrder->technician_id == $t->id) ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
