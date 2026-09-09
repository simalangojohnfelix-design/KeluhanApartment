<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-6">Kelola Pengguna</h2>
<?php if(session('success')): ?><div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm"><?php echo e(session('success')); ?></div><?php endif; ?>


<div class="mb-8">
    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2"><span class="w-2 h-5 bg-blue-600 rounded inline-block"></span> Penyewa (Tenant) &mdash; <?php echo e($tenants->count()); ?> orang</h3>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email / No. HP</th>
                    <th class="px-5 py-3 text-left">Unit</th>
                    <th class="px-5 py-3 text-left">Masa Sewa</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium"><?php echo e($t->name); ?></td>
                    <td class="px-5 py-3 text-sm">
                        <div><?php echo e($t->email); ?></div>
                        <div class="text-gray-400"><?php echo e($t->phone '-'); ?></div>
                    </td>
                    <td class="px-5 py-3">
                        <?php if($t->propertyUnit): ?>
                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-bold"><?php echo e($t->propertyUnit->unit_number); ?></span>
                            <span class="text-xs text-gray-500 ml-1"><?php echo e($t->propertyUnit->floor); ?></span>
                        <?php else: ?>
                            <span class="text-gray-400 text-xs">Belum ditentukan</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-600">
                        <?php if($t->propertyUnit?->lease_start): ?>
                            <?php echo e(\Carbon\Carbon::parse($t->propertyUnit->lease_start)->format('d M Y')); ?>

                            &rarr;
                            <?php echo e(\Carbon\Carbon::parse($t->propertyUnit->lease_end)->format('d M Y')); ?>

                            <?php $daysLeft = now()->diffInDays($t->propertyUnit->lease_end, false); ?>
                            <?php if($daysLeft < 0): ?>
                                <span class="ml-1 text-xs text-red-600 font-semibold">(Kadaluarsa)</span>
                            <?php elseif($daysLeft < 30): ?>
                                <span class="ml-1 text-xs text-yellow-600 font-semibold">(<?php echo e($daysLeft); ?>hr lagi)</span>
                            <?php endif; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3">
                        <a href="<?php echo e(route('admin.users.edit', $t->id)); ?>" class="text-blue-600 text-sm hover:underline">Edit</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<div class="mb-8">
    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2"><span class="w-2 h-5 bg-green-600 rounded inline-block"></span> Teknisi &mdash; <?php echo e($technicians->count()); ?> orang</h3>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">No. HP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium"><?php echo e($t->name); ?></td>
                    <td class="px-5 py-3 text-sm"><?php echo e($t->email); ?></td>
                    <td class="px-5 py-3 text-sm text-gray-500"><?php echo e($t->phone '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<div>
    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2"><span class="w-2 h-5 bg-gray-600 rounded inline-block"></span> Admin & Owner</h3>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium"><?php echo e($a->name); ?></td>
                    <td class="px-5 py-3 text-sm"><?php echo e($a->email); ?></td>
                    <td class="px-5 py-3"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs uppercase font-semibold"><?php echo e($a->role); ?></span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/users/index.blade.php ENDPATH**/ ?>