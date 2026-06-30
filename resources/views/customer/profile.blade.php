@php
    $initial = mb_substr($user->name, 0, 1);
@endphp

@php use App\Models\Appointment; @endphp
@extends('layouts.customer')

@section('title', __('My Account'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- بطاقة الترحيب --}}
    <div class="bg-gradient-to-br from-rose-50 via-white to-amber-50 rounded-[2rem] shadow-xl shadow-rose-200/50 p-8 flex items-center gap-5">
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-amber-400 to-rose-500 flex items-center justify-center text-white text-2xl font-bold shadow-md shrink-0">
            {{ $initial }}
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('Welcome') }}, {{ $user->name }}</h1>
            <p class="text-gray-500 mt-0.5">{{ __('Member since') }} <span dir="ltr" class="inline-block">{{ $user->created_at->format('Y-m-d') }}</span></p>
        </div>
    </div>

    {{-- بطاقات الاحصائيات --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-5 text-center">
            <p class="text-3xl font-bold text-amber-600">{{ $totalBookings }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ __('Total Bookings') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-5 text-center">
            <p class="text-3xl font-bold text-rose-500">{{ $activeBookings }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ __('In Progress') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-5 text-center">
            <p class="text-3xl font-bold text-green-500">{{ $completedBookings }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ __('Completed') }}</p>
        </div>
    </div>

    {{-- اقرب حجز --}}
    @if($upcomingAppointment)
    <div class="bg-gradient-to-br from-amber-50 via-white to-rose-50 rounded-[2rem] shadow-md shadow-amber-100/50 p-6">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h2 class="text-lg font-bold text-gray-800">{{ __('Your Upcoming Booking') }}</h2>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="space-y-1.5">
                <p class="text-gray-700">
                    <span class="text-gray-500">{{ __('Date') }}:</span>
                    <span class="font-semibold" dir="ltr">{{ $upcomingAppointment->appointment_date->format('Y-m-d') }}</span>
                </p>
                <p class="text-gray-700">
                    <span class="text-gray-500">{{ __('Shift') }}:</span>
                    <span class="font-semibold">{{ $upcomingAppointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
                </p>
                @if($upcomingAppointment->display_services)
                <p class="text-gray-700">
                    <span class="text-gray-500">{{ __('Services') }}:</span>
                    <span class="font-semibold">{{ $upcomingAppointment->display_services }}</span>
                </p>
                @endif
                <p class="text-gray-700">
                    <span class="text-gray-500">{{ __('Status') }}:</span>
                    @switch($upcomingAppointment->status)
                        @case(Appointment::STATUS_PENDING) <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-lg text-sm font-medium">{{ __('Pending') }}</span> @break
                        @case(Appointment::STATUS_ASSIGNED) <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-lg text-sm font-medium">{{ __('Assigned') }}</span> @break
                        @case(Appointment::STATUS_IN_PROGRESS) <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-lg text-sm font-medium">{{ __('In Progress') }}</span> @break
                    @endswitch
                </p>
            </div>
            <a href="{{ route('customer.appointment.show', $upcomingAppointment) }}"
               class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-gradient-to-l from-amber-500 to-amber-600 text-white rounded-xl text-sm font-medium shadow-md shadow-amber-200 hover:from-amber-600 hover:to-amber-700 transition-all duration-200">
                {{ __('View Details') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    @endif

    {{-- تعديل الملف الشخصي - قابل للطي --}}
    <details class="bg-white rounded-[2rem] shadow-sm border border-rose-100 group" @error('name') open @enderror @error('phone') open @enderror @error('email') open @enderror>
        <summary class="p-6 cursor-pointer list-none flex items-center justify-between select-none hover:bg-rose-50/50 rounded-[2rem] transition-all">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Edit Your Account Information') }}</h2>
            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </summary>
        <div class="px-6 pb-6">
            <form method="POST" action="{{ route('customer.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] @error('name') border-red-300 @enderror">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5">{{ __('Mobile Number') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] @error('phone') border-red-300 @enderror"
                            inputmode="numeric" placeholder="6xxxxxxx">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5">{{ __('Email') }} <span class="text-xs text-gray-400 font-normal">{{ __('(Optional)') }}</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] @error('email') border-red-300 @enderror">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-l from-rose-500 to-rose-600 text-white rounded-xl text-sm font-medium shadow-md shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </details>

    {{-- تغيير كلمة المرور - قابل للطي --}}
    <details class="bg-white rounded-[2rem] shadow-sm border border-rose-100 group" @error('current_password') open @enderror @error('new_password') open @enderror>
        <summary class="p-6 cursor-pointer list-none flex items-center justify-between select-none hover:bg-rose-50/50 rounded-[2rem] transition-all">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Change Password') }}</h2>
            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </summary>
        <div class="px-6 pb-6">
            <form method="POST" action="{{ route('customer.profile.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5">{{ __('Current Password') }} <span class="text-red-500">*</span></label>
                        <input type="password" name="current_password"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] @error('current_password') border-red-300 @enderror">
                        @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5">{{ __('New Password') }} <span class="text-red-500">*</span></label>
                        <input type="password" name="new_password"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px] @error('new_password') border-red-300 @enderror">
                        @error('new_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[15px] font-medium text-gray-700 mb-1.5">{{ __('Confirm New Password') }} <span class="text-red-500">*</span></label>
                        <input type="password" name="new_password_confirmation"
                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 transition duration-200 text-[15px]">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-l from-rose-500 to-rose-600 text-white rounded-xl text-sm font-medium shadow-md shadow-rose-200 hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        {{ __('Change Password') }}
                    </button>
                </div>
            </form>
        </div>
    </details>

    {{-- آخر الحجوزات --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-rose-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Recent Bookings') }}</h2>
            <a href="{{ route('customer.appointments') }}" class="text-rose-600 hover:text-rose-700 text-sm font-medium inline-flex items-center gap-1">
                {{ __('View All') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @if($recentBookings->count())
        <div class="space-y-3">
            @foreach($recentBookings as $apt)
            <a href="{{ route('customer.appointment.show', $apt) }}"
               class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:shadow-sm transition-all duration-200 group">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-gray-800 text-[15px] break-words">{{ $apt->display_services ?: __('Booking') }}</p>
                        <p class="text-sm text-gray-500" dir="ltr">{{ $apt->appointment_date->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @switch($apt->status)
                        @case(Appointment::STATUS_PENDING) <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-lg text-xs font-medium">{{ __('Pending') }}</span> @break
                        @case(Appointment::STATUS_ASSIGNED) <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-lg text-xs font-medium">{{ __('Assigned') }}</span> @break
                        @case(Appointment::STATUS_IN_PROGRESS) <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-lg text-xs font-medium">{{ __('In Progress') }}</span> @break
                        @case(Appointment::STATUS_COMPLETED) <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-lg text-xs font-medium">{{ __('Completed') }}</span> @break
                        @case(Appointment::STATUS_CANCELLED) <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-lg text-xs font-medium">{{ __('Cancelled') }}</span> @break
                    @endswitch
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-gray-400 text-center py-6">{{ __('You have no bookings yet') }} 😊</p>
        @endif
    </div>

</div>
@endsection
