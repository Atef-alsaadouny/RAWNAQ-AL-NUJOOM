<?php use App\Models\Appointment; ?>


<?php $__env->startSection('title', __('My Bookings')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><?php echo e(__('My Bookings')); ?></h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <a href="<?php echo e(route('customer.appointment.show', $apt)); ?>"
       class="block bg-white rounded-[2rem] shadow-sm border border-rose-100 p-5 mb-4 hover:shadow-md hover:border-amber-200 transition-all duration-200 group">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-amber-100 to-rose-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800"><?php echo e($apt->display_services ?: __('Booking')); ?></p>
                    <p class="text-sm text-gray-500" dir="ltr"><?php echo e($apt->appointment_date?->format('Y-m-d')); ?></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($apt->status):
                    case (Appointment::STATUS_PENDING): ?> <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-xs font-medium"><?php echo e(__('Pending')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_ASSIGNED): ?> <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-xs font-medium"><?php echo e(__('Assigned')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_IN_PROGRESS): ?> <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-lg text-xs font-medium"><?php echo e(__('In Progress')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_COMPLETED): ?> <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-xs font-medium"><?php echo e(__('Completed')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_CANCELLED): ?> <span class="bg-red-100 text-red-800 px-3 py-1 rounded-lg text-xs font-medium"><?php echo e(__('Cancelled')); ?></span> <?php break; ?>
                <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-4 text-sm text-gray-500">
            <span class="inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <?php echo e($apt->employee?->name ?? '—'); ?>

            </span>
            <span class="inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e($apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?>

            </span>
            <span class="inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <?php echo e($apt->ticket_number); ?>

            </span>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->status === Appointment::STATUS_COMPLETED && !$apt->rating): ?>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <span class="text-amber-600 text-sm font-medium inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <?php echo e(__('Click on the booking to rate it')); ?>

            </span>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </a>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <div class="bg-white rounded-[2rem] shadow-sm border border-rose-100 p-12 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-rose-50 flex items-center justify-center">
            <svg class="w-8 h-8 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <p class="text-gray-500 text-lg mb-2"><?php echo e(__('You have no bookings yet')); ?> 😊</p>
        <p class="text-gray-400 text-sm mb-6"><?php echo e(__('Book your first appointment and enjoy a premium experience')); ?></p>
        <a href="<?php echo e(route('book')); ?>" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-gradient-to-l from-amber-500 to-amber-600 text-white rounded-xl text-sm font-medium shadow-sm shadow-amber-200 hover:from-amber-600 hover:to-amber-700 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <?php echo e(__('Book Now')); ?>

        </a>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="mt-6">
        <?php echo e($appointments->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/customer/appointments.blade.php ENDPATH**/ ?>