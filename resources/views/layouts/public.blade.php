{{-- ============================================================
    التخطيط العام للصفحات العامة
    هذا الملف هو الهيكل الأساسي لجميع صفحات الموقع العامة.
    ============================================================ --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    {{-- قسم الرأس: يحتوي على الإعدادات الأساسية للصفحة مثل الترميز و viewport --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="description" content="@yield('meta_description', __('alnjoom Beauty Salon Description'))">
    <meta property="og:title" content="@yield('title', __('site_name'))">
    <meta property="og:description" content="@yield('meta_description', __('alnjoom Beauty Salon'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-default.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_KW' : 'en_US' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('images/og-default.jpg') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() . '?locale=en' }}">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() . '?locale=ar' }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">
    <title>@yield('title', __('site_name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>body{font-family:'Tajawal','Segoe UI',Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6{font-family:'Playfair Display','Tajawal',serif;}</style>
    @php
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
    @endphp
    <script type="application/ld+json">
    @json($ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    </script>
</head>
    <body class="font-sans antialiased bg-rose-50/40">
    {{-- شريط التنقل العلوي: يحتوي على روابط التنقل الرئيسية للموقع --}}
    <nav class="bg-white shadow-md border-b border-gray-100 sticky top-0 z-50">
        <input type="checkbox" id="menu-toggle-cb" class="hidden peer">
        <label for="menu-toggle-cb" class="fixed inset-0 z-40 hidden peer-checked:block cursor-default"></label>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14 md:h-16">
                {{-- اسم الموقع/الشعار --}}
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <picture>
                            <source srcset="{{ asset('images/Header.webp') }}" type="image/webp">
                            <img src="{{ asset('images/Header.png') }}" alt="{{ __('site_name') }}" class="h-12 w-auto md:h-14 -ml-[21px]">
                        </picture>
                        <div class="flex flex-col justify-center min-w-0">
                            @if(app()->getLocale() === 'en')
                                <span class="text-rose-900 font-bold text-xl leading-tight">{{ config('app.name') }}</span>
                                <span class="text-gray-500 font-medium text-xs tracking-wider" dir="rtl">رونق النجوم</span>
                            @else
                                <span class="text-rose-900 font-bold text-xl leading-tight">{{ __('site_name') }}</span>
                                <span class="text-gray-500 font-medium text-xs tracking-wider">{{ config('app.name') }}</span>
                            @endif
                        </div>
                    </a>
                </div>
                {{-- روابط الصفحات العامة (ظاهرة فقط في الديسكتوب) --}}
                <div class="hidden md:flex items-center gap-0.5">
                    <a href="{{ route('services') }}" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap {{ request()->routeIs('services') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50' }}">
                        {{ __('Services') }}
                    </a>
                    <a href="{{ route('about') }}" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap {{ request()->routeIs('about') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50' }}">
                        {{ __('About Us') }}
                    </a>
                    <a href="{{ route('faq') }}" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap {{ request()->routeIs('faq') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50' }}">
                        {{ __('Faq') }}
                    </a>
                    <a href="{{ route('contact') }}" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap {{ request()->routeIs('contact') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50' }}">
                        {{ __('Contact Us') }}
                    </a>
                    <a href="{{ route('track') }}" class="px-2.5 py-1.5 rounded-lg text-[15px] font-medium transition-all duration-200 whitespace-nowrap {{ request()->routeIs('track') || request()->routeIs('track.*') ? 'bg-rose-100 text-rose-700 shadow-sm' : 'text-gray-600 hover:text-rose-600 hover:bg-rose-50' }}">
                        {{ __('Track Booking') }}
                    </a>
                </div>
                {{-- روابط التنقل --}}
                <div class="flex items-center gap-1.5 justify-end shrink-0">
                     <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                        class="px-2 md:px-3 py-1.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 font-medium text-xs md:text-sm transition-all duration-200">
                         {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                     </a>
                     <a href="{{ route('book') }}"
                         class="hidden md:inline-flex bg-gradient-to-l from-rose-500 to-rose-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-xl font-medium shadow-sm shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200 text-xs md:text-sm">
                         {{ __('Book Now') }}
                     </a>
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                            <a href="{{ route('admin.dashboard') }}" class="text-rose-600 hover:text-rose-700 font-medium px-2 md:px-3 py-1.5 md:py-2 rounded-lg hover:bg-rose-50 transition-all duration-200 text-xs md:text-sm">{{ __('Admin Panel') }}</a>
                        @elseif(auth()->user()->isEmployee())
                            <a href="{{ route('employee.dashboard') }}" class="text-rose-600 hover:text-rose-700 font-medium px-2 md:px-3 py-1.5 md:py-2 rounded-lg hover:bg-rose-50 transition-all duration-200 text-xs md:text-sm">{{ __('Employee Dashboard') }}</a>
                        @else
                            <a href="{{ route('customer.profile') }}" class="text-rose-600 hover:text-rose-700 font-medium px-2 md:px-3 py-1.5 md:py-2 rounded-lg hover:bg-rose-50 transition-all duration-200 text-xs md:text-sm">{{ __('My Account') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" title="{{ __('Logout') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="hidden md:inline-flex bg-gradient-to-l from-amber-400 to-amber-500 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-xl font-medium shadow-sm shadow-amber-200 hover:from-amber-500 hover:to-amber-600 transition-all duration-200 text-xs md:text-sm">{{ __('Register / Login') }}</a>
                    @endauth
                    <label for="menu-toggle-cb" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-rose-600 hover:bg-rose-50 transition-all duration-200 cursor-pointer">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>
        {{-- المنيو للجوال --}}
        <div class="hidden peer-checked:block md:hidden border-t border-rose-100/20 bg-white/70 backdrop-blur-xl shadow-lg shadow-rose-900/10 relative z-50">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('services') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('services') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600' }}">
                    {{ __('Services') }}
                </a>
                <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('about') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600' }}">
                    {{ __('About Us') }}
                </a>
                <a href="{{ route('faq') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('faq') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600' }}">
                    {{ __('Faq') }}
                </a>
                <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600' }}">
                    {{ __('Contact Us') }}
                </a>
                <a href="{{ route('track') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('track') || request()->routeIs('track.*') ? 'bg-rose-100 text-rose-700' : 'text-gray-600 hover:bg-rose-50 hover:text-rose-600' }}">
                    {{ __('Track Booking') }}
                </a>
                <hr class="my-3 border-gray-100">
                <div class="flex flex-col gap-2 px-4">
                    <a href="{{ route('book') }}" class="w-full text-center bg-gradient-to-l from-rose-500 to-rose-600 text-white px-4 py-2.5 rounded-xl font-medium text-sm shadow-sm">{{ __('Book Now') }}</a>
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                            <a href="{{ route('admin.dashboard') }}" class="w-full text-center text-rose-600 hover:bg-rose-50 px-4 py-2.5 rounded-xl font-medium text-sm transition-all">{{ __('Admin Panel') }}</a>
                        @elseif(auth()->user()->isEmployee())
                            <a href="{{ route('employee.dashboard') }}" class="w-full text-center text-rose-600 hover:bg-rose-50 px-4 py-2.5 rounded-xl font-medium text-sm transition-all">{{ __('Employee Dashboard') }}</a>
                        @else
                            <a href="{{ route('customer.profile') }}" class="w-full text-center text-rose-600 hover:bg-rose-50 px-4 py-2.5 rounded-xl font-medium text-sm transition-all">{{ __('My Account') }}</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="w-full text-center bg-gradient-to-l from-amber-400 to-amber-500 text-white px-4 py-2.5 rounded-xl font-medium text-sm">{{ __('Register / Login') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <div id="app" class="overflow-x-hidden">
    {{-- المحتوى الرئيسي للصفحة: يتم حقنه من خلال @yield('content') --}}
    <main class="py-8">
        @yield('content')
    </main>

    {{-- فوتر بسيط — بدون تكرار للهيدر أو المحتوى الرئيسي --}}
    <footer class="bg-gradient-to-br from-rose-900 via-rose-800 to-amber-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="#" aria-label="{{ __('Instagram') }}" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2"/></svg>
                    </a>
                    <a href="#" aria-label="{{ __('WhatsApp') }}" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                    </a>
                    <a href="#" aria-label="{{ __('Snapchat') }}" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </a>
                </div>
                <div class="flex items-center gap-3 text-xs text-rose-300">
                    <a href="#" class="hover:text-amber-300 transition-colors">{{ __('Privacy Policy') }}</a>
                    <span class="text-rose-500">·</span>
                    <a href="#" class="hover:text-amber-300 transition-colors">{{ __('Terms of Service') }}</a>
                </div>
                <div class="text-xs text-rose-400">
                    © {{ date('Y') }} {{ __('site_name') }} — {{ __('All Rights Reserved') }}
                </div>
            </div>
        </div>
    </footer>

    @include('partials.flash')
    @include('partials.whatsapp-button')

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
