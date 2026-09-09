@extends('layouts.app')
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali ke Dashboard</a>
        <h2 class="text-xl font-bold mt-1">Manajemen Aset per Unit</h2>
        <p class="text-gray-500 text-sm">{{ $units->count() }} unit &bull; Geser ke kanan untuk melihat unit lain</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
@endif

{{-- Horizontal Swipe Container --}}
<div class="flex overflow-x-auto gap-6 pb-4 snap-x">
    @foreach($units as $unit)
    <div class="bg-white rounded-lg shadow min-w-[800px] flex-shrink-0 snap-center flex flex-col">
        {{-- Unit Header --}}
        <div class="flex justify-between items-center px-5 py-3 bg-blue-700 text-white rounded-t-lg">
            <div>
                <span class="font-bold text-lg">{{ $unit->unit_number }}</span>
                <span class="ml-3 text-sm opacity-80">{{ $unit->floor }}</span>
            </div>
            <div class="text-right text-sm">
                <span>Penyewa: <strong>{{ optional($unit->tenant)->name ?? 'Kosong' }}</strong></span>
                @if($unit->lease_end)
                <span class="ml-3 opacity-80">s.d. {{ \Carbon\Carbon::parse($unit->lease_end)->format('d M Y') }}</span>
                @endif
            </div>
        </div>

        {{-- Assets Table per unit --}}
        <div class="overflow-hidden flex-1">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-5 py-2 text-left">Aset</th>
                        <th class="px-5 py-2 text-left">Kondisi</th>
                        <th class="px-5 py-2 text-left">Status</th>
                        <th class="px-5 py-2 text-left">Maint. Berikutnya</th>
                        <th class="px-5 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($unit->assets as $asset)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-sm font-medium">
                            {{ $asset->name }}
                            <div class="text-xs text-gray-500 font-normal">{{ $asset->category }}</div>
                        </td>
                        <td class="px-5 py-3 text-sm">
                            <span class="px-2 py-0.5 rounded text-xs font-semibold
                                {{ $asset->condition == 'Good' ? 'bg-green-100 text-green-700' :
                                  ($asset->condition == 'Needs Repair' ? 'bg-yellow-100 text-yellow-700' :
                                  ($asset->condition == 'Broken' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ $asset->condition }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <x-status-badge :status="$asset->status" />
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-500">
                            {{ $asset->maintenance_date ? \Carbon\Carbon::parse($asset->maintenance_date)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-3">
                            <form action="{{ route('admin.assets.update', $asset->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PUT')
                                <select name="condition" class="border rounded px-2 py-1 text-xs">
                                    @foreach(['Good','Needs Repair','Broken','Replaced'] as $c)
                                        <option {{ $asset->condition == $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                                <select name="status" class="border rounded px-2 py-1 text-xs">
                                    @foreach(['active','maintenance','broken','retired'] as $s)
                                        <option value="{{ $s }}" {{ $asset->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <input type="date" name="maintenance_date" value="{{ $asset->maintenance_date }}" class="border rounded px-2 py-1 text-xs">
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-700">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection
