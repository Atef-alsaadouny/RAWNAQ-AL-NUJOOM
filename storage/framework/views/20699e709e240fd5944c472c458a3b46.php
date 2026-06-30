<?php $__env->startSection('page-title', __('Profile')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm">
    <div class="space-y-3">
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600"><?php echo e(__('Name')); ?></span>
            <span class="font-bold"><?php echo e(auth()->user()->name); ?></span>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600"><?php echo e(__('Email')); ?></span>
            <span><?php echo e(auth()->user()->email); ?></span>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600"><?php echo e(__('Phone')); ?></span>
            <span><?php echo e(auth()->user()->phone ?? '—'); ?></span>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/profile.blade.php ENDPATH**/ ?>