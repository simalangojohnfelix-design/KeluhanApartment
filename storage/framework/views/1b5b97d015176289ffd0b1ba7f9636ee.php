<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Executive Dashboard</title>
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
            <a href="<?php echo e(route('owner.dashboard')); ?>" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">Executive Dashboard</a>
            <a href="<?php echo e(route('owner.approvals.index')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition flex justify-between items-center">
                <span>Persetujuan Biaya</span>
                <?php if($pendingApprovals > 0): ?>
                    <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full"><?php echo e($pendingApprovals); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('owner.cost-log.index')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Riwayat Biaya (Log)</a>
            
            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 px-4 mt-6">Manajemen Mutlak</div>
            <a href="<?php echo e(route('owner.users.index')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Pengguna</a>
            <a href="<?php echo e(route('owner.units.index')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Unit</a>
            <a href="<?php echo e(route('owner.assets.index')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Kelola Aset</a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <div class="px-4 mb-4 text-sm font-medium text-gray-300">Hak Akses: <?php echo e(Auth::user()->name); ?></div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-lg transition font-bold text-sm">&larr; Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 overflow-y-auto p-10">
        <div class="mb-10">
            <h2 class="text-4xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Executive Dashboard</h2>
            <p class="text-gray-500 mt-2 font-medium">Ringkasan performa operasional, finansial, dan penguasaan aset properti.</p>
        </div>

        <?php if($pendingApprovals > 0): ?>
        <div class="bg-gray-900 text-white rounded-2xl shadow-lg p-8 mb-10 flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">Persetujuan Tertunda</h3>
                <p class="text-gray-400 text-sm">Terdapat <strong class="text-white"><?php echo e($pendingApprovals); ?> pengajuan anggaran</strong> dari teknisi yang memerlukan validasi Anda.</p>
            </div>
            <a href="<?php echo e(route('owner.approvals.index')); ?>" class="mt-4 md:mt-0 bg-white text-gray-900 px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-100 transition shadow-sm inline-block">
                Tinjau Sekarang &rarr;
            </a>
        </div>
        <?php endif; ?>

        <!-- Kartu Metrik Properti (CRUD Mutlak) -->
        <h3 class="font-bold text-gray-800 uppercase tracking-widest text-xs mb-4">Penguasaan Properti</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <a href="<?php echo e(route('owner.users.index')); ?>" class="block bg-indigo-50 border border-indigo-100 rounded-2xl p-6 hover:shadow-md transition">
                <p class="text-xs font-bold tracking-widest uppercase text-indigo-400 mb-2">Total Pengguna</p>
                <div class="flex justify-between items-end">
                    <p class="text-3xl font-bold text-indigo-900"><?php echo e($totalUsers); ?></p>
                    <span class="text-indigo-600 font-bold text-sm">Kelola &rarr;</span>
                </div>
            </a>
            <a href="<?php echo e(route('owner.units.index')); ?>" class="block bg-blue-50 border border-blue-100 rounded-2xl p-6 hover:shadow-md transition">
                <p class="text-xs font-bold tracking-widest uppercase text-blue-400 mb-2">Total Unit Apartemen</p>
                <div class="flex justify-between items-end">
                    <p class="text-3xl font-bold text-blue-900"><?php echo e($totalUnits); ?></p>
                    <span class="text-blue-600 font-bold text-sm">Kelola &rarr;</span>
                </div>
            </a>
            <a href="<?php echo e(route('owner.assets.index')); ?>" class="block bg-emerald-50 border border-emerald-100 rounded-2xl p-6 hover:shadow-md transition">
                <p class="text-xs font-bold tracking-widest uppercase text-emerald-400 mb-2">Total Aset Tercatat</p>
                <div class="flex justify-between items-end">
                    <p class="text-3xl font-bold text-emerald-900"><?php echo e($totalAssets); ?></p>
                    <span class="text-emerald-600 font-bold text-sm">Kelola &rarr;</span>
                </div>
            </a>
        </div>

        <!-- Kartu Metrik Finansial & Operasional -->
        <h3 class="font-bold text-gray-800 uppercase tracking-widest text-xs mb-4">Finansial & Operasional</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Biaya Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900">Rp <?php echo e(number_format($totalCostMonth, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Biaya Tahun Ini</p>
                <p class="text-3xl font-bold text-gray-900">Rp <?php echo e(number_format($totalCostYear, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Kesehatan Aset</p>
                <p class="text-3xl font-bold <?php echo e($assetHealthPct > 70 ? 'text-green-600' : 'text-amber-500'); ?>"><?php echo e($assetHealthPct); ?>%</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Keluhan Selesai</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($resolvedComplaints); ?> <span class="text-lg text-gray-400 font-medium">/ <?php echo e($totalComplaints); ?></span></p>
            </div>
        </div>

    </main>
</body>
</html><?php /**PATH D:\MSI\sistem-apartemen\resources\views/owner/dashboard.blade.php ENDPATH**/ ?>