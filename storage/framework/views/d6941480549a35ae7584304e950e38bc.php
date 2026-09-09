<?php $__env->startSection('content'); ?>
<?php $unit = auth()->user()->propertyUnit; ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard Tenant</h1>
    <?php if($unit): ?>
        <p class="text-gray-600">Unit Anda: <strong><?php echo e($unit->unit_number); ?></strong> &bull; Sewa s.d: <?php echo e($unit->lease_end ? \Carbon\Carbon::parse($unit->lease_end)->format('d M Y') : '-'); ?></p>
    <?php else: ?>
        <p class="text-yellow-600">Unit belum ditetapkan. Hubungi Admin.</p>
    <?php endif; ?>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="<?php echo e(route('tenant.assets.index')); ?>" class="block bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-blue-500">
        <h3 class="font-bold text-lg text-blue-600">Aset Unit Saya</h3>
        <p class="text-gray-600 text-sm mt-2">Lihat daftar fasilitas & aset di unit Anda.</p>
    </a>
    <a href="<?php echo e(route('tenant.complaints.create')); ?>" class="block bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-red-500">
        <h3 class="font-bold text-lg text-red-600">Laporkan Keluhan</h3>
        <p class="text-gray-600 text-sm mt-2">Buat laporan kerusakan baru dengan foto.</p>
    </a>
    <a href="<?php echo e(route('tenant.complaints.index')); ?>" class="block bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-green-500">
        <h3 class="font-bold text-lg text-green-600">Lacak Perbaikan</h3>
        <p class="text-gray-600 text-sm mt-2">Pantau status & timeline perbaikan Anda.</p>
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/tenant/dashboard.blade.php ENDPATH**/ ?>