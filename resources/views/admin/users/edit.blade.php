@extends('layouts.app')
@section('content')
<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
    <h2 class="text-xl font-bold">Edit Pengguna</h2>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-6 rounded shadow max-w-xl mx-auto space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium">Nama Lengkap</label>
        <input type="text" name="name" value="{{ $user->name }}" class="mt-1 w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="mt-1 w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">No. Handphone</label>
        <input type="text" name="phone" value="{{ $user->phone }}" class="mt-1 w-full border rounded p-2">
    </div>
    <div>
        <label class="block text-sm font-medium">Role</label>
        <select name="role" class="mt-1 w-full border rounded p-2">
            @foreach(['tenant', 'technician', 'admin', 'owner'] as $role)
                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
    </div>

    @if($user->role === 'tenant')
    <div class="border-t pt-4 mt-4">
        <h3 class="font-bold text-gray-700 mb-3">Informasi Sewa Unit</h3>
        <div>
            <label class="block text-sm font-medium">Pilih Unit</label>
            <select name="unit_id" class="mt-1 w-full border rounded p-2">
                <option value="">-- Tidak ada unit --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ $user->propertyUnit?->id === $unit->id ? 'selected' : '' }}>
                        {{ $unit->unit_number }} ({{ $unit->floor }}) - {{ ucfirst($unit->status) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium">Mulai Sewa</label>
                <input type="date" name="lease_start" value="{{ $user->propertyUnit?->lease_start }}" class="mt-1 w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Berakhir Sewa</label>
                <input type="date" name="lease_end" value="{{ $user->propertyUnit?->lease_end }}" class="mt-1 w-full border rounded p-2">
            </div>
        </div>
    </div>
    @endif

    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded font-bold hover:bg-blue-700 mt-6">Simpan Perubahan</button>
</form>
@endsection
