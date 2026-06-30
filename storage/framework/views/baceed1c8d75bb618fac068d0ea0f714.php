<?php $__env->startSection('page-title', __('Edit Package')); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.packages.update', $package)); ?>" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Edit Package')); ?></h2>
    </div>

    <div class="p-6 space-y-6">
        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Name (arabic)')); ?> <span class="text-red-500">*</span></label>
            <input type="text" name="name_ar" required value="<?php echo e(old('name_ar', $package->name_ar)); ?>"
                class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Name (english)')); ?></label>
            <input type="text" name="name_en" value="<?php echo e(old('name_en', $package->name_en)); ?>"
                class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Description (arabic)')); ?></label>
            <textarea name="description_ar" rows="3" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition"><?php echo e(old('description_ar', $package->description_ar)); ?></textarea>
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Description (english)')); ?></label>
            <textarea name="description_en" rows="3" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition"><?php echo e(old('description_en', $package->description_en)); ?></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Package Price (kwd)')); ?> <span class="text-red-500">*</span></label>
                <input type="number" step="0.001" name="price" required value="<?php echo e(old('price', $package->price)); ?>"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Original Price (kwd)')); ?></label>
                <input type="number" step="0.001" name="original_price" value="<?php echo e(old('original_price', $package->original_price)); ?>"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 gap-x-2">
                <input type="checkbox" name="is_active" value="1" <?php echo e($package->is_active ? 'checked' : ''); ?>

                    class="rounded border-gray-300 text-amber-600">
                <span class="text-sm font-medium"><?php echo e(__('Active')); ?></span>
            </label>
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Services')); ?> <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-400 mb-2"><?php echo e(__('Select Services Included')); ?></p>
            <div class="grid grid-cols-2 gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <label class="flex items-center gap-2 rounded-xl border border-gray-200 p-3.5 cursor-pointer hover:border-amber-400 transition">
                    <input type="checkbox" name="service_ids[]" value="<?php echo e($service->id); ?>"
                        <?php echo e(in_array($service->id, old('service_ids', $package->services->pluck('id')->toArray())) ? 'checked' : ''); ?>

                        class="rounded border-gray-300 text-amber-600">
                    <div>
                        <span class="text-sm font-medium"><?php echo e($service->name); ?></span>
                        <span class="text-xs text-gray-400 block"><?php echo e($service->name_en); ?></span>
                    </div>
                </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['service_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium"><?php echo e(__('Sort Order')); ?></label>
            <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $package->sort_order)); ?>"
                class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <?php echo e(__('Update Package')); ?>

            </button>
            <a href="<?php echo e(route('admin.packages.index')); ?>" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors">
                <?php echo e(__('Cancel')); ?>

            </a>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/packages/edit.blade.php ENDPATH**/ ?>