<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Booking') . ': ' . $appointment->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-4 md:px-6 py-3 md:py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center justify-center bg-amber-100 text-amber-700 rounded-xl px-3 py-1.5 text-center leading-tight">
                    <span class="text-lg font-bold"><?php echo e($appointment->appointment_date?->format('d')); ?></span>
                    <span class="text-[10px] font-medium opacity-75"><?php echo e($appointment->appointment_date?->format('M')); ?></span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-sm text-gray-400"><?php echo e($appointment->ticket_number); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->display_priority === Appointment::PRIORITY_VIP): ?>
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-emerald-200/50"><?php echo e(__('Vip')); ?></span>
                        <?php elseif($appointment->display_priority === Appointment::PRIORITY_URGENT): ?>
                            <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800"><?php echo e($appointment->customer_name ?? $appointment->customer?->name ?? '—'); ?></h1>
                    <div class="text-sm text-gray-500"><?php echo e($appointment->customer_phone); ?></div>
                </div>
            </div>
            <div class="shrink-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($appointment->status):
                    case (Appointment::STATUS_ASSIGNED): ?> <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50"><?php echo e(__('Assigned')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_IN_PROGRESS): ?> <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-purple-200/50"><?php echo e(__('In Progress')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_COMPLETED): ?> <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-teal-200/50"><?php echo e(__('Completed')); ?></span> <?php break; ?>
                    <?php case (Appointment::STATUS_CANCELLED): ?> <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50"><?php echo e(__('Cancelled')); ?></span> <?php break; ?>
                <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-l from-amber-50 to-white px-4 md:px-5 py-3 md:py-3.5 border-b border-gray-100">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->appointment_date?->isBefore(now()->startOfDay()) && in_array($appointment->status, Appointment::EDITABLE_STATUSES)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4 mb-4 text-sm font-bold">
                <?php echo e(__('This booking date has passed')); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php echo e(__('Booking Details')); ?>

                </h2>
            </div>
            <div class="p-4 md:p-5 divide-y divide-gray-50">
                <div class="py-2.5">
                    <span class="text-gray-500 text-sm block mb-1"><?php echo e(__('Services & Packages')); ?></span>
                    <div class="space-y-1.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $appointment->packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
                            <span class="font-medium text-gray-800"><?php echo e($pkg->name); ?></span>
                            <span class="text-[10px] bg-amber-50 text-amber-700 px-1.5 py-0.5 rounded font-bold"><?php echo e(__('Package')); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $appointment->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php $inPackage = $appointment->packages->contains(fn($p) => $p->services->contains($svc->id)); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$inPackage): ?>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                            <span class="font-medium text-gray-800"><?php echo e($svc->name); ?></span>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->packages->isEmpty() && $appointment->services->isEmpty()): ?>
                        <span class="text-gray-400"><?php echo e(__('Not Specified')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Date')); ?></span>
                    <span class="font-medium text-gray-800 text-left" dir="ltr"><?php echo e($appointment->appointment_date?->format('Y-m-d')); ?></span>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Shift')); ?></span>
                    <span class="font-medium text-gray-800"><?php echo e($appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-gray-500 text-sm"><?php echo e(__('Time')); ?></span>
                    <span class="font-bold text-gray-800"><?php echo e($appointment->assigned_time ?? __('Not Specified')); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->notes): ?>
                <div class="py-2.5">
                    <span class="text-gray-500 text-sm block mb-1"><?php echo e(__('Notes')); ?></span>
                    <p class="text-gray-700 bg-gray-50 rounded-lg p-3 text-sm"><?php echo e($appointment->notes); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->cancel_reason): ?>
                <div class="py-2.5">
                    <span class="text-gray-500 text-sm block mb-1"><?php echo e(__('Cancel Reason')); ?></span>
                    <p class="text-red-700 bg-red-50 rounded-lg p-3 text-sm"><?php echo e($appointment->cancel_reason); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->status === Appointment::STATUS_ASSIGNED && $appointment->appointment_date?->isToday()): ?>
            <div class="px-4 md:px-5 py-3 md:py-4 border-t border-gray-100 bg-gray-50/30">
                <form method="POST" action="<?php echo e(route('employee.appointment.status', $appointment)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="status" value="<?php echo e(Appointment::STATUS_IN_PROGRESS); ?>">
                    <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2.5 rounded-xl font-bold hover:bg-purple-700 active:scale-[0.98] transition-all"><?php echo e(__('Start Service')); ?></button>
                </form>
            </div>
            <?php elseif($appointment->status === Appointment::STATUS_IN_PROGRESS): ?>
            <div class="px-4 md:px-5 py-3 md:py-4 border-t border-gray-100 bg-gray-50/30">
                <form method="POST" action="<?php echo e(route('employee.appointment.status', $appointment)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="status" value="<?php echo e(Appointment::STATUS_COMPLETED); ?>">
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2.5 rounded-xl font-bold hover:bg-green-700 active:scale-[0.98] transition-all"><?php echo e(__('Finish Service')); ?></button>
                </form>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="space-y-6">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->rating): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-yellow-50 to-white px-4 md:px-5 py-3 md:py-3.5 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <?php echo e(__('Customer Rating')); ?>

                    </h2>
                </div>
                <div class="p-4 md:p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-4xl font-bold text-amber-600"><?php echo e($appointment->rating->rating); ?></span>
                        <div class="flex gap-0.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg class="w-5 h-5 <?php echo e($i <= $appointment->rating->rating ? 'text-yellow-400' : 'text-gray-200'); ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->rating->comment): ?>
                    <p class="text-gray-600 bg-gray-50 rounded-lg p-3 text-sm">"<?php echo e($appointment->rating->comment); ?>"</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-amber-50 to-white px-5 py-3.5 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <?php echo e(__('Activity Log')); ?>

                    </h2>
                </div>
                <div class="p-5">
                    <div class="space-y-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $appointment->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex gap-3 py-3 border-b border-gray-50 last:border-0">
                            <div class="flex flex-col items-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-400 mt-1.5"></div>
                                <div class="w-px flex-1 bg-gray-100 <?php echo e($loop->last ? 'opacity-0' : ''); ?>"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-sm text-gray-800"><?php echo e($log->actionBy?->name); ?></span>
                                    <span class="text-xs text-gray-400" dir="ltr"><?php echo e($log->created_at->format('H:i')); ?></span>
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    <?php
                                        $statusMap = [Appointment::STATUS_PENDING => __('Pending'), Appointment::STATUS_ASSIGNED => __('Assigned'), Appointment::STATUS_IN_PROGRESS => __('In Progress'), Appointment::STATUS_COMPLETED => __('Completed'), Appointment::STATUS_CANCELLED => __('Cancelled')];
                                    ?>
                                    <?php echo e($statusMap[$log->old_status] ?? $log->old_status); ?>

                                    <span class="mx-1">←</span>
                                    <span class="font-bold text-amber-700"><?php echo e($statusMap[$log->new_status] ?? $log->new_status); ?></span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->notes): ?>
                                <div class="text-xs text-gray-400 mt-0.5"><?php echo e($log->notes); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.employee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/employee/show.blade.php ENDPATH**/ ?>