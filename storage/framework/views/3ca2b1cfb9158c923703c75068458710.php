<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold">Admin Dashboard</h1>
    <p class="text-gray-500 text-sm">Ringkasan operasional harian</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-yellow-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Keluhan Bulan Ini</p>
        <p class="text-3xl font-bold mt-1"><?php echo e($totalComplaints); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-red-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Menunggu Tindakan</p>
        <p class="text-3xl font-bold mt-1"><?php echo e($pendingComplaints); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-5 border-t-4 border-green-500">
        <p class="text-xs text-gray-500 uppercase font-medium">Total Biaya Perbaikan</p>
        <p class="text-3xl font-bold mt-1">Rp <?php echo e(number_format($totalRepairCost, 0, ',', '.')); ?></p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-xs text-gray-500 uppercase font-medium">Total Aset Terdaftar</p>
        <p class="text-3xl font-bold mt-1"><?php echo e($totalAssets); ?></p>
        <?php if($badAssets > 0): ?>
            <p class="text-sm text-red-600 mt-1">? <?php echo e($badAssets); ?> aset butuh perhatian</p>
        <?php else: ?>
            <p class="text-sm text-green-600 mt-1">? Semua aset dalam kondisi baik</p>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="<?php echo e(route('admin.complaints.index')); ?>" class="block bg-blue-600 text-white rounded-lg p-4 text-center font-bold hover:bg-blue-700 transition">
       <div class="mt-1">Kelola Keluhan</div>
    </a>
    <a href="<?php echo e(route('admin.units.index')); ?>" class="block bg-green-600 text-white rounded-lg p-4 text-center font-bold hover:bg-green-700 transition">
       <div class="mt-1">Kelola Unit</div>
    </a>
    <a href="<?php echo e(route('admin.assets.index')); ?>" class="block bg-yellow-600 text-white rounded-lg p-4 text-center font-bold hover:bg-yellow-700 transition">
       <div class="mt-1">Kelola Aset</div>
    </a>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="block bg-gray-600 text-white rounded-lg p-4 text-center font-bold hover:bg-gray-700 transition">
       <div class="mt-1">Kelola Pengguna</div>
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>