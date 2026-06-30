<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', $customer->name); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Customer Data')); ?></h2>
        </div>
        <div class="divide-y divide-gray-50">
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Name')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($customer->name); ?></span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Email')); ?></span>
                <span class="text-gray-700"><?php echo e($customer->email ?? '—'); ?></span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Phone')); ?></span>
                <span class="text-gray-700"><?php echo e($customer->phone ?? '—'); ?></span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Total Bookings')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($customer->appointments->count()); ?></span>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-50">
            <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="inline-flex items-center gap-1 bg-amber-600 text-white px-4 py-2 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <?php echo e(__('Edit Customer Data')); ?>

            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Bookings')); ?></h2>
        </div>
        <div class="divide-y divide-gray-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $customer->appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="px-6 py-3.5">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-sm font-medium text-gray-500"><?php echo e($apt->ticket_number); ?></span>
                    <span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($apt->status):
                            case (Appointment::STATUS_PENDING): ?>
                                <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-yellow-200/50"><?php echo e(__('Pending')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_ASSIGNED): ?>
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50"><?php echo e(__('Assigned')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_IN_PROGRESS): ?>
                                <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-purple-200/50"><?php echo e(__('In Progress')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_COMPLETED): ?>
                                <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-teal-200/50"><?php echo e(__('Completed')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_CANCELLED): ?>
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50"><?php echo e(__('Cancelled')); ?></span>
                                <?php break; ?>
                        <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                </div>
                <div class="text-sm text-gray-400 mt-1"><?php echo e($apt->appointment_date?->format('Y-m-d')); ?></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="px-6 py-8 text-center">
                <div class="flex flex-col items-center gap-2 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm"><?php echo e(__('No Bookings')); ?></p>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/customers/show.blade.php ENDPATH**/ ?>