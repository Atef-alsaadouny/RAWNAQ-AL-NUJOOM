<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Work Schedule')); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Add Work Time')); ?></h2>
    </div>
    <div class="p-6">
        <form method="POST" action="<?php echo e(route('admin.schedule.store')); ?>" class="max-w-lg">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Day')); ?></label>
                    <select name="day_of_week" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                        <option value="0"><?php echo e(__('Sunday')); ?></option>
                        <option value="1"><?php echo e(__('Monday')); ?></option>
                        <option value="2"><?php echo e(__('Tuesday')); ?></option>
                        <option value="3"><?php echo e(__('Wednesday')); ?></option>
                        <option value="4"><?php echo e(__('Thursday')); ?></option>
                        <option value="5"><?php echo e(__('Friday')); ?></option>
                        <option value="6"><?php echo e(__('Saturday')); ?></option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Shift')); ?></label>
                    <select name="shift" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                        <option value="<?php echo e(Appointment::SHIFT_MORNING); ?>"><?php echo e(__('Morning')); ?></option>
                        <option value="<?php echo e(Appointment::SHIFT_EVENING); ?>"><?php echo e(__('Evening')); ?></option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Start')); ?></label>
                    <input type="time" name="start_time" required class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('End')); ?></label>
                    <input type="time" name="end_time" required class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>
            </div>
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <?php echo e(__('Save Schedule')); ?>

            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Day')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Shift')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('From')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('To')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Status')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Actions')); ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            <?php $days = [__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday')]; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $daySchedules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $daySchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
<tr class="hover:bg-amber-50/30 transition-colors <?php echo e($loop->parent->even ? 'bg-amber-50/20' : ''); ?>">
                    <td class="text-start px-5 py-4 text-sm font-medium text-gray-800"><?php echo e($days[$day] ?? $day); ?></td>
                    <td class="text-start px-5 py-4 text-sm text-gray-600"><?php echo e($schedule->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></td>
                    <td class="text-start px-5 py-4 text-sm text-gray-600"><?php echo e($schedule->start_time); ?></td>
                    <td class="text-start px-5 py-4 text-sm text-gray-600"><?php echo e($schedule->end_time); ?></td>
                    <td class="text-start px-5 py-4 text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedule->is_active): ?>
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-green-200/50"><?php echo e(__('Active')); ?></span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50"><?php echo e(__('Inactive')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <form method="POST" action="<?php echo e(route('admin.schedule.destroy', $schedule)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" onclick="return window.inlineConfirm(this, event, '<?php echo e(__("Are you sure?")); ?>')" class="text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors"><?php echo e(__('Delete')); ?></button>
                        </form>
                    </td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <tr>
            <td colspan="6" class="text-center px-5 py-16 text-sm text-gray-400"><?php echo e(__('No Schedule')); ?></td>
        </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/schedule/index.blade.php ENDPATH**/ ?>