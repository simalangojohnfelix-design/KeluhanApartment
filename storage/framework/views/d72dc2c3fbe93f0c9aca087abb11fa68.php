<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Pemeliharaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-blue-800 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center text-white">
            <a href="#" class="font-bold text-xl">SIPEMA</a>
            <div>
                <?php if(auth()->guard()->check()): ?>
                    <span class="mr-4">Halo, <?php echo e(auth()->user()->name); ?> (<?php echo e(auth()->user()->role); ?>)</span>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-8 px-4">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html>
<?php /**PATH D:\MSI\sistem-apartemen\resources\views/layouts/app.blade.php ENDPATH**/ ?>