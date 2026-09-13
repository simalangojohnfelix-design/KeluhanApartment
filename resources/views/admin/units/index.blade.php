<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Pantau Unit</title>
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
            <a href="{{ route('admin.units.index') }}" class="block px-4 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-md transition">Pantau Unit</a>
            <a href="{{ route('admin.assets.index') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Pantau Aset</a>
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
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Daftar Unit Apartemen</h2>
            <p class="text-gray-500 mt-2">Mode pantau (Read-Only) untuk melihat status kepemilikan dan masa sewa.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm uppercase tracking-wide">
                    <tr>
                        <th class="p-4 font-bold">Unit & Lantai</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold">Penyewa</th>
                        <th class="p-4 font-bold">Masa Sewa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($units as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <span class="font-bold text-gray-800 text-lg">{{ $u->unit_number }}</span>
                            <span class="text-sm text-gray-500 ml-2">Lantai {{ $u->floor }}</span>
                        </td>
                        <td class="p-4"><x-status-badge :status="$u->status" /></td>
                        <td class="p-4 font-medium text-gray-800">{{ optional($u->tenant)->name ?: 'Kosong' }}</td>
                        <td class="p-4 text-sm text-gray-600">
                            @if($u->lease_start)
                                {{ \Carbon\Carbon::parse($u->lease_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($u->lease_end)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-8 text-center text-gray-500">Belum ada data unit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>