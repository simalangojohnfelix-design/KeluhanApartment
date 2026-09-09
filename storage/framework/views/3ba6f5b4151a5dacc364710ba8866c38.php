<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-4">Daftar Unit Properti (Admin)</h2>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyewa (Tenant)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Masa Sewa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-6 py-4"><?php echo e($u->unit_number); ?> - <?php echo e($u->type); ?></td>
                <td class="px-6 py-4"><?php echo e(ucfirst($u->status)); ?></td>
                <td class="px-6 py-4"><?php echo e($u->tenant->name ?? 'Kosong'); ?></td>
                <td class="px-6 py-4">
                    <?php if($u->lease_start && $u->lease_end): ?>
                        <?php echo e(\Carbon\Carbon::parse($u->lease_start)->format('d/m/Y')); ?> s.d <?php echo e(\Carbon\Carbon::parse($u->lease_end)->format('d/m/Y')); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                    <a href="<?php echo e(route('admin.units.edit', $u->id)); ?>" class="text-blue-600 hover:text-blue-900">Kelola</a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/units/index.blade.php ENDPATH**/ ?>