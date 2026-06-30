<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>" style="overflow-x:hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', __('My Account').' - '.__('site_name')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta name="description" content="<?php echo e(__('Customer Dashboard Description')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>body{font-family:'Tajawal','Segoe UI',Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6{font-family:'Playfair Display','Tajawal',serif;}</style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-rose-50 via-white to-amber-50 min-h-screen">
    
    <nav class="bg-white/80 backdrop-blur-md shadow-sm border-b border-rose-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between h-16 items-center">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-1.5">
                    <picture>
                        <source srcset="<?php echo e(asset('images/Header.webp')); ?>" type="image/webp">
                        <img src="<?php echo e(asset('images/Header.png')); ?>" alt="<?php echo e(__('site_name')); ?>" class="h-10 w-auto md:h-12 -ml-[21px]">
                    </picture>
                    <div class="hidden md:flex flex-col justify-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() === 'en'): ?>
                            <span class="text-rose-900 font-bold text-lg leading-tight"><?php echo e(config('app.name')); ?></span>
                            <span class="text-gray-500 font-medium text-xs tracking-wider" dir="rtl">رونق النجوم</span>
                        <?php else: ?>
                            <span class="text-rose-900 font-bold text-lg leading-tight"><?php echo e(__('site_name')); ?></span>
                            <span class="text-gray-500 font-medium text-xs tracking-wider"><?php echo e(config('app.name')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </a>
                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="<?php echo e(route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar')); ?>"
                       class="px-2.5 py-1 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 font-medium text-xs transition-all duration-200">
                        <?php echo e(app()->getLocale() === 'ar' ? 'EN' : 'عربي'); ?>

                    </a>
                    <a href="<?php echo e(route('book')); ?>"
                       class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-l from-rose-500 to-rose-600 text-white rounded-xl text-sm font-medium shadow-sm shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <?php echo e(__('New Booking')); ?>

                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->routeIs('customer.profile')): ?>
                        <a href="<?php echo e(route('customer.appointments')); ?>"
                           class="text-gray-600 hover:text-rose-600 transition text-sm font-medium px-2 py-1">
                            <?php echo e(__('My Bookings')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('customer.profile')); ?>"
                           class="text-gray-600 hover:text-rose-600 transition text-sm font-medium px-2 py-1">
                            <?php echo e(__('My Account')); ?>

                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-red-400 hover:text-red-500 transition text-sm font-medium px-2 py-1">
                            <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline"><?php echo e(__('Logout')); ?></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.whatsapp-button', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translate(-50%, -16px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        .animate-fade-in {
            animation: fadeInDown 0.4s ease-out;
        }
    </style>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/customer.blade.php ENDPATH**/ ?>