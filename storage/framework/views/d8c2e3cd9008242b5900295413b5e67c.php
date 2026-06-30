<?php $__env->startSection('page-title', __('Edit Customer')); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.customers.update', $customer)); ?>" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Edit Customer Data')); ?></h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Name')); ?> <span class="text-red-500">*</span></label>
                <input type="text" name="name" required value="<?php echo e(old('name', $customer->name)); ?>"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Email')); ?></label>
                <input type="email" name="email" value="<?php echo e(old('email', $customer->email)); ?>"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('New Password')); ?></label>
                <input type="password" name="password"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <p class="text-xs text-gray-400 mt-1"><?php echo e(__('Leave Empty To Keep')); ?></p>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-1 bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?php echo e(__('Update Customer')); ?>

            </button>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-gray-500 px-4 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium transition-colors"><?php echo e(__('Cancel')); ?></a>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/customers/edit.blade.php ENDPATH**/ ?>