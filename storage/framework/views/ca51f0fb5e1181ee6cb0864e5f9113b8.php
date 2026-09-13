<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo Palace - Daftar Pengguna</title>
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
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Validasi Keluhan</a>
            <a href="<?php echo e(route('admin.units.index')); ?>" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Pantau Unit</a>
            <a href="<?php echo e(route('admin.assets.index')); ?>" class="block px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg font-medium transition">Pantau Aset</a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="block px-4 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-md transition">Daftar Pengguna</a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <div class="px-4 mb-4 text-sm font-medium text-gray-300">Halo, <?php echo e(Auth::user()->name); ?></div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-lg transition font-bold text-sm">&larr; Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 overflow-y-auto p-10">
        <div class="mb-10">
            <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Direktori Akun</h2>
            <p class="text-gray-500 mt-2">Daftar rekapitulasi penyewa, teknisi, dan manajemen.</p>
        </div>

        <!-- Tabel Tenants -->
        <div class="mb-10">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-blue-600 pl-3">Penyewa (Tenant) - <?php echo e($tenants->count()); ?> orang</h3>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wide">
                        <tr>
                            <th class="p-4 font-bold">Nama Lengkap</th>
                            <th class="p-4 font-bold">Kontak</th>
                            <th class="p-4 font-bold">Unit Ditempati</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-bold text-gray-800"><?php echo e($t->name); ?></td>
                            <td class="p-4">
                                <div class="text-sm font-medium text-gray-800"><?php echo e($t->email); ?></div>
                                <div class="text-xs text-gray-500 mt-1"><?php echo e($t->phone ?: 'Tidak ada nomor'); ?></div>
                            </td>
                            <td class="p-4">
                                <?php if($t->propertyUnit): ?>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold"><?php echo e($t->propertyUnit->unit_number); ?></span>
                                    <span class="text-xs text-gray-500 ml-2 font-medium">Lantai <?php echo e($t->propertyUnit->floor); ?></span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs font-medium italic">Belum ditentukan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Teknisi & Admin -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-green-600 pl-3">Tim Teknisi - <?php echo e($technicians->count()); ?> orang</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wide">
                            <tr><th class="p-4 font-bold">Nama</th><th class="p-4 font-bold">Email</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-800"><?php echo e($t->name); ?></td>
                                <td class="p-4 text-sm text-gray-600 font-medium"><?php echo e($t->email); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-gray-900 pl-3">Manajemen (Admin & Owner)</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200 text-xs text-gray-600 uppercase tracking-wide">
                            <tr><th class="p-4 font-bold">Nama</th><th class="p-4 font-bold">Hak Akses</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-800">
                                    <?php echo e($a->name); ?>

                                    <div class="text-xs text-gray-500 font-medium mt-1"><?php echo e($a->email); ?></div>
                                </td>
                                <td class="p-4">
                                    <span class="bg-gray-900 text-white px-3 py-1 rounded-full text-xs uppercase font-bold tracking-wider"><?php echo e($a->role); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</body>
</html><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/users/index.blade.php ENDPATH**/ ?>