<?php $__env->startSection('title', __('Payment Cancelled')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto px-4 py-6">
    <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-10 text-center">

        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-rose-400 to-amber-400 rounded-full flex items-center justify-center shadow-lg shadow-rose-200/50 mb-6">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2"><?php echo e(__('Payment Cancelled')); ?></h1>
        <p class="text-gray-500 mb-2"><?php echo e(__('Ticket Number')); ?>: <strong class="text-rose-600"><?php echo e($appointment->ticket_number); ?></strong></p>
        <p class="text-gray-400 text-sm mb-6"><?php echo e(__('No Amount Deducted')); ?></p>

        <div class="flex flex-col gap-3">
            <a href="<?php echo e(route('track.result', $appointment)); ?>" class="inline-flex items-center justify-center gap-2 bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 px-6 rounded-2xl font-bold shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <?php echo e(__('Back To Booking')); ?>

            </a>
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center justify-center gap-2 bg-white text-gray-600 border-2 border-gray-100 py-3.5 px-6 rounded-2xl font-bold hover:border-amber-200 hover:text-amber-600 transition-all duration-200">
                <?php echo e(__('Back To Home')); ?>

            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/payment/cancel.blade.php ENDPATH**/ ?>