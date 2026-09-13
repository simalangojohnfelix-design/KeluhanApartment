<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Kelola Unit: <?php echo e($unit->unit_number); ?></h2>
    <form action="<?php echo e(route('admin.units.update', $unit->id)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Status Unit</label>
            <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <option value="available" <?php echo e($unit->status == 'available' ? 'selected' : ''); ?>>Available</option>
                <option value="occupied" <?php echo e($unit->status == 'occupied' ? 'selected' : ''); ?>>Occupied</option>
                <option value="maintenance" <?php echo e($unit->status == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Pilih Penyewa (Tenant)</label>
            <select name="user_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <option value="">-- Kosongkan --</option>
                <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->id); ?>" <?php echo e($unit->user_id == $t->id ? 'selected' : ''); ?>><?php echo e($t->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai Sewa</label>
            <input type="date" name="lease_start" value="<?php echo e($unit->lease_start); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Sewa</label>
            <input type="date" name="lease_end" value="<?php echo e($unit->lease_end); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Simpan Perubahan</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/units/edit.blade.php ENDPATH**/ ?>