<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Kelola Aset</title>
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
            <a href="{{ route('owner.users.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Pengguna</a>
            <a href="{{ route('owner.units.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Unit</a>
            <a href="{{ route('owner.assets.index') }}" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">Kelola Aset</a>
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
                <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Manajemen Aset per Unit</h2>
                <p class="text-gray-500 mt-2 text-sm">Inventarisasi perabotan dan utilitas apartemen dengan kendali penuh.</p>
            </div>
            <div class="flex items-center gap-4">
                <p class="text-blue-600 text-sm font-bold bg-blue-50 px-4 py-2 rounded-full border border-blue-100 hidden lg:block">
                    &larr; Geser ke kanan untuk unit lain &rarr;
                </p>
                <a href="{{ route('owner.assets.create') }}" class="bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition flex items-center gap-2">
                    + Tambah Aset Baru
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 font-medium shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @php
            // Mengelompokkan aset berdasarkan ID Unit. Jika null, masuk ke 'fasilitas_umum'
            $groupedAssets = $assets->groupBy(function($asset) {
                return $asset->property_unit_id ?: 'fasilitas_umum';
            });
        @endphp

        <div class="flex overflow-x-auto gap-8 pb-8 snap-x">
            @forelse($groupedAssets as $unitId => $unitAssets)
                @php
                    // Ambil relasi unit dari aset pertama dalam grup ini (jika bukan fasilitas umum)
                    $unit = $unitId !== 'fasilitas_umum' ? $unitAssets->first()->propertyUnit : null;
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 min-w-[700px] flex-shrink-0 snap-center flex flex-col overflow-hidden">
                    
                    <!-- Header Kartu Unit -->
                    <div class="flex justify-between items-center px-6 py-4 bg-gray-900 text-white">
                        <div>
                            <span class="font-bold text-xl font-playfair">
                                {{ $unit ? 'Unit ' . $unit->unit_number : 'Fasilitas Umum' }}
                            </span>
                            @if($unit && $unit->type)
                                <span class="ml-2 text-sm text-gray-400">Tipe: {{ $unit->type }}</span>
                            @endif
                        </div>
                        <div class="text-right text-sm">
                            <span class="text-gray-300">Penyewa:</span> 
                            <span class="font-bold">{{ $unit && optional($unit->user)->name ? $unit->user->name : 'Kosong / Umum' }}</span>
                        </div>
                    </div>

                    <!-- Tabel Aset di dalam Kartu -->
                    <div class="overflow-y-auto flex-1 max-h-[60vh]">
                        <table class="min-w-full text-left">
                            <thead class="bg-gray-50 sticky top-0 border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wide">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Nama / Keterangan Aset</th>
                                    <th class="px-6 py-4 font-bold">Kategori</th>
                                    <th class="px-6 py-4 font-bold">Kondisi (Status)</th>
                                    <th class="px-6 py-4 font-bold text-center">Aksi Mutlak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach($unitAssets as $asset)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $asset->name }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $asset->type }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                            {{ $asset->status == 'good' ? 'bg-green-100 text-green-700' : 
                                              ($asset->status == 'maintenance' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $asset->status == 'good' ? 'Baik' : ($asset->status == 'damaged' ? 'Rusak' : 'Perawatan') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('owner.assets.edit', $asset->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-gray-200">
                                                Edit
                                            </a>
                                            <form action="{{ route('owner.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Hapus data aset inventaris ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-red-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="w-full bg-white rounded-2xl shadow-sm border border-gray-200 p-16 text-center text-gray-500">
                    Belum ada data aset yang didaftarkan. Klik "Tambah Aset Baru" untuk memulai.
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>