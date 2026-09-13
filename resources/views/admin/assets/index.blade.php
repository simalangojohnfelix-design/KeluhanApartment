<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Pantau Aset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden" style="font-family: 'Inter', sans-serif;">

    <!-- Sidebar Hitam -->
    <aside class="w-64 bg-gray-950 text-white flex flex-col shadow-2xl flex-shrink-0">
        <div class="p-8 border-b border-gray-800">
            <h1 class="text-2xl font-bold" style="font-family: 'Playfair Display', serif;">Palazzo Palace</h1>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">Admin Panel</p>
        </div>
        <nav class="flex-1 py-6 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Validasi Keluhan</a>
            <a href="{{ route('admin.units.index') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Pantau Unit</a>
            <a href="{{ route('admin.assets.index') }}" class="block px-4 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-md transition">Pantau Aset</a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Daftar Pengguna</a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <div class="px-4 mb-4 text-sm font-medium text-gray-300">Halo, {{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-lg transition font-bold text-sm">&larr; Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 overflow-y-auto p-10">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Inventaris Aset per Unit</h2>
                <p class="text-gray-500 mt-2">Mode pantau (Read-Only) seluruh fasilitas gedung.</p>
            </div>
            <p class="text-blue-600 text-sm font-bold bg-blue-50 px-4 py-2 rounded-full border border-blue-100">
                &larr; Geser ke kanan untuk unit lain &rarr;
            </p>
        </div>

        <div class="flex overflow-x-auto gap-8 pb-8 snap-x">
            @foreach($units as $unit)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 min-w-[700px] flex-shrink-0 snap-center flex flex-col overflow-hidden">
                <div class="flex justify-between items-center px-6 py-4 bg-gray-900 text-white">
                    <div>
                        <span class="font-bold text-xl font-playfair">{{ $unit->unit_number }}</span>
                        <span class="ml-2 text-sm text-gray-400">Lantai {{ $unit->floor }}</span>
                    </div>
                    <div class="text-right text-sm">
                        <span class="text-gray-300">Penyewa:</span> <span class="font-bold">{{ optional($unit->tenant)->name ?? 'Kosong' }}</span>
                    </div>
                </div>
                <div class="overflow-y-auto flex-1 max-h-[60vh]">
                    <table class="min-w-full text-left">
                        <thead class="bg-gray-50 sticky top-0 border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wide">
                            <tr>
                                <th class="px-6 py-3 font-bold">Aset</th>
                                <th class="px-6 py-3 font-bold">Kondisi</th>
                                <th class="px-6 py-3 font-bold">Status Sistem</th>
                                <th class="px-6 py-3 font-bold">Maint. Berikutnya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($unit->assets as $asset)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $asset->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $asset->category }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                        {{ $asset->condition == 'Good' ? 'bg-green-100 text-green-700' : 
                                          ($asset->condition == 'Needs Repair' ? 'bg-yellow-100 text-yellow-700' : 
                                          ($asset->condition == 'Broken' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                        {{ $asset->condition }}
                                    </span>
                                </td>
                                <td class="px-6 py-4"><x-status-badge :status="$asset->status" /></td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                                    {{ $asset->maintenance_date ? \Carbon\Carbon::parse($asset->maintenance_date)->format('d M Y') : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-8 text-center text-gray-400">Tidak ada aset di unit ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</body>
</html>