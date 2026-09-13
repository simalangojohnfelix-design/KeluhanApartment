<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Edit Unit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden" style="font-family: 'Inter', sans-serif;">
    <aside class="w-64 bg-gray-950 text-white flex flex-col shadow-2xl flex-shrink-0">
        <div class="p-8 border-b border-gray-800">
            <h1 class="text-2xl font-bold" style="font-family: 'Playfair Display', serif;">Palazzo Palace</h1>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">Owner Panel</p>
        </div>
        <nav class="flex-1 py-6 px-4 space-y-2 text-sm font-medium">
            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 px-4 mt-2">Operasional</div>
            <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Executive Dashboard</a>
            <a href="{{ route('owner.approvals.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Persetujuan Biaya</a>
            <a href="{{ route('owner.cost-log.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Riwayat Biaya (Log)</a>
            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 px-4 mt-6">Manajemen Mutlak</div>
            <a href="{{ route('owner.users.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Pengguna</a>
            <a href="{{ route('owner.units.index') }}" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">Kelola Unit</a>
            <a href="{{ route('owner.assets.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Aset</a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-lg transition font-bold text-sm">&larr; Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-10">
        <div class="mb-8"><h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Edit Unit Apartemen</h2></div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 max-w-2xl">
            <form action="{{ route('owner.units.update', $unit->id) }}" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Nomor Unit</label><input type="text" name="unit_number" value="{{ $unit->unit_number }}" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500" required></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Tipe Unit</label><input type="text" name="type" value="{{ $unit->type }}" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500" required></div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="available" {{ $unit->status == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="occupied" {{ $unit->status == 'occupied' ? 'selected' : '' }}>Terisi (Occupied)</option>
                        <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>Dalam Perawatan (Maintenance)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Penghuni (Tenant)</label>
                    <select name="user_id" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Kosong --</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ $unit->user_id == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-4 flex gap-4">
                    <a href="{{ route('owner.units.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl text-sm hover:bg-blue-700 transition shadow-md">Perbarui Unit</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>