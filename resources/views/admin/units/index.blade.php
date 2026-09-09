@extends('layouts.app')
@section('content')
<div class="mb-5">
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali ke Dashboard</a>
    <h2 class="text-xl font-bold mt-1">Kelola Unit Apartemen</h2>
</div>
@if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>@endif
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Unit</th>
                <th class="px-5 py-3 text-left">Lantai</th>
                <th class="px-5 py-3 text-left">Status</th>
                <th class="px-5 py-3 text-left">Penyewa</th>
                <th class="px-5 py-3 text-left">Masa Sewa</th>
                <th class="px-5 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($units as $u)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-bold">{{ $u->unit_number }}</td>
                <td class="px-5 py-3 text-sm">{{ $u->floor }}</td>
                <td class="px-5 py-3"><x-status-badge :status="$u->status" /></td>
                <td class="px-5 py-3">{{ optional($u->tenant)->name ?: 'Kosong' }}</td>
                <td class="px-5 py-3 text-sm">
                    @if($u->lease_start)
                        {{ \Carbon\Carbon::parse($u->lease_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($u->lease_end)->format('d M Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.units.edit', $u->id) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
