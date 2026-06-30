{{-- ============================================================
    صفحة تتبع الحجز (Track Booking Page)
    ============================================================ --}}
@extends('layouts.public')

@section('title', __('site_name') . ' — ' . __('Track Your Booking'))

@section('content')
<div class="max-w-lg mx-auto px-4">

    {{-- بطاقة البحث --}}
    <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-sm border border-rose-100/50 p-8 md:p-10">

        {{-- أيقونة --}}
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-rose-100 to-amber-100 rounded-2xl flex items-center justify-center shadow-sm">
                <span class="text-3xl">🔍</span>
            </div>
        </div>

        {{-- عنوان --}}
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-2">{{ __('Track Your Booking') }}</h1>
        <p class="text-gray-500 text-center text-sm mb-8 leading-relaxed">{{ __("Enter your ticket number with phone number, or phone number only") }}</p>

        {{-- نموذج البحث --}}
        <form method="POST" action="{{ route('track.lookup') }}">
            @csrf

            {{-- رقم التذكرة --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium text-sm mb-2">{{ __('Ticket Number') }}</label>
                <div class="relative">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">🎫</span>
                    <input type="text" name="ticket_number" dir="ltr"
                        class="w-full border border-gray-200 rounded-xl px-4 pr-11 py-3 text-center text-lg font-bold text-gray-800 tracking-widest focus:ring-2 focus:ring-rose-400 focus:border-transparent transition-all duration-200"
                        placeholder="00001">
                </div>
            </div>

            {{-- رقم الهاتف --}}
            <div class="mb-8">
                <label class="block text-gray-700 font-medium text-sm mb-2">{{ __('Phone Number') }}</label>
                <div class="relative">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">📞</span>
                    <input type="text" name="phone" dir="ltr"
                        class="w-full border border-gray-200 rounded-xl px-4 pr-11 py-3 text-center text-lg font-bold text-gray-800 tracking-wide focus:ring-2 focus:ring-rose-400 focus:border-transparent transition-all duration-200"
                        placeholder="5xxxxxxx">
                </div>
            </div>

            {{-- زر البحث --}}
            <button type="submit"
                class="w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 transition-all duration-200 text-[15px]">
                {{ __('Search') }}
            </button>
        </form>
    </div>

</div>
@endsection
