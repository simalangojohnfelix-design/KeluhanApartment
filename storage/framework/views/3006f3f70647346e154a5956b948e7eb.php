<?php $__env->startSection('content'); ?>
<!-- Bagian Header (Selaras dengan Dashboard) -->
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between border-b border-gray-200 pb-6" data-aos="fade-down">
    <div>
        <a href="<?php echo e(route('tenant.dashboard')); ?>" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition mb-2 inline-block" style="font-family: 'Inter', sans-serif;">&larr; Batal & Kembali ke Dasbor</a>
        <h2 class="text-3xl font-bold text-gray-800 mt-1" style="font-family: 'Playfair Display', serif;">Riwayat Keluhan</h2>
        <p class="text-gray-500 mt-1" style="font-family: 'Inter', sans-serif;">Lacak status perbaikan fasilitas unit Anda di sini.</p>
    </div>
    <a href="<?php echo e(route('tenant.complaints.create')); ?>" class="mt-4 md:mt-0 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-md inline-flex items-center">
        + Buat Laporan Baru
    </a>
</div>

<!-- Notifikasi Berhasil -->
<?php if(session('success')): ?>
<div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-8 font-medium" data-aos="fade-in" style="font-family: 'Inter', sans-serif;">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<!-- Daftar Keluhan -->
<div class="space-y-4" style="font-family: 'Inter', sans-serif;">
    <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row md:items-center justify-between group hover:shadow-md transition-all duration-300" data-aos="fade-up" data-aos-delay="<?php echo e($index * 50); ?>">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-xs font-bold tracking-widest uppercase text-gray-500"><?php echo e($c->category); ?></span>
                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                <!-- Indikator Warna Urgensi -->
                <span class="text-xs font-bold tracking-widest uppercase 
                    <?php echo e($c->urgency == 'high' ? 'text-red-600' : ($c->urgency == 'medium' ? 'text-yellow-600' : 'text-green-600')); ?>">
                    Urgensi: <?php echo e(ucfirst($c->urgency)); ?>

                </span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($c->title); ?></h3>
            <p class="text-gray-500 text-sm line-clamp-2"><?php echo e(Str::limit($c->description, 100)); ?></p>
        </div>
        
        <div class="mt-4 md:mt-0 md:ml-8 flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-4">
            <!-- Badge Status -->
            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 uppercase tracking-wide">
                <?php echo e($c->status); ?>

            </span>
            <a href="<?php echo e(route('tenant.complaints.show', $c->id)); ?>" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                Lihat Detail &rarr;
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <!-- Tampilan Jika Data Kosong -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-16 text-center" data-aos="fade-up">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <p class="text-gray-500 font-medium">Belum ada riwayat keluhan. Unit Anda dalam kondisi prima!</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/tenant/complaints/index.blade.php ENDPATH**/ ?>