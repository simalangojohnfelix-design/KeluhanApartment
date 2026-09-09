<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-4">Daftar Keluhan (Admin)</h2>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tenant & Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori & Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status & Urgensi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi & Assign Teknisi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-6 py-4">
                    <span class="font-bold"><?php echo e($c->tenant->name '-'); ?></span><br>
                    <span class="text-sm text-gray-500">Unit: <?php echo e($c->propertyUnit->unit_number '-'); ?></span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs bg-gray-200 px-2 py-1 rounded"><?php echo e($c->category 'Lainnya'); ?></span><br>
                    <?php echo e($c->title); ?>

                </td>
                <td class="px-6 py-4">
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
                    <span class="text-xs ml-2 text-<?php echo e($c->urgency == 'high' ? 'red' : ($c->urgency == 'medium' ? 'yellow' : 'green')); ?>-600"><?php echo e(ucfirst($c->urgency)); ?></span>
                </td>
                <td class="px-6 py-4">
                    <?php if($c->rating): ?>
                        ? <?php echo e($c->rating); ?>/5
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-sm">
                    <form action="<?php echo e(route('admin.complaints.update', $c->id)); ?>" method="POST" class="flex flex-col space-y-2">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <select name="status" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                            <option value="pending" <?php echo e($c->status=='pending'?'selected':''); ?>>Pending</option>
                            <option value="verified" <?php echo e($c->status=='verified'?'selected':''); ?>>Verified</option>
                            <option value="assigned" <?php echo e($c->status=='assigned'?'selected':''); ?>>Assigned</option>
                            <option value="in_progress" <?php echo e($c->status=='in_progress'?'selected':''); ?>>In Progress</option>
                            <option value="resolved" <?php echo e($c->status=='resolved'?'selected':''); ?>>Resolved</option>
                            <option value="rejected" <?php echo e($c->status=='rejected'?'selected':''); ?>>Rejected</option>
                        </select>
                        
                        <?php if(!in_array($c->status, ['resolved', 'rejected'])): ?>
                            <select name="technician_id" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                <option value="">-- Assign Teknisi --</option>
                                <?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t->id); ?>" <?php echo e(($c->workOrder && $c->workOrder->technician_id == $t->id) ? 'selected' : ''); ?>><?php echo e($t->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/complaints/index.blade.php ENDPATH**/ ?>