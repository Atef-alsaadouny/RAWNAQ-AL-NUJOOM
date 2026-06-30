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
    <title>{{ __('site_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>body{font-family:'Tajawal','Segoe UI',Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6{font-family:'Playfair Display','Tajawal',serif;}</style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-rose-50 via-white to-amber-50">
        <div class="mb-6 text-center">
            <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
               class="inline-block mb-4 px-3 py-1.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 font-medium text-sm transition-all duration-200">
                {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
            </a>
            <a href="{{ route('home') }}" class="flex flex-col items-center">
                <picture>
                    <source srcset="{{ asset('images/logo.webp') }}" type="image/webp">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ __('site_name') }}" class="h-36 w-auto drop-shadow-sm">
                </picture>
            </a>
        </div>
        <div class="w-full sm:max-w-md px-8 py-8 bg-white/80 backdrop-blur-sm shadow-xl shadow-rose-200/40 rounded-[2rem] border border-rose-100/50">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
