<?php $__env->startSection('page-title', __('Customers')); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Name')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Email')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Phone')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Total Bookings')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Actions')); ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr class="hover:bg-amber-50/30 transition-colors <?php echo e($loop->even ? 'bg-amber-50/20' : ''); ?>">
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="font-medium text-gray-800"><?php echo e($customer->name); ?></span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="text-gray-600"><?php echo e($customer->email ?? '—'); ?></span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="text-gray-600"><?php echo e($customer->phone ?? '—'); ?></span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="inline-flex items-center gap-1 bg-gray-50 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-gray-200/50"><?php echo e($customer->appointments_count); ?></span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <div class="flex items-center gap-2 justify-start">
                        <a href="<?php echo e(route('admin.customers.show', $customer)); ?>" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <?php echo e(__('View')); ?>

                        </a>
                        <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <?php echo e(__('Edit')); ?>

                        </a>
                        <form method="POST" action="<?php echo e(route('admin.customers.destroy', $customer)); ?>" class="inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" onclick="return window.inlineConfirm(this, event, <?php echo json_encode(__('confirm_delete_customer', ['name' => $customer->name]), 512) ?>)" class="inline-flex items-center gap-1 text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <?php echo e(__('Delete')); ?>

                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="5" class="text-center px-5 py-16 text-sm text-gray-400"><?php echo e(__('No Customers')); ?></td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customers->hasPages()): ?>
    <div class="mt-4">
        <?php echo e($customers->links()); ?>

    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>