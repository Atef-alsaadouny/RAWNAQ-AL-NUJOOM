<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('New Booking')); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.appointments.store')); ?>" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" id="adminBookingForm">
    <?php echo csrf_field(); ?>

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('New Booking')); ?></h2>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Customer Name')); ?> <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" required value="<?php echo e(old('customer_name')); ?>"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Customer Phone')); ?> <span class="text-red-500">*</span></label>
                <input type="text" name="customer_phone" required value="<?php echo e(old('customer_phone')); ?>"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isNotEmpty()): ?>
        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Package')); ?></label>
            <p class="text-xs text-gray-400 mb-2"><?php echo e(__('Select Multiple Packages')); ?></p>
            <div class="space-y-2" id="adminPackageContainer">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <label class="flex items-center border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition admin-package-label <?php echo e(in_array($pkg->id, old('package_ids', [])) ? 'border-amber-400 bg-amber-50/50' : ''); ?>">
                    <input type="checkbox" name="package_ids[]" value="<?php echo e($pkg->id); ?>" class="ml-3 admin-package-checkbox"
                        <?php echo e(in_array($pkg->id, old('package_ids', [])) ? 'checked' : ''); ?>

                        data-services="<?php echo e($pkg->services->pluck('id')->join(',')); ?>"
                        onchange="adminUpdatePackages()">
                    <span class="text-sm"><?php echo e($pkg->name); ?> <span class="text-gray-400">(<?php echo e(formatCurrency($pkg->price)); ?>)</span></span>
                </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Services')); ?></label>
            <div class="space-y-1.5" id="adminServicesContainer">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <label class="flex items-center border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition service-label"
                    data-service-id="<?php echo e($svc->id); ?>">
                    <input type="checkbox" name="service_ids[]" value="<?php echo e($svc->id); ?>" class="ml-3 service-checkbox" <?php echo e(in_array($svc->id, old('service_ids', [])) ? 'checked' : ''); ?>>
                    <span class="text-sm"><?php echo e($svc->name); ?> <span class="text-gray-400">(<?php echo e(formatCurrency($svc->price)); ?>)</span></span>
                </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Booking Date')); ?> <span class="text-red-500">*</span></label>
                <input type="date" name="appointment_date" required value="<?php echo e(old('appointment_date')); ?>"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Shift')); ?> <span class="text-red-500">*</span></label>
                <select name="shift" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="<?php echo e(Appointment::SHIFT_MORNING); ?>" <?php echo e(old('shift') === Appointment::SHIFT_MORNING ? 'selected' : ''); ?>><?php echo e(__('Morning')); ?></option>
                    <option value="<?php echo e(Appointment::SHIFT_EVENING); ?>" <?php echo e(old('shift') === Appointment::SHIFT_EVENING ? 'selected' : ''); ?>><?php echo e(__('Evening')); ?></option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Priority')); ?> <span class="text-red-500">*</span></label>
            <select name="priority" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <option value="<?php echo e(Appointment::PRIORITY_NORMAL); ?>" <?php echo e(old('priority') === Appointment::PRIORITY_NORMAL ? 'selected' : ''); ?>><?php echo e(__('Normal')); ?></option>
                <option value="<?php echo e(Appointment::PRIORITY_URGENT); ?>" <?php echo e(old('priority') === Appointment::PRIORITY_URGENT ? 'selected' : ''); ?>><?php echo e(__('Urgent')); ?></option>
                <option value="<?php echo e(Appointment::PRIORITY_VIP); ?>" <?php echo e(old('priority') === Appointment::PRIORITY_VIP ? 'selected' : ''); ?>><?php echo e(__('Vip')); ?></option>
            </select>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($employees) && $employees->isNotEmpty()): ?>
        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Employee Optional')); ?></label>
            <select name="employee_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <option value=""><?php echo e(__('No Assignment')); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee_id') == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Notes')); ?></label>
            <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition resize-none"><?php echo e(old('notes')); ?></textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <?php echo e(__('Create Booking')); ?>

            </button>
            <a href="<?php echo e(route('admin.appointments.index')); ?>" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors">
                <?php echo e(__('Cancel')); ?>

            </a>
        </div>
    </div>
</form>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isNotEmpty()): ?>
<script>
function adminUpdatePackages() {
    let allServiceIds = [];
    document.querySelectorAll('.admin-package-checkbox:checked').forEach(cb => {
        const ids = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allServiceIds = allServiceIds.concat(ids);
    });

    document.querySelectorAll('#adminServicesContainer .service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackage = allServiceIds.includes(sid);
        if (isPackage) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-label').style.backgroundColor = '#fdf2f4';
        } else {
            cb.disabled = false;
            cb.closest('.service-label').style.backgroundColor = '';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.admin-package-checkbox:checked')) {
        adminUpdatePackages();
    }
});
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/appointments/create.blade.php ENDPATH**/ ?>