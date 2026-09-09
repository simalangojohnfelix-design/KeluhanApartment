<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-2">WO-<?php echo e($task->id); ?>: <?php echo e(optional($task->complaint)->title); ?></h2>
        <p class="text-sm text-gray-500">Unit: <strong><?php echo e(optional(optional($task->complaint)->propertyUnit)->unit_number); ?></strong> &bull; Penyewa: <strong><?php echo e(optional(optional($task->complaint)->tenant)->name); ?></strong> (<?php echo e(optional(optional($task->complaint)->tenant)->email); ?>)</p>
        <p class="text-gray-700 mt-3"><?php echo e(optional($task->complaint)->description); ?></p>
        <?php if(optional($task->complaint)->photo): ?>
        <div class="mt-3">
            <p class="text-xs text-gray-500 mb-1">Foto dari Tenant:</p>
            <img src="<?php echo e(asset('storage/'.$task->complaint->photo)); ?>" class="rounded max-h-48 object-cover" alt="Foto Keluhan">
        </div>
        <?php endif; ?>
    </div>

    <?php if(session('success')): ?><div class="bg-green-100 text-green-700 p-3 rounded"><?php echo e(session('success')); ?></div><?php endif; ?>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-lg mb-4">Update Progress Pekerjaan</h3>
        <form action="<?php echo e(route('technician.tasks.update', $task->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label class="block text-sm font-medium">Status Pengerjaan</label>
                <select name="status" class="mt-1 w-full border rounded p-2">
                    <option value="pending" <?php echo e($task->status=='pending'?'selected':''); ?>>Pending</option>
                    <option value="working" <?php echo e($task->status=='working'?'selected':''); ?>>Start Work</option>
                    <option value="on_hold" <?php echo e($task->status=='on_hold'?'selected':''); ?>>? On Hold</option>
                    <option value="completed" <?php echo e($task->status=='completed'?'selected':''); ?>>? Completed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Detail Tindakan Perbaikan</label>
                <textarea name="action_details" rows="3" class="mt-1 w-full border rounded p-2" placeholder="Apa yang sudah dilakukan..."><?php echo e($task->action_details); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Suku Cadang / Sparepart Digunakan</label>
                <textarea name="spare_parts" rows="2" class="mt-1 w-full border rounded p-2" placeholder="Contoh: Filter AC 1 pcs, Kabel 2m..."><?php echo e($task->spare_parts); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Estimasi Biaya (Rp)</label>
                <input type="number" name="cost_estimate" value="<?php echo e($task->cost_estimate); ?>" class="mt-1 w-full border rounded p-2" placeholder="0">
                <p class="text-xs text-gray-500 mt-1">? Jika melebihi Rp 1.000.000, otomatis diajukan ke Owner untuk persetujuan.</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Foto SEBELUM</label>
                    <input type="file" name="photo_before" accept="image/*" class="mt-1 w-full text-sm">
                    <?php if($task->photo_before): ?><img src="<?php echo e(asset('storage/'.$task->photo_before)); ?>" class="mt-2 rounded max-h-24 object-cover"><?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium">Foto SESUDAH</label>
                    <input type="file" name="photo_after" accept="image/*" class="mt-1 w-full text-sm">
                    <?php if($task->photo_after): ?><img src="<?php echo e(asset('storage/'.$task->photo_after)); ?>" class="mt-2 rounded max-h-24 object-cover"><?php endif; ?>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">Simpan Update</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/technician/tasks/show.blade.php ENDPATH**/ ?>