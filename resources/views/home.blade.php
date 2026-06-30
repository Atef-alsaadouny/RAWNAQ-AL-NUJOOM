@php use App\Models\Appointment; @endphp
@extends('layouts.public')

@section('title', __('site_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4">

    {{-- 1. Welcome section --}}
    <div class="text-center py-20 bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] mx-4 shadow-sm border border-rose-100/50">
        <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-6">
            <span class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></span>
            {{ __("Luxury Ladies Salon") }}
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-4 leading-tight">{{ __('Welcome to') }} <span class="text-transparent bg-clip-text bg-gradient-to-l from-amber-600 to-rose-500">{{ __('site_name') }}</span></h1>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
            {{ __("Experience the best personal care services in a luxurious atmosphere") }}
        </p>
    </div>

    @auth
    @if($upcomingAppointment)
    <div class="mt-8 mx-4">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100/60 p-4 md:p-5 flex items-center justify-between gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-rose-100 to-amber-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-rose-400 font-medium">{{ __('Upcoming Appointment') }}</p>
                    @php
                        $days = ['Sunday'=>__('Sunday'),'Monday'=>__('Monday'),'Tuesday'=>__('Tuesday'),'Wednesday'=>__('Wednesday'),'Thursday'=>__('Thursday'),'Friday'=>__('Friday'),'Saturday'=>__('Saturday')];
                        $dayName = $days[$upcomingAppointment->appointment_date->format('l')] ?? $upcomingAppointment->appointment_date->format('l');
                    @endphp
                    <p class="font-bold text-gray-800">{{ $dayName }} {{ $upcomingAppointment->appointment_date->format('Y-m-d') }} — {{ $upcomingAppointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        @if($upcomingAppointment->display_services)
                            {{ $upcomingAppointment->display_services }}
                        @else
                            —
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('customer.appointment.show', $upcomingAppointment) }}"
               class="shrink-0 px-4 py-2 bg-gradient-to-l from-amber-500 to-amber-600 text-white rounded-xl text-sm font-medium shadow-sm shadow-amber-200 hover:from-amber-600 hover:to-amber-700 transition-all duration-200">
                {{ __('View Booking') }}
            </a>
        </div>
    </div>
    @endif
    @endauth

    {{-- 2. About section --}}
    <div class="mt-16 bg-white rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-rose-100/60 overflow-hidden">
        <div class="grid md:grid-cols-2">
            <div class="p-12 flex flex-col justify-center order-2 md:order-1">
                <div class="inline-flex items-center gap-2 bg-rose-50 text-rose-600 px-4 py-1.5 rounded-full text-xs font-medium mb-4 w-fit">
                    {{ __('About Us') }}
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('About') }} {{ __('site_name') }}</h2>
                <p class="text-gray-500 leading-relaxed mb-8 text-[15px]">
                    {{ __("alnjoom is a specialized salon offering personal care services with the highest quality standards") }}.
                    {{ __("Our experienced professional team ensures a distinctive experience and complete comfort") }}.
                    {{ __("We use the best global products to guarantee the best results for our valued clients") }}.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-rose-50/50 rounded-xl">
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-700 text-sm">{{ __('Working Hours') }}</p>
                            <p class="text-gray-500 text-sm">{{ __('Sat - Thu: 10:00 AM - 10:00 PM') }}</p>
                            <p class="text-gray-500 text-sm">{{ __('Fri: 1:00 PM - 8:00 PM') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-amber-50/50 rounded-xl">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-700 text-sm">{{ __('Location') }}</p>
                            <p class="text-gray-500 text-sm">{{ __("Kuwait — Salmiya, Arabian Gulf Street") }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-rose-50/50 rounded-xl">
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-700 text-sm">{{ __('Phone') }}</p>
                            <p class="text-gray-500 text-sm">+965 1234 5678</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-rose-100 via-rose-50 to-amber-50 p-12 flex items-center justify-center order-1 md:order-2 min-h-[300px]">
                <div class="text-center">
                    <div class="w-28 h-28 bg-white/70 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-rose-200/50">
                        <span class="text-5xl">💅</span>
                    </div>
                    <p class="text-rose-800 font-bold text-lg">{{ __("Your ideal place for personal care") }}</p>
                    <p class="text-rose-500 text-sm mt-2">{{ __("Combine beauty and relaxation") }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Registration benefits section (highlighted) --}}
    <div class="mt-16 py-16 px-8 bg-gradient-to-br from-rose-500 via-rose-600 to-amber-700 rounded-[2.5rem] text-center text-white shadow-xl shadow-rose-200/50">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur text-white/90 px-5 py-2 rounded-full text-sm font-medium mb-4 border border-white/20">
            ✨ {{ __('Exclusive Benefits') }}
        </div>
        <h2 class="text-3xl font-bold mb-3">{{ __('Why Register?') }}</h2>
        <p class="text-rose-100 text-lg mb-12">{{ __("Create your account and enjoy exclusive benefits") }}</p>

        <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ __('Your Previous Bookings') }}</h3>
                <p class="text-rose-100 text-sm leading-relaxed">{{ __("See all your bookings in one place without needing a ticket number") }}</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ __('Repeat Booking with One Click') }}</h3>
                <p class="text-rose-100 text-sm leading-relaxed">{{ __("Want to book the same service again? Repeat your previous booking with one click") }}</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ __('Rate Services') }}</h3>
                    <p class="text-rose-100 text-sm leading-relaxed">{{ __("After the service, rate your experience and help others choose") }}</p>
            </div>
        </div>

        {{-- 4. Login/register options (visitors only) --}}
        @guest
        <div class="mt-12">
            <p class="text-rose-100 mb-8 text-lg">{{ __('Start Now') }}:</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <a href="{{ route('register') }}"
                   class="bg-white text-rose-600 px-10 py-4 rounded-xl text-lg font-bold shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('Create New Account') }}
                </a>
                <a href="{{ route('login') }}"
                   class="bg-rose-400 text-white border-2 border-white/30 px-8 py-4 rounded-xl text-lg font-bold hover:bg-rose-300 hover:-translate-y-0.5 transition-all duration-200">
                    {{ __("I have an account — Login") }}
                </a>
            </div>
        </div>
        @endguest
    </div>

    {{-- 5. How It Works --}}
    <div class="mt-16 mb-16">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                {{ __('How It Works') }}
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mt-4">{{ __('Booking in 3 Simple Steps') }}</h2>
            <p class="text-gray-500 mt-2 max-w-xl mx-auto">{{ __('From choosing the service to enjoying your experience, we make it easy') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-[1.75rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-rose-100/60 text-center group hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-50 to-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-sm font-bold shadow-md">1</div>
                <h3 class="text-lg font-bold text-gray-800">{{ __('Choose Your Service') }}</h3>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed">{{ __('Browse our services and pick what suits you best') }}</p>
            </div>

            <div class="bg-white p-8 rounded-[1.75rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-rose-100/60 text-center group hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-50 to-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-sm font-bold shadow-md">2</div>
                <h3 class="text-lg font-bold text-gray-800">{{ __('Pick Your Time') }}</h3>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed">{{ __('Choose a convenient date and time for your appointment') }}</p>
            </div>

            <div class="bg-white p-8 rounded-[1.75rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-rose-100/60 text-center group hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-50 to-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-sm font-bold shadow-md">3</div>
                <h3 class="text-lg font-bold text-gray-800">{{ __('Enjoy Your Experience') }}</h3>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed">{{ __('Visit us and let our team take care of you') }}</p>
            </div>
        </div>
    </div>

    {{-- 6. معرض صور --}}
    <div class="mt-16 mb-16">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
                📸 {{ __('Salon Tour') }}
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ __('Gallery') }}</h2>
            <p class="text-gray-500 max-w-xl mx-auto">{{ __("A quick look at our salon and some of our work") }}</p>
        </div>

        @php
            $homeImages = [
                ['src' => asset('images/gallery/salon-interior.webp'), 'emoji' => '💇‍♀️', 'title' => __('Beauty Salon')],
                ['src' => asset('images/gallery/manicure.webp'), 'emoji' => '💅', 'title' => __('Pedicure & Manicure')],
                ['src' => asset('images/gallery/makeup.webp'), 'emoji' => '💄', 'title' => __('Professional Makeup')],
                ['src' => asset('images/gallery/massage.webp'), 'emoji' => '💆‍♀️', 'title' => __('Massage & Relaxation')],
            ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($homeImages as $img)
            <div class="group relative overflow-hidden rounded-[1.75rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-rose-100/60 aspect-square bg-gradient-to-br from-rose-50 to-amber-50 flex items-center justify-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-300 cursor-pointer">
                <span class="text-5xl opacity-20 group-hover:opacity-30 transition-opacity duration-300 select-none">{{ $img['emoji'] }}</span>
                <img src="{{ $img['src'] }}"
                     alt="{{ $img['title'] }}"
                     loading="lazy"
                     onerror="this.style.display='none'"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-white font-bold text-sm">{{ $img['title'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('gallery') }}"
               class="inline-flex items-center gap-2 text-rose-600 hover:text-rose-700 font-medium transition-colors duration-200">
                {{ __('See All Photos') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

</div>
@endsection
