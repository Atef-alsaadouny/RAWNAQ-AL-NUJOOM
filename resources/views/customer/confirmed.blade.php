@php use App\Models\Appointment; use App\Models\Payment; @endphp
@extends('layouts.public')

@section('title', __('Booking Confirmed'))

@section('content')
<div class="max-w-lg mx-auto px-4 py-6">
    <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-10">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-rose-400 to-amber-400 rounded-full flex items-center justify-center shadow-lg shadow-rose-200/50 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('Booking Confirmed') }} 🎉</h1>
            <p class="text-gray-400 text-sm mt-1">{{ __('Your ticket number') }}</p>
        </div>

        {{-- Ticket number --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-rose-100/50 text-center shadow-sm">
            <div class="text-7xl font-black tracking-widest leading-none text-transparent bg-clip-text bg-gradient-to-l from-rose-600 to-amber-500">
                {{ $appointment->ticket_number }}
            </div>
            <p class="mt-3 text-sm text-rose-700 font-medium">{{ __('Use this number to track your booking') }}</p>
        </div>

        {{-- Reminder --}}
        @if($appointment->appointment_date->isAfter(now()->addDay()->startOfDay()))
        <div class="bg-gradient-to-l from-amber-50 to-rose-50 border border-amber-200/50 rounded-2xl p-4 mb-6 text-center shadow-sm">
            <p class="text-sm font-bold text-amber-800 flex items-center justify-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                {{ __("We'll remind you of your appointment a day before") }} 🤍
            </p>
        </div>
        @endif

        {{-- Details --}}
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500">{{ __('Name') }}</span>
                <span class="font-bold text-gray-800">{{ $appointment->customer_name }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500">{{ __('Phone Number') }}</span>
                <span class="font-bold text-gray-800 ltr" dir="ltr">{{ $appointment->customer_phone }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500">{{ __('Date') }}</span>
                <span class="font-bold text-gray-800">{{ $appointment->appointment_date->format('Y-m-d') }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500">{{ __('Shift') }}</span>
                <span class="font-bold text-gray-800">{{ $appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
            </div>
            @if($appointment->employee)
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500">{{ __('Employee') }}</span>
                <span class="font-bold text-rose-600">{{ $appointment->employee->name }}</span>
            </div>
            @endif

            {{-- Price breakdown --}}
            @php
                $packageServiceIds = collect();
                foreach ($appointment->packages as $pkg) {
                    $packageServiceIds = $packageServiceIds->merge($pkg->services->pluck('id'));
                }
                $servicesTotal = $appointment->services
                    ->reject(fn($svc) => $packageServiceIds->contains($svc->id))
                    ->sum('price');
                $packagesTotal = $appointment->packages->sum('price');
            @endphp

            @if($appointment->packages->isNotEmpty() || $servicesTotal > 0)
            <div class="bg-white/70 rounded-2xl p-5 border border-rose-100/50 space-y-3 mt-2 shadow-sm">
                <h3 class="font-bold text-gray-800 text-sm mb-3">{{ __('Invoice Details') }}</h3>

                @foreach($appointment->packages as $pkg)
                @php $saved = $pkg->original_price && $pkg->original_price > $pkg->price ? $pkg->original_price - $pkg->price : 0; @endphp
                <div class="flex justify-between items-start py-2">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400 shrink-0"></span>
                            <span class="text-sm font-bold text-gray-800">{{ $pkg->name }}</span>
                            <span class="text-xs bg-rose-100 text-rose-700 px-1.5 py-0.5 rounded font-bold">{{ __('Package') }}</span>
                            @if($saved > 0)
                            <span class="text-xs bg-fuchsia-100 text-fuchsia-700 px-1.5 py-0.5 rounded font-bold">{{ __('Save') }} {{ formatCurrency($saved) }}</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-1.5 mr-3 mt-1.5">
                            @foreach($pkg->services as $ps)
                                <span class="text-xs bg-rose-50 text-rose-600 px-2 py-0.5 rounded-lg">{{ $ps->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <span class="font-bold text-rose-600 text-lg shrink-0 mr-3">{{ formatCurrency($pkg->price) }}</span>
                </div>
                @endforeach

                @if($servicesTotal > 0)
                <div class="border-t border-rose-100/50 pt-2">
                    @foreach($appointment->services as $svc)
                    @php
                        $inPackage = false;
                        foreach ($appointment->packages as $pkg) {
                            if ($pkg->services->contains($svc->id)) { $inPackage = true; break; }
                        }
                    @endphp
                    @if(!$inPackage)
                    <div class="flex justify-between items-center py-1.5">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
                            <span class="text-sm text-gray-700">{{ $svc->name }}</span>
                        </div>
                        <span class="font-bold text-gray-700 text-sm">{{ formatCurrency($svc->price) }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                <div class="border-t border-rose-200/60 pt-3 mt-2 flex justify-between items-center">
                    <span class="font-bold text-gray-800 text-base">{{ __('Total') }}</span>
                    <span class="text-2xl font-extrabold text-rose-600">{{ formatCurrency($servicesTotal + $packagesTotal) }}</span>
                </div>
            </div>
            @endif

            {{-- Payment Status --}}
            @php $payment = $appointment->payment; @endphp
            @if($payment)
            <div class="mt-4 bg-white/70 rounded-2xl p-5 border border-rose-100/50 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        @if($payment->isPaid())
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-emerald-700 text-sm">{{ __('Paid') }} ✓</p>
                            <p class="text-xs text-gray-400">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '' }}</p>
                        </div>
                        @else
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-amber-700 text-sm">{{ __('Not paid') }}</p>
                            <p class="text-xs text-gray-400">{{ __('Payment method') }}: {{ $payment->method === Payment::METHOD_KNET ? __('KNET') : ($payment->method === Payment::METHOD_APPLE_PAY ? __('Apple Pay') : ($payment->method === Payment::METHOD_GOOGLE_PAY ? __('Google Pay') : __('Cash'))) }}</p>
                        </div>
                        @endif
                    </div>
                    <span class="text-lg font-extrabold text-gray-800">{{ formatCurrency($payment->amount) }}</span>
                </div>
                @if(!$payment->isPaid() && !$payment->isCash())
                <button type="button" onclick="showPayNowModal()" class="mt-3 w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3 rounded-2xl font-bold text-sm shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    {{ __('Pay Now') }}
                </button>
                @endif
            </div>
            @endif

            {{-- Pay Now Warning Modal --}}
            <div id="payNowWarningModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
                <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl shadow-rose-200/30 transform transition-all duration-300">
                    <div class="text-center mb-5">
                        <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('Important Notice') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ __('If payment is made, the booking cannot be modified or cancelled except through contacting support') }}</p>
                    </div>
                    <div class="bg-amber-50/80 rounded-2xl p-4 mb-5">
                        <p class="text-sm text-amber-800 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('Support number') }}: <a href="https://wa.me/{{ config('app.whatsapp') }}" target="_blank" dir="ltr" class="underline">{{ config('app.whatsapp') }}</a>
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <form action="{{ route('payment.process', $appointment) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="method" value="{{ Payment::METHOD_KNET }}">
                            <button type="submit" class="w-full bg-rose-500 text-white py-3 rounded-2xl font-bold hover:bg-rose-600 transition text-sm">{{ __('Confirm Payment') }}</button>
                        </form>
                        <button type="button" onclick="hidePayNowModal()" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-2xl font-bold hover:bg-gray-200 transition text-sm">{{ __('Back') }}</button>
                    </div>
                </div>
            </div>

            <script>
            function showPayNowModal() {
                document.getElementById('payNowWarningModal').classList.remove('hidden');
                document.getElementById('payNowWarningModal').classList.add('flex');
            }
            function hidePayNowModal() {
                document.getElementById('payNowWarningModal').classList.add('hidden');
                document.getElementById('payNowWarningModal').classList.remove('flex');
            }
            </script>

            @if(!auth()->check())
            <a href="{{ route('track.result', ['appointment' => $appointment, 'phone' => $appointment->customer_phone, 'token' => request('token')]) }}"
               rel="noreferrer" class="mt-3 block w-full text-center bg-gray-100 text-gray-700 py-3.5 rounded-2xl font-bold hover:bg-gray-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                {{ __('Track Your Booking') }}
            </a>
            @else
            <a href="{{ route('customer.appointment.show', $appointment) }}"
               class="mt-3 block w-full text-center bg-gray-100 text-gray-700 py-3.5 rounded-2xl font-bold hover:bg-gray-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                {{ __('View Booking Details') }}
            </a>
            @endif

            <a href="{{ route('home') }}"
               class="mt-3 block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 rounded-2xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] text-center flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                {{ __('Back to Homepage') }}
            </a>
        </div>
    </div>
</div>
@endsection
