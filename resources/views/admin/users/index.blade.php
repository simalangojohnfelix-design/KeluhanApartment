@extends('layouts.app')
@section('content')
<h2 class="text-xl font-bold mb-6">Kelola Pengguna</h2>
@if(session('success'))<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>@endif

{{-- TENANTS --}}
<div class="mb-8">
    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2"><span class="w-2 h-5 bg-blue-600 rounded inline-block"></span> Penyewa (Tenant) &mdash; {{ $tenants->count() }} orang</h3>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email / No. HP</th>
                    <th class="px-5 py-3 text-left">Unit</th>
                    <th class="px-5 py-3 text-left">Masa Sewa</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($tenants as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $t->name }}</td>
                    <td class="px-5 py-3 text-sm">
                        <div>{{ $t->email }}</div>
                        <div class="text-gray-400">{{ $t->phone '-' }}</div>
                    </td>
                    <td class="px-5 py-3">
                        @if($t->propertyUnit)
                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-bold">{{ $t->propertyUnit->unit_number }}</span>
                            <span class="text-xs text-gray-500 ml-1">{{ $t->propertyUnit->floor }}</span>
                        @else
                            <span class="text-gray-400 text-xs">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-600">
                        @if($t->propertyUnit?->lease_start)
                            {{ \Carbon\Carbon::parse($t->propertyUnit->lease_start)->format('d M Y') }}
                            &rarr;
                            {{ \Carbon\Carbon::parse($t->propertyUnit->lease_end)->format('d M Y') }}
                            @php $daysLeft = now()->diffInDays($t->propertyUnit->lease_end, false); @endphp
                            @if($daysLeft < 0)
                                <span class="ml-1 text-xs text-red-600 font-semibold">(Kadaluarsa)</span>
                            @elseif($daysLeft < 30)
                                <span class="ml-1 text-xs text-yellow-600 font-semibold">({{ $daysLeft }}hr lagi)</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.users.edit', $t->id) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- TECHNICIANS --}}
<div class="mb-8">
    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2"><span class="w-2 h-5 bg-green-600 rounded inline-block"></span> Teknisi &mdash; {{ $technicians->count() }} orang</h3>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">No. HP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($technicians as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $t->name }}</td>
                    <td class="px-5 py-3 text-sm">{{ $t->email }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $t->phone '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ADMIN & OWNER --}}
<div>
    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2"><span class="w-2 h-5 bg-gray-600 rounded inline-block"></span> Admin & Owner</h3>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($admins as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $a->name }}</td>
                    <td class="px-5 py-3 text-sm">{{ $a->email }}</td>
                    <td class="px-5 py-3"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs uppercase font-semibold">{{ $a->role }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
