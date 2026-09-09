<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-2">Riwayat Biaya Pemeliharaan</h2>
<p class="text-gray-500 mb-4">Total keseluruhan: <strong>Rp <?php echo e(number_format($totalCost, 0, ',', '.')); ?></strong></p>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">WO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teknisi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tindakan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biaya</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-6 py-4">WO-<?php echo e($log->id); ?></td>
                <td class="px-6 py-4"><?php echo e(optional(optional($log->complaint)->propertyUnit)->unit_number ?? '-'); ?></td>
                <td class="px-6 py-4"><?php echo e(optional($log->technician)->name ?? '-'); ?></td>
                <td class="px-6 py-4 text-sm"><?php echo e(Str::limit($log->action_details, 60) ?? '-'); ?></td>
                <td class="px-6 py-4 font-semibold">Rp <?php echo e(number_format($log->cost_estimate, 0, ',', '.')); ?></td>
                <td class="px-6 py-4 text-sm"><?php echo e($log->updated_at->format('d M Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<div class="mt-4"><?php echo e($logs->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/owner/cost-log/index.blade.php ENDPATH**/ ?>