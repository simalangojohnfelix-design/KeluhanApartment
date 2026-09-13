<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Kelola Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden" style="font-family: 'Inter', sans-serif;">

    <!-- Sidebar Hitam Owner -->
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
            <a href="{{ route('owner.users.index') }}" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">Kelola Pengguna</a>
            <a href="{{ route('owner.units.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Unit</a>
            <a href="{{ route('owner.assets.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Aset</a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <div class="px-4 mb-4 text-sm font-medium text-gray-300">Hak Akses: {{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-lg transition font-bold text-sm">&larr; Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 overflow-y-auto p-10">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Manajemen Pengguna</h2>
                <p class="text-gray-500 mt-2 text-sm">Hak akses mutlak untuk menambah, mengubah, atau menghapus akun.</p>
            </div>
            <a href="{{ route('owner.users.create') }}" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
                + Tambah Pengguna Baru
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 font-medium shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="p-5 font-bold">Informasi Pengguna</th>
                        <th class="p-5 font-bold">Kontak</th>
                        <th class="p-5 font-bold">Peran (Role)</th>
                        <th class="p-5 font-bold text-center">Aksi Mutlak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5">
                            <span class="font-bold text-gray-900 block">{{ $user->name }}</span>
                            <span class="text-xs text-gray-500 mt-1">Dibuat: {{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="p-5 font-medium text-gray-700">
                            {{ $user->email }}
                            <div class="text-xs text-gray-400 mt-1">{{ $user->phone ?? 'Tanpa Nomor' }}</div>
                        </td>
                        <td class="p-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                {{ $user->role == 'owner' ? 'bg-purple-100 text-purple-700' : 
                                  ($user->role == 'admin' ? 'bg-blue-100 text-blue-700' : 
                                  ($user->role == 'technician' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('owner.users.edit', $user->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-gray-200">Edit</a>
                                <form action="{{ route('owner.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini secara permanen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-red-200">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-10 text-center text-gray-500">Tidak ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>