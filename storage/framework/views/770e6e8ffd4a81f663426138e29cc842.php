<?php $__env->startSection('page-title', __('Add Service')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto bg-white/90 backdrop-blur-sm rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 overflow-hidden">
    <div class="bg-gradient-to-l from-rose-50 to-white px-6 py-5 border-b border-rose-100">
        <h2 class="text-xl font-bold text-gray-800"><?php echo e(__('Add New Service')); ?></h2>
    </div>
    <form method="POST" action="<?php echo e(route('admin.services.store')); ?>" class="p-6 md:p-8">
        <?php echo csrf_field(); ?>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Name (arabic)')); ?> <span class="text-rose-500">*</span></label>
            <input type="text" name="name_ar" required value="<?php echo e(old('name_ar')); ?>"
                class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Name (english)')); ?></label>
            <input type="text" name="name_en" value="<?php echo e(old('name_en')); ?>"
                class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Category')); ?> <span class="text-rose-500">*</span></label>
            <select name="category" required class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                <option value=""><?php echo e(__('Select Category')); ?></option>
                <option value="شعر" <?php echo e(old('category') == 'شعر' ? 'selected' : ''); ?>><?php echo e(__('Hair')); ?></option>
                <option value="مكياج" <?php echo e(old('category') == 'مكياج' ? 'selected' : ''); ?>><?php echo e(__('Makeup')); ?></option>
                <option value="بشرة" <?php echo e(old('category') == 'بشرة' ? 'selected' : ''); ?>><?php echo e(__('Skin')); ?></option>
                <option value="أظافر" <?php echo e(old('category') == 'أظافر' ? 'selected' : ''); ?>><?php echo e(__('Nails')); ?></option>
                <option value="مساج" <?php echo e(old('category') == 'مساج' ? 'selected' : ''); ?>><?php echo e(__('Massage')); ?></option>
                <option value="عناية" <?php echo e(old('category') == 'عناية' ? 'selected' : ''); ?>><?php echo e(__('Care')); ?></option>
                <option value="أخرى" <?php echo e(old('category') == 'أخرى' ? 'selected' : ''); ?>><?php echo e(__('Other')); ?></option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Description (arabic)')); ?></label>
            <textarea name="description_ar" rows="3" class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none"><?php echo e(old('description_ar')); ?></textarea>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Description (english)')); ?></label>
            <textarea name="description_en" rows="3" class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none"><?php echo e(old('description_en')); ?></textarea>
        </div>

        <div class="grid grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Price')); ?> <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="number" step="0.001" name="price" required value="<?php echo e(old('price')); ?>"
                        class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 pr-14">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium"><?php echo e(__('KWD')); ?></span>
                </div>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Duration')); ?> <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="number" name="duration_minutes" required value="<?php echo e(old('duration_minutes', 30)); ?>"
                        class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 pr-14">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium"><?php echo e(__('Min')); ?></span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2"><?php echo e(__('Sort Order')); ?></label>
            <input type="number" name="sort_order" value="<?php echo e(old('sort_order', 0)); ?>"
                class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-gradient-to-l from-rose-500 to-rose-600 text-white px-7 py-3 rounded-xl font-bold shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 transition-all duration-200 text-sm">
                <?php echo e(__('Create Service')); ?>

            </button>
            <a href="<?php echo e(route('admin.services.index')); ?>" class="bg-white text-gray-700 px-7 py-3 rounded-xl border-2 border-gray-100 hover:border-rose-200 hover:text-rose-700 text-sm font-bold transition-all duration-200">
                <?php echo e(__('Cancel')); ?>

            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/services/create.blade.php ENDPATH**/ ?>