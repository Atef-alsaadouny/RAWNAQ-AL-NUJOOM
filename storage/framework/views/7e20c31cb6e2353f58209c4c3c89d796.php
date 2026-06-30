<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('My Bookings')); ?>

<?php $__env->startSection('content'); ?>
<form method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <select name="status" data-auto-submit class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none" style="padding-right: 30px;">
            <option value=""><?php echo e(__('All Statuses')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_PENDING); ?>" <?php echo e(request('status') === Appointment::STATUS_PENDING ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_EXPIRED); ?>" <?php echo e(request('status') === Appointment::STATUS_EXPIRED ? 'selected' : ''); ?>><?php echo e(__('Expired')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_ASSIGNED); ?>" <?php echo e(request('status') === Appointment::STATUS_ASSIGNED ? 'selected' : ''); ?>><?php echo e(__('Assigned')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_IN_PROGRESS); ?>" <?php echo e(request('status') === Appointment::STATUS_IN_PROGRESS ? 'selected' : ''); ?>><?php echo e(__('In Progress')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_COMPLETED); ?>" <?php echo e(request('status') === Appointment::STATUS_COMPLETED ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_CANCELLED); ?>" <?php echo e(request('status') === Appointment::STATUS_CANCELLED ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
        </select>
        <select name="priority" data-auto-submit class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none" style="padding-right: 30px;">
            <option value=""><?php echo e(__('All Priorities')); ?></option>
            <option value="<?php echo e(Appointment::PRIORITY_NORMAL); ?>" <?php echo e(request('priority') === Appointment::PRIORITY_NORMAL ? 'selected' : ''); ?>><?php echo e(__('Normal')); ?></option>
            <option value="<?php echo e(Appointment::PRIORITY_URGENT); ?>" <?php echo e(request('priority') === Appointment::PRIORITY_URGENT ? 'selected' : ''); ?>><?php echo e(__('Urgent')); ?></option>
            <option value="<?php echo e(Appointment::PRIORITY_VIP); ?>" <?php echo e(request('priority') === Appointment::PRIORITY_VIP ? 'selected' : ''); ?>><?php echo e(__('Vip')); ?></option>
        </select>
        <input type="date" name="date" value="<?php echo e(request('date')); ?>" data-auto-submit class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none">
        <div class="flex gap-2">
            <a href="<?php echo e(route('employee.appointments', array_merge(request()->only('status', 'priority'), ['date' => now()->format('Y-m-d')]))); ?>" class="px-4 py-2.5 rounded-xl text-sm font-medium transition <?php echo e(request('date') === now()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>"><?php echo e(__('Today')); ?></a>
            <a href="<?php echo e(route('employee.appointments', array_merge(request()->only('status', 'priority'), ['date' => now()->addDay()->format('Y-m-d')]))); ?>" class="px-4 py-2.5 rounded-xl text-sm font-medium transition <?php echo e(request('date') === now()->addDay()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>"><?php echo e(__('Tomorrow')); ?></a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('status') || request('priority') || request('date')): ?>
            <a href="<?php echo e(route('employee.appointments')); ?>" class="bg-white text-gray-500 px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm transition"><?php echo e(__('Clear Filter')); ?></a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</form>

<div class="space-y-3">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <a href="<?php echo e(route('employee.appointment.show', $apt)); ?>" class="flex items-stretch gap-2 md:gap-4 group">
        <div class="w-16 md:w-20 shrink-0 flex flex-col items-center justify-center rounded-xl md:rounded-2xl text-center leading-tight text-xs md:text-base
            <?php switch($apt->status):
                case (Appointment::STATUS_COMPLETED): ?> bg-teal-50 text-teal-700 <?php break; ?>
                <?php case (Appointment::STATUS_IN_PROGRESS): ?> bg-purple-50 text-purple-700 <?php break; ?>
                <?php case (Appointment::STATUS_CANCELLED): ?> bg-red-50 text-red-700 <?php break; ?>
                <?php default: ?> bg-amber-50 text-amber-700 <?php endswitch; ?>">
            <span class="text-sm md:text-lg font-bold"><?php echo e($apt->appointment_date?->format('d')); ?></span>
            <span class="text-[9px] md:text-[10px] font-medium opacity-75"><?php echo e($apt->appointment_date?->format('M')); ?></span>
            <span class="text-[9px] md:text-[10px] font-medium opacity-75"><?php echo e($apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
        </div>
        <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between bg-white border border-gray-100 rounded-xl md:rounded-2xl px-3 md:px-5 py-2.5 md:py-3.5 group-hover:shadow-md group-hover:border-gray-200 transition-all gap-1.5 md:gap-0">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="font-mono text-xs text-gray-400"><?php echo e($apt->ticket_number); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->display_priority === Appointment::PRIORITY_VIP): ?>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-emerald-200/50"><?php echo e(__('Vip')); ?></span>
                    <?php elseif($apt->display_priority === Appointment::PRIORITY_URGENT): ?>
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="font-bold text-gray-800 truncate"><?php echo e($apt->customer_name ?? $apt->customer?->name ?? '—'); ?></div>
                <div class="text-xs text-gray-500 truncate"><?php echo e($apt->display_services ?: '—'); ?></div>
            </div>
            <div class="shrink-0 md:mr-3 flex items-center gap-2 self-stretch md:self-auto">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->rating?->rating): ?>
                <span class="text-yellow-500 text-sm font-bold"><?php echo e($apt->rating->rating); ?>★</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($apt->status):
                    case (Appointment::STATUS_ASSIGNED): ?> <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-blue-200/50"><?php echo e(__('Assigned')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_IN_PROGRESS): ?> <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-purple-200/50"><?php echo e(__('In Progress')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_COMPLETED): ?> <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-teal-200/50"><?php echo e(__('Completed')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_CANCELLED): ?> <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-red-200/50"><?php echo e(__('Cancelled')); ?></span> <?php break; ?>
                <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </a>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-gray-500 text-lg"><?php echo e(__('No Bookings')); ?></p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<div class="mt-6"><?php echo e($appointments->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('change', function(e) {
    if (e.target.matches('[data-auto-submit]')) {
        e.target.form.submit();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.employee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/employee/appointments.blade.php ENDPATH**/ ?>