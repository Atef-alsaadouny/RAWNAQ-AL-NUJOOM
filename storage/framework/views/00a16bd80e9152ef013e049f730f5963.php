<?php $__env->startSection('page-title', __('Packages')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-5 flex items-center justify-end">
    <a href="<?php echo e(route('admin.packages.create')); ?>" class="inline-flex items-center gap-2 bg-gradient-to-l from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl hover:from-amber-600 hover:to-amber-700 text-sm font-bold shadow-lg shadow-amber-200/40 hover:shadow-xl transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <?php echo e(__('Add Package')); ?>

    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">#</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Name')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Services')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Price')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Original Price')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Status')); ?></th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700"><?php echo e(__('Actions')); ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr class="hover:bg-amber-50/30 transition-colors <?php echo e($loop->even ? 'bg-amber-50/20' : ''); ?>">
                <td class="text-start px-5 py-4 text-sm font-medium text-gray-500"><?php echo e($pkg->sort_order); ?></td>
                <td class="text-start px-5 py-4 text-sm font-bold text-gray-800"><?php echo e($pkg->name); ?></td>
                <td class="text-start px-5 py-4 text-sm text-gray-500"><?php echo e($pkg->services->pluck('name')->implode(', ')); ?></td>
                <td class="text-start px-5 py-4 text-sm font-bold text-amber-600"><?php echo e(formatCurrency($pkg->price)); ?></td>
                <td class="text-start px-5 py-4 text-sm text-gray-400"><?php echo e($pkg->original_price ? formatCurrency($pkg->original_price) : '—'); ?></td>
                <td class="text-start px-5 py-4 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pkg->is_active): ?>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50"><?php echo e(__('Active')); ?></span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50"><?php echo e(__('Inactive')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <div class="flex items-center justify-center gap-1.5">
                        <a href="<?php echo e(route('admin.packages.edit', $pkg)); ?>" class="inline-flex items-center gap-1.5 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <?php echo e(__('Edit')); ?>

                        </a>
                        <form method="POST" action="<?php echo e(route('admin.packages.destroy', $pkg)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" onclick="return window.inlineConfirm(this, event, '<?php echo e(__("Are you sure?")); ?>')" class="inline-flex items-center gap-1.5 text-red-600 bg-red-50 hover:bg-red-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <?php echo e(__('Delete')); ?>

                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="7" class="text-start px-5 py-16 text-sm text-gray-400"><?php echo e(__('No Packages')); ?></td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/packages/index.blade.php ENDPATH**/ ?>