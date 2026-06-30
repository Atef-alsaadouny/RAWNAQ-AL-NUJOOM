<?php use App\Models\Appointment; use App\Models\Payment; ?>


<?php $__env->startSection('title', __('Book Appointment')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-gray-800"><?php echo e(__('Book Your Appointment')); ?></h1>
        <p class="text-gray-500 mt-1.5"><?php echo e(__('Choose the services you want and we will prepare everything')); ?></p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="alert mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="bg-white/90 backdrop-blur-sm rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-8">
        <form method="POST" action="<?php echo e(route('book.store')); ?>" id="bookingForm">
            <?php echo csrf_field(); ?>

            <div style="position:absolute;left:-9999px" aria-hidden="true">
                <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            <input type="hidden" name="form_loaded_at" value="">
            <input type="hidden" name="_form_token" value="<?php echo e($bookingToken); ?>">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
            <div class="bg-gradient-to-br from-rose-50 to-amber-50/30 rounded-2xl p-5 mb-8 border border-rose-100/50">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <?php echo e(__('Your Information')); ?>

                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Name')); ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>" required placeholder="<?php echo e(__('Your Full Name')); ?>"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Phone Number')); ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" required placeholder="5XXXXXXX"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50/30 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" dir="ltr">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php elseif(auth()->user()->isCustomer()): ?>
            <div class="mb-8 bg-gradient-to-br from-rose-50 to-amber-50/30 border border-rose-100/50 rounded-2xl px-5 py-4 text-sm text-gray-600 flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span><?php echo e(__('Booking under your name')); ?>: <strong><?php echo e(auth()->user()->name); ?></strong> (<?php echo e(auth()->user()->phone); ?>)</span>
            </div>
            <?php else: ?>
            <div class="bg-gradient-to-br from-rose-50 to-amber-50/30 rounded-2xl p-5 mb-8 border border-rose-100/50">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <?php echo e(__('Your Information')); ?>

                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Name')); ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>" required placeholder="<?php echo e(__('Your Full Name')); ?>"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Phone Number')); ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" required placeholder="5XXXXXXX"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50/30 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" dir="ltr">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1.5"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isNotEmpty()): ?>
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <label class="block text-gray-700 font-bold text-sm"><?php echo e(__('Packages & Offers')); ?></label>
                </div>
                <p class="text-sm text-gray-400 mb-4 mr-7"><?php echo e(__('You can select more than one package')); ?></p>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <label class="package-card border-2 rounded-2xl p-4 md:p-5 cursor-pointer transition-all duration-200 flex items-center gap-3 md:gap-4 <?php echo e(in_array($package->id, $preselectedPackageIds) ? 'border-rose-300 bg-rose-50/40 shadow-sm' : 'border-gray-100 bg-white hover:border-rose-200 hover:shadow-sm'); ?>">
                        <input type="checkbox" name="package_ids[]" value="<?php echo e($package->id); ?>" class="package-checkbox w-5 h-5 text-rose-500 rounded"
                            <?php echo e(in_array($package->id, $preselectedPackageIds) ? 'checked' : ''); ?>

                            data-services="<?php echo e($package->services->pluck('id')->join(',')); ?>"
                            onchange="updatePackages()">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-800"><?php echo e($package->name); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->original_price && $package->original_price > $package->price): ?>
                                <span class="bg-rose-100 text-rose-700 text-xs px-2.5 py-0.5 rounded-full font-bold">
                                    <?php echo e(__('Save')); ?> <?php echo e(formatCurrency($package->original_price - $package->price)); ?>

                                </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="text-gray-400 text-sm mt-0.5 truncate"><?php echo e($package->services->pluck('name')->implode(' + ')); ?></div>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-xl font-extrabold text-rose-600"><?php echo e(formatCurrency($package->price)); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->original_price && $package->original_price > $package->price): ?>
                                <span class="text-gray-300 text-sm line-through"><?php echo e(formatCurrency($package->original_price)); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <label class="block text-gray-700 font-bold text-sm" id="servicesLabel"><?php echo e(__('Services')); ?></label>
                </div>

                <div id="packageServicesInfo" class="hidden bg-rose-50/70 border border-rose-200/60 rounded-2xl p-5 mb-4 mt-3">
                    <p class="text-sm text-rose-700 font-medium mb-2.5" id="packageServicesText"></p>
                    <div class="flex flex-wrap gap-2" id="packageServicesTags"></div>
                </div>

                <div class="space-y-2 mt-3" id="servicesContainer">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $inAnyPreselected = false;
                        if (!empty($preselectedPackageIds)) {
                            $selPkgs = $packages->whereIn('id', $preselectedPackageIds);
                            foreach ($selPkgs as $sp) {
                                if ($sp->services->contains($service->id)) { $inAnyPreselected = true; break; }
                            }
                        }
                    ?>
                    <label class="service-item border-2 rounded-2xl p-3 md:p-4 cursor-pointer transition-all duration-200 flex justify-between items-center gap-2 md:gap-4 <?php echo e($inAnyPreselected ? 'border-rose-200 bg-rose-50/30' : 'border-gray-100 bg-white hover:border-rose-200 hover:shadow-sm'); ?>"
                        data-service-id="<?php echo e($service->id); ?>"
                        data-package-service="<?php echo e($inAnyPreselected ? 'true' : 'false'); ?>">
                        <div class="flex items-center gap-3 min-w-0">
                            <input type="checkbox" name="service_ids[]" value="<?php echo e($service->id); ?>" class="service-checkbox w-5 h-5 text-rose-500 rounded shrink-0"
                                <?php echo e($inAnyPreselected ? 'checked disabled' : ''); ?>

                                <?php echo e(in_array($service->id, old('service_ids', $preselected ? [$preselected] : [])) ? 'checked' : ''); ?>>
                            <div>
                                <span class="font-bold <?php echo e($inAnyPreselected ? 'text-rose-600' : 'text-gray-800'); ?>"><?php echo e($service->name); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inAnyPreselected): ?>
                                <span class="package-badge text-xs text-rose-500 mr-1"><?php echo e(__('(From package)')); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <div class="text-left shrink-0">
                            <span class="text-rose-600 font-bold"><?php echo e(formatCurrency($service->price)); ?></span>
                        </div>
                    </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            <div class="bg-gradient-to-br from-rose-50 to-amber-50/30 rounded-2xl p-5 mb-8 border border-rose-100/50">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <?php echo e(__('Appointment')); ?>

                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Date')); ?> <span class="text-red-500">*</span></label>
                        <input type="date" name="appointment_date" required min="<?php echo e(now()->format('Y-m-d')); ?>" value="<?php echo e(old('appointment_date')); ?>"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Shift')); ?> <span class="text-red-500">*</span></label>
                        <select name="shift" required class="appearance-none bg-no-repeat w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 bg-[length:18px] bg-[center_right_12px] pr-12 !rtl:bg-[center_left_12px] !rtl:pr-5 !rtl:pl-12 bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22m6 9 6 6 6-6%22/%3E%3C/svg%3E')]">
                            <option value="<?php echo e(Appointment::SHIFT_MORNING); ?>" <?php echo e(old('shift') == Appointment::SHIFT_MORNING ? 'selected' : ''); ?>><?php echo e(__('Morning')); ?></option>
                            <option value="<?php echo e(Appointment::SHIFT_EVENING); ?>" <?php echo e(old('shift') == Appointment::SHIFT_EVENING ? 'selected' : ''); ?>><?php echo e(__('Evening')); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($employees) && $employees->isNotEmpty()): ?>
            <input type="hidden" name="employee_id" id="employeeInput" value="<?php echo e(old('employee_id', '')); ?>">
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <label class="block text-gray-700 font-bold text-sm"><?php echo e(__('Choose Employee')); ?> <span class="text-gray-400 font-normal"><?php echo e(__('(Optional)')); ?></span></label>
                </div>
                <p class="text-sm text-gray-400 mb-3 mr-7"><?php echo e(__('Choose the employee you prefer')); ?></p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="employeeContainer">
                    <div class="employee-option flex flex-col items-center gap-2 rounded-2xl px-4 py-5 cursor-pointer transition-all duration-200 border-2 text-center <?php echo e(!old('employee_id') ? 'border-rose-300 bg-rose-50 shadow-sm ring-2 ring-rose-400' : 'border-gray-100 bg-white text-gray-500 hover:border-amber-200 hover:text-amber-600'); ?>" data-value="">
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <span class="font-medium text-sm"><?php echo e(__('Without Employee')); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="employee-option flex flex-col items-center gap-2 rounded-2xl px-4 py-5 cursor-pointer transition-all duration-200 border-2 text-center <?php echo e(old('employee_id') == $emp->id ? 'border-rose-300 bg-rose-50 shadow-sm ring-2 ring-rose-400' : 'border-gray-100 bg-white text-gray-500 hover:border-amber-200 hover:text-amber-600'); ?>" data-value="<?php echo e($emp->id); ?>">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center shadow-sm">
                            <span class="text-rose-600 font-bold text-lg"><?php echo e(mb_substr($emp->name, 0, 1)); ?></span>
                        </div>
                        <span class="font-medium text-sm"><?php echo e($emp->name); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="mb-8">
                <label class="block text-gray-700 font-bold text-sm mb-2"><?php echo e(__('Notes')); ?> <span class="text-gray-400 font-normal"><?php echo e(__('(Optional)')); ?></span></label>
                <textarea name="notes" rows="3" class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none" placeholder="<?php echo e(__('Anything you want to request?')); ?>"><?php echo e(old('notes')); ?></textarea>
            </div>

            
            <div id="priceSummary" class="hidden bg-white border-2 border-rose-200/70 rounded-2xl p-5 mb-8 space-y-3 shadow-sm">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m0 0l-6-6m6 6H3"/>
                    </svg>
                    <?php echo e(__('Invoice Summary')); ?>

                </h3>
                <div id="summaryItems" class="space-y-1.5"></div>
                <div class="border-t border-rose-200/40 pt-3 flex justify-between items-center">
                    <span class="font-bold text-gray-700"><?php echo e(__('Total')); ?></span>
                    <span class="text-2xl font-extrabold text-rose-700" id="summaryTotal"><?php echo e(formatCurrency(0)); ?></span>
                </div>
            </div>

            
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <label class="block text-gray-700 font-bold text-sm"><?php echo e(__('Payment Method')); ?></label>
                </div>
                <p class="text-sm text-gray-400 mb-3 mr-7"><?php echo e(__('Choose your preferred payment method')); ?></p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="paymentContainer">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Payment::availableMethods(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php $isCash = $method === \App\Models\Payment::METHOD_CASH; ?>
                        <label class="payment-option border-2 rounded-2xl px-4 py-3 cursor-pointer transition-all duration-200 flex items-center gap-2.5 border-gray-100 bg-white text-gray-500 hover:border-amber-200 hover:text-amber-600">
                            <input type="radio" name="payment_method" value="<?php echo e($method); ?>" <?php echo e($isCash ? 'checked' : ''); ?> class="payment-radio w-4 h-4 text-rose-500 shrink-0">
                            <span class="font-medium"><?php echo e($isCash ? __('Cash') : ($method === \App\Models\Payment::METHOD_KNET ? __('KNET') : ($method === \App\Models\Payment::METHOD_APPLE_PAY ? __('Apple Pay') : __('Google Pay')))); ?></span>
                        </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            
            <div id="paymentWarningModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/40" onclick="resetToCash()"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo e(__('Payment Confirmation')); ?></h3>
                    <p class="text-sm text-gray-500 mb-6"><?php echo e(__('Payment must be made at the salon upon arrival for non-Cash methods.')); ?></p>
                    <div class="flex gap-3">
                        <button type="button" onclick="hidePaymentWarning()" class="flex-1 bg-rose-500 hover:bg-rose-600 text-white py-3 rounded-2xl font-bold transition-all duration-200">
                            <?php echo e(__('Got it, Continue')); ?>

                        </button>
                        <button type="button" onclick="resetToCash()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-2xl font-bold transition-all duration-200">
                            <?php echo e(__('Go Back')); ?>

                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" id="submitBtn" class="w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                <span id="submitText" class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <?php echo e(__('Confirm Booking')); ?>

                </span>
                <span id="submitSpinner" class="hidden items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <?php echo e(__('Confirming...')); ?>

                </span>
            </button>
        </form>
    </div>
</div>

<script>
function selectEmployee(el) {
    var value = el.getAttribute('data-value');
    document.getElementById('employeeInput').value = value;
    document.querySelectorAll('.employee-option').forEach(function(opt) {
        opt.classList.remove('border-rose-300', 'bg-rose-50', 'text-rose-700', 'shadow-sm', 'ring-2', 'ring-rose-400');
        opt.classList.add('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
    });
    el.classList.add('border-rose-300', 'bg-rose-50', 'text-rose-700', 'shadow-sm', 'ring-2', 'ring-rose-400');
    el.classList.remove('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.employee-option').forEach(function(el) {
        el.addEventListener('click', function() {
            selectEmployee(this);
        });
    });
});

// Payment method
var hasConfirmedPayment = false;

function applyPaymentVisual() {
    document.querySelectorAll('.payment-option').forEach(function(opt) {
        var radio = opt.querySelector('.payment-radio');
        if (radio && radio.checked) {
            opt.classList.add('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            opt.classList.remove('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
        } else {
            opt.classList.remove('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            opt.classList.add('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
        }
    });
}

function showPaymentWarning() {
    var el = document.getElementById('paymentWarningModal');
    if (el) el.classList.remove('hidden');
}

function hidePaymentWarning() {
    var el = document.getElementById('paymentWarningModal');
    if (el) el.classList.add('hidden');
    hasConfirmedPayment = true;
}

function resetToCash() {
    hidePaymentWarning();
    document.querySelectorAll('.payment-radio').forEach(function(r) {
        if (r.value === '<?php echo e(Payment::METHOD_CASH); ?>') {
            r.checked = true;
        }
    });
    hasConfirmedPayment = false;
    applyPaymentVisual();
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.payment-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            applyPaymentVisual();
            if (this.value !== '<?php echo e(Payment::METHOD_CASH); ?>' && !hasConfirmedPayment) {
                showPaymentWarning();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('bookingForm');
    if (!form) return;

    var loadedAt = form.querySelector('input[name="form_loaded_at"]');
    if (loadedAt) loadedAt.value = Date.now();

    form.addEventListener('submit', function() {
        var btn = document.getElementById('submitBtn');
        if (btn) btn.disabled = true;
        var st = document.getElementById('submitText');
        if (st) st.classList.add('hidden');
        var ss = document.getElementById('submitSpinner');
        if (ss) ss.classList.remove('hidden');
    });
});

<?php if($packages->isNotEmpty()): ?>
let previousPackageServiceIds = [];

function updatePriceSummary() {
    const summaryBox = document.getElementById('priceSummary');
    const itemsEl = document.getElementById('summaryItems');
    const totalEl = document.getElementById('summaryTotal');
    let items = [];
    let total = 0;

    document.querySelectorAll('.package-checkbox:checked').forEach(cb => {
        const card = cb.closest('.package-card');
        const name = card?.querySelector('.font-bold.text-gray-800')?.textContent || '';
        const priceText = card?.querySelector('.text-xl.font-extrabold')?.textContent || '0';
        const price = parseFloat(priceText) || 0;
        items.push({ name, price, type: 'package' });
        total += price;
    });

    document.querySelectorAll('.service-checkbox:checked:not(:disabled)').forEach(cb => {
        const item = cb.closest('.service-item');
        const name = item?.querySelector('span.font-bold')?.textContent || '';
        const priceText = item?.querySelector('.text-rose-600.font-bold')?.textContent || '0';
        const price = parseInt(priceText) || 0;
        items.push({ name, price, type: 'service' });
        total += price;
    });

    if (items.length === 0) {
        summaryBox.classList.add('hidden');
        return;
    }

    summaryBox.classList.remove('hidden');
    itemsEl.innerHTML = '';
    items.forEach(i => {
        const row = document.createElement('div');
        row.className = 'flex justify-between items-center py-1 text-sm';
        const nameSpan = document.createElement('span');
        nameSpan.className = i.type === 'package' ? 'text-rose-600' : 'text-gray-700';
        if (i.type === 'package') {
            const badge = document.createElement('span');
            badge.className = 'text-xs bg-rose-100 text-rose-700 px-1.5 py-0.5 rounded font-bold';
            badge.textContent = '<?php echo e(__("Package")); ?>';
            nameSpan.appendChild(badge);
            nameSpan.appendChild(document.createTextNode(' ' + i.name));
        } else {
            nameSpan.textContent = i.name;
        }
        row.appendChild(nameSpan);
        const priceSpan = document.createElement('span');
        priceSpan.className = 'font-bold';
        priceSpan.textContent = i.price + ' <?php echo e(__("KWD")); ?>';
        row.appendChild(priceSpan);
        itemsEl.appendChild(row);
    });
    totalEl.textContent = total + ' <?php echo e(__("KWD")); ?>';

    summaryBox.style.transform = 'scale(0.95)';
    summaryBox.style.opacity = '0';
    requestAnimationFrame(() => {
        summaryBox.style.transition = 'all 0.2s ease-out';
        summaryBox.style.transform = 'scale(1)';
        summaryBox.style.opacity = '1';
    });
}

function updatePackages() {
    const checkedBoxes = document.querySelectorAll('.package-checkbox:checked');
    const infoBox = document.getElementById('packageServicesInfo');
    const infoText = document.getElementById('packageServicesText');
    const tagsContainer = document.getElementById('packageServicesTags');
    const servicesLabel = document.getElementById('servicesLabel');

    let allSelectedServiceIds = [];
    let allSelectedNames = [];
    let allSelectedTags = [];

    checkedBoxes.forEach(cb => {
        const card = cb.closest('.package-card');
        const name = card ? card.querySelector('.font-bold.text-gray-800')?.textContent || '' : '';
        const tagText = card ? card.querySelector('.text-gray-400.text-sm.truncate')?.textContent || '' : '';
        const services = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allSelectedServiceIds = allSelectedServiceIds.concat(services);
        if (name) {
            allSelectedNames.push(name);
            if (tagText) {
                allSelectedTags = allSelectedTags.concat(tagText.split(' + '));
            }
        }
    });

    document.querySelectorAll('.package-card').forEach(card => {
        const cb = card.querySelector('.package-checkbox');
        card.classList.toggle('border-rose-300', cb.checked);
        card.classList.toggle('bg-rose-50/40', cb.checked);
        card.classList.toggle('shadow-sm', cb.checked);
        card.classList.toggle('border-gray-100', !cb.checked);
    });

    document.querySelectorAll('.service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackageService = allSelectedServiceIds.includes(sid);
        const wasPackageService = previousPackageServiceIds.includes(sid);

        if (isPackageService) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-item').classList.add('border-rose-200', 'bg-rose-50/30');
            cb.closest('.service-item').classList.remove('border-gray-100', 'bg-white', 'hover:border-amber-200', 'hover:shadow-sm');
            cb.closest('.service-item').querySelector('span.font-bold')?.classList.add('text-rose-600');
            let badge = cb.closest('.service-item').querySelector('.package-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'package-badge text-xs text-rose-500 mr-1';
                badge.textContent = '<?php echo e(__("From package")); ?>';
                const container = cb.closest('.service-item').querySelector('.flex.items-center.gap-3.min-w-0 div');
                if (container) container.appendChild(badge);
            }
        } else {
            if (wasPackageService && !isPackageService) {
                cb.checked = false;
            }
            cb.disabled = false;
            cb.closest('.service-item').classList.remove('border-rose-200', 'bg-rose-50/30');
            cb.closest('.service-item').classList.add('border-gray-100', 'bg-white', 'hover:border-amber-200', 'hover:shadow-sm');
            cb.closest('.service-item').querySelector('span.font-bold')?.classList.remove('text-rose-600');
            const badge = cb.closest('.service-item').querySelector('.package-badge');
            if (badge) badge.remove();
        }
    });

    previousPackageServiceIds = allSelectedServiceIds;

    if (checkedBoxes.length > 0) {
        infoText.textContent = '<?php echo e(__("Package Services")); ?>: ' + allSelectedNames.join(' + ');
        tagsContainer.innerHTML = '';
        [...new Set(allSelectedTags)].forEach(s => {
            const tag = document.createElement('span');
            tag.className = 'bg-rose-100 text-rose-700 text-sm px-3 py-1.5 rounded-lg';
            tag.textContent = '✅ ' + s.trim();
            tagsContainer.appendChild(tag);
        });
        infoBox.classList.remove('hidden');
        servicesLabel.textContent = '<?php echo e(__("Extra Services for Package")); ?>';
    } else {
        infoBox.classList.add('hidden');
        servicesLabel.textContent = '<?php echo e(__("Services")); ?>';
    }

    updatePriceSummary();
}

document.querySelectorAll('.service-checkbox:not(:disabled)').forEach(cb => {
    cb.addEventListener('change', updatePriceSummary);
});

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.package-checkbox:checked')) {
        updatePackages();
    }
    updatePriceSummary();
});
<?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/customer/book.blade.php ENDPATH**/ ?>