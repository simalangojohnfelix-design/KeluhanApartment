<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded shadow max-w-xl mx-auto">
    <div class="mb-5">
        <a href="<?php echo e(route('tenant.complaints.index')); ?>" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
        <h2 class="text-xl font-bold mt-1">Buat Keluhan Baru</h2>
    </div>
    <?php if(session('success')): ?><div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo e(session('success')); ?></div><?php endif; ?>
    <?php if($errors->any()): ?><div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm"><ul class="list-disc pl-4"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
    <form action="<?php echo e(route('tenant.complaints.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block text-sm font-medium text-gray-700">Judul Masalah <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="<?php echo e(old('title')); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Aset / Fasilitas Bermasalah</label>
            <select name="asset_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <option value="">-- Tidak ada aset spesifik --</option>
                <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($asset->id); ?>" <?php echo e(old('asset_id') == $asset->id ? 'selected' : ''); ?>>
                        <?php echo e($asset->name); ?><?php echo e($asset->category ? ' (' . $asset->category . ')' : ''); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <p class="text-xs text-gray-400 mt-1">Daftar aset berdasarkan inventaris unit Anda.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori Masalah <span class="text-red-500">*</span></label>
            <select name="category" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                <option value="">-- Pilih Kategori --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat); ?>" <?php echo e(old('category') == $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Tingkat Urgensi <span class="text-red-500">*</span></label>
            <div class="mt-1 grid grid-cols-3 gap-3">
                <label class="flex items-center gap-2 border rounded p-3 cursor-pointer hover:bg-green-50 <?php echo e(old('urgency','low')=='low'?'border-green-500 bg-green-50':''); ?>">
                    <input type="radio" name="urgency" value="low" <?php echo e(old('urgency','low')=='low'?'checked':''); ?> class="text-green-500"> <span class="text-sm">Rendah</span>
                </label>
                <label class="flex items-center gap-2 border rounded p-3 cursor-pointer hover:bg-yellow-50 <?php echo e(old('urgency')=='medium'?'border-yellow-500 bg-yellow-50':''); ?>">
                    <input type="radio" name="urgency" value="medium" <?php echo e(old('urgency')=='medium'?'checked':''); ?> class="text-yellow-500"> <span class="text-sm">Sedang</span>
                </label>
                <label class="flex items-center gap-2 border rounded p-3 cursor-pointer hover:bg-red-50 <?php echo e(old('urgency')=='high'?'border-red-500 bg-red-50':''); ?>">
                    <input type="radio" name="urgency" value="high" <?php echo e(old('urgency')=='high'?'checked':''); ?> class="text-red-500"> <span class="text-sm">Darurat</span>
                </label>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi Detail <span class="text-red-500">*</span></label>
            <textarea name="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Jelaskan masalah secara detail..." required><?php echo e(old('description')); ?></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Foto Bukti Kerusakan</label>
            <input type="file" name="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
            <p class="text-xs text-gray-400 mt-1">Maks. 5MB. Format: JPG, PNG, WEBP.</p>
        </div>
        <button type="submit" class="w-full bg-red-600 text-white py-2.5 px-4 rounded font-bold hover:bg-red-700">Kirim Keluhan</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/tenant/complaints/create.blade.php ENDPATH**/ ?>