<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">
    <a href="<?php echo e(route('tenant.complaints.index')); ?>" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali ke Riwayat Keluhan</a>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between">
            <div>
                <span class="text-xs bg-gray-100 px-2 py-1 rounded"><?php echo e($complaint->category); ?></span>
                <h2 class="text-xl font-bold mt-2"><?php echo e($complaint->title); ?></h2>
            </div>
            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $complaint->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($complaint->status)]); ?>
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
        <p class="text-gray-600 mt-3"><?php echo e($complaint->description); ?></p>
        <?php if($complaint->photo): ?>
        <div class="mt-4"><img src="<?php echo e(asset('storage/' . $complaint->photo)); ?>" class="rounded-lg max-h-64 w-full object-cover" alt="Foto Keluhan"></div>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Timeline Perbaikan</h3>
        <ol class="relative border-l border-gray-200 ml-3 space-y-6">
            <?php
                $steps = [
                    ['label'=>'Keluhan Masuk','date'=>$complaint->created_at,'done'=>true],
                    ['label'=>'Diverifikasi Admin','date'=>$complaint->updated_at,'done'=>in_array($complaint->status,['verified','assigned','in_progress','resolved'])],
                    ['label'=>'Teknisi Ditugaskan','date'=>$complaint->updated_at,'done'=>in_array($complaint->status,['assigned','in_progress','resolved'])],
                    ['label'=>'Sedang Dikerjakan','date'=>$complaint->updated_at,'done'=>in_array($complaint->status,['in_progress','resolved'])],
                    ['label'=>'Selesai','date'=>$complaint->updated_at,'done'=>$complaint->status=='resolved'],
                ];
            ?>
            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="mb-2 ml-4">
                <div class="absolute w-3 h-3 rounded-full mt-1 -left-1.5 border border-white <?php echo e($step['done'] ? 'bg-green-500' : 'bg-gray-300'); ?>"></div>
                <p class="text-sm <?php echo e($step['done'] ? 'text-gray-900 font-semibold' : 'text-gray-400'); ?>"><?php echo e($step['label']); ?></p>
                <?php if($step['done']): ?><time class="text-xs text-gray-500"><?php echo e($step['date']->format('d M Y H:i')); ?></time><?php endif; ?>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </div>

    <?php if($complaint->workOrder && $complaint->workOrder->technician): ?>
    <div class="bg-blue-50 rounded-lg shadow p-5">
        <h3 class="font-bold mb-2">Teknisi yang Ditugaskan</h3>
        <p><strong><?php echo e($complaint->workOrder->technician->name); ?></strong></p>
        <p class="text-sm text-gray-600"><?php echo e($complaint->workOrder->technician->email); ?></p>
        <p class="text-sm mt-1">Status WO: <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $complaint->workOrder->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($complaint->workOrder->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></p>
    </div>
    <?php endif; ?>

    <?php if($complaint->status == 'resolved' && !$complaint->is_confirmed): ?>
    <div class="bg-yellow-50 rounded-lg shadow p-6 border border-yellow-200">
        <h3 class="font-bold text-lg mb-3">Berikan Penilaian</h3>
        <form action="<?php echo e(route('tenant.complaints.rate', $complaint->id)); ?>" method="POST" class="space-y-3">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium">Rating (1-5)</label>
                <select name="rating" class="mt-1 w-full border rounded p-2" required>
                    <option value="5">5 - Sangat Puas</option>
                    <option value="4">4 - Puas</option>
                    <option value="3">3 - Cukup</option>
                    <option value="2">2 - Kurang</option>
                    <option value="1">1 - Sangat Kurang</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Ulasan</label>
                <textarea name="review" rows="3" class="mt-1 w-full border rounded p-2" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>
            <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded font-bold">Kirim Ulasan dan Konfirmasi Selesai</button>
        </form>
    </div>
    <?php elseif($complaint->is_confirmed): ?>
    <div class="bg-green-50 rounded-lg shadow p-5 text-center">
        <p class="font-bold text-green-700">Perbaikan telah dikonfirmasi!</p>
        <p class="text-lg mt-2">Rating: <?php echo e($complaint->rating); ?>/5</p>
        <p class="text-gray-600 mt-1 italic">"<?php echo e($complaint->review); ?>"</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/tenant/complaints/show.blade.php ENDPATH**/ ?>