<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Owner Panel</title>
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
            <a href="{{ route('owner.approvals.index') }}" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">
                <span>Persetujuan Biaya</span>
                @if(isset($pendingApprovals) && $pendingApprovals > 0)
                    <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $pendingApprovals }}</span>
                @endif
            </a>
            <a href="{{ route('owner.cost-log.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Riwayat Biaya (Log)</a>
            
            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 px-4 mt-6">Manajemen Mutlak</div>
            <a href="{{ route('owner.users.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Pengguna</a>
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
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Persetujuan Anggaran (ACC)</h2>
            <p class="text-gray-500 mt-2">Tinjau dan berikan keputusan atas estimasi biaya (RAB) yang diajukan oleh teknisi.</p>
        </div>

        @if(session('success')) 
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl font-medium shadow-sm mb-6">
            {{ session('success') }}
        </div> 
        @endif 

        <div class="space-y-8 max-w-5xl">
            @forelse($approvals as $a)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-blue-600">Work Order #WO-{{ $a->id }}</span>
                        <h3 class="font-bold text-xl text-gray-900 mt-1" style="font-family: 'Playfair Display', serif;">{{ optional($a->complaint)->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Unit: <strong class="text-gray-800">No. {{ optional(optional($a->complaint)->propertyUnit)->unit_number }}</strong> &bull; 
                            Teknisi: <strong class="text-gray-800">{{ optional($a->technician)->name }}</strong>
                        </p>
                    </div>
                    <span class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                        Menunggu Tindakan
                    </span>
                </div> 

                <!-- Kotak Informasi Rincian Biaya -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Estimasi Biaya</p>
                        <p class="font-bold text-3xl text-blue-600">Rp {{ number_format($a->cost_estimate, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Estimasi pengerjaan: {{ $a->estimated_days ?? 1 }} Hari</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tindakan Lapangan</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $a->action_details ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Rincian Material</p>
                        @php
                            $items = [];
                            try {
                                $items = json_decode($a->spare_parts, true) ?? [];
                            } catch(\Exception $e) {
                                $items = [];
                            }
                        @endphp

                        @if(is_array($items) && count($items) > 0)
                            <ul class="space-y-1">
                                @foreach($items as $item)
                                <li class="text-xs flex justify-between border-b border-gray-200 pb-1">
                                    <span class="text-gray-700">{{ $item['name'] }} <span class="text-gray-400">({{ $item['qty'] }})</span></span>
                                    <span class="font-medium text-gray-800">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-700">{{ $a->spare_parts ?? 'Tidak ada rincian.' }}</p>
                        @endif
                    </div>
                </div> 

                <!-- Foto Lapangan -->
                @if($a->photo_before)
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Foto Kondisi Sebelum</p>
                        <img src="{{ asset('storage/'.$a->photo_before) }}" class="rounded-xl max-h-48 object-cover w-full border border-gray-200 shadow-sm">
                    </div>
                    @if($a->photo_after)
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Foto Kondisi Sesudah</p>
                        <img src="{{ asset('storage/'.$a->photo_after) }}" class="rounded-xl max-h-48 object-cover w-full border border-gray-200 shadow-sm">
                    </div>
                    @endif
                </div>
                @endif 

                <!-- Form Keputusan Owner -->
                <form action="{{ route('owner.approvals.update', $a->id) }}" method="POST" class="space-y-4 pt-6 border-t border-gray-200">
                    @csrf @method('PUT') 
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Komentar Khusus (Tampil di panel Teknisi)</label>
                        <textarea name="comment" rows="2" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-blue-500 outline-none bg-white" placeholder="Berikan catatan, instruksi tambahan, atau alasan jika ditolak..."></textarea>
                    </div> 
                    <div class="flex flex-col md:flex-row gap-4">
                        <button type="submit" name="status" value="approved" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-bold transition shadow-sm text-sm flex items-center justify-center gap-2">
                            ✓ ACC (Setujui Anggaran & Lanjutkan Pekerjaan)
                        </button>
                        <button type="submit" name="status" value="rejected" class="md:w-1/3 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-3 rounded-xl font-bold transition shadow-sm text-sm flex items-center justify-center gap-2">
                            ✕ Tolak (Minta Revisi Teknisi)
                        </button>
                    </div>
                </form>
            </div> 
            @empty 
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-16 text-center">
                <p class="text-xl font-bold text-gray-400" style="font-family: 'Playfair Display', serif;">Tidak Ada Pengajuan</p>
                <p class="text-sm text-gray-500 mt-2">Seluruh estimasi biaya perbaikan telah Anda tinjau.</p>
            </div> 
            @endforelse 
        </div> 
    </main>
</body>
</html>