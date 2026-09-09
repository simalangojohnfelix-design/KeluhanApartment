<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold">Manajemen Aset per Unit</h2>
        <p class="text-gray-500 text-sm"><?php echo e($units->count()); ?> unit &bull; Setiap unit dilengkapi aset standar</p>
    </div>
</div>

<?php if(session('success')): ?>
<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="space-y-6">
    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        
        <div class="flex justify-between items-center px-5 py-3 bg-blue-700 text-white">
            <div>
                <span class="font-bold text-lg"><?php echo e($unit->unit_number); ?></span>
                <span class="ml-3 text-sm opacity-80"><?php echo e($unit->floor); ?></span>
            </div>
            <div class="text-right text-sm">
                <span>Penyewa: <strong><?php echo e(optional($unit->tenant)->name ?? 'Kosong'); ?></strong></span>
                <?php if($unit->lease_end): ?>
                <span class="ml-3 opacity-80">s.d. <?php echo e(\Carbon\Carbon::parse($unit->lease_end)->format('d M Y')); ?></span>
                <?php endif; ?>
            </div>
        </div>

        
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-2 text-left">Aset</th>
                    <th class="px-5 py-2 text-left">Kategori</th>
                    <th class="px-5 py-2 text-left">Kondisi</th>
                    <th class="px-5 py-2 text-left">Status</th>
                    <th class="px-5 py-2 text-left">Maint. Berikutnya</th>
                    <th class="px-5 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $unit->assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-sm font-medium"><?php echo e($asset->name); ?></td>
                    <td class="px-5 py-3 text-sm text-gray-500"><?php echo e($asset->category); ?></td>
                    <td class="px-5 py-3 text-sm">
                        <span class="px-2 py-0.5 rounded text-xs font-semibold
                            <?php echo e($asset->condition == 'Good' ? 'bg-green-100 text-green-700' :
                              ($asset->condition == 'Needs Repair' ? 'bg-yellow-100 text-yellow-700' :
                              ($asset->condition == 'Broken' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700'))); ?>">
                            <?php echo e($asset->condition); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $asset->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($asset->status)]); ?>
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
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-500">
                        <?php echo e($asset->maintenance_date ? \Carbon\Carbon::parse($asset->maintenance_date)->format('d M Y') : '-'); ?>

                    </td>
                    <td class="px-5 py-3">
                        <form action="<?php echo e(route('admin.assets.update', $asset->id)); ?>" method="POST" class="flex items-center gap-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <select name="condition" class="border rounded px-2 py-1 text-xs">
                                <?php $__currentLoopData = ['Good','Needs Repair','Broken','Replaced']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e($asset->condition == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="status" class="border rounded px-2 py-1 text-xs">
                                <?php $__currentLoopData = ['active','maintenance','broken','retired']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s); ?>" <?php echo e($asset->status == $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="date" name="maintenance_date" value="<?php echo e($asset->maintenance_date); ?>" class="border rounded px-2 py-1 text-xs">
                            <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700">Simpan</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/assets/index.blade.php ENDPATH**/ ?>