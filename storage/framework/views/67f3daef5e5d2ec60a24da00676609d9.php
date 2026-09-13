 

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto space-y-6" style="font-family: 'Inter', sans-serif;">
    
    <!-- Header Halaman -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Antrean Tugas Perbaikan</h2>
            <p class="text-gray-500 mt-1 text-sm">Kelola dan pantau surat tugas pemeliharaan unit apartemen Anda.</p>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl font-medium shadow-sm">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <!-- Bar Pencarian dan Filter di Atas Tabel -->
    <form method="GET" action="<?php echo e(route('technician.tasks.index')); ?>" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-4 justify-between items-center">
        
        <!-- Input Pencarian -->
        <div class="w-full md:w-1/2 flex gap-2">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari keluhan, deskripsi, atau nomor unit..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">
                Cari
            </button>
        </div>

        <!-- Filter Status -->
        <div class="w-full md:w-auto flex items-center gap-2">
            <select name="status" onchange="this.form.submit()" class="w-full md:w-auto border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none bg-white focus:ring-2 focus:ring-blue-500 text-gray-700 font-medium">
                <option value="">Semua Status</option>
                <option value="ready" <?php echo e(request('status') == 'ready' ? 'selected' : ''); ?>>Siap Dikerjakan / Aktif</option>
                <option value="waiting_approval" <?php echo e(request('status') == 'waiting_approval' ? 'selected' : ''); ?>>Menunggu ACC Owner</option>
                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Selesai</option>
            </select>

            <?php if(request('search') || request('status')): ?>
                <a href="<?php echo e(route('technician.tasks.index')); ?>" class="text-xs font-bold text-gray-600 hover:text-gray-900 bg-gray-100 px-3.5 py-2.5 rounded-lg transition border border-gray-200">
                    Reset
                </a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Tabel Daftar Tugas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase tracking-wide">
                <tr>
                    <th class="p-4 font-bold">No. WO & Unit</th>
                    <th class="p-4 font-bold">Rincian Keluhan</th>
                    <th class="p-4 font-bold">Status Pekerjaan</th>
                    <th class="p-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <span class="font-bold text-gray-800">WO-<?php echo e($task->id); ?></span>
                        <div class="text-xs text-gray-500 mt-1">Unit: <span class="font-semibold"><?php echo e(optional(optional($task->complaint)->propertyUnit)->unit_number ?: '-'); ?></span></div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-gray-800"><?php echo e(optional($task->complaint)->title); ?></div>
                        <div class="text-xs text-gray-500 mt-1 line-clamp-1"><?php echo e(optional($task->complaint)->description); ?></div>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide 
                            <?php echo e($task->status == 'completed' ? 'bg-green-100 text-green-700' : ($task->status == 'waiting_approval' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700')); ?>">
                            <?php echo e(str_replace('_', ' ', $task->status)); ?>

                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <a href="<?php echo e(route('technician.tasks.show', $task->id)); ?>" class="inline-block bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm">
                            Kelola Tugas &rarr;
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="p-12 text-center text-gray-500 font-medium">
                        Tidak ada tugas yang ditemukan sesuai pencarian atau filter Anda.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/technician/tasks/index.blade.php ENDPATH**/ ?>