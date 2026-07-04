@php use App\Models\Appointment; use App\Models\Payment; @endphp
@extends('layouts.public')

@section('title', __('Book Appointment'))

@section('content')
<div class="max-w-3xl mx-auto px-4 md:px-5 lg:px-6 pt-6 pb-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-gray-800">{{ __('Book Your Appointment') }}</h1>
        <p class="text-gray-500 mt-1.5">{{ __('Choose the services you want and we will prepare everything') }}</p>
    </div>

    @if(session('error'))
        <div class="alert mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white/90 backdrop-blur-sm rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-8">
        <form method="POST" action="{{ route('book.store') }}" id="bookingForm">
            @csrf

            <div style="position:absolute;left:-9999px" aria-hidden="true">
                <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            <input type="hidden" name="form_loaded_at" value="">
            <input type="hidden" name="_form_token" value="{{ $bookingToken }}">

            @guest
            <div class="bg-gradient-to-br from-rose-50 to-amber-50/30 rounded-2xl p-5 mb-8 border border-rose-100/50">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ __('Your Information') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="{{ __('Your Full Name') }}"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Phone Number') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="5XXXXXXX"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 @error('customer_phone') border-red-300 bg-red-50/30 @enderror" dir="ltr">
                        @error('customer_phone')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-rose-200/60">
                    <label class="flex items-start gap-3 cursor-pointer group" for="create_account">
                        <input type="checkbox" name="create_account" value="1" id="create_account"
                               class="mt-0.5 w-5 h-5 rounded border-gray-300 text-rose-500 focus:ring-rose-400 focus:ring-2 cursor-pointer shrink-0">
                        <div class="select-none">
                            <span class="font-medium text-gray-800 text-sm group-hover:text-rose-600 transition-colors">
                                {{ __('Create an account to save your data for next time') }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                {{ __('Register with one click to save your data, and easily manage or modify your upcoming bookings!') }}
                            </p>
                        </div>
                    </label>

                    <div id="accountFields" class="mt-4 space-y-4 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Email') }} <span class="text-gray-400 font-normal">({{ __('Optional') }})</span></label>
                                <input type="email" name="email" autocomplete="email" value="{{ old('email') }}"
                                       class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200" dir="ltr">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Password') }} <span class="text-red-500">*</span></label>
                                <input type="password" name="password" autocomplete="new-password"
                                       class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                            </div>
                        </div>
                        <div class="md:w-1/2">
                            <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Confirm Password') }} <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                   class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                        </div>
                    </div>
                </div>
            </div>
            @elseif(auth()->user()->isCustomer())
            <div class="mb-8 bg-gradient-to-br from-rose-50 to-amber-50/30 border border-rose-100/50 rounded-2xl px-5 py-4 text-sm text-gray-600 flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ __('Booking under your name') }}: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->phone }})</span>
            </div>
            @else
            <div class="bg-gradient-to-br from-rose-50 to-amber-50/30 rounded-2xl p-5 mb-8 border border-rose-100/50">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ __('Your Information') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="{{ __('Your Full Name') }}"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Phone Number') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="5XXXXXXX"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 @error('customer_phone') border-red-300 bg-red-50/30 @enderror" dir="ltr">
                        @error('customer_phone')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endguest

            @if($packages->isNotEmpty())
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <label class="block text-gray-700 font-bold text-sm">{{ __('Packages & Offers') }}</label>
                </div>
                <p class="text-sm text-gray-400 mb-4 mr-7">{{ __('You can select more than one package') }}</p>
                <div class="space-y-3">
                    @foreach($packages as $package)
                    <label class="package-card border-2 rounded-2xl p-4 md:p-5 cursor-pointer transition-all duration-200 flex items-center gap-3 md:gap-4 {{ in_array($package->id, $preselectedPackageIds) ? 'border-rose-300 bg-rose-50/40 shadow-sm' : 'border-amber-100 bg-white hover:border-amber-300 hover:shadow-sm' }}">
                        <input type="checkbox" name="package_ids[]" value="{{ $package->id }}" class="package-checkbox w-5 h-5 text-rose-500 rounded"
                            {{ in_array($package->id, $preselectedPackageIds) ? 'checked' : '' }}
                            data-services="{{ $package->services->pluck('id')->join(',') }}"
                            onchange="updatePackages()">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-800">{{ $package->name }}</span>
                                @if($package->original_price && $package->original_price > $package->price)
                                <span class="bg-rose-100 text-rose-700 text-xs px-2.5 py-0.5 rounded-full font-bold">
                                    {{ __('Save') }} {{ formatCurrency($package->original_price - $package->price) }}
                                </span>
                                @endif
                            </div>
                            <div class="text-gray-400 text-sm mt-0.5 truncate">{{ $package->services->pluck('name')->implode(' + ') }}</div>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-xl font-extrabold text-rose-600">{{ formatCurrency($package->price) }}</span>
                                @if($package->original_price && $package->original_price > $package->price)
                                <span class="text-gray-300 text-sm line-through">{{ formatCurrency($package->original_price) }}</span>
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <label class="block text-gray-700 font-bold text-sm" id="servicesLabel">{{ __('Services') }}</label>
                </div>

                <div id="packageServicesInfo" class="hidden bg-rose-50/70 border border-rose-200/60 rounded-2xl p-5 mb-4 mt-3">
                    <p class="text-sm text-rose-700 font-medium mb-2.5" id="packageServicesText"></p>
                    <div class="flex flex-wrap gap-2" id="packageServicesTags"></div>
                </div>

                <div class="space-y-2 mt-3" id="servicesContainer">
                    @foreach($services as $service)
                    @php
                        $inAnyPreselected = false;
                        if (!empty($preselectedPackageIds)) {
                            $selPkgs = $packages->whereIn('id', $preselectedPackageIds);
                            foreach ($selPkgs as $sp) {
                                if ($sp->services->contains($service->id)) { $inAnyPreselected = true; break; }
                            }
                        }
                    @endphp
                    <label class="service-item border-2 rounded-2xl p-3 md:p-4 cursor-pointer transition-all duration-200 flex justify-between items-center gap-2 md:gap-4 {{ $inAnyPreselected ? 'border-rose-200 bg-rose-50/30' : 'border-amber-100 bg-white hover:border-amber-300 hover:shadow-sm' }}"
                        data-service-id="{{ $service->id }}"
                        data-package-service="{{ $inAnyPreselected ? 'true' : 'false' }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" class="service-checkbox w-5 h-5 text-rose-500 rounded shrink-0"
                                {{ $inAnyPreselected ? 'checked disabled' : '' }}
                                {{ in_array($service->id, old('service_ids', $preselected ? [$preselected] : [])) ? 'checked' : '' }}>
                            <div>
                                <span class="font-bold {{ $inAnyPreselected ? 'text-rose-600' : 'text-gray-800' }}">{{ $service->name }}</span>
                                @if($inAnyPreselected)
                                <span class="package-badge text-xs text-rose-500 mr-1">{{ __('(From package)') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-left shrink-0">
                            <span class="text-rose-600 font-bold">{{ formatCurrency($service->price) }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-br from-rose-50 to-amber-50/30 rounded-2xl p-5 mb-8 border border-rose-100/50">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ __('Appointment') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Date') }} <span class="text-red-500">*</span></label>
                        <input type="date" name="appointment_date" required min="{{ now()->format('Y-m-d') }}" value="{{ old('appointment_date') }}"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Shift') }} <span class="text-red-500">*</span></label>
                        <select name="shift" required class="appearance-none bg-no-repeat w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 bg-[length:18px] bg-[center_right_12px] pr-12 !rtl:bg-[center_left_12px] !rtl:pr-5 !rtl:pl-12 bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22m6 9 6 6 6-6%22/%3E%3C/svg%3E')]">
                            <option value="{{ Appointment::SHIFT_MORNING }}" {{ old('shift') == Appointment::SHIFT_MORNING ? 'selected' : '' }}>{{ __('Morning') }}</option>
                            <option value="{{ Appointment::SHIFT_EVENING }}" {{ old('shift') == Appointment::SHIFT_EVENING ? 'selected' : '' }}>{{ __('Evening') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            @if(isset($employees) && $employees->isNotEmpty())
<input type="hidden" name="employee_id" id="employeeInput" value="{{ old('employee_id', '') }}">
            <div class="mb-10 relative">

                <div class="flex items-center gap-2.5 mb-2">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <label class="text-[22px] font-semibold text-gray-800">{{ __('Choose Employee') }} <span class="text-gray-400 font-normal text-base">{{ __('(Optional)') }}</span></label>
                </div>
                <p class="text-sm text-gray-400 mb-6">{{ __("We'll assign the best available employee for your appointment.") }}</p>

                    @php
                        $avatarColors = [
                            'Dalia' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
                            'Marwa' => ['bg' => '#FCE7F3', 'text' => '#9D174D'],
                            'Tala'  => ['bg' => '#FFE4E6', 'text' => '#9F1239'],
                            'Shrouk'=> ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
                            'Dana'  => ['bg' => '#D1FAE5', 'text' => '#065F46'],
                            'Roaa'  => ['bg' => '#EDE9FE', 'text' => '#5B21B6'],
                            'Jana'  => ['bg' => '#FFEDD5', 'text' => '#9A3412'],
                        ];
                        $palette = [
                            ['bg' => '#FCE4EC', 'text' => '#880E4F'],
                            ['bg' => '#E0F7FA', 'text' => '#006064'],
                            ['bg' => '#F3E5F5', 'text' => '#6A1B9A'],
                            ['bg' => '#E8F5E9', 'text' => '#1B5E20'],
                            ['bg' => '#FFF3E0', 'text' => '#E65100'],
                            ['bg' => '#E1F5FE', 'text' => '#01579B'],
                            ['bg' => '#F1F8E9', 'text' => '#33691E'],
                            ['bg' => '#FBE9E7', 'text' => '#BF360C'],
                            ['bg' => '#E8EAF6', 'text' => '#283593'],
                            ['bg' => '#F9FBE7', 'text' => '#827717'],
                        ];
                    @endphp

                <div id="autoAssignCard" class="relative border rounded-2xl p-6 cursor-pointer transition-all duration-250 w-full shadow-[0_6px_20px_rgba(0,0,0,.05)] {{ !old('employee_id') ? 'border-rose-300 bg-rose-50 shadow-rose-200/50' : 'border-black/5 bg-white hover:shadow-md' }}" onclick="selectAutoAssign(this)">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-full bg-rose-100 flex items-center justify-center shrink-0 shadow-sm">
                            <span class="text-xl">✨</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-base font-semibold text-gray-800">{{ __('Auto Assign') }}</span>
                                <span class="text-[11px] font-medium text-rose-600 bg-rose-100 px-2 py-0.5 rounded-full">{{ __('(Recommended)') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ __("We'll automatically assign the best available employee based on your appointment.") }}</p>
                            <p class="text-[11px] text-rose-500 mt-2 font-medium leading-tight">&check; {{ __('Fastest option for most customers') }}</p>
                        </div>
                        <div class="check-icon shrink-0 {{ !old('employee_id') ? '' : 'hidden' }}">
                            <svg class="w-6 h-6 text-rose-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" fill="currentColor" class="text-rose-500" opacity="0.12"/>
                                <path d="M9 12l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-8 mb-8">
                    <div class="flex-1 border-t" style="border-color: #E8E8E8;"></div>
                    <span class="text-[13px] font-medium" style="color: #9CA3AF;">{{ __('Or') }}</span>
                    <div class="flex-1 border-t" style="border-color: #E8E8E8;"></div>
                </div>

                <div id="manualCard" class="border border-black/5 bg-white rounded-2xl p-6 shadow-[0_6px_20px_rgba(0,0,0,.05)]">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-full bg-amber-100 flex items-center justify-center shrink-0 shadow-sm">
                            <span class="text-lg">👩</span>
                        </div>
                        <div>
                            <div class="text-base font-semibold text-gray-800">{{ __('Do you have a preferred employee?') }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 leading-relaxed">{{ __("Choose a specific employee if you'd like.") }}</div>
                        </div>
                    </div>
                    <button type="button" id="selectEmployeeBtn" class="mt-5 h-11 px-6 rounded-xl bg-gradient-to-l from-rose-500 to-rose-600 text-white font-medium text-sm shadow-sm hover:shadow-md hover:scale-[1.02] active:scale-100 transition-all duration-200">
                        {{ __('Show Employees') }}
                    </button>
                </div>

                <div id="employeeSection" class="overflow-hidden transition-all duration-[250ms] ease-in-out {{ old('employee_id') ? 'max-h-[2000px] opacity-100 mt-5' : 'max-h-0 opacity-0 mt-0' }}">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" id="employeeContainer">
                        @foreach($employees as $emp)
                        @php $color = $avatarColors[$emp->name] ?? $palette[crc32($emp->name) % count($palette)]; @endphp
                        <div class="emp-card relative border rounded-2xl px-3 py-3 text-center cursor-pointer transition-all duration-200 shadow-[0_6px_20px_rgba(0,0,0,.05)] {{ old('employee_id') == $emp->id ? 'border-amber-500 bg-amber-50 shadow-amber-200/50' : 'border-black/5 bg-white hover:shadow-md' }}" data-value="{{ $emp->id }}" data-services='{{ $emp->services->isNotEmpty() ? json_encode($emp->services->pluck('name')->toArray()) : '[]' }}' onclick="selectEmployee(this)">
                            <span class="check-badge absolute top-2 start-2 w-4 h-4 rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] {{ old('employee_id') == $emp->id ? '' : 'hidden' }}">✓</span>
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-1.5 shadow-sm" style="background-color: {{ $color['bg'] }};">
                                <span class="font-bold text-base" style="color: {{ $color['text'] }};">{{ mb_substr($emp->name, 0, 1) }}</span>
                            </div>
                            <div class="font-semibold text-xs">{{ $emp->name }}</div>
                            @if($emp->services->isNotEmpty())
                            <button type="button" class="info-btn absolute end-1.5 w-5 h-5 rounded-full bg-gray-100 text-gray-400 hover:bg-amber-100 hover:text-amber-500 flex items-center justify-center transition-colors" style="bottom: 2px;" onclick="event.stopPropagation();">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <div id="empPopup" class="absolute z-20 hidden pointer-events-none" style="top: 0; left: 0;">
                    <div class="bg-white border border-amber-200 rounded-xl shadow-xl p-3 min-w-[180px] max-w-[220px] transition-all duration-200 opacity-0 scale-95 -translate-y-1">
                        <div class="font-semibold text-sm text-gray-800" id="empPopupName"></div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ __('Specialized in') }}</div>
                        <ul class="mt-1 space-y-0.5" id="empPopupServices"></ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="mb-8">
                <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Notes') }} <span class="text-gray-400 font-normal">{{ __('(Optional)') }}</span></label>
                <textarea name="notes" rows="3" class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none" placeholder="{{ __('Anything you want to request?') }}">{{ old('notes') }}</textarea>
            </div>

            {{-- Price Summary above submit --}}
            <div id="priceSummary" class="hidden bg-white border-2 border-rose-200/70 rounded-2xl p-5 mb-8 space-y-3 shadow-sm">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m0 0l-6-6m6 6H3"/>
                    </svg>
                    {{ __('Invoice Summary') }}
                </h3>
                <div id="summaryItems" class="space-y-1.5"></div>
                <div class="border-t border-rose-200/40 pt-3 flex justify-between items-center">
                    <span class="font-bold text-gray-700">{{ __('Total') }}</span>
                    <span class="text-2xl font-extrabold text-rose-700" id="summaryTotal">{{ formatCurrency(0) }}</span>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <label class="block text-gray-700 font-bold text-sm">{{ __('Payment Method') }}</label>
                </div>
                <p class="text-sm text-gray-400 mb-3 mr-7">{{ __('Choose your preferred payment method') }}</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="paymentContainer">
                    {{-- Payment Unavailable Toast --}}
                    <div id="paymentNotify" class="hidden opacity-0 col-span-full bg-gradient-to-l from-amber-500 to-orange-500 text-white px-5 py-3 rounded-2xl shadow-lg shadow-amber-200/30 flex items-center gap-3 text-sm font-medium mb-1.5">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                        </svg>
                        <span>{{ __('This service is currently unavailable') }}</span>
                    </div>
                    @foreach(\App\Models\Payment::availableMethods() as $method)
                        @php $isCash = $method === \App\Models\Payment::METHOD_CASH; @endphp
                        <label class="payment-option border-2 rounded-2xl px-4 py-3 cursor-pointer transition-all duration-200 flex items-center gap-2.5 border-gray-100 bg-white text-gray-500 hover:border-amber-200 hover:text-amber-600">
                            <input type="radio" name="payment_method" value="{{ $method }}" {{ $isCash ? 'checked' : '' }} class="payment-radio w-4 h-4 text-rose-500 shrink-0">
                            <span class="font-medium">{{ $isCash ? __('Cash') : ($method === \App\Models\Payment::METHOD_KNET ? __('KNET') : ($method === \App\Models\Payment::METHOD_APPLE_PAY ? __('Apple Pay') : __('Google Pay'))) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" id="submitBtn" class="w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                <span id="submitText" class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Confirm Booking') }}
                </span>
                <span id="submitSpinner" class="hidden items-center justify-center gap-2">
                    <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    {{ __('Confirming...') }}
                </span>
            </button>
        </form>
    </div>
</div>

<script>
function selectAutoAssign(el) {
    document.getElementById('employeeInput').value = '';

    document.querySelectorAll('.emp-card').forEach(function(c) {
        c.classList.remove('border-amber-500', 'bg-amber-50', 'shadow-amber-200/50');
        c.classList.add('border-black/5', 'bg-white');
        var badge = c.querySelector('.check-badge');
        if (badge) badge.classList.add('hidden');
    });

    el.classList.remove('border-black/5', 'bg-white', 'hover:shadow-md');
    el.classList.add('border-rose-300', 'bg-rose-50', 'shadow-rose-200/50');

    var icon = el.querySelector('.check-icon');
    if (icon) icon.classList.remove('hidden');

    var section = document.getElementById('employeeSection');
    section.classList.remove('max-h-[2000px]', 'opacity-100', 'mt-5');
    section.classList.add('max-h-0', 'opacity-0', 'mt-0');

    hideEmployeePopup();
}

function selectEmployee(el) {
    var value = el.getAttribute('data-value');
    document.getElementById('employeeInput').value = value;

    document.querySelectorAll('.emp-card').forEach(function(c) {
        c.classList.remove('border-amber-500', 'bg-amber-50', 'shadow-amber-200/50');
        c.classList.add('border-black/5', 'bg-white');
        var badge = c.querySelector('.check-badge');
        if (badge) badge.classList.add('hidden');
    });

    el.classList.remove('border-black/5', 'bg-white');
    el.classList.add('border-amber-500', 'bg-amber-50', 'shadow-amber-200/50');
    var badge = el.querySelector('.check-badge');
    if (badge) badge.classList.remove('hidden');

    var autoCard = document.getElementById('autoAssignCard');
    autoCard.classList.remove('border-rose-300', 'bg-rose-50', 'shadow-rose-200/50');
    autoCard.classList.add('border-black/5', 'bg-white', 'hover:shadow-md');

    var icon = autoCard.querySelector('.check-icon');
    if (icon) icon.classList.add('hidden');

    var section = document.getElementById('employeeSection');
    section.classList.remove('max-h-0', 'opacity-0', 'mt-0');
    section.classList.add('max-h-[2000px]', 'opacity-100', 'mt-5');
}

function showEmployeePopup(el) {
    var raw = el.getAttribute('data-services');
    if (!raw) return;

    var services;
    try { services = JSON.parse(raw); } catch(e) { return; }
    if (services.length === 0) return;

    var popup = document.getElementById('empPopup');
    var nameEl = el.querySelector('.font-semibold.text-xs');
    document.getElementById('empPopupName').textContent = nameEl ? nameEl.textContent : '';

    var list = document.getElementById('empPopupServices');
    list.innerHTML = '';
    services.forEach(function(s) {
        var li = document.createElement('li');
        li.className = 'text-xs text-gray-600 flex items-center gap-1.5';
        li.innerHTML = '<span class="text-amber-500 font-bold text-[10px]">\u2713</span> ' + s;
        list.appendChild(li);
    });

    var container = popup.parentElement;
    var cardRect = el.getBoundingClientRect();
    var containerRect = container.getBoundingClientRect();

    var top = cardRect.bottom - containerRect.top + 6;
    var left = Math.max(4, cardRect.left - containerRect.left);
    var maxLeft = containerRect.width - 184;
    if (left > maxLeft) left = maxLeft;

    popup.style.top = top + 'px';
    popup.style.left = left + 'px';

    popup.classList.remove('hidden');
    var inner = popup.querySelector('div');
    inner.classList.remove('opacity-0', 'scale-95', '-translate-y-1');
}

function hideEmployeePopup() {
    var popup = document.getElementById('empPopup');
    var inner = popup.querySelector('div');
    inner.classList.add('opacity-0', 'scale-95', '-translate-y-1');
    setTimeout(function() {
        popup.classList.add('hidden');
    }, 200);
}

document.addEventListener('DOMContentLoaded', function() {
    var hoverTimer;

    document.querySelectorAll('.emp-card').forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimer);
            showEmployeePopup(card);
        });

        card.addEventListener('mouseleave', function() {
            var popup = document.getElementById('empPopup');
            if (popup._clickOpened) return;
            hoverTimer = setTimeout(hideEmployeePopup, 200);
        });

        var infoBtn = card.querySelector('.info-btn');
        if (infoBtn) {
            infoBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                var popup = document.getElementById('empPopup');
                if (popup._clickOpened && !popup.classList.contains('hidden')) {
                    popup._clickOpened = false;
                    hideEmployeePopup();
                } else {
                    popup._clickOpened = true;
                    showEmployeePopup(card);
                }
            });
        }
    });

    document.addEventListener('click', function(e) {
        var popup = document.getElementById('empPopup');
        if (popup._clickOpened && !popup.classList.contains('hidden')) {
            if (!e.target.closest('.emp-card')) {
                popup._clickOpened = false;
                hideEmployeePopup();
            }
        }
    });

    var selectBtn = document.getElementById('selectEmployeeBtn');
    if (selectBtn) {
        selectBtn.addEventListener('click', function() {
            var autoCard = document.getElementById('autoAssignCard');
            if (autoCard) {
                autoCard.classList.remove('border-rose-300', 'bg-rose-50', 'shadow-rose-200/50');
                autoCard.classList.add('border-black/5', 'bg-white', 'hover:shadow-md');
                var icon = autoCard.querySelector('.check-icon');
                if (icon) icon.classList.add('hidden');
            }

            document.getElementById('employeeInput').value = '';

            var section = document.getElementById('employeeSection');
            section.classList.remove('max-h-0', 'opacity-0', 'mt-0');
            section.classList.add('max-h-[2000px]', 'opacity-100', 'mt-5');
        });
    }

    var empInput = document.getElementById('employeeInput');
    if (empInput && empInput.value !== '') {
        var section = document.getElementById('employeeSection');
        var container = document.getElementById('employeeContainer');
        if (section && container) {
            section.style.maxHeight = container.scrollHeight + 'px';
        }
    }
});
// Payment method
function applyPaymentVisual() {
    document.querySelectorAll('.payment-option').forEach(function(opt) {
        var radio = opt.querySelector('.payment-radio');
        if (radio && radio.checked) {
            opt.classList.add('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            opt.classList.remove('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
        } else {
            opt.classList.remove('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            opt.classList.add('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
        }
    });
}

function showPaymentNotify() {
    var el = document.getElementById('paymentNotify');
    if (!el) return;
    el.classList.remove('hidden');
    el.style.transition = 'opacity 0.3s ease-out';
    el.style.opacity = '1';
    setTimeout(function() {
        el.style.transition = 'opacity 0.3s ease-in';
        el.style.opacity = '0';
        setTimeout(function() {
            el.classList.add('hidden');
            el.style.transition = '';
            el.style.opacity = '';
        }, 300);
    }, 3000);
    document.querySelectorAll('.payment-radio').forEach(function(r) {
        if (r.value === '{{ Payment::METHOD_CASH }}') r.checked = true;
    });
    applyPaymentVisual();
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.payment-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            applyPaymentVisual();
            if (this.value !== '{{ Payment::METHOD_CASH }}') {
                showPaymentNotify();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('bookingForm');
    if (!form) return;

    var loadedAt = form.querySelector('input[name="form_loaded_at"]');
    if (loadedAt) loadedAt.value = Date.now();

    form.addEventListener('submit', function(e) {
        var hasService = document.querySelector('input[name="service_ids[]"]:checked');
        var hasPackage = document.querySelector('input[name="package_ids[]"]:checked');
        if (!hasService && !hasPackage) {
            e.preventDefault();
            alert('{{ __("Please select at least one service or package") }}');
            return;
        }
        var btn = document.getElementById('submitBtn');
        if (btn) btn.disabled = true;
        var st = document.getElementById('submitText');
        if (st) st.classList.add('hidden');
        var ss = document.getElementById('submitSpinner');
        if (ss) ss.classList.remove('hidden');
    });
});

@if($packages->isNotEmpty())
let previousPackageServiceIds = [];

function updatePriceSummary() {
    const summaryBox = document.getElementById('priceSummary');
    const itemsEl = document.getElementById('summaryItems');
    const totalEl = document.getElementById('summaryTotal');
    let items = [];
    let total = 0;

    document.querySelectorAll('.package-checkbox:checked').forEach(cb => {
        const card = cb.closest('.package-card');
        const name = card?.querySelector('.font-bold.text-gray-800')?.textContent || '';
        const priceText = card?.querySelector('.text-xl.font-extrabold')?.textContent || '0';
        const price = parseFloat(priceText) || 0;
        items.push({ name, price, type: 'package' });
        total += price;
    });

    document.querySelectorAll('.service-checkbox:checked:not(:disabled)').forEach(cb => {
        const item = cb.closest('.service-item');
        const name = item?.querySelector('span.font-bold')?.textContent || '';
        const priceText = item?.querySelector('.text-rose-600.font-bold')?.textContent || '0';
        const price = parseInt(priceText) || 0;
        items.push({ name, price, type: 'service' });
        total += price;
    });

    if (items.length === 0) {
        summaryBox.classList.add('hidden');
        return;
    }

    summaryBox.classList.remove('hidden');
    itemsEl.innerHTML = '';
    items.forEach(i => {
        const row = document.createElement('div');
        row.className = 'flex justify-between items-center py-1 text-sm';
        const nameSpan = document.createElement('span');
        nameSpan.className = i.type === 'package' ? 'text-rose-600' : 'text-gray-700';
        if (i.type === 'package') {
            const badge = document.createElement('span');
            badge.className = 'text-xs bg-rose-100 text-rose-700 px-1.5 py-0.5 rounded font-bold';
            badge.textContent = '{{ __("Package") }}';
            nameSpan.appendChild(badge);
            nameSpan.appendChild(document.createTextNode(' ' + i.name));
        } else {
            nameSpan.textContent = i.name;
        }
        row.appendChild(nameSpan);
        const priceSpan = document.createElement('span');
        priceSpan.className = 'font-bold';
        priceSpan.textContent = i.price + ' {{ __("KWD") }}';
        row.appendChild(priceSpan);
        itemsEl.appendChild(row);
    });
    totalEl.textContent = total + ' {{ __("KWD") }}';

    summaryBox.style.transform = 'scale(0.95)';
    summaryBox.style.opacity = '0';
    requestAnimationFrame(() => {
        summaryBox.style.transition = 'all 0.2s ease-out';
        summaryBox.style.transform = 'scale(1)';
        summaryBox.style.opacity = '1';
    });
}

function updatePackages() {
    const checkedBoxes = document.querySelectorAll('.package-checkbox:checked');
    const infoBox = document.getElementById('packageServicesInfo');
    const infoText = document.getElementById('packageServicesText');
    const tagsContainer = document.getElementById('packageServicesTags');
    const servicesLabel = document.getElementById('servicesLabel');

    let allSelectedServiceIds = [];
    let allSelectedNames = [];
    let allSelectedTags = [];

    checkedBoxes.forEach(cb => {
        const card = cb.closest('.package-card');
        const name = card ? card.querySelector('.font-bold.text-gray-800')?.textContent || '' : '';
        const tagText = card ? card.querySelector('.text-gray-400.text-sm.truncate')?.textContent || '' : '';
        const services = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allSelectedServiceIds = allSelectedServiceIds.concat(services);
        if (name) {
            allSelectedNames.push(name);
            if (tagText) {
                allSelectedTags = allSelectedTags.concat(tagText.split(' + '));
            }
        }
    });

    document.querySelectorAll('.package-card').forEach(card => {
        const cb = card.querySelector('.package-checkbox');
        card.classList.toggle('border-rose-300', cb.checked);
        card.classList.toggle('bg-rose-50/40', cb.checked);
        card.classList.toggle('shadow-sm', cb.checked);
        card.classList.toggle('border-gray-100', !cb.checked);
    });

    document.querySelectorAll('.service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackageService = allSelectedServiceIds.includes(sid);
        const wasPackageService = previousPackageServiceIds.includes(sid);

        if (isPackageService) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-item').classList.add('border-rose-200', 'bg-rose-50/30');
            cb.closest('.service-item').classList.remove('border-gray-100', 'bg-white', 'hover:border-amber-200', 'hover:shadow-sm');
            cb.closest('.service-item').querySelector('span.font-bold')?.classList.add('text-rose-600');
            let badge = cb.closest('.service-item').querySelector('.package-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'package-badge text-xs text-rose-500 mr-1';
                badge.textContent = '{{ __("From package") }}';
                const container = cb.closest('.service-item').querySelector('.flex.items-center.gap-3.min-w-0 div');
                if (container) container.appendChild(badge);
            }
        } else {
            if (wasPackageService && !isPackageService) {
                cb.checked = false;
            }
            cb.disabled = false;
            cb.closest('.service-item').classList.remove('border-rose-200', 'bg-rose-50/30');
            cb.closest('.service-item').classList.add('border-gray-100', 'bg-white', 'hover:border-amber-200', 'hover:shadow-sm');
            cb.closest('.service-item').querySelector('span.font-bold')?.classList.remove('text-rose-600');
            const badge = cb.closest('.service-item').querySelector('.package-badge');
            if (badge) badge.remove();
        }
    });

    previousPackageServiceIds = allSelectedServiceIds;

    if (checkedBoxes.length > 0) {
        infoText.textContent = '{{ __("Package Services") }}: ' + allSelectedNames.join(' + ');
        tagsContainer.innerHTML = '';
        [...new Set(allSelectedTags)].forEach(s => {
            const tag = document.createElement('span');
            tag.className = 'bg-rose-100 text-rose-700 text-sm px-3 py-1.5 rounded-lg';
            tag.textContent = '✅ ' + s.trim();
            tagsContainer.appendChild(tag);
        });
        infoBox.classList.remove('hidden');
        servicesLabel.textContent = '{{ __("Extra Services for Package") }}';
    } else {
        infoBox.classList.add('hidden');
        servicesLabel.textContent = '{{ __("Services") }}';
    }

    updatePriceSummary();
}

document.querySelectorAll('.service-checkbox:not(:disabled)').forEach(cb => {
    cb.addEventListener('change', updatePriceSummary);
});

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.package-checkbox:checked')) {
        updatePackages();
    }
    updatePriceSummary();
});
@endif

{{-- Account creation toggle --}}
document.addEventListener('DOMContentLoaded', function() {
    var cb = document.getElementById('create_account');
    var fields = document.getElementById('accountFields');
    if (cb && fields) {
        if (cb.checked) {
            fields.classList.remove('hidden');
            fields.style.opacity = '1';
            fields.style.transform = 'translateY(0)';
        }
        cb.addEventListener('change', function() {
            if (this.checked) {
                fields.classList.remove('hidden');
                fields.style.opacity = '0';
                fields.style.transform = 'translateY(-8px)';
                fields.style.transition = 'none';
                requestAnimationFrame(function() {
                    fields.style.transition = 'all 0.3s ease-out';
                    fields.style.opacity = '1';
                    fields.style.transform = 'translateY(0)';
                });
            } else {
                fields.style.opacity = '0';
                fields.style.transform = 'translateY(-8px)';
                fields.style.transition = 'all 0.2s ease-in';
                setTimeout(function() {
                    fields.classList.add('hidden');
                }, 200);
            }
        });
    }
});
</script>
@endsection
