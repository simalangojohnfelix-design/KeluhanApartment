<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-4">Persetujuan Biaya Perbaikan</h2>
<?php if(session('success')): ?><div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo e(session('success')); ?></div><?php endif; ?>
<div class="space-y-6">
    <?php $__empty_1 = true; $__currentLoopData = $approvals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="font-bold text-lg">WO-<?php echo e($a->work_order_id); ?>: <?php echo e(optional(optional($a->workOrder)->complaint)->title); ?></h3>
                <p class="text-sm text-gray-500">
                    Unit: <strong><?php echo e(optional(optional(optional($a->workOrder)->complaint)->propertyUnit)->unit_number); ?></strong> &bull;
                    Teknisi: <strong><?php echo e(optional(optional($a->workOrder)->technician)->name); ?></strong>
                </p>
            </div>
            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $a->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($a->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 bg-gray-50 rounded p-4">
            <div>
                <p class="text-xs text-gray-500 uppercase">Estimasi Biaya</p>
                <p class="font-bold text-xl text-red-600">Rp <?php echo e(number_format(optional($a->workOrder)->cost_estimate, 0, ',', '.')); ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Tindakan Dilakukan</p>
                <p class="text-sm"><?php echo e(optional($a->workOrder)->action_details ?? '-'); ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Suku Cadang</p>
                <p class="text-sm"><?php echo e(optional($a->workOrder)->spare_parts ?? '-'); ?></p>
            </div>
        </div>
        <?php if(optional($a->workOrder)->photo_before): ?>
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Foto Sebelum:</p>
                <img src="<?php echo e(asset('storage/'.$a->workOrder->photo_before)); ?>" class="rounded max-h-32 object-cover w-full">
            </div>
            <?php if(optional($a->workOrder)->photo_after): ?>
            <div>
                <p class="text-xs text-gray-500 mb-1">Foto Sesudah:</p>
                <img src="<?php echo e(asset('storage/'.$a->workOrder->photo_after)); ?>" class="rounded max-h-32 object-cover w-full">
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if($a->status == 'pending'): ?>
        <form action="<?php echo e(route('owner.approvals.update', $a->id)); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="mb-3">
                <label class="text-sm font-medium">Komentar (opsional)</label>
                <textarea name="comment" rows="2" class="mt-1 w-full border rounded p-2 text-sm" placeholder="Alasan persetujuan atau penolakan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button name="status" value="approved" class="flex-1 bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">? Approve</button>
                <button name="status" value="rejected" class="flex-1 bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">? Reject</button>
            </div>
        </form>
        <?php else: ?>
        <div class="bg-gray-50 rounded p-3 text-sm">
            <span class="font-medium">Komentar:</span> <?php echo e($a->comment ?? '-'); ?>

        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="bg-white rounded shadow p-10 text-center text-gray-400">Tidak ada pengajuan saat ini.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/owner/approvals/index.blade.php ENDPATH**/ ?>