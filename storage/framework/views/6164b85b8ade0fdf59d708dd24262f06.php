<?php $__env->startSection('title', __('404 - Page Not Found')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-brand-500 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4"><?php echo e(__('Page Not Found')); ?></h2>
        <p class="text-gray-600 mb-8"><?php echo e(__('The page you are looking for does not exist or has been moved.')); ?></p>
        <a href="<?php echo e(url('/')); ?>" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-lg transition">
            <?php echo e(__('Back to Home')); ?>

        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/errors/404.blade.php ENDPATH**/ ?>