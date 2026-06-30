<?php $__env->startSection('title', __('419 - Session Expired')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-amber-500 mb-4">419</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4"><?php echo e(__('Session Expired')); ?></h2>
        <p class="text-gray-600 mb-8"><?php echo e(__('Your session has expired. Please refresh the page and try again.')); ?></p>
        <a href="<?php echo e(url()->previous()); ?>" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-lg transition">
            <?php echo e(__('Try Again')); ?>

        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/errors/419.blade.php ENDPATH**/ ?>