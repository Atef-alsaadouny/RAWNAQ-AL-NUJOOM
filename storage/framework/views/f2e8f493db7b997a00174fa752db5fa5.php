<?php use App\Models\Appointment; ?>


<?php $__env->startSection('page-title', __('Dashboard')); ?>

<?php $__env->startSection('content'); ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold text-amber-600"><?php echo e($stats['today_count']); ?></div>
        <div class="text-gray-500 text-sm mt-0.5"><?php echo e(__('Today Bookings')); ?></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold text-green-600"><?php echo e($stats['completed_today']); ?></div>
        <div class="text-gray-500 text-sm mt-0.5"><?php echo e(__('Completed Today')); ?></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold text-blue-600"><?php echo e($stats['pending']); ?></div>
        <div class="text-gray-500 text-sm mt-0.5"><?php echo e(__('Pending')); ?></div>
    </div>
</div>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="bg-gradient-to-l from-amber-50 to-white px-4 md:px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Today Bookings')); ?></h2>
    </div>
    <div class="p-3 md:p-5" id="todayAppointmentsList">
        <?php echo $__env->make('employee.partials.today-appointments', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingAppointments->count() > 0): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-l from-blue-50 to-white px-4 md:px-6 py-3 md:py-4 border-b border-gray-100">
        <h2 class="text-sm md:text-lg font-bold text-gray-800"><?php echo e(__('Upcoming Bookings')); ?></h2>
    </div>
    <div class="p-3 md:p-5">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <a href="<?php echo e(route('employee.appointment.show', $apt)); ?>" class="flex items-stretch gap-2 md:gap-4 mb-3 last:mb-0 group">
            <div class="w-16 md:w-20 shrink-0 flex flex-col items-center justify-center rounded-xl bg-blue-50 text-blue-700 text-center leading-tight text-xs md:text-base">
                <span class="text-sm md:text-lg font-bold"><?php echo e($apt->appointment_date?->format('d')); ?></span>
                <span class="text-[9px] md:text-[10px] font-medium opacity-75"><?php echo e($apt->appointment_date?->format('M')); ?></span>
                <span class="text-[9px] md:text-[10px] font-medium opacity-75"><?php echo e($apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
            </div>
            <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between bg-white border border-gray-100 rounded-xl px-3 md:px-4 py-2.5 md:py-3 group-hover:shadow-md group-hover:border-blue-200 transition-all gap-1.5 md:gap-0">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="font-mono text-xs text-gray-400"><?php echo e($apt->ticket_number); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($apt->display_priority === Appointment::PRIORITY_VIP): ?>
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-emerald-200/50"><?php echo e(__('Vip')); ?></span>
                        <?php elseif($apt->display_priority === Appointment::PRIORITY_URGENT): ?>
                            <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-rose-200/50"><?php echo e(__('Urgent')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="font-bold text-gray-800 truncate"><?php echo e($apt->customer_name ?? $apt->customer?->name); ?></div>
                    <div class="text-xs text-gray-500 truncate"><?php echo e($apt->display_services ?: '—'); ?></div>
                </div>
                <div class="shrink-0 md:mr-3">
                    <span class="text-gray-400 text-xs flex items-center gap-1">
                        <?php echo e(__('View Details')); ?>

                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </div>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
(function() {
    var list = document.getElementById('todayAppointmentsList');
    if (!list) return;

    function poll() {
        fetch('<?php echo e(route("employee.dashboard.today")); ?>', {
            headers: { 'Accept': 'text/html', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.text(); })
        .then(function(html) {
            list.innerHTML = html;
        })
        .catch(function() {});
    }

    setInterval(poll, 10000);
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.employee', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/employee/dashboard.blade.php ENDPATH**/ ?>