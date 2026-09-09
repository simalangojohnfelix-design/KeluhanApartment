<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-4">Daftar Tugas Perbaikan (Work Orders)</h2>
<div class="space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php $urgency = optional($task->complaint)->urgency; ?>
    <div class="bg-white rounded-lg shadow p-5 border-l-4 <?php echo e($urgency == 'high' ? 'border-red-500' : ($urgency == 'medium' ? 'border-yellow-500' : 'border-green-500')); ?>">
        <div class="flex justify-between items-start">
            <div>
                <span class="font-bold text-gray-800">WO-<?php echo e($task->id); ?></span>
                <span class="ml-2 text-xs font-bold uppercase text-<?php echo e($urgency=='high'?'red':($urgency=='medium'?'yellow':'green')); ?>-700 bg-<?php echo e($urgency=='high'?'red':($urgency=='medium'?'yellow':'green')); ?>-100 px-2 py-0.5 rounded"><?php echo e($urgency); ?></span>
                <h3 class="text-lg font-semibold mt-1"><?php echo e(optional($task->complaint)->title); ?></h3>
                <p class="text-sm text-gray-500">Unit: <?php echo e(optional(optional($task->complaint)->propertyUnit)->unit_number); ?> &bull; <?php echo e(optional(optional($task->complaint)->tenant)->name); ?></p>
            </div>
            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $task->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task->status)]); ?>
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
        <p class="text-gray-600 text-sm mt-2"><?php echo e(Str::limit(optional($task->complaint)->description, 120)); ?></p>
        <div class="mt-3 flex gap-3">
            <a href="<?php echo e(route('technician.tasks.show', $task->id)); ?>" class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-700">Detail & Update</a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="bg-white rounded shadow p-10 text-center text-gray-400">Tidak ada tugas yang ditetapkan saat ini.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/technician/tasks/index.blade.php ENDPATH**/ ?>