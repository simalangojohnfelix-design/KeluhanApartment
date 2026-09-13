<?php $__env->startSection('content'); ?>
<div class="mb-5 flex items-center justify-between">
    <a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
    <h2 class="text-xl font-bold">Edit Pengguna</h2>
</div>

<?php if(session('success')): ?>
<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST" class="bg-white p-6 rounded shadow max-w-xl mx-auto space-y-4">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div>
        <label class="block text-sm font-medium">Nama Lengkap</label>
        <input type="text" name="name" value="<?php echo e($user->name); ?>" class="mt-1 w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="<?php echo e($user->email); ?>" class="mt-1 w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">No. Handphone</label>
        <input type="text" name="phone" value="<?php echo e($user->phone); ?>" class="mt-1 w-full border rounded p-2">
    </div>
    <div>
        <label class="block text-sm font-medium">Role</label>
        <select name="role" class="mt-1 w-full border rounded p-2">
            <?php $__currentLoopData = ['tenant', 'technician', 'admin', 'owner']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($role); ?>" <?php echo e($user->role === $role ? 'selected' : ''); ?>><?php echo e(ucfirst($role)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <?php if($user->role === 'tenant'): ?>
    <div class="border-t pt-4 mt-4">
        <h3 class="font-bold text-gray-700 mb-3">Informasi Sewa Unit</h3>
        <div>
            <label class="block text-sm font-medium">Pilih Unit</label>
            <select name="unit_id" class="mt-1 w-full border rounded p-2">
                <option value="">-- Tidak ada unit --</option>
                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($unit->id); ?>" <?php echo e($user->propertyUnit?->id === $unit->id ? 'selected' : ''); ?>>
                        <?php echo e($unit->unit_number); ?> (<?php echo e($unit->floor); ?>) - <?php echo e(ucfirst($unit->status)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium">Mulai Sewa</label>
                <input type="date" name="lease_start" value="<?php echo e($user->propertyUnit?->lease_start); ?>" class="mt-1 w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Berakhir Sewa</label>
                <input type="date" name="lease_end" value="<?php echo e($user->propertyUnit?->lease_end); ?>" class="mt-1 w-full border rounded p-2">
            </div>
        </div>
    </div>
    <?php endif; ?>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded font-bold hover:bg-blue-700 mt-6">Simpan Perubahan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>