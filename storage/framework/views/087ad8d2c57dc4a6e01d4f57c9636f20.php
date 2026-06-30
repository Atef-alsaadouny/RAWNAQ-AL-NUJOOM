<?php use App\Models\Appointment; use App\Models\Payment; ?>


<?php $__env->startSection('title', __('Booking Confirmed')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto px-4 py-6">
    <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-10">

        
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-rose-400 to-amber-400 rounded-full flex items-center justify-center shadow-lg shadow-rose-200/50 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800"><?php echo e(__('Booking Confirmed')); ?> 🎉</h1>
            <p class="text-gray-400 text-sm mt-1"><?php echo e(__('Your ticket number')); ?></p>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-rose-100/50 text-center shadow-sm">
            <div class="text-7xl font-black tracking-widest leading-none text-transparent bg-clip-text bg-gradient-to-l from-rose-600 to-amber-500">
                <?php echo e($appointment->ticket_number); ?>

            </div>
            <p class="mt-3 text-sm text-rose-700 font-medium"><?php echo e(__('Use this number to track your booking')); ?></p>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->appointment_date->isAfter(now()->addDay()->startOfDay())): ?>
        <div class="bg-gradient-to-l from-amber-50 to-rose-50 border border-amber-200/50 rounded-2xl p-4 mb-6 text-center shadow-sm">
            <p class="text-sm font-bold text-amber-800 flex items-center justify-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <?php echo e(__("We'll remind you of your appointment a day before")); ?> 🤍
            </p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500"><?php echo e(__('Name')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($appointment->customer_name); ?></span>
            </div>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500"><?php echo e(__('Phone Number')); ?></span>
                <span class="font-bold text-gray-800 ltr" dir="ltr"><?php echo e($appointment->customer_phone); ?></span>
            </div>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500"><?php echo e(__('Date')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($appointment->appointment_date->format('Y-m-d')); ?></span>
            </div>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500"><?php echo e(__('Shift')); ?></span>
                <span class="font-bold text-gray-800"><?php echo e($appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->employee): ?>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500"><?php echo e(__('Employee')); ?></span>
                <span class="font-bold text-rose-600"><?php echo e($appointment->employee->name); ?></span>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php
                $packageServiceIds = collect();
                foreach ($appointment->packages as $pkg) {
                    $packageServiceIds = $packageServiceIds->merge($pkg->services->pluck('id'));
                }
                $servicesTotal = $appointment->services
                    ->reject(fn($svc) => $packageServiceIds->contains($svc->id))
                    ->sum('price');
                $packagesTotal = $appointment->packages->sum('price');
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($appointment->packages->isNotEmpty() || $servicesTotal > 0): ?>
            <div class="bg-white/70 rounded-2xl p-5 border border-rose-100/50 space-y-3 mt-2 shadow-sm">
                <h3 class="font-bold text-gray-800 text-sm mb-3"><?php echo e(__('Invoice Details')); ?></h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $appointment->packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php $saved = $pkg->original_price && $pkg->original_price > $pkg->price ? $pkg->original_price - $pkg->price : 0; ?>
                <div class="flex justify-between items-start py-2">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400 shrink-0"></span>
                            <span class="text-sm font-bold text-gray-800"><?php echo e($pkg->name); ?></span>
                            <span class="text-xs bg-rose-100 text-rose-700 px-1.5 py-0.5 rounded font-bold"><?php echo e(__('Package')); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($saved > 0): ?>
                            <span class="text-xs bg-fuchsia-100 text-fuchsia-700 px-1.5 py-0.5 rounded font-bold"><?php echo e(__('Save')); ?> <?php echo e(formatCurrency($saved)); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex flex-wrap gap-1.5 mr-3 mt-1.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pkg->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <span class="text-xs bg-rose-50 text-rose-600 px-2 py-0.5 rounded-lg"><?php echo e($ps->name); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                    <span class="font-bold text-rose-600 text-lg shrink-0 mr-3"><?php echo e(formatCurrency($pkg->price)); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($servicesTotal > 0): ?>
                <div class="border-t border-rose-100/50 pt-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $appointment->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $inPackage = false;
                        foreach ($appointment->packages as $pkg) {
                            if ($pkg->services->contains($svc->id)) { $inPackage = true; break; }
                        }
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$inPackage): ?>
                    <div class="flex justify-between items-center py-1.5">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
                            <span class="text-sm text-gray-700"><?php echo e($svc->name); ?></span>
                        </div>
                        <span class="font-bold text-gray-700 text-sm"><?php echo e(formatCurrency($svc->price)); ?></span>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="border-t border-rose-200/60 pt-3 mt-2 flex justify-between items-center">
                    <span class="font-bold text-gray-800 text-base"><?php echo e(__('Total')); ?></span>
                    <span class="text-2xl font-extrabold text-rose-600"><?php echo e(formatCurrency($servicesTotal + $packagesTotal)); ?></span>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php $payment = $appointment->payment; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment): ?>
            <div class="mt-4 bg-white/70 rounded-2xl p-5 border border-rose-100/50 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->isPaid()): ?>
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-emerald-700 text-sm"><?php echo e(__('Paid')); ?> ✓</p>
                            <p class="text-xs text-gray-400"><?php echo e($payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : ''); ?></p>
                        </div>
                        <?php else: ?>
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-amber-700 text-sm"><?php echo e(__('Not paid')); ?></p>
                            <p class="text-xs text-gray-400"><?php echo e(__('Payment method')); ?>: <?php echo e($payment->method === Payment::METHOD_KNET ? __('KNET') : ($payment->method === Payment::METHOD_APPLE_PAY ? __('Apple Pay') : ($payment->method === Payment::METHOD_GOOGLE_PAY ? __('Google Pay') : __('Cash')))); ?></p>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <span class="text-lg font-extrabold text-gray-800"><?php echo e(formatCurrency($payment->amount)); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$payment->isPaid() && !$payment->isCash()): ?>
                <button type="button" onclick="showPayNowModal()" class="mt-3 w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3 rounded-2xl font-bold text-sm shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <?php echo e(__('Pay Now')); ?>

                </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div id="payNowWarningModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
                <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl shadow-rose-200/30 transform transition-all duration-300">
                    <div class="text-center mb-5">
                        <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e(__('Important Notice')); ?></h3>
                        <p class="text-gray-600 leading-relaxed"><?php echo e(__('If payment is made, the booking cannot be modified or cancelled except through contacting support')); ?></p>
                    </div>
                    <div class="bg-amber-50/80 rounded-2xl p-4 mb-5">
                        <p class="text-sm text-amber-800 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <?php echo e(__('Support number')); ?>: <a href="https://wa.me/<?php echo e(config('app.whatsapp')); ?>" target="_blank" dir="ltr" class="underline"><?php echo e(config('app.whatsapp')); ?></a>
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <form action="<?php echo e(route('payment.process', $appointment)); ?>" method="POST" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="method" value="<?php echo e(Payment::METHOD_KNET); ?>">
                            <button type="submit" class="w-full bg-rose-500 text-white py-3 rounded-2xl font-bold hover:bg-rose-600 transition text-sm"><?php echo e(__('Confirm Payment')); ?></button>
                        </form>
                        <button type="button" onclick="hidePayNowModal()" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-2xl font-bold hover:bg-gray-200 transition text-sm"><?php echo e(__('Back')); ?></button>
                    </div>
                </div>
            </div>

            <script>
            function showPayNowModal() {
                document.getElementById('payNowWarningModal').classList.remove('hidden');
                document.getElementById('payNowWarningModal').classList.add('flex');
            }
            function hidePayNowModal() {
                document.getElementById('payNowWarningModal').classList.add('hidden');
                document.getElementById('payNowWarningModal').classList.remove('flex');
            }
            </script>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->check()): ?>
            <a href="<?php echo e(route('track.result', ['appointment' => $appointment, 'phone' => $appointment->customer_phone, 'token' => request('token')])); ?>"
               rel="noreferrer" class="mt-3 block w-full text-center bg-gray-100 text-gray-700 py-3.5 rounded-2xl font-bold hover:bg-gray-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <?php echo e(__('Track Your Booking')); ?>

            </a>
            <?php else: ?>
            <a href="<?php echo e(route('customer.appointment.show', $appointment)); ?>"
               class="mt-3 block w-full text-center bg-gray-100 text-gray-700 py-3.5 rounded-2xl font-bold hover:bg-gray-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <?php echo e(__('View Booking Details')); ?>

            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <a href="<?php echo e(route('home')); ?>"
               class="mt-3 block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 rounded-2xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] text-center flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <?php echo e(__('Back to Homepage')); ?>

            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/customer/confirmed.blade.php ENDPATH**/ ?>