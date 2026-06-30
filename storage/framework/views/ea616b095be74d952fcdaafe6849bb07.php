<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Edit Booking')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $selectedPackageIds = $appointment->packages->pluck('id')->toArray();
    $allPackageServiceIds = [];
    foreach ($appointment->packages as $pkg) {
        $allPackageServiceIds = array_merge($allPackageServiceIds, $pkg->services->pluck('id')->toArray());
    }
?>

<form method="POST" action="<?php echo e(route('admin.appointments.update', $appointment)); ?>" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Edit Booking')); ?></h2>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Customer Name')); ?> <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" required value="<?php echo e(old('customer_name', $appointment->customer_name ?? $appointment->customer?->name)); ?>"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Customer Phone')); ?> <span class="text-red-500">*</span></label>
                <input type="text" name="customer_phone" required value="<?php echo e(old('customer_phone', $appointment->customer_phone)); ?>"
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
            <input type="hidden" name="package_ids" value="">
            <div class="space-y-2" id="adminPackageContainer">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <label class="flex items-center border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition admin-package-label <?php echo e(in_array($pkg->id, $selectedPackageIds) ? 'border-amber-400 bg-amber-50/50' : ''); ?>">
                    <input type="checkbox" name="package_ids[]" value="<?php echo e($pkg->id); ?>" class="ml-3 admin-package-checkbox"
                        <?php echo e(in_array($pkg->id, $selectedPackageIds) ? 'checked' : ''); ?>

                        data-services="<?php echo e($pkg->services->pluck('id')->join(',')); ?>"
                        onchange="adminUpdatePackages()">
                    <span class="text-sm"><?php echo e($pkg->name); ?> <span class="text-gray-400">(<?php echo e(formatCurrency($pkg->price)); ?>)</span></span>
                </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5" id="adminServicesLabel"><?php echo e(__('Services')); ?></label>

            <div id="adminPackageServicesInfo" class="mb-3 <?php echo e(!empty($selectedPackageIds) ? '' : 'hidden'); ?> bg-rose-50/70 border border-rose-200/70 rounded-xl p-3.5">
                <p class="text-sm text-rose-700 font-medium mb-1.5" id="adminPackageServicesText">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($selectedPackageIds)): ?>
                        <?php echo e(__('Package Services')); ?>: <?php echo e($appointment->packages->pluck('name')->implode(' + ')); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
                <div class="flex flex-wrap gap-1.5" id="adminPackageServicesTags">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $appointment->packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pkg->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <span class="bg-rose-100 text-rose-700 text-xs px-2.5 py-1 rounded-lg">✅ <?php echo e($ps->name); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            <div class="space-y-1.5 max-h-52 overflow-y-auto border border-gray-200 rounded-xl p-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $isPackageService = in_array($svc->id, $allPackageServiceIds);
                    $hasService = $appointment->services->contains($svc->id);
                ?>
                <label class="flex items-center px-3 py-2.5 hover:bg-gray-50 rounded-lg cursor-pointer transition <?php echo e($isPackageService ? 'bg-rose-50/50' : ''); ?> service-label"
                    data-service-id="<?php echo e($svc->id); ?>">
                    <input type="checkbox" name="service_ids[]" value="<?php echo e($svc->id); ?>" class="ml-3 service-checkbox"
                        <?php echo e($isPackageService ? 'checked disabled' : ''); ?>

                        <?php echo e(!$isPackageService && $hasService ? 'checked' : ''); ?>>
                    <span class="text-sm"><?php echo e($svc->name); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPackageService): ?>
                    <span class="text-xs text-rose-500 mr-2"><?php echo e(__('From Package')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Employee')); ?></label>
                <select name="employee_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value=""><?php echo e(__('Unassigned')); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($emp->id); ?>" <?php echo e($appointment->employee_id == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Time Optional')); ?></label>
                <input type="time" name="assigned_time" value="<?php echo e(old('assigned_time', $appointment->assigned_time)); ?>"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Date')); ?> <span class="text-red-500">*</span></label>
                <input type="date" name="appointment_date" required value="<?php echo e(old('appointment_date', $appointment->appointment_date?->format('Y-m-d'))); ?>"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Shift')); ?> <span class="text-red-500">*</span></label>
                <select name="shift" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="<?php echo e(Appointment::SHIFT_MORNING); ?>" <?php echo e($appointment->shift === Appointment::SHIFT_MORNING ? 'selected' : ''); ?>><?php echo e(__('Morning')); ?></option>
                    <option value="<?php echo e(Appointment::SHIFT_EVENING); ?>" <?php echo e($appointment->shift === Appointment::SHIFT_EVENING ? 'selected' : ''); ?>><?php echo e(__('Evening')); ?></option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Priority')); ?></label>
                <select name="priority" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="<?php echo e(Appointment::PRIORITY_NORMAL); ?>" <?php echo e($appointment->priority === Appointment::PRIORITY_NORMAL ? 'selected' : ''); ?>><?php echo e(__('Normal')); ?></option>
                    <option value="<?php echo e(Appointment::PRIORITY_URGENT); ?>" <?php echo e($appointment->priority === Appointment::PRIORITY_URGENT ? 'selected' : ''); ?>><?php echo e(__('Urgent')); ?></option>
                    <option value="<?php echo e(Appointment::PRIORITY_VIP); ?>" <?php echo e($appointment->priority === Appointment::PRIORITY_VIP ? 'selected' : ''); ?>><?php echo e(__('Vip')); ?></option>
                </select>
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Status')); ?></label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="<?php echo e(Appointment::STATUS_PENDING); ?>" <?php echo e($appointment->status === Appointment::STATUS_PENDING ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                    <option value="<?php echo e(Appointment::STATUS_ASSIGNED); ?>" <?php echo e($appointment->status === Appointment::STATUS_ASSIGNED ? 'selected' : ''); ?>><?php echo e(__('Assigned')); ?></option>
                    <option value="<?php echo e(Appointment::STATUS_IN_PROGRESS); ?>" <?php echo e($appointment->status === Appointment::STATUS_IN_PROGRESS ? 'selected' : ''); ?>><?php echo e(__('In Progress')); ?></option>
                    <option value="<?php echo e(Appointment::STATUS_COMPLETED); ?>" <?php echo e($appointment->status === Appointment::STATUS_COMPLETED ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
                    <option value="<?php echo e(Appointment::STATUS_CANCELLED); ?>" <?php echo e($appointment->status === Appointment::STATUS_CANCELLED ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5"><?php echo e(__('Customer Notes')); ?></label>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->notes): ?>
            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 mb-3"><?php echo e($appointment->notes); ?></div>
            <?php else: ?>
            <p class="text-gray-400 text-sm mb-3"><?php echo e(__('No Notes')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition resize-none" placeholder="<?php echo e(__('Admin Notes Optional')); ?>"><?php echo e(old('notes')); ?></textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <?php echo e(__('Update Booking')); ?>

            </button>
            <a href="<?php echo e(route('admin.appointments.show', $appointment)); ?>" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors">
                <?php echo e(__('Cancel')); ?>

            </a>
        </div>
    </div>
</form>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isNotEmpty()): ?>
<script>
let adminPreviousPackageServiceIds = [];

function adminUpdatePackages() {
    let allServiceIds = [];
    let allNames = [];
    let allTags = [];

    document.querySelectorAll('.admin-package-checkbox:checked').forEach(cb => {
        const ids = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allServiceIds = allServiceIds.concat(ids);
        const label = cb.closest('.admin-package-label');
        if (label) {
            const name = label.querySelector('span')?.textContent || '';
            allNames.push(name);
        }
    });

    document.querySelectorAll('#adminPackageContainer .admin-package-label').forEach(label => {
        const cb = label.querySelector('.admin-package-checkbox');
        label.classList.toggle('border-amber-400', cb.checked);
        label.classList.toggle('bg-amber-50/50', cb.checked);
    });

    document.querySelectorAll('.service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackageService = allServiceIds.includes(sid);
        const wasPackageService = adminPreviousPackageServiceIds.includes(sid);

        if (isPackageService) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-label').style.backgroundColor = '#fdf2f4';
        } else {
            if (wasPackageService && !isPackageService) {
                cb.checked = false;
            }
            cb.disabled = false;
            cb.closest('.service-label').style.backgroundColor = '';
        }
    });

    adminPreviousPackageServiceIds = allServiceIds;

    const infoBox = document.getElementById('adminPackageServicesInfo');
    const infoText = document.getElementById('adminPackageServicesText');
    const tagsContainer = document.getElementById('adminPackageServicesTags');

    if (document.querySelectorAll('.admin-package-checkbox:checked').length > 0) {
        infoText.textContent = '<?php echo e(__('Package Services')); ?>: ' + allNames.join(' + ');
        infoBox.classList.remove('hidden');
    } else {
        infoBox.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    adminPreviousPackageServiceIds = [];
    document.querySelectorAll('.admin-package-checkbox:checked').forEach(cb => {
        const ids = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        adminPreviousPackageServiceIds = adminPreviousPackageServiceIds.concat(ids);
    });
});
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/appointments/edit.blade.php ENDPATH**/ ?>