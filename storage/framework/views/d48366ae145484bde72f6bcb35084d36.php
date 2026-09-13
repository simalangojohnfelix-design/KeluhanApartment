<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Cost Log</title>
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
            <a href="<?php echo e(route('owner.dashboard')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition">Executive Dashboard</a>
            <a href="<?php echo e(route('owner.approvals.index')); ?>" class="block px-4 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-900 transition flex justify-between items-center">
                <span>Persetujuan Biaya</span>
                <?php if(isset($pendingApprovals) && $pendingApprovals > 0): ?>
                    <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full"><?php echo e($pendingApprovals); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('owner.cost-log.index')); ?>" class="block px-4 py-2.5 bg-blue-600 text-white font-bold shadow-md rounded-lg transition">Riwayat Biaya (Log)</a>
            
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
        
        <!-- Header & Ringkasan -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Riwayat Biaya Perbaikan</h2>
                <p class="text-gray-500 mt-2">Log rekapitulasi seluruh pengeluaran operasional yang telah disetujui (ACC).</p>
            </div>
            <div class="bg-white px-6 py-4 rounded-2xl border border-gray-200 shadow-sm min-w-[250px] text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Keseluruhan</p>
                <p class="text-3xl font-bold text-blue-600">Rp <?php echo e(number_format($totalCost, 0, ',', '.')); ?></p>
            </div>
        </div>

        <!-- Tabel Riwayat Biaya -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="p-5 font-bold">No. WO & Unit</th>
                            <th class="p-5 font-bold">Teknisi Bertugas</th>
                            <th class="p-5 font-bold">Tindakan Lapangan</th>
                            <th class="p-5 font-bold text-right">Nominal (Rp)</th>
                            <th class="p-5 font-bold text-center">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-5">
                                <span class="font-bold text-gray-800 block">WO-<?php echo e($log->id); ?></span>
                                <span class="text-xs text-gray-500 font-medium">Unit: <?php echo e(optional(optional($log->complaint)->propertyUnit)->unit_number ?? '-'); ?></span>
                            </td>
                            <td class="p-5 font-medium text-gray-700">
                                <?php echo e(optional($log->technician)->name ?? '-'); ?>

                            </td>
                            <td class="p-5 text-gray-600">
                                <div class="line-clamp-2 leading-relaxed" title="<?php echo e($log->action_details); ?>"><?php echo e($log->action_details ?? '-'); ?></div>
                            </td>
                            <td class="p-5 text-right">
                                <span class="font-bold text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg">
                                    <?php echo e(number_format($log->cost_estimate, 0, ',', '.')); ?>

                                </span>
                            </td>
                            <td class="p-5 text-center text-gray-500 text-xs font-medium">
                                <?php echo e($log->updated_at->format('d M Y')); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="p-16 text-center">
                                <p class="text-xl font-bold text-gray-400" style="font-family: 'Playfair Display', serif;">Belum Ada Riwayat</p>
                                <p class="text-sm text-gray-500 mt-2">Data log pengeluaran operasional masih kosong.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginasi -->
        <div class="mt-6">
            <?php echo e($logs->links()); ?>

        </div>

    </main>
</body>
</html><?php /**PATH D:\MSI\sistem-apartemen\resources\views/owner/cost-log/index.blade.php ENDPATH**/ ?>