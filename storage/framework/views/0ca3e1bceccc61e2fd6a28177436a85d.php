<?php use App\Models\Appointment; use App\Models\Payment; ?>
<div id="unassignedSection" class="bg-white rounded-2xl shadow-sm border border-amber-100 mb-8 overflow-hidden">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-2">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Unassigned Appointments')); ?></h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unassignedAppointments->count() > 0): ?>
        <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold"><?php echo e($unassignedAppointments->count()); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unassignedAppointments->count() > 0): ?>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Ticket')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Customer')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Service')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Payment')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Priority')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Date')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Shift')); ?></th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Assign Employee')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-amber-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $unassignedAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr class="hover:bg-amber-50/30 transition-colors <?php echo e($loop->even ? 'bg-amber-50/20' : ''); ?>">
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="font-mono font-medium text-gray-500"><?php echo e($apt->ticket_number); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="font-medium text-gray-800"><?php echo e($apt->customer_name ?? '—'); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="text-gray-600"><?php echo e($apt->display_services ?: '—'); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <?php $pm = $apt->payment; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pm): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pm->isCash()): ?>
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-green-200/50"><?php echo e(__('Cash')); ?></span>
                            <?php elseif($pm->method === Payment::METHOD_KNET): ?>
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50"><?php echo e(__('KNET')); ?></span>
                            <?php elseif($pm->method === Payment::METHOD_APPLE_PAY): ?>
                            <span class="text-xs font-medium text-gray-700"><?php echo e(__('Apple Pay')); ?></span>
                            <?php elseif($pm->method === Payment::METHOD_GOOGLE_PAY): ?>
                            <span class="text-xs font-medium text-gray-700"><?php echo e(__('Google Pay')); ?></span>
                            <?php else: ?>
                            <span class="text-xs text-gray-500"><?php echo e($pm->method); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$pm->isPaid()): ?>
                            <span class="text-[10px] text-red-500 block mt-0.5"><?php echo e(__('Unpaid')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <span class="text-gray-400">—</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->display_priority === Appointment::PRIORITY_VIP): ?>
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50"><?php echo e(__('Vip')); ?></span>
                        <?php elseif($apt->display_priority === Appointment::PRIORITY_URGENT): ?>
                            <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-slate-200/50"><?php echo e(__('Normal')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span dir="ltr"><?php echo e($apt->appointment_date?->format('Y-m-d')); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span><?php echo e($apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <form method="POST" action="<?php echo e(route('admin.appointments.assign.store', $apt)); ?>" class="flex gap-2 justify-start">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="redirect_url" value="<?php echo e(url()->full()); ?>">
                            <select name="employee_id" class="appearance-none bg-no-repeat border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition bg-[length:14px] bg-[center_right_8px] pr-8 !rtl:bg-[center_left_8px] !rtl:pr-[0.625rem] !rtl:pl-8 bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22m6 9 6 6 6-6%22/%3E%3C/svg%3E')]">
                                <option value=""><?php echo e(__('Random')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->name); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <button type="submit" class="inline-flex items-center gap-1 bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-green-700 whitespace-nowrap transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <?php echo e(__('Assign')); ?>

                            </button>
                        </form>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="flex flex-col items-center gap-2 py-16 text-gray-400">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm"><?php echo e(__('No Unassigned Appointments')); ?></p>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/admin/partials/dashboard-unassigned.blade.php ENDPATH**/ ?>