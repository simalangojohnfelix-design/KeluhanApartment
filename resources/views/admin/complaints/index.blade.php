@extends('layouts.app')
@section('content')
<div class="mb-5">
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali ke Dashboard</a>
    <h2 class="text-xl font-bold mt-1">Kelola Keluhan</h2>
</div>
@if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>@endif
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Pelapor / Unit</th>
                <th class="px-5 py-3 text-left">Keluhan</th>
                <th class="px-5 py-3 text-left">Urgensi</th>
                <th class="px-5 py-3 text-left">Status</th>
                <th class="px-5 py-3 text-left">Assign Teknisi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($complaints as $c)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <span class="font-bold">{{ optional($c->tenant)->name ?: '-' }}</span><br>
                    <span class="text-sm text-gray-500">Unit: {{ optional($c->propertyUnit)->unit_number ?: '-' }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-xs bg-gray-200 px-2 py-1 rounded">{{ $c->category ?: 'Lainnya' }}</span><br>
                    <span class="font-medium">{{ $c->title }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-xs font-bold uppercase px-2 py-0.5 rounded {{ $c->urgency=='high' ? 'bg-red-100 text-red-700' : ($c->urgency=='medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">{{ $c->urgency }}</span>
                </td>
                <td class="px-5 py-3">
                    <form action="{{ route('admin.complaints.update', $c->id) }}" method="POST" class="inline">
                        @csrf @method('PUT')
                        <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-xs">
                            @foreach(['pending','verified','assigned','in_progress','resolved','rejected'] as $s)
                                <option value="{{ $s }}" {{ $c->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td class="px-5 py-3">
                    <form action="{{ route('admin.complaints.update', $c->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="{{ $c->status }}">
                        <select name="technician_id" class="border rounded px-2 py-1 text-xs">
                            <option value="">-- Pilih --</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ optional($c->workOrder)->technician_id == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                            @endforeach
                        </select>
                        <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs font-bold">Assign</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
