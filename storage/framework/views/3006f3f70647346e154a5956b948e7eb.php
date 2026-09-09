<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Riwayat Keluhan Saya</h2>
    <a href="<?php echo e(route('tenant.complaints.create')); ?>" class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">+ Buat Keluhan Baru</a>
</div>
<?php if(session('success')): ?><div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo e(session('success')); ?></div><?php endif; ?>
<div class="space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-lg shadow p-5 border-l-4 <?php echo e($c->urgency == 'high' ? 'border-red-500' : ($c->urgency == 'medium' ? 'border-yellow-500' : 'border-green-500')); ?>">
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs font-medium bg-gray-100 px-2 py-1 rounded mr-2"><?php echo e($c->category); ?></span>
                <span class="text-xs font-medium text-<?php echo e($c->urgency=='high'?'red':($c->urgency=='medium'?'yellow':'green')); ?>-700 bg-<?php echo e($c->urgency=='high'?'red':($c->urgency=='medium'?'yellow':'green')); ?>-100 px-2 py-1 rounded"><?php echo e(strtoupper($c->urgency)); ?></span>
                <h3 class="font-bold text-lg mt-2"><?php echo e($c->title); ?></h3>
            </div>
            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $c->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($c->status)]); ?>
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
        <p class="text-gray-600 text-sm mt-2"><?php echo e(Str::limit($c->description, 100)); ?></p>
        <?php if($c->workOrder && $c->workOrder->technician): ?>
        <div class="mt-3 bg-blue-50 rounded p-3 text-sm">
            <strong>Teknisi:</strong> <?php echo e($c->workOrder->technician->name); ?>

        </div>
        <?php endif; ?>
        <div class="mt-3 flex gap-2">
            <a href="<?php echo e(route('tenant.complaints.show', $c->id)); ?>" class="text-sm text-blue-600 hover:underline">Lihat Detail & Timeline</a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="bg-white rounded shadow p-10 text-center text-gray-400">Belum ada keluhan yang dibuat.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/tenant/complaints/index.blade.php ENDPATH**/ ?>