<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="overflow-x:hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="429 - {{ __('Too Many Requests') }}">
    <title>429 - {{ __('Too Many Requests') }} | {{ __('site_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', 'Segoe UI', Tahoma, sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', 'Tajawal', serif; }
    </style>
</head>
<body class="font-sans antialiased bg-rose-50/40 overflow-x-hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="text-center max-w-md w-full">
            <a href="{{ route('home') }}" class="inline-block mb-8">
                <picture>
                    <source srcset="{{ asset('images/Header.webp') }}" type="image/webp">
                    <img src="{{ asset('images/Header.png') }}" alt="{{ __('site_name') }}" class="h-20 w-auto mx-auto drop-shadow-sm">
                </picture>
            </a>
            <div class="text-9xl font-bold text-rose-200 select-none" style="font-family:'Playfair Display',serif;">429</div>
            <h1 class="text-3xl font-bold text-rose-900 mt-4">{{ __('Too Many Requests') }}</h1>
            <p class="text-gray-500 mt-3 text-[15px] leading-relaxed">{{ __('You have made too many requests. Please try again later.') }}</p>
            <a href="{{ route('home') }}"
               class="inline-block mt-8 bg-gradient-to-l from-rose-500 to-rose-600 text-white px-6 py-3 rounded-xl font-medium shadow-sm shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                <svg class="w-4 h-4 inline -mt-0.5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M19 12H5m7 7l-7-7 7-7' : 'M5 12h14m-7-7l7 7-7 7' }}"/>
                </svg>
                {{ __('Back to Homepage') }}
            </a>
        </div>
    </div>
</body>
</html>
