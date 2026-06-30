<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Appointments')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4 flex gap-4">
    <a href="<?php echo e(route('admin.appointments.create')); ?>" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">
        + <?php echo e(__('New Booking')); ?>

    </a>
</div>

<!-- Filters -->
<form method="GET" class="bg-white p-4 rounded-xl shadow-sm mb-4">
    <div class="flex flex-wrap items-center gap-3">
        <select name="status" data-auto-submit class="border rounded-lg px-3 py-2 text-sm" style="padding-right: 30px;">
            <option value=""><?php echo e(__('All Statuses')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_PENDING); ?>" <?php echo e(request('status') === Appointment::STATUS_PENDING ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_EXPIRED); ?>" <?php echo e(request('status') === Appointment::STATUS_EXPIRED ? 'selected' : ''); ?>><?php echo e(__('Expired')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_ASSIGNED); ?>" <?php echo e(request('status') === Appointment::STATUS_ASSIGNED ? 'selected' : ''); ?>><?php echo e(__('Assigned')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_IN_PROGRESS); ?>" <?php echo e(request('status') === Appointment::STATUS_IN_PROGRESS ? 'selected' : ''); ?>><?php echo e(__('In Progress')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_COMPLETED); ?>" <?php echo e(request('status') === Appointment::STATUS_COMPLETED ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
            <option value="<?php echo e(Appointment::STATUS_CANCELLED); ?>" <?php echo e(request('status') === Appointment::STATUS_CANCELLED ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
        </select>
        <select name="priority" data-auto-submit class="border rounded-lg px-3 py-2 text-sm" style="padding-right: 30px;">
            <option value=""><?php echo e(__('All Priorities')); ?></option>
            <option value="<?php echo e(Appointment::PRIORITY_NORMAL); ?>" <?php echo e(request('priority') === Appointment::PRIORITY_NORMAL ? 'selected' : ''); ?>><?php echo e(__('Normal')); ?></option>
            <option value="<?php echo e(Appointment::PRIORITY_URGENT); ?>" <?php echo e(request('priority') === Appointment::PRIORITY_URGENT ? 'selected' : ''); ?>><?php echo e(__('Urgent')); ?></option>
            <option value="<?php echo e(Appointment::PRIORITY_VIP); ?>" <?php echo e(request('priority') === Appointment::PRIORITY_VIP ? 'selected' : ''); ?>><?php echo e(__('Vip')); ?></option>
        </select>
        <select name="employee_id" data-auto-submit class="border rounded-lg px-3 py-2 text-sm" style="padding-right: 30px;">
            <option value=""><?php echo e(__('All Employees')); ?></option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <option value="<?php echo e($emp->id); ?>" <?php echo e(request('employee_id') == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>
        <input type="date" name="date" value="<?php echo e(request('date')); ?>" data-auto-submit class="border rounded-lg px-3 py-2 text-sm">
        <div class="flex gap-1">
            <a href="<?php echo e(route('admin.appointments.index', array_merge(request()->only('status', 'priority', 'employee_id'), ['date' => now()->format('Y-m-d')]))); ?>" class="px-3 py-2 rounded-lg text-sm font-medium transition <?php echo e(request('date') === now()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>"><?php echo e(__('Today')); ?></a>
            <a href="<?php echo e(route('admin.appointments.index', array_merge(request()->only('status', 'priority', 'employee_id'), ['date' => now()->addDay()->format('Y-m-d')]))); ?>" class="px-3 py-2 rounded-lg text-sm font-medium transition <?php echo e(request('date') === now()->addDay()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>"><?php echo e(__('Tomorrow')); ?></a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('status') || request('priority') || request('employee_id') || request('date')): ?>
            <a href="<?php echo e(route('admin.appointments.index')); ?>" class="bg-white text-gray-500 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm"><?php echo e(__('Clear Filter')); ?></a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</form>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Ticket')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Customer')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Employee')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Price')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Payment')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Date')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Shift')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Priority')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Status')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Rating')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Actions')); ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr class="hover:bg-amber-50/30 transition-colors <?php echo e($loop->even ? 'bg-amber-50/20' : ''); ?>">
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-mono font-medium text-gray-500"><?php echo e($apt->ticket_number); ?></span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-medium text-gray-800"><?php echo e($apt->customer_name ?? $apt->customer?->name ?? '—'); ?></span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="text-gray-600"><?php echo e($apt->employee?->name ?? '—'); ?></span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-bold text-amber-700"><?php echo e(formatCurrency($apt->total_price)); ?></span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <?php $_p = $apt->payment; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($_p && $_p->isPaid()): ?>
                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-xs font-bold leading-none border border-emerald-200/50"><?php echo e(__('Paid')); ?></span>
                    <?php elseif($_p): ?>
                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2 py-0.5 rounded-lg text-xs font-bold leading-none border border-amber-200/50"><?php echo e($_p->method === \App\Models\Payment::METHOD_CASH ? __('Cash') : __('Unpaid')); ?></span>
                    <?php else: ?>
                    <span class="text-xs text-gray-400">—</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span dir="ltr"><?php echo e($apt->appointment_date?->format('Y-m-d')); ?></span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span><?php echo e($apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->display_priority === Appointment::PRIORITY_VIP): ?>
                    <span class="bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded-lg text-xs font-bold"><?php echo e(__('Vip')); ?></span>
                    <?php elseif($apt->display_priority === Appointment::PRIORITY_URGENT): ?>
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-slate-200/50"><?php echo e(__('Normal')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($apt->status):
                        case (Appointment::STATUS_PENDING): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->appointment_date?->isPast()): ?>
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none"><?php echo e(__('Missed')); ?></span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-yellow-200/50"><?php echo e(__('Pending')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->status === Appointment::STATUS_COMPLETED && $apt->rating): ?>
                    <span class="text-yellow-500 font-bold whitespace-nowrap"><?php echo e($apt->rating->rating); ?>★</span>
                    <?php else: ?>
                    <span class="text-gray-300">—</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <div class="flex items-center gap-2 justify-start">
                        <a href="<?php echo e(route('admin.appointments.show', $apt)); ?>" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <?php echo e(__('View')); ?>

                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->status === Appointment::STATUS_PENDING): ?>
                        <a href="<?php echo e(route('admin.appointments.assign', $apt)); ?>" class="inline-flex items-center gap-1 text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <?php echo e(__('Assign')); ?>

                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="11" class="text-center px-5 py-16 text-sm text-gray-400"><?php echo e(__('No Appointments')); ?></td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-4">
    <?php echo e($appointments->links()); ?>

</div>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/appointments/index.blade.php ENDPATH**/ ?>