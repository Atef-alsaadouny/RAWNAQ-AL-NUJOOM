<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Booking') . ': ' . $appointment->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Details')); ?></h2>
            <span class="font-mono text-amber-700 font-bold tracking-wide"><?php echo e($appointment->ticket_number); ?></span>
        </div>
        <div class="p-6 divide-y divide-gray-50">
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Customer')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($appointment->customer_name ?? $appointment->customer?->name ?? '—'); ?></span>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Phone')); ?></span>
                <span class="text-gray-700" dir="ltr"><?php echo e($appointment->customer_phone); ?></span>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Service')); ?></span>
                <span class="text-gray-700"><?php echo e($appointment->display_services ?: __('Unspecified')); ?></span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->packages->isNotEmpty()): ?>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Package')); ?></span>
                <span class="font-bold text-rose-600"><?php echo e($appointment->packages->pluck('name')->implode(' + ')); ?></span>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex justify-between py-2.5 items-center">
                <span class="text-gray-500 text-sm"><?php echo e(__('Employee')); ?></span>
                <div class="flex items-center gap-2">
                    <span class="text-gray-700"><?php echo e($appointment->employee?->name ?? __('Unassigned')); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->status === Appointment::STATUS_PENDING || $appointment->status === Appointment::STATUS_ASSIGNED || $appointment->status === Appointment::STATUS_IN_PROGRESS): ?>
                    <?php $emps = \App\Models\User::where('business_id', auth()->user()->business_id)->where('role', 'employee')->where('is_active', true)->get(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($emps->isNotEmpty()): ?>
                    <form method="POST" action="<?php echo e(route('admin.appointments.assign.store', $appointment)); ?>" class="flex items-center gap-1.5">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="redirect_url" value="<?php echo e(url()->current()); ?>">
                        <select name="employee_id" class="border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition" style="padding-inline-end: <?php echo e(app()->getLocale() === 'en' ? '10px' : '0px'); ?>;">
                            <option value=""><?php echo e(__('Random')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $emps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($emp->id); ?>" <?php echo e($appointment->employee_id == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                        <button type="submit" onclick="return window.inlineConfirm(this, event, '<?php echo e(__("Confirm Change Employee")); ?>?')" class="text-xs text-amber-700 bg-amber-50 hover:bg-amber-100 px-2 py-1 rounded-lg font-medium transition-colors whitespace-nowrap"><?php echo e(__('Change')); ?></button>
                    </form>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Date')); ?></span>
                <span class="text-gray-700" dir="ltr"><?php echo e($appointment->appointment_date?->format('Y-m-d')); ?></span>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Shift')); ?></span>
                <span class="text-gray-700"><?php echo e($appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->assigned_time): ?>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-500 text-sm"><?php echo e(__('Time')); ?></span>
                <span class="font-bold text-gray-700"><?php echo e($appointment->assigned_time); ?></span>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex justify-between py-2.5 items-center">
                <span class="text-gray-500 text-sm"><?php echo e(__('Priority')); ?></span>
                <span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->display_priority === Appointment::PRIORITY_VIP): ?>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50"><?php echo e(__('Vip')); ?></span>
                    <?php elseif($appointment->display_priority === Appointment::PRIORITY_URGENT): ?>
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-slate-200/50"><?php echo e(__('Normal')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
            </div>
            <div class="flex justify-between py-2.5 items-center">
                <span class="text-gray-500 text-sm"><?php echo e(__('Status')); ?></span>
                <span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($appointment->status):
                        case (Appointment::STATUS_PENDING): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->appointment_date?->isPast()): ?>
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
                </span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->notes): ?>
            <div class="py-2.5">
                <span class="text-gray-500 text-sm block mb-1"><?php echo e(__('Notes')); ?></span>
                <p class="text-gray-700 bg-gray-50 rounded-lg px-3 py-2 text-sm"><?php echo e($appointment->notes); ?></p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->cancel_reason): ?>
            <div class="py-2.5">
                <span class="text-gray-500 text-sm block mb-1"><?php echo e(__('Cancel Reason')); ?></span>
                <p class="text-red-700 bg-red-50 rounded-lg px-3 py-2 text-sm"><?php echo e($appointment->cancel_reason); ?></p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php $payment = $appointment->payment; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment): ?>
            <div class="border-t border-gray-50 mt-2 pt-2 px-6 pb-6">
                <div class="flex justify-between py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Payment Method')); ?></span>
                    <span class="font-bold text-gray-700"><?php echo e($payment->method === \App\Models\Payment::METHOD_KNET ? __('KNET') : ($payment->method === \App\Models\Payment::METHOD_APPLE_PAY ? __('Apple Pay') : ($payment->method === \App\Models\Payment::METHOD_GOOGLE_PAY ? __('Google Pay') : __('Cash')))); ?></span>
                </div>
                <div class="flex justify-between py-2.5 items-center">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Payment Status')); ?></span>
                    <span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->isPaid()): ?>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50"><?php echo e(__('Paid')); ?> ✓</span>
                        <?php elseif($payment->status === \App\Models\Payment::STATUS_FAILED): ?>
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50"><?php echo e(__('Failed')); ?></span>
                        <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-amber-200/50"><?php echo e(__('Unpaid')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->paid_at): ?>
                <div class="flex justify-between py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Payment Date')); ?></span>
                    <span class="text-gray-700 text-sm" dir="ltr"><?php echo e($payment->paid_at->format('Y-m-d H:i')); ?></span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->transaction_id): ?>
                <div class="flex justify-between py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Transaction Id')); ?></span>
                    <span class="text-gray-700 text-xs font-mono" dir="ltr"><?php echo e($payment->transaction_id); ?></span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="flex justify-between py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Amount')); ?></span>
                    <span class="font-bold text-gray-800"><?php echo e(formatCurrency($payment->amount)); ?></span>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 flex gap-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->status === Appointment::STATUS_PENDING): ?>
            <a href="<?php echo e(route('admin.appointments.assign', $appointment)); ?>" class="inline-flex items-center gap-1.5 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <?php echo e(__('Assign To Employee')); ?>

            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->status === Appointment::STATUS_CANCELLED): ?>
            <a href="<?php echo e(route('admin.appointments.rebook', $appointment)); ?>" class="inline-flex items-center gap-1.5 bg-rose-600 text-white px-4 py-2 rounded-lg hover:bg-rose-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <?php echo e(__('Rebook')); ?>

            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($appointment->status, [Appointment::STATUS_COMPLETED, Appointment::STATUS_CANCELLED])): ?>
            <a href="<?php echo e(route('admin.appointments.edit', $appointment)); ?>" class="inline-flex items-center gap-1.5 bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <?php echo e(__('Edit')); ?>

            </a>
            <form method="POST" action="<?php echo e(route('admin.appointments.cancel', $appointment)); ?>" class="inline" onsubmit="return confirm('<?php echo e(__('Are you sure?')); ?>')">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <?php echo e(__('Cancel')); ?>

                </button>
            </form>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="space-y-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->rating): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Customer Rating')); ?></h2>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-4xl font-bold text-amber-600"><?php echo e($appointment->rating->rating); ?></span>
                    <div class="flex gap-0.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg class="w-5 h-5 <?php echo e($i <= $appointment->rating->rating ? 'text-amber-400' : 'text-gray-200'); ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->rating->comment): ?>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-700 text-sm leading-relaxed">"<?php echo e($appointment->rating->comment); ?>"</p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Activity Log')); ?></h2>
            </div>
            <div class="p-6">
                <div class="space-y-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $appointment->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex items-start gap-3 py-3 <?php echo e(!$loop->last ? 'border-b border-gray-50' : ''); ?>">
                        <div class="w-2 h-2 rounded-full bg-amber-400 mt-1.5 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 text-sm">
                                <span class="font-bold text-gray-800"><?php echo e($log->actionBy?->name); ?></span>
                                <span class="text-gray-300">•</span>
                                <span class="text-gray-500" dir="ltr"><?php echo e($log->created_at->format('H:i')); ?></span>
                            </div>
                            <div class="text-sm mt-0.5">
                                <span class="text-gray-500"><?php echo e(__('Changed Status To')); ?></span>
                                <span class="font-bold text-gray-700 mr-1">
                                    <?php $sMap = [Appointment::STATUS_PENDING=>__('Pending'),Appointment::STATUS_ASSIGNED=>__('Assigned'),Appointment::STATUS_IN_PROGRESS=>__('In Progress'),Appointment::STATUS_COMPLETED=>__('Completed'),Appointment::STATUS_CANCELLED=>__('Cancelled')]; ?>
                                    <?php echo e($sMap[$log->new_status] ?? $log->new_status); ?>

                                </span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->notes): ?>
                                <span class="text-gray-400 text-xs block mt-0.5"><?php echo e($log->notes); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="flex flex-col items-center gap-2 py-8 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm"><?php echo e(__('No Activity')); ?></p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/appointments/show.blade.php ENDPATH**/ ?>