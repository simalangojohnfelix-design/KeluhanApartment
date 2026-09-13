<?php $__env->startSection('content'); ?>
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between border-b border-gray-200 pb-6" data-aos="fade-down">
    <div>
        <a href="<?php echo e(route('tenant.dashboard')); ?>" class="text-xs font-medium text-gray-400 uppercase tracking-wider hover:text-gray-900 transition mb-2 inline-block">&larr; Back to Dashboard</a>
        <h2 class="font-playfair text-3xl font-bold text-gray-900 mt-1">Residence Inventory</h2>
    </div>
    <?php if($unit): ?>
    <p class="text-sm text-gray-500 mt-3 md:mt-0 font-light">Unit <strong class="text-gray-900"><?php echo e($unit->unit_number); ?></strong></p>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 p-6 flex flex-col h-full" data-aos="fade-up" data-aos-delay="<?php echo e($index * 50); ?>">
        <div class="mb-auto">
            <span class="text-[10px] font-semibold tracking-widest uppercase text-gray-400 mb-2 block"><?php echo e($asset->category ?: 'General'); ?></span>
            <h3 class="font-playfair font-semibold text-lg text-gray-900 leading-snug"><?php echo e($asset->name); ?></h3>
        </div>
        <div class="mt-6 pt-4 border-t border-gray-50">
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500">Condition</span>
                <span class="text-xs font-medium <?php echo e($asset->condition == 'Good' ? 'text-green-600' : 'text-amber-600'); ?>"><?php echo e($asset->condition); ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full py-16 text-center" data-aos="fade-up">
        <p class="text-gray-400 font-light">No assets have been inventoried for this residence yet.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/tenant/assets/index.blade.php ENDPATH**/ ?>