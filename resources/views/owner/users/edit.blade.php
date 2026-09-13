<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Edit Pengguna</title>
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
            <a href="{{ route('owner.users.index') }}" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">Kelola Pengguna</a>
            <a href="{{ route('owner.units.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Unit</a>
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
        <div class="mb-8"><h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Edit Pengguna</h2></div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 max-w-2xl">
            <form action="{{ route('owner.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label><input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500" required></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Email</label><input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500" required></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Password Baru <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label><input type="password" name="password" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500" minlength="8"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">No. Telepon</label><input type="text" name="phone" value="{{ $user->phone }}" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hak Akses (Role)</label>
                    <select name="role" class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="tenant" {{ $user->role == 'tenant' ? 'selected' : '' }}>Tenant (Penyewa)</option>
                        <option value="technician" {{ $user->role == 'technician' ? 'selected' : '' }}>Technician (Teknisi)</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Dispatcher)</option>
                        <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik)</option>
                    </select>
                </div>
                <div class="pt-4 flex gap-4">
                    <a href="{{ route('owner.users.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl text-sm hover:bg-blue-700 transition shadow-md">Perbarui Pengguna</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>