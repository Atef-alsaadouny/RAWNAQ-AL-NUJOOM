<?php
    $initial = mb_substr($user->name, 0, 1);
?>

<?php use App\Models\Appointment; ?>


<?php $__env->startSection('title', __('My Account')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">

    
    <div class="bg-gradient-to-br from-rose-50 via-white to-amber-50 rounded-[2rem] shadow-xl shadow-rose-200/50 p-8 flex items-center gap-5">
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-amber-400 to-rose-500 flex items-center justify-center text-white text-2xl font-bold shadow-md shrink-0">
            <?php echo e($initial); ?>

        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><?php echo e(__('Welcome')); ?>, <?php echo e($user->name); ?></h1>
            <p class="text-gray-500 mt-0.5"><?php echo e(__('Member since')); ?> <span dir="ltr" class="inline-block"><?php echo e($user->created_at->format('Y-m-d')); ?></span></p>
        </div>
    </div>

    
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-5 text-center">
            <p class="text-3xl font-bold text-amber-600"><?php echo e($totalBookings); ?></p>
            <p class="text-sm text-gray-500 mt-1"><?php echo e(__('Total Bookings')); ?></p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-5 text-center">
            <p class="text-3xl font-bold text-rose-500"><?php echo e($activeBookings); ?></p>
            <p class="text-sm text-gray-500 mt-1"><?php echo e(__('In Progress')); ?></p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-5 text-center">
            <p class="text-3xl font-bold text-green-500"><?php echo e($completedBookings); ?></p>
            <p class="text-sm text-gray-500 mt-1"><?php echo e(__('Completed')); ?></p>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingAppointment): ?>
    <div class="bg-gradient-to-br from-amber-50 via-white to-rose-50 rounded-[2rem] shadow-md shadow-amber-100/50 p-6">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Your Upcoming Booking')); ?></h2>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="space-y-1.5">
                <p class="text-gray-700">
                    <span class="text-gray-500"><?php echo e(__('Date')); ?>:</span>
                    <span class="font-semibold" dir="ltr"><?php echo e($upcomingAppointment->appointment_date->format('Y-m-d')); ?></span>
                </p>
                <p class="text-gray-700">
                    <span class="text-gray-500"><?php echo e(__('Shift')); ?>:</span>
                    <span class="font-semibold"><?php echo e($upcomingAppointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening')); ?></span>
                </p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingAppointment->display_services): ?>
                <p class="text-gray-700">
                    <span class="text-gray-500"><?php echo e(__('Services')); ?>:</span>
                    <span class="font-semibold"><?php echo e($upcomingAppointment->display_services); ?></span>
                </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="text-gray-700">
                    <span class="text-gray-500"><?php echo e(__('Status')); ?>:</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($upcomingAppointment->status):
                        case (Appointment::STATUS_PENDING): ?> <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-lg text-sm font-medium"><?php echo e(__('Pending')); ?></span> <?php break; ?>
                        <?php case (Appointment::STATUS_ASSIGNED): ?> <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-lg text-sm font-medium"><?php echo e(__('Assigned')); ?></span> <?php break; ?>
                        <?php case (Appointment::STATUS_IN_PROGRESS): ?> <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-lg text-sm font-medium"><?php echo e(__('In Progress')); ?></span> <?php break; ?>
                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
            <a href="<?php echo e(route('customer.appointment.show', $upcomingAppointment)); ?>"
               class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-gradient-to-l from-amber-500 to-amber-600 text-white rounded-xl text-sm font-medium shadow-md shadow-amber-200 hover:from-amber-600 hover:to-amber-700 transition-all duration-200">
                <?php echo e(__('View Details')); ?>

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <details class="bg-white rounded-[2rem] shadow-sm border border-rose-100 group" <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
        <summary class="p-6 cursor-pointer list-none flex items-center justify-between select-none hover:bg-rose-50/50 rounded-[2rem] transition-all">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Edit Your Account Information')); ?></h2>
            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </summary>
        <div class="px-6 pb-6">
            <form method="POST" action="<?php echo e(route('customer.profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5"><?php echo e(__('Name')); ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5"><?php echo e(__('Mobile Number')); ?> <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            inputmode="numeric" placeholder="6xxxxxxx">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5"><?php echo e(__('Email')); ?> <span class="text-xs text-gray-400 font-normal"><?php echo e(__('(Optional)')); ?></span></label>
                        <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-l from-rose-500 to-rose-600 text-white rounded-xl text-sm font-medium shadow-md shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <?php echo e(__('Save Changes')); ?>

                    </button>
                </div>
            </form>
        </div>
    </details>

    
    <details class="bg-white rounded-[2rem] shadow-sm border border-rose-100 group" <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> open <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
        <summary class="p-6 cursor-pointer list-none flex items-center justify-between select-none hover:bg-rose-50/50 rounded-[2rem] transition-all">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Change Password')); ?></h2>
            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </summary>
        <div class="px-6 pb-6">
            <form method="POST" action="<?php echo e(route('customer.profile.password')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5"><?php echo e(__('Current Password')); ?> <span class="text-red-500">*</span></label>
                        <input type="password" name="current_password"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5"><?php echo e(__('New Password')); ?> <span class="text-red-500">*</span></label>
                        <input type="password" name="new_password"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5"><?php echo e(__('Confirm New Password')); ?> <span class="text-red-500">*</span></label>
                        <input type="password" name="new_password_confirmation"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px]">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-l from-rose-500 to-rose-600 text-white rounded-xl text-sm font-medium shadow-md shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <?php echo e(__('Change Password')); ?>

                    </button>
                </div>
            </form>
        </div>
    </details>

    
    <div class="bg-white rounded-[2rem] shadow-sm border border-rose-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-gray-800"><?php echo e(__('Recent Bookings')); ?></h2>
            <a href="<?php echo e(route('customer.appointments')); ?>" class="text-rose-600 hover:text-rose-700 text-sm font-medium inline-flex items-center gap-1">
                <?php echo e(__('View All')); ?>

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentBookings->count()): ?>
        <div class="space-y-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <a href="<?php echo e(route('customer.appointment.show', $apt)); ?>"
               class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:shadow-sm transition-all duration-200 group">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-gray-800 text-[15px] break-words"><?php echo e($apt->display_services ?: __('Booking')); ?></p>
                        <p class="text-sm text-gray-500" dir="ltr"><?php echo e($apt->appointment_date->format('Y-m-d')); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($apt->status):
                        case (Appointment::STATUS_PENDING): ?> <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-lg text-xs font-medium"><?php echo e(__('Pending')); ?></span> <?php break; ?>
                        <?php case (Appointment::STATUS_ASSIGNED): ?> <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-lg text-xs font-medium"><?php echo e(__('Assigned')); ?></span> <?php break; ?>
                        <?php case (Appointment::STATUS_IN_PROGRESS): ?> <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-lg text-xs font-medium"><?php echo e(__('In Progress')); ?></span> <?php break; ?>
                        <?php case (Appointment::STATUS_COMPLETED): ?> <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-lg text-xs font-medium"><?php echo e(__('Completed')); ?></span> <?php break; ?>
                        <?php case (Appointment::STATUS_CANCELLED): ?> <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-lg text-xs font-medium"><?php echo e(__('Cancelled')); ?></span> <?php break; ?>
                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php else: ?>
        <p class="text-gray-400 text-center py-6"><?php echo e(__('You have no bookings yet')); ?> 😊</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.customer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/customer/profile.blade.php ENDPATH**/ ?>