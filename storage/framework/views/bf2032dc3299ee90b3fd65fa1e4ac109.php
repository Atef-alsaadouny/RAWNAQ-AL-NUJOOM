<?php use App\Models\Appointment; ?>
<div id="recentSection" class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-2">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Latest Appointments')); ?></h2>
        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full"><?php echo e($recentAppointments->count()); ?></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Ticket')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Customer')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Employee')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Service')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Date')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Status')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Rating')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-amber-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr class="hover:bg-amber-50/30 transition-colors <?php echo e($loop->even ? 'bg-amber-50/20' : ''); ?>">
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="font-mono font-medium text-gray-500"><?php echo e($apt->ticket_number); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="font-medium text-gray-800"><?php echo e($apt->customer_name ?? $apt->customer?->name ?? '—'); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="text-gray-600"><?php echo e($apt->employee?->name ?? __('Unassigned')); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="text-gray-600"><?php echo e($apt->display_services ?: '—'); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span dir="ltr" class="whitespace-nowrap"><?php echo e($apt->appointment_date?->format('Y-m-d')); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($apt->status):
                            case (Appointment::STATUS_PENDING): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->appointment_date?->isPast()): ?>
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none whitespace-nowrap"><?php echo e(__('Missed')); ?></span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-yellow-200/50 whitespace-nowrap"><?php echo e(__('Pending')); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_ASSIGNED): ?>
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50 whitespace-nowrap"><?php echo e(__('Assigned')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_IN_PROGRESS): ?>
                                <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-purple-200/50 whitespace-nowrap"><?php echo e(__('In Progress')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_COMPLETED): ?>
                                <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-teal-200/50 whitespace-nowrap"><?php echo e(__('Completed')); ?></span>
                                <?php break; ?>
                            <?php case (Appointment::STATUS_CANCELLED): ?>
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50 whitespace-nowrap"><?php echo e(__('Cancelled')); ?></span>
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
                        <a href="<?php echo e(route('admin.appointments.show', $apt)); ?>" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <?php echo e(__('View')); ?>

                        </a>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="8" class="text-center px-5 py-16 text-sm text-gray-400"><?php echo e(__('No Appointments')); ?></td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/admin/partials/dashboard-recent.blade.php ENDPATH**/ ?>