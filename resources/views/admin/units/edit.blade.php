@extends('layouts.app')
@section('content')
<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Kelola Unit: {{ $unit->unit_number }}</h2>
    <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Status Unit</label>
            <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <option value="available" {{ $unit->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="occupied" {{ $unit->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Pilih Penyewa (Tenant)</label>
            <select name="user_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <option value="">-- Kosongkan --</option>
                @foreach($tenants as $t)
                    <option value="{{ $t->id }}" {{ $unit->user_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai Sewa</label>
            <input type="date" name="lease_start" value="{{ $unit->lease_start }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Sewa</label>
            <input type="date" name="lease_end" value="{{ $unit->lease_end }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Simpan Perubahan</button>
    </form>
</div>
@endsection
