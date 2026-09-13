<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Admin Panel</title>
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
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-md transition">
                Validasi Keluhan
            </a>
            <a href="{{ route('admin.units.index') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">
                Pantau Unit
            </a>
            <a href="{{ route('admin.assets.index') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">
                Pantau Aset
            </a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">
                Daftar Pengguna
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <div class="px-4 mb-4 text-sm font-medium text-gray-300">
                Halo, {{ Auth::user()->name }}
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-lg transition font-bold text-sm">
                    &larr; Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama (Langsung Menampilkan Tabel Validasi) -->
    <main class="flex-1 overflow-y-auto p-10">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Antrean Validasi Keluhan</h2>
            <p class="text-gray-500 mt-2">Periksa laporan masuk, pilih teknisi, dan teruskan ke Owner untuk disetujui.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-8 font-medium shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm uppercase tracking-wide">
                    <tr>
                        <th class="p-4 font-bold">Pelapor & Unit</th>
                        <th class="p-4 font-bold">Rincian Kerusakan</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-center">Tindakan Dispatcher</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($complaints as $c)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ optional($c->tenant)->name ?: '-' }}</div>
                            <div class="text-sm text-gray-500 mt-1">Unit: <span class="font-semibold">{{ optional($c->propertyUnit)->unit_number ?: '-' }}</span></div>
                        </td>
                        <td class="p-4">
                            <span class="text-xs font-bold tracking-widest uppercase text-blue-600">{{ $c->category ?: 'Lainnya' }}</span><br>
                            <div class="font-bold text-gray-800 mt-1">{{ $c->title }}</div>
                            <span class="inline-block mt-2 text-xs font-bold uppercase px-3 py-1 rounded-full {{ $c->urgency=='high' ? 'bg-red-100 text-red-700' : ($c->urgency=='medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                Urgensi: {{ $c->urgency }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 uppercase tracking-wide">
                                {{ str_replace('_', ' ', $c->status) }}
                            </span>
                        </td>
                        <td class="p-4 bg-gray-50 border-l border-gray-100">
                            <form action="{{ route('admin.complaints.update', $c->id) }}" method="POST" class="flex flex-col gap-3">
                                @csrf @method('PUT')
                                @if($c->status == 'pending')
                                    <select name="technician_id" required class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 outline-none bg-white">
                                        <option value="">-- Pilih Teknisi Bertugas --</option>
                                        @foreach($technicians as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="flex gap-2">
                                        <button type="submit" name="status" value="waiting_approval" class="flex-1 bg-gray-900 hover:bg-black text-white px-3 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                                            Minta ACC Teknisi
                                        </button>
                                        <button type="submit" name="status" value="rejected" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-xs font-bold transition">
                                            Tolak
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center text-sm text-gray-500 font-medium py-2">
                                        Menunggu Tindakan Lain
                                    </div>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500 font-medium">Belum ada keluhan masuk yang perlu divalidasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>