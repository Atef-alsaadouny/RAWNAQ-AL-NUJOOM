<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Assign Booking') . ': ' . $appointment->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Booking Details')); ?></h2>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-gray-500 text-sm"><?php echo e(__('Customer')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($appointment->customer_name); ?></span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm"><?php echo e(__('Service')); ?></span>
                <span class="text-gray-700"><?php echo e($appointment->display_services); ?></span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm"><?php echo e(__('Date')); ?></span>
                <span class="text-gray-700" dir="ltr"><?php echo e($appointment->appointment_date?->format('Y-m-d')); ?></span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm"><?php echo e(__('Shift')); ?></span>
                <span class="text-gray-700"><?php echo e($appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm"><?php echo e(__('Priority')); ?></span>
                <span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->display_priority === Appointment::PRIORITY_VIP): ?>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50"><?php echo e(__('Vip')); ?></span>
                    <?php elseif($appointment->display_priority === Appointment::PRIORITY_URGENT): ?>
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-slate-200/50"><?php echo e(__('Normal')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Assign To Employee')); ?></h2>
        </div>
        <div class="p-6">
            <form method="POST" action="<?php echo e(route('admin.appointments.assign.store', $appointment)); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="redirect_url" value="<?php echo e(url()->previous()); ?>">
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Select Employee')); ?></label>
                    <select name="employee_id" class="appearance-none bg-no-repeat w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition bg-[length:14px] bg-[center_right_8px] pr-8 !rtl:bg-[center_left_8px] !rtl:pr-4 !rtl:pl-8 bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22m6 9 6 6 6-6%22/%3E%3C/svg%3E')]">
                        <option value=""><?php echo e(__('Random')); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee_id') == $emp->id ? 'selected' : ''); ?>>
                            <?php echo e($emp->name); ?> (<?php echo e($emp->employee_id); ?>) - <?php echo e($emp->assigned_appointments_count); ?> <?php echo e(__('Active')); ?>

                        </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Time Optional')); ?></label>
                    <input type="time" name="assigned_time" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <p class="text-xs text-gray-400 mt-1"><?php echo e(__('Set Suitable Time')); ?></p>
                </div>
                <button type="submit" class="inline-flex items-center gap-1 bg-green-600 text-white px-6 py-2.5 rounded-xl hover:bg-green-700 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <?php echo e(__('Confirm Assignment')); ?>

                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/appointments/assign.blade.php ENDPATH**/ ?>