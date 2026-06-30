@php use App\Models\Appointment; use App\Models\Payment; @endphp
@extends('layouts.public')

@section('title', __('site_name') . ' — ' . __('Booking Details'))

@section('content')
<div class="max-w-lg mx-auto px-4 py-6">

    <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-8">

        {{-- رقم التذكرة --}}
        <div class="text-center mb-8">
            <p class="text-gray-400 text-sm mb-2">{{ __('Ticket Number') }}</p>
            <div class="text-5xl md:text-6xl font-black tracking-widest leading-none text-transparent bg-clip-text bg-gradient-to-l from-rose-600 to-amber-500">
                {{ $appointment->ticket_number }}
            </div>
        </div>

        {{-- حالة الحجز --}}
        <div class="flex justify-center mb-8">
            @php
                $statusMap = [
                    Appointment::STATUS_PENDING => ['bg-amber-100 text-amber-700 border-amber-200', '🕐'],
                    Appointment::STATUS_ASSIGNED => ['bg-sky-100 text-sky-700 border-sky-200', '👤'],
                    Appointment::STATUS_IN_PROGRESS => ['bg-rose-100 text-rose-700 border-rose-200', '⚙️'],
                    Appointment::STATUS_COMPLETED => ['bg-emerald-100 text-emerald-700 border-emerald-200', '✅'],
                    Appointment::STATUS_CANCELLED => ['bg-red-100 text-red-700 border-red-200', '❌'],
                ];
                $s = $statusMap[$appointment->status] ?? $statusMap[Appointment::STATUS_PENDING];
            @endphp
            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-2xl border-2 font-bold text-sm {{ $s[0] }}">
                {{ $s[1] }} {{ $appointment->status === Appointment::STATUS_PENDING ? __('Pending') : ($appointment->status === Appointment::STATUS_ASSIGNED ? __('Assigned') : ($appointment->status === Appointment::STATUS_IN_PROGRESS ? __('In Progress') : ($appointment->status === Appointment::STATUS_COMPLETED ? __('Completed') : __('Cancelled')))) }}
            </span>
        </div>

        {{-- تفاصيل الحجز --}}
        <div class="space-y-4">
            {{-- العميل --}}
            <div class="bg-rose-50/50 rounded-2xl p-5 border border-rose-100/50">
                <h3 class="text-xs font-bold text-rose-500 uppercase tracking-wide mb-3">{{ __('Client') }}</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ __('Name') }}</span>
                        <span class="font-bold text-gray-800">{{ $appointment->customer_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ __('Phone Number') }}</span>
                        <span class="font-bold text-gray-800" dir="ltr">{{ $appointment->customer_phone }}</span>
                    </div>
                </div>
            </div>

            {{-- الخدمات --}}
            <div class="bg-amber-50/30 rounded-2xl p-5 border border-amber-100/50">
                <h3 class="text-xs font-bold text-amber-500 uppercase tracking-wide mb-3">{{ __('Services & Packages') }}</h3>
                @if($appointment->service_names)
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach(explode(' + ', $appointment->service_names ?? '—') as $sn)
                        <span class="bg-rose-100 text-rose-700 text-sm px-3 py-1.5 rounded-xl font-medium">{{ $sn }}</span>
                    @endforeach
                </div>
                @endif
                @if($appointment->packages->isNotEmpty())
                    @foreach($appointment->packages as $pkg)
                    <div class="flex items-center gap-2 text-sm text-amber-700 bg-amber-50/70 rounded-xl px-3 py-2 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
                        <span class="font-medium">{{ $pkg->name }}</span>
                        <span class="mr-auto text-amber-800 font-bold">{{ formatCurrency($pkg->price) }}</span>
                    </div>
                    @endforeach
                @endif

                {{-- الخدمات الإضافية --}}
                @php
                    $packageServiceIds = collect();
                    foreach ($appointment->packages as $pkg) {
                        $packageServiceIds = $packageServiceIds->merge($pkg->services->pluck('id'));
                    }
                    $extraServices = $appointment->services->reject(fn($s) => $packageServiceIds->contains($s->id));
                @endphp
                @if($extraServices->isNotEmpty())
                <div class="mt-3 pt-3 border-t border-amber-200/40 space-y-1.5">
                    @foreach($extraServices as $svc)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">{{ $svc->name }}</span>
                        <span class="text-gray-800 font-medium">{{ formatCurrency($svc->price) }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- الإجمالي --}}
                <div class="mt-3 pt-3 border-t border-amber-200/40 flex justify-between items-center">
                    <span class="text-gray-700 font-bold">{{ __('Total') }}</span>
                    <span class="text-xl font-black text-rose-700">
                        {{ formatCurrency($appointment->total_price) }}
                    </span>
                </div>
            </div>

            {{-- الموظفة/الموظفين --}}
            @if($appointment->employee)
            <div class="flex justify-between items-center py-3.5 border-b border-gray-100">
                <span class="text-gray-500">{{ __('Stylist') }}</span>
                <span class="font-bold text-rose-600">{{ $appointment->employee->name }}</span>
            </div>
            @endif

            {{-- الموعد --}}
            <div class="bg-rose-50/50 rounded-2xl p-5 border border-rose-100/50">
                <h3 class="text-xs font-bold text-rose-500 uppercase tracking-wide mb-3">{{ __('Appointment') }}</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ __('Date') }}</span>
                        <span class="font-bold text-gray-800">{{ $appointment->appointment_date->format('Y-m-d') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ __('Period') }}</span>
                        <span class="font-bold text-gray-800">{{ $appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
                    </div>
                    @if($appointment->assigned_time)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">{{ __('Time') }}</span>
                        <span class="font-bold text-amber-600 text-lg">{{ $appointment->assigned_time }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- الملاحظات --}}
            @if($appointment->notes)
            <div class="py-3.5">
                <span class="text-gray-500 block mb-1">{{ __('Notes') }}</span>
                <p class="text-gray-700 bg-gray-50 rounded-2xl px-4 py-3">"{{ $appointment->notes }}"</p>
            </div>
            @endif
        </div>

        {{-- Payment Status --}}
        @php $payment = $appointment->payment; @endphp
        @if($payment)
        <div class="mt-6 rounded-2xl p-5 border shadow-sm {{ $payment->isPaid() ? 'bg-emerald-50/50 border-emerald-100/50' : 'bg-amber-50/50 border-amber-100/50' }}">
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
                        <p class="font-bold text-amber-700 text-sm">{{ __('Not Paid') }}</p>
                        <p class="text-xs text-gray-400">{{ __('Payment method:') }} {{ $payment->method === \App\Models\Payment::METHOD_KNET ? __('KNET') : ($payment->method === \App\Models\Payment::METHOD_APPLE_PAY ? __('Apple Pay') : ($payment->method === \App\Models\Payment::METHOD_GOOGLE_PAY ? __('Google Pay') : __('Cash'))) }}</p>
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
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl shadow-rose-200/30">
                <div class="text-center mb-5">
                    <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('Important Notice') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __("Once paid, the booking cannot be modified or cancelled except by contacting support") }}</p>
                </div>
                <div class="bg-amber-50/80 rounded-2xl p-4 mb-5">
                    <p class="text-sm text-amber-800 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Support number:') }} <a href="https://wa.me/{{ config('app.whatsapp') }}" target="_blank" dir="ltr" class="underline">{{ config('app.whatsapp') }}</a>
                    </p>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('payment.process', $appointment) }}" method="POST" class="flex-1">
                        @csrf
                            <input type="hidden" name="method" value="{{ \App\Models\Payment::METHOD_KNET }}">
                        @if(request('token'))<input type="hidden" name="token" value="{{ request('token') }}">@endif
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

        {{-- أزرار الإجراءات --}}
        @if(in_array($appointment->status, Appointment::EDITABLE_STATUSES))
        <div class="mt-8 space-y-3">
            @if($appointment->isEditable())
            <a href="{{ route('booking.guest.edit', $appointment) }}?phone={{ $appointment->customer_phone }}&token={{ request('token') }}"
               rel="noreferrer" class="block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 rounded-2xl font-bold text-center shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                {{ __('Edit Booking') }}
            </a>
            @else
            <div class="bg-amber-50 border border-amber-200/60 rounded-2xl p-4 text-sm text-amber-800 font-medium text-center">
                {{ __("This booking is paid, please contact support to modify or cancel it") }}
            </div>
            @endif
            @if($appointment->isEditable())
            <button type="button" onclick="document.getElementById('cancelBox').classList.toggle('hidden')"
               class="block w-full bg-red-50 text-red-700 py-3.5 rounded-2xl font-bold border-2 border-red-200 hover:bg-red-100 hover:border-red-300 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ __('Cancel Booking') }}
            </button>
            <div id="cancelBox" class="hidden p-5 bg-red-50/70 rounded-2xl border border-red-200">
                <form method="POST" action="{{ route('booking.guest.cancel', $appointment) }}" id="cancelForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="phone" value="{{ $appointment->customer_phone }}">
                    @if(request('token'))<input type="hidden" name="token" value="{{ request('token') }}">@endif
                    <textarea name="cancel_reason" id="cancelReason" rows="2" class="w-full border-2 border-red-200 rounded-xl px-4 py-3 text-sm focus:ring-0 focus:border-red-400 focus:bg-red-50/50 transition-all duration-200 resize-none" placeholder="{{ __('Is there a reason for cancellation?') }}"></textarea>
                    <div class="flex gap-3 mt-3">
                        <button type="button" onclick="confirmCancel()" class="flex-1 bg-red-600 text-white py-2.5 rounded-xl font-bold hover:bg-red-700 transition text-sm">{{ __('Confirm Cancellation') }}</button>
                        <button type="button" onclick="document.getElementById('cancelBox').classList.add('hidden')" class="flex-1 bg-emerald-500 text-white py-2.5 rounded-xl font-bold hover:bg-emerald-600 transition text-sm">{{ __('Go Back') }}</button>
                    </div>
                </form>
            </div>
            <script>
            function confirmCancel() {
                const reason = document.getElementById('cancelReason');
                if (!reason.value.trim()) {
                    reason.classList.add('border-red-500');
                    reason.focus();
                    return;
                }
                reason.classList.remove('border-red-500');
                document.getElementById('cancelForm').submit();
            }
            </script>
            @endif
        </div>
        @endif

        {{-- رجوع --}}
        <a href="{{ route('track') }}"
           class="mt-3 block w-full text-center bg-gray-100 text-gray-700 py-3.5 rounded-2xl font-bold hover:bg-gray-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px] flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('Back') }}
        </a>
    </div>

    {{-- تقييم الخدمة --}}
    @if($appointment->status === Appointment::STATUS_COMPLETED && !$appointment->rating)
    <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-[2.5rem] p-6 md:p-8 border border-amber-100/50 shadow-lg shadow-amber-100/20">
        <h3 class="font-bold text-gray-800 text-center mb-4 text-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            {{ __('Rate the Service') }} 🤍
        </h3>
                        <form method="POST" action="{{ route('rating.guest.store', $appointment) }}">
                            @csrf
                            <input type="hidden" name="phone" value="{{ $appointment->customer_phone }}">
                            @if(request('token'))<input type="hidden" name="token" value="{{ request('token') }}">@endif
                            <div class="flex justify-center gap-2 mb-5">
                <style>
                    .star-select-g { display: inline-flex; flex-direction: row-reverse; }
                    .star-select-g input { display: none; }
                    .star-select-g label { font-size: 2.5rem; cursor: pointer; color: #d1d5db; transition: color 0.15s; }
                    .star-select-g input:checked ~ label { color: #facc15; }
                    .star-select-g label:hover, .star-select-g label:hover ~ label { color: #facc15; }
                </style>
                <div class="star-select-g">
                    @for($i = 5; $i >= 1; $i--)
                    <input type="radio" name="rating" value="{{ $i }}" id="gstar{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                    <label for="gstar{{ $i }}">★</label>
                    @endfor
                </div>
            </div>
            <div class="mb-4">
                <textarea name="comment" rows="3" placeholder="{{ __('Comment (optional)') }}"
                    class="w-full border-2 border-gray-100 rounded-xl px-4 py-3 text-sm focus:ring-0 focus:border-amber-400 focus:bg-amber-50/20 transition-all duration-200 resize-none">{{ old('comment') }}</textarea>
            </div>
            @error('rating')
            <p class="text-red-500 text-sm text-center mb-3">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="w-full bg-gradient-to-l from-amber-400 to-amber-500 text-white py-3 rounded-xl font-bold shadow-lg shadow-amber-200/60 hover:shadow-xl hover:from-amber-500 hover:to-amber-600 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-[15px]">
                {{ __('Submit Rating') }}
            </button>
        </form>
    </div>
    @endif

    {{-- عرض التقييم السابق (للزوار) --}}
    @if($appointment->rating)
    <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-[2.5rem] p-6 md:p-8 border border-amber-100/50 shadow-lg shadow-amber-100/20">
        <h3 class="font-bold text-gray-800 mb-4 text-lg">{{ __('Your Rating') }}</h3>
        <div class="flex items-center gap-2">
            @for($i = 1; $i <= 5; $i++)
                <span class="text-3xl {{ $i <= $appointment->rating->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
            @endfor
            <span class="mr-2 font-bold text-gray-700">{{ $appointment->rating->rating }}/5</span>
        </div>
        @if($appointment->rating->comment)
        <p class="mt-3 text-gray-600 bg-gray-50 rounded-2xl p-4">"{{ $appointment->rating->comment }}"</p>
        @endif
    </div>
    @endif

</div>
@endsection
