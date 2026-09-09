@extends('layouts.app')
@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Unit Properti (Admin)</h2>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyewa (Tenant)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Masa Sewa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($units as $u)
            <tr>
                <td class="px-6 py-4">{{ $u->unit_number }} - {{ $u->type }}</td>
                <td class="px-6 py-4">{{ ucfirst($u->status) }}</td>
                <td class="px-6 py-4">{{ $u->tenant->name 'Kosong' }}</td>
                <td class="px-6 py-4">
                    @if($u->lease_start && $u->lease_end)
                        {{ \Carbon\Carbon::parse($u->lease_start)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($u->lease_end)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.units.edit', $u->id) }}" class="text-blue-600 hover:text-blue-900">Kelola</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
