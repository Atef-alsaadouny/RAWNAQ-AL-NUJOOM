<?php $__env->startSection('title', __('503 - Maintenance')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-gray-400 mb-4">503</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4"><?php echo e(__('Under Maintenance')); ?></h2>
        <p class="text-gray-600 mb-8"><?php echo e(__('We are currently performing maintenance. Please check back soon.')); ?></p>
        <a href="<?php echo e(url('/')); ?>" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-lg transition">
            <?php echo e(__('Refresh')); ?>

        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/errors/503.blade.php ENDPATH**/ ?>