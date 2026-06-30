<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="overflow-x:hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Employee').' - '.__('site_name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>body{font-family:'Tajawal','Segoe UI',Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6{font-family:'Playfair Display','Tajawal',serif;}</style>
</head>
<body class="font-sans antialiased bg-gray-100">

<div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden" data-toggle-sidebar></div>

<div class="flex h-screen">

    <aside id="sidebar" class="fixed md:relative w-64 bg-white shadow-lg z-40 h-full transition-all duration-300 md:translate-x-0 flex flex-col">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-1.5">
                <picture>
                    <source srcset="{{ asset('images/Header.webp') }}" type="image/webp">
                    <img src="{{ asset('images/Header.png') }}" alt="{{ __('site_name') }}" class="h-10 w-auto md:h-12 -ml-[21px]">
                </picture>
                <div class="flex flex-col justify-center">
                    @if(app()->getLocale() === 'en')
                        <span class="text-rose-900 font-bold text-base leading-tight" style="font-size:13px">{{ config('app.name') }}</span>
                        <span class="text-gray-500 font-medium text-[10px] tracking-wider" dir="rtl" style="font-size:12px">رونق النجوم</span>
                    @else
                        <span class="text-rose-900 font-bold text-base leading-tight">{{ __('site_name') }}</span>
                        <span class="text-gray-500 font-medium text-[13px] tracking-wider" style="font-size:12px">{{ config('app.name') }}</span>
                    @endif
                </div>
            </a>
            <button data-toggle-sidebar class="md:hidden text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
            <a href="{{ route('employee.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('employee.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>{{ __('Dashboard') }}</span>
            </a>
            <a href="{{ route('employee.appointments') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('employee.appointments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.appointments.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ __('My Bookings') }}</span>
            </a>
            <a href="{{ route('employee.available') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('employee.available') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.available') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ __('Available Bookings') }}</span>
            </a>
            <a href="{{ route('employee.ratings') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('employee.ratings') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.ratings') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span>{{ __('My Ratings') }}</span>
            </a>
            <div class="my-2 border-t border-gray-100"></div>
            <a href="{{ route('home') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                <svg class="w-5 h-5 shrink-0 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m0 0c1.657 0 3 4.03 3 9s-1.343 9-3 9z"/></svg>
                <span>{{ __('Main Site') }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                    <svg class="w-5 h-5 shrink-0 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>{{ __('Logout') }}</span>
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
                    <h1 class="text-2xl font-bold text-gray-800">@yield('page-title')</h1>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                       class="px-2.5 py-1 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50 font-medium text-xs transition-all duration-200">
                        {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                    </a>
                    <button id="notifBellBtn" onclick="toggleNotifPanel()" class="relative text-gray-500 hover:text-blue-600 transition-colors" title="{{ __('New Bookings') }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span id="notifBadge" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full shadow-sm border-2 border-white" style="display:none">0</span>
                    </button>
                    <span class="text-gray-500">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Notification Panel --}}
        <div id="notifPanel" class="hidden fixed top-20 right-4 w-80 md:w-96 bg-white rounded-2xl shadow-xl border border-gray-200 z-50 overflow-hidden" style="max-height: calc(100vh - 120px);">
            <div class="bg-gradient-to-l from-blue-50 to-white px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="font-bold text-gray-800 text-sm">{{ __('Booking Notifications') }}</span>
                </div>
                <button onclick="toggleNotifPanel()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="notifList" class="overflow-y-auto" style="max-height: calc(100vh - 190px);">
                <div class="flex items-center justify-center py-12 text-gray-400">
                    <div class="text-center">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <p class="text-sm">{{ __('No new bookings') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            @yield('content')
        </div>
    </div>
</div>

@include('partials.flash')

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
    var notifSeenTime = '{{ now()->toDateTimeString() }}';

    function addNotifItem(booking) {
        notifCount++;
        notifBadge.style.display = '';
        notifBadge.textContent = notifCount;

        var emptyMsg = notifList.querySelector('.flex.items-center.justify-center.py-12');
        if (emptyMsg) emptyMsg.remove();

        var item = document.createElement('div');
        item.className = 'px-4 py-3.5 hover:bg-blue-50/50 transition-colors border-b border-gray-50 last:border-b-0 animate-notif-in';
        item.innerHTML =
            '<div class="flex items-start gap-3">' +
                '<div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">' +
                    '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>' +
                '</div>' +
                '<div class="flex-1 min-w-0">' +
                    '<div class="flex items-center justify-between gap-2">' +
                        '<span class="font-bold text-gray-800 text-sm truncate" data-notif="name"></span>' +
                        '<span class="text-[10px] text-gray-400 shrink-0" data-notif="time"></span>' +
                    '</div>' +
                    '<div class="flex items-center gap-2 mt-0.5">' +
                        '<span class="text-xs text-gray-500 truncate" data-notif="services"></span>' +
                        '<span class="text-xs font-bold text-blue-600 shrink-0" data-notif="total"></span>' +
                    '</div>' +
                    '<div class="flex items-center gap-2 mt-1.5">' +
                        '<span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-medium" data-notif="date"></span>' +
                        '<span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded font-medium" data-notif="shift"></span>' +
                        '<span class="text-[10px] font-mono text-gray-400" data-notif="ticket"></span>' +
                    '</div>' +
                '</div>' +
                '<a href="#" class="shrink-0 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg px-2.5 py-1.5 text-xs font-medium transition-colors" data-notif="link">{{ __("View") }}</a>' +
            '</div>';

        var link = item.querySelector('[data-notif="link"]');
        if (link) {
            var safeId = typeof booking.id === 'number' ? booking.id : parseInt(booking.id, 10);
            if (Number.isFinite(safeId)) {
                link.href = '/employee/appointments/' + safeId;
            }
        }

        item.querySelector('[data-notif="name"]').textContent = booking.customer_name;
        item.querySelector('[data-notif="time"]').textContent = booking.created_at;
        item.querySelector('[data-notif="services"]').textContent = booking.display_services || '—';
        item.querySelector('[data-notif="total"]').textContent = booking.total + ' {{ __("KWD") }}';
        item.querySelector('[data-notif="date"]').textContent = booking.date;
        item.querySelector('[data-notif="shift"]').textContent = booking.shift;
        item.querySelector('[data-notif="ticket"]').textContent = booking.ticket;

        notifList.prepend(item);

        while (notifList.children.length > 30) {
            notifList.removeChild(notifList.lastChild);
        }
    }

    function pollNotifications() {
        fetch('{{ route("employee.notifications.recent") }}?since=' + encodeURIComponent(notifSeenTime), {
            headers: { 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
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
        .catch(function() {});
    }

    setInterval(pollNotifications, 7000);
    setTimeout(pollNotifications, 3000);
});

function toggleNotifPanel() {
    var panel = document.getElementById('notifPanel');
    panel.classList.toggle('hidden');
}
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
@stack('scripts')
@yield('scripts')
</body>
</html>
