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
    <title><?php echo $__env->yieldContent('title', __('Admin Control').' - '.__('site_name')); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link rel="alternate icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>body{font-family:'Tajawal','Segoe UI',Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6{font-family:'Playfair Display','Tajawal',serif;}</style>
</head>
<body class="font-sans antialiased bg-gray-100">

<div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden" data-toggle-sidebar></div>

<div class="flex h-screen">

    <aside id="sidebar" class="fixed md:relative w-64 bg-white shadow-lg z-40 h-full transition-all duration-300 md:translate-x-0 flex flex-col">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-1.5">
                <picture>
                    <source srcset="<?php echo e(asset('images/Header.webp')); ?>" type="image/webp">
                    <img src="<?php echo e(asset('images/Header.png')); ?>" alt="<?php echo e(__('site_name')); ?>" class="h-10 w-auto md:h-12 -ml-[21px]">
                </picture>
                <div class="flex flex-col justify-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() === 'en'): ?>
                        <span class="text-rose-900 font-bold text-base leading-tight" style="font-size:13px"><?php echo e(config('app.name')); ?></span>
                        <span class="text-gray-500 font-medium text-[10px] tracking-wider" dir="rtl" style="font-size:12px">رونق النجوم</span>
                    <?php else: ?>
                        <span class="text-rose-900 font-bold text-base leading-tight"><?php echo e(__('site_name')); ?></span>
                        <span class="text-gray-500 font-medium text-[13px] tracking-wider" style="font-size:12px"><?php echo e(config('app.name')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </a>
            <button data-toggle-sidebar class="md:hidden text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.dashboard') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span><?php echo e(__('Dashboard')); ?></span>
            </a>
            <a href="<?php echo e(route('admin.appointments.index')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.appointments.*') && !request()->routeIs('admin.appointments.cancelled') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.appointments.*') && !request()->routeIs('admin.appointments.cancelled') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span><?php echo e(__('Bookings')); ?></span>
            </a>

            <div class="my-2 border-t border-gray-100"></div>
            <a href="<?php echo e(route('admin.employees.index')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.employees.*') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.employees.*') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span><?php echo e(__('Employees')); ?></span>
            </a>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.customers.*') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.customers.*') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span><?php echo e(__('Customers')); ?></span>
            </a>
            <a href="<?php echo e(route('admin.services.index')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.services.*') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.services.*') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2M3 8V6a1 1 0 011-1h16a1 1 0 011 1v2M5 8h14l-1.5 8H6.5L5 8z"/></svg>
                <span><?php echo e(__('Services')); ?></span>
            </a>
            <a href="<?php echo e(route('admin.packages.index')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.packages.*') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.packages.*') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span><?php echo e(__('Packages')); ?></span>
            </a>
            <a href="<?php echo e(route('admin.schedule')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.schedule') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.schedule') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span><?php echo e(__('Schedules')); ?></span>
            </a>
            <a href="<?php echo e(route('admin.reports')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.reports') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <svg class="w-5 h-5 shrink-0 <?php echo e(request()->routeIs('admin.reports') ? 'text-amber-500' : 'text-gray-400 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span><?php echo e(__('Reports')); ?></span>
            </a>
            <div class="my-2 border-t border-gray-100"></div>
            <a href="<?php echo e(route('home')); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                <svg class="w-5 h-5 shrink-0 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m0 0c1.657 0 3 4.03 3 9s-1.343 9-3 9z"/></svg>
                <span><?php echo e(__('Main Site')); ?></span>
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                    <svg class="w-5 h-5 shrink-0 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span><?php echo e(__('Logout')); ?></span>
                </button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 overflow-auto">
        <header class="bg-white shadow-sm p-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <button data-toggle-sidebar class="md:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800"><?php echo $__env->yieldContent('page-title'); ?></h1>
                </div>
                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar')); ?>"
                       class="px-2.5 py-1 rounded-lg border border-amber-200 text-amber-600 hover:bg-amber-50 font-medium text-xs transition-all duration-200">
                        <?php echo e(app()->getLocale() === 'ar' ? 'EN' : 'عربي'); ?>

                    </a>
                    <button id="notifBellBtn" onclick="toggleNotifPanel()" class="relative text-gray-500 hover:text-amber-600 transition-colors" title="<?php echo e(__('New Bookings')); ?>">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span id="notifBadge" class="absolute -top-1.5 -left-1.5 bg-red-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full shadow-sm border-2 border-white" style="display:none">0</span>
                    </button>
                    <span class="text-gray-500"><?php echo e(auth()->user()->name); ?></span>
                </div>
            </div>
        </header>

        
        <div id="notifPanel" class="hidden fixed w-80 md:w-96 bg-white rounded-2xl shadow-xl border border-gray-200 z-50 overflow-hidden" style="max-height: calc(100vh - 120px);">
            <div class="bg-gradient-to-l from-amber-50 to-white px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="font-bold text-gray-800 text-sm"><?php echo e(__('Booking Notifications')); ?></span>
                </div>
                <button onclick="toggleNotifPanel()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="notifList" class="overflow-y-auto" style="max-height: calc(100vh - 190px);">
                <div class="flex items-center justify-center py-12 text-gray-400">
                    <div class="text-center">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <p class="text-sm"><?php echo e(__('Awaiting New Bookings')); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<?php echo $__env->make('partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
document.addEventListener('click', function(e) {
    if (e.target.closest('[data-toggle-sidebar]')) {
        toggleSidebar();
    }
});
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebarOverlay');
    const isRtl = document.documentElement.dir === 'rtl';
    if (s.dataset.open === 'true') {
        s.style.transform = isRtl ? 'translateX(100%)' : 'translateX(-100%)';
        s.dataset.open = 'false';
        o.classList.add('hidden');
    } else {
        s.style.transform = 'translateX(0)';
        s.dataset.open = 'true';
        o.classList.remove('hidden');
    }
}

window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
        const s = document.getElementById('sidebar');
        s.style.transform = '';
        s.dataset.open = 'false';
        document.getElementById('sidebarOverlay').classList.add('hidden');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // ===== Real-time notification system =====
    var notifiedIds = new Set();
    var notifPanel = document.getElementById('notifPanel');
    var notifList = document.getElementById('notifList');
    var notifBadge = document.getElementById('notifBadge');
    var notifCount = 0;
    var notifSeenTime = '<?php echo e(now()->toDateTimeString()); ?>';

    function addNotifItem(booking) {
        notifCount++;
        notifBadge.style.display = '';
        notifBadge.textContent = notifCount;

        var emptyMsg = notifList.querySelector('.flex.items-center.justify-center.py-12');
        if (emptyMsg) emptyMsg.remove();

        var item = document.createElement('div');
        item.className = 'px-4 py-3.5 hover:bg-amber-50/50 transition-colors border-b border-gray-50 last:border-b-0 animate-notif-in';
        item.innerHTML =
            '<div class="flex items-start gap-3">' +
                '<div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">' +
                    '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>' +
                '</div>' +
                '<div class="flex-1 min-w-0">' +
                    '<div class="flex items-center justify-between gap-2">' +
                        '<span class="font-bold text-gray-800 text-sm truncate" data-notif="name"></span>' +
                        '<span class="text-[10px] text-gray-400 shrink-0" data-notif="time"></span>' +
                    '</div>' +
                    '<div class="flex items-center gap-2 mt-0.5">' +
                        '<span class="text-xs text-gray-500 truncate" data-notif="services"></span>' +
                        '<span class="text-xs font-bold text-amber-600 shrink-0" data-notif="total"></span>' +
                    '</div>' +
                    '<div class="flex items-center gap-2 mt-1.5">' +
                        '<span class="text-[10px] bg-amber-50 text-amber-700 px-2 py-0.5 rounded font-medium" data-notif="date"></span>' +
                        '<span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-medium" data-notif="shift"></span>' +
                        '<span class="text-[10px] font-mono text-gray-400" data-notif="ticket"></span>' +
                    '</div>' +
                '</div>' +
                '<a href="#" class="shrink-0 text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg px-2.5 py-1.5 text-xs font-medium transition-colors" data-notif="link"><?php echo e(__("view")); ?></a>' +
            '</div>';

        var link = item.querySelector('[data-notif="link"]');
        if (link) {
            var safeId = typeof booking.id === 'number' ? booking.id : parseInt(booking.id, 10);
            if (Number.isFinite(safeId)) {
                link.href = '/admin/appointments/' + safeId;
            }
        }

        item.querySelector('[data-notif="name"]').textContent = booking.customer_name;
        item.querySelector('[data-notif="time"]').textContent = booking.created_at;
        item.querySelector('[data-notif="services"]').textContent = booking.display_services;
        item.querySelector('[data-notif="total"]').textContent = booking.total + ' <?php echo e(__("KWD")); ?>';
        item.querySelector('[data-notif="date"]').textContent = booking.date;
        item.querySelector('[data-notif="shift"]').textContent = booking.shift;
        item.querySelector('[data-notif="ticket"]').textContent = booking.ticket;

        notifList.prepend(item);

        while (notifList.children.length > 30) {
            notifList.removeChild(notifList.lastChild);
        }
    }

    function pollNotifications() {
        fetch('<?php echo e(route("admin.notifications.recent")); ?>?since=' + encodeURIComponent(notifSeenTime), {
            headers: { 'Accept': 'application/json' }
        })
        .then(function(r) {
            if (!r.ok) throw new Error('Notif poll HTTP ' + r.status);
            return r.json();
        })
        .then(function(data) {
            notifSeenTime = data.server_time;
            var newOnes = data.bookings.filter(function(b) { return !notifiedIds.has(b.id); });
            if (newOnes.length > 0) {
                newOnes.forEach(function(b) {
                    notifiedIds.add(b.id);
                    addNotifItem(b);
                });
            }
        })
        .catch(function(err) { console.error('Notif poll error:', err); });
    }

    setInterval(pollNotifications, 7000);
    setTimeout(pollNotifications, 3000);
});

function toggleNotifPanel() {
    var panel = document.getElementById('notifPanel');
    var btn = document.getElementById('notifBellBtn');
    if (panel.classList.contains('hidden')) {
        panel.style.visibility = 'hidden';
        panel.classList.remove('hidden');
        var rect = btn.getBoundingClientRect();
        var panelWidth = panel.offsetWidth;
        var top = rect.bottom + 8;
        var left = rect.left + window.scrollX + rect.width - panelWidth;
        if (left < 8) left = 8;
        if (left + panelWidth > window.innerWidth - 8) {
            left = window.innerWidth - panelWidth - 8;
        }
        panel.style.top = top + 'px';
        panel.style.left = left + 'px';
        panel.style.visibility = '';
    } else {
        panel.classList.add('hidden');
    }
}

// ===== Inline Confirmation Dropdown =====
window.inlineConfirm = function(btn, event, message) {
    event.preventDefault();
    var form = btn.closest('form');
    var existing = document.querySelector('.inline-confirm-dropdown');
    if (existing) existing.remove();

    var dropdown = document.createElement('div');
    dropdown.className = 'inline-confirm-dropdown fixed z-50 bg-white rounded-xl shadow-xl border border-gray-200 p-4 min-w-[220px] animate-fade-in';

    var yesText = '<?php echo e(__("Yes, Delete")); ?>';
    var cancelText = '<?php echo e(__("Cancel")); ?>';

    var msgP = document.createElement('p');
    msgP.className = 'text-sm text-gray-700 mb-3 leading-relaxed';
    msgP.textContent = message;
    dropdown.appendChild(msgP);

    var btnDiv = document.createElement('div');
    btnDiv.className = 'flex gap-2 justify-end';
    btnDiv.innerHTML =
        '<button type="button" class="inline-confirm-cancel px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-200 transition-colors">' + cancelText + '</button>' +
        '<button type="button" class="inline-confirm-yes px-3 py-1.5 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition-colors">' + yesText + '</button>';
    dropdown.appendChild(btnDiv);

    var rect = btn.getBoundingClientRect();
    dropdown.style.left = Math.max(8, rect.left) + 'px';
    dropdown.style.top = (rect.bottom + 6) + 'px';

    document.body.appendChild(dropdown);

    dropdown.querySelector('.inline-confirm-yes').onclick = function() {
        form.submit();
    };

    var close = function() {
        dropdown.remove();
    };
    dropdown.querySelector('.inline-confirm-cancel').onclick = close;

    setTimeout(function() {
        document.addEventListener('click', function handler(e) {
            if (!dropdown.contains(e.target) && e.target !== btn) {
                dropdown.remove();
                document.removeEventListener('click', handler);
            }
        });
    }, 0);
};
</script>
<style>
@keyframes fadeInDown { from { opacity: 0; transform: translate(-50%, -16px); } to { opacity: 1; transform: translate(-50%, 0); } }
@keyframes notifIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fadeInDown 0.4s ease-out; }
.animate-notif-in { animation: notifIn 0.3s ease-out; }
@media (max-width: 767px) { #sidebar { transform: translateX(-100%); } html[dir="rtl"] #sidebar { transform: translateX(100%); } }
#notifList::-webkit-scrollbar { width: 4px; }
#notifList::-webkit-scrollbar-track { background: transparent; }
#notifList::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
</style>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/admin.blade.php ENDPATH**/ ?>