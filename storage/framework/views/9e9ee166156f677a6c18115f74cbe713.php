
<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', __('alnjoom Beauty Salon Description')); ?>">
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', __('site_name')); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta_description', __('alnjoom Beauty Salon')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image" content="<?php echo e(asset('images/og-default.jpg')); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="<?php echo e(app()->getLocale() === 'ar' ? 'ar_KW' : 'en_US'); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="<?php echo e(asset('images/og-default.jpg')); ?>">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link rel="alternate icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="alternate" hreflang="en" href="<?php echo e(url()->current() . '?locale=en'); ?>">
    <link rel="alternate" hreflang="ar" href="<?php echo e(url()->current() . '?locale=ar'); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo e(url('/')); ?>">
    <title><?php echo $__env->yieldContent('title', __('site_name')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>body{font-family:'Tajawal','Segoe UI',Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6{font-family:'Playfair Display','Tajawal',serif;}</style>
    <?php
        $siteName = app()->getLocale() === 'ar' ? 'رونق النجوم' : config('app.name');
        $ld = [
            '@context' => 'https://schema.org',
            '@type' => 'BeautySalon',
            'name' => $siteName,
            'description' => __('Beauty Salon Description'),
            'url' => url('/'),
            'telephone' => config('app.phone', '+965 1234 5678'),
            'email' => config('app.contact_email', 'info@rawnaqalnujoom.com'),
            'image' => asset('images/Header.webp'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => __('Kuwait — Salmiya, Arabian Gulf Street'),
                'addressLocality' => 'Salmiya',
                'addressRegion' => 'Kuwait City',
                'addressCountry' => 'KW',
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                    'opens' => '10:00',
                    'closes' => '22:00',
                ],
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => 'Friday',
                    'opens' => '13:00',
                    'closes' => '20:00',
                ],
            ],
            'priceRange' => '$$',
            'sameAs' => ['https://www.instagram.com/rawnaqalnujoom'],
        ];
    ?>
    <script type="application/ld+json">
    <?php echo json_encode($ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE, 512) ?>
    </script>
</head>
    <body class="font-sans antialiased bg-rose-50/40">
    
    <nav class="bg-white shadow-md border-b border-gray-100 sticky top-0 z-50">
        <input type="checkbox" id="menu-toggle-cb" class="hidden peer">
        <label for="menu-toggle-cb" class="fixed inset-0 z-40 hidden peer-checked:block cursor-default"></label>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14 md:h-16">
                
                <div>
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                        <picture>
                            <source srcset="<?php echo e(asset('images/Header.webp')); ?>" type="image/webp">
                            <img src="<?php echo e(asset('images/Header.png')); ?>" alt="<?php echo e(__('site_name')); ?>" class="h-12 w-auto md:h-14 -ml-[21px]">
                        </picture>
                        <div class="flex flex-col justify-center min-w-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() === 'en'): ?>
                                <span class="text-rose-900 font-bold text-xl leading-tight"><?php echo e(config('app.name')); ?></span>
                                <span class="text-gray-500 font-medium text-xs tracking-wider" dir="rtl">رونق النجوم</span>
                            <?php else: ?>
                                <span class="text-rose-900 font-bold text-xl leading-tight"><?php echo e(__('site_name')); ?></span>
                                <span class="text-gray-500 font-medium text-xs tracking-wider"><?php echo e(config('app.name')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center gap-0.5">
                    <a href="<?php echo e(route('services')); ?>" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap <?php echo e(request()->routeIs('services') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50'); ?>">
                        <?php echo e(__('Services')); ?>

                    </a>
                    <a href="<?php echo e(route('about')); ?>" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap <?php echo e(request()->routeIs('about') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50'); ?>">
                        <?php echo e(__('About Us')); ?>

                    </a>
                    <a href="<?php echo e(route('faq')); ?>" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap <?php echo e(request()->routeIs('faq') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50'); ?>">
                        <?php echo e(__('Faq')); ?>

                    </a>
                    <a href="<?php echo e(route('contact')); ?>" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap <?php echo e(request()->routeIs('contact') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50'); ?>">
                        <?php echo e(__('Contact Us')); ?>

                    </a>
                    <a href="<?php echo e(route('track')); ?>" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap <?php echo e(request()->routeIs('track') || request()->routeIs('track.*') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50'); ?>">
                        <?php echo e(__('Track Booking')); ?>

                    </a>
                </div>
                
                <div class="flex items-center gap-1.5 justify-end shrink-0">
                     <a href="<?php echo e(route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar')); ?>"
                        class="px-2 md:px-3 py-1.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 font-medium text-xs md:text-sm transition-all duration-200">
                         <?php echo e(app()->getLocale() === 'ar' ? 'EN' : 'عربي'); ?>

                     </a>
                     <a href="<?php echo e(route('book')); ?>"
                         class="hidden md:inline-flex bg-gradient-to-l from-rose-500 to-rose-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-xl font-medium shadow-sm shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200 text-xs md:text-sm">
                         <?php echo e(__('Book Now')); ?>

                     </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin() || auth()->user()->isOwner()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-rose-600 hover:text-rose-700 font-medium px-2 md:px-3 py-1.5 md:py-2 rounded-lg hover:bg-rose-50 transition-all duration-200 text-xs md:text-sm"><?php echo e(__('Admin Panel')); ?></a>
                        <?php elseif(auth()->user()->isEmployee()): ?>
                            <a href="<?php echo e(route('employee.dashboard')); ?>" class="text-rose-600 hover:text-rose-700 font-medium px-2 md:px-3 py-1.5 md:py-2 rounded-lg hover:bg-rose-50 transition-all duration-200 text-xs md:text-sm"><?php echo e(__('Employee Dashboard')); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('customer.profile')); ?>" class="text-rose-600 hover:text-rose-700 font-medium px-2 md:px-3 py-1.5 md:py-2 rounded-lg hover:bg-rose-50 transition-all duration-200 text-xs md:text-sm"><?php echo e(__('My Account')); ?></a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" title="<?php echo e(__('Logout')); ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('register')); ?>" class="hidden md:inline-flex bg-gradient-to-l from-amber-400 to-amber-500 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-xl font-medium shadow-sm shadow-amber-200 hover:from-amber-500 hover:to-amber-600 transition-all duration-200 text-xs md:text-sm"><?php echo e(__('Register / Login')); ?></a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <label for="menu-toggle-cb" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-rose-600 hover:bg-rose-50 transition-all duration-200 cursor-pointer">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="hidden peer-checked:block md:hidden border-t border-rose-100/20 bg-white/70 backdrop-blur-xl shadow-lg shadow-rose-900/10 relative z-50">
            <div class="px-4 py-4 space-y-1">
                <a href="<?php echo e(route('services')); ?>" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('services') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600'); ?>">
                    <?php echo e(__('Services')); ?>

                </a>
                <a href="<?php echo e(route('about')); ?>" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('about') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600'); ?>">
                    <?php echo e(__('About Us')); ?>

                </a>
                <a href="<?php echo e(route('faq')); ?>" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('faq') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600'); ?>">
                    <?php echo e(__('Faq')); ?>

                </a>
                <a href="<?php echo e(route('contact')); ?>" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('contact') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600'); ?>">
                    <?php echo e(__('Contact Us')); ?>

                </a>
                <a href="<?php echo e(route('track')); ?>" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('track') || request()->routeIs('track.*') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600'); ?>">
                    <?php echo e(__('Track Booking')); ?>

                </a>
                <hr class="my-3 border-gray-100">
                <div class="flex flex-col gap-2 px-4">
                    <a href="<?php echo e(route('book')); ?>" class="w-full text-center bg-gradient-to-l from-rose-500 to-rose-600 text-white px-4 py-2.5 rounded-xl font-medium text-sm shadow-sm"><?php echo e(__('Book Now')); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin() || auth()->user()->isOwner()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="w-full text-center text-rose-600 hover:bg-rose-50 px-4 py-2.5 rounded-xl font-medium text-sm transition-all"><?php echo e(__('Admin Panel')); ?></a>
                        <?php elseif(auth()->user()->isEmployee()): ?>
                            <a href="<?php echo e(route('employee.dashboard')); ?>" class="w-full text-center text-rose-600 hover:bg-rose-50 px-4 py-2.5 rounded-xl font-medium text-sm transition-all"><?php echo e(__('Employee Dashboard')); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('customer.profile')); ?>" class="w-full text-center text-rose-600 hover:bg-rose-50 px-4 py-2.5 rounded-xl font-medium text-sm transition-all"><?php echo e(__('My Account')); ?></a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('register')); ?>" class="w-full text-center bg-gradient-to-l from-amber-400 to-amber-500 text-white px-4 py-2.5 rounded-xl font-medium text-sm"><?php echo e(__('Register / Login')); ?></a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <div id="app" class="overflow-x-hidden">
    
    <main class="py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="bg-gradient-to-br from-rose-900 via-rose-800 to-amber-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="#" aria-label="<?php echo e(__('Instagram')); ?>" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2"/></svg>
                    </a>
                    <a href="#" aria-label="<?php echo e(__('WhatsApp')); ?>" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                    </a>
                    <a href="#" aria-label="<?php echo e(__('Snapchat')); ?>" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </a>
                </div>
                <div class="flex items-center gap-3 text-xs text-rose-300">
                    <a href="#" class="hover:text-amber-300 transition-colors"><?php echo e(__('Privacy Policy')); ?></a>
                    <span class="text-rose-500">·</span>
                    <a href="#" class="hover:text-amber-300 transition-colors"><?php echo e(__('Terms of Service')); ?></a>
                </div>
                <div class="text-xs text-rose-400">
                    © <?php echo e(date('Y')); ?> <?php echo e(__('site_name')); ?> — <?php echo e(__('All Rights Reserved')); ?>

                </div>
            </div>
        </div>
    </footer>

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
</div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/public.blade.php ENDPATH**/ ?>