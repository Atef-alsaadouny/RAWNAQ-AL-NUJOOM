<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Available Bookings')); ?>

<?php $__env->startSection('content'); ?>
<form method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
    <?php $selectedDate = request('date', now()->format('Y-m-d')); ?>
    <div class="flex flex-wrap items-center gap-3">
        <input type="date" name="date" value="<?php echo e($selectedDate); ?>" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none">
        <div class="flex gap-2">
            <a href="<?php echo e(route('employee.available', ['date' => now()->format('Y-m-d')])); ?>" class="px-4 py-2.5 rounded-xl text-sm font-medium transition <?php echo e($selectedDate === now()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>"><?php echo e(__('Today')); ?></a>
            <a href="<?php echo e(route('employee.available', ['date' => now()->addDay()->format('Y-m-d')])); ?>" class="px-4 py-2.5 rounded-xl text-sm font-medium transition <?php echo e($selectedDate === now()->addDay()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>"><?php echo e(__('Tomorrow')); ?></a>
        </div>
        <button type="submit" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-200 text-sm font-medium transition"><?php echo e(__('Filter')); ?></button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('date')): ?>
            <a href="<?php echo e(route('employee.available')); ?>" class="bg-white text-gray-500 px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm transition"><?php echo e(__('Clear Filter')); ?></a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class="flex items-stretch gap-2 md:gap-4 group">
        <div class="w-16 md:w-20 shrink-0 flex flex-col items-center justify-center rounded-xl md:rounded-2xl bg-amber-50 text-amber-700 text-center leading-tight text-xs md:text-base">
            <span class="text-sm md:text-lg font-bold"><?php echo e($apt->appointment_date?->format('d')); ?></span>
            <span class="text-[9px] md:text-[10px] font-medium opacity-75"><?php echo e($apt->appointment_date?->format('M')); ?></span>
            <span class="text-[9px] md:text-[10px] font-medium opacity-75"><?php echo e($apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
        </div>
        <div class="flex-1 bg-white border border-gray-100 rounded-xl md:rounded-2xl p-3 md:p-4 group-hover:shadow-md group-hover:border-blue-200 transition-all">
            <div class="flex items-center gap-2 mb-1">
                <span class="font-mono text-xs text-gray-400"><?php echo e($apt->ticket_number); ?></span>
                <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-yellow-200/50"><?php echo e(__('Pending')); ?></span>
            </div>
            <h3 class="font-bold text-gray-800 text-sm md:text-base mb-2"><?php echo e($apt->customer_name); ?></h3>

            <div class="space-y-1.5 text-xs md:text-sm text-gray-600 mb-3 md:mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2M3 8V6a1 1 0 011-1h16a1 1 0 011 1v2M5 8h14l-1.5 8H6.5L5 8z"/></svg>
                    <span><?php echo e($apt->display_services ?: '—'); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->notes): ?>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                    <span class="text-gray-500 truncate"><?php echo e($apt->notes); ?></span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <form method="POST" action="<?php echo e(route('employee.appointment.claim', $apt)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 md:py-2.5 rounded-xl hover:bg-blue-700 active:scale-[0.98] font-medium text-xs md:text-sm transition-all"><?php echo e(__('Claim Booking')); ?></button>
            </form>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-gray-500 text-lg"><?php echo e(__('No Available Bookings')); ?></p>
        <p class="text-gray-400 text-sm mt-1"><?php echo e(__('All Bookings Assigned Or Completed')); ?></p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="mt-6"><?php echo e($appointments->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.employee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/employee/available.blade.php ENDPATH**/ ?>