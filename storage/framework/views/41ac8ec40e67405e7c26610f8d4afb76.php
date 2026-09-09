<?php $__env->startSection('content'); ?>
<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Login SIPEMA</h2>
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>
    <form action="/login" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-blue-500" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:border-blue-500" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">Login</button>
    </form>
    <div class="mt-4 text-sm text-gray-600">
        Hint login: admin@mail.com, tenant@mail.com, tech@mail.com, owner@mail.com. Pass: password
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\MSI\sistem-apartemen\resources\views/auth/login.blade.php ENDPATH**/ ?>