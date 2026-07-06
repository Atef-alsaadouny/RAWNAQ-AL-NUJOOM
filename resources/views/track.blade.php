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
        <p class="text-gray-500 text-center text-sm mb-8 leading-relaxed">{{ __("Enter your booking number and phone number to track your booking") }}</p>

        {{-- نموذج البحث --}}
        <form method="POST" action="{{ route('track.lookup') }}">
            @csrf

            {{-- رقم الحجز --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium text-sm mb-2">{{ __('Booking Number') }}</label>
                <div class="relative">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">🎫</span>
                    <input type="text" name="ticket_number" value="{{ old('ticket_number') }}" dir="ltr"
                        class="w-full border rounded-xl px-4 pr-11 py-3 text-center text-lg font-bold text-gray-800 tracking-widest transition-all duration-200 @error('ticket_number') border-red-400 bg-red-50 ring-1 ring-red-400 @else border-gray-200 focus:ring-2 focus:ring-rose-400 focus:border-transparent @enderror"
                        placeholder="00001">
                </div>
                @error('ticket_number')
                <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1.5 @if(app()->getLocale() === 'ar') text-right @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- رقم الهاتف --}}
            <div class="mb-8">
                <label class="block text-gray-700 font-medium text-sm mb-2">{{ __('Phone Number') }}</label>
                <div class="relative">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">📞</span>
                    <input type="text" name="phone" value="{{ old('phone') }}" dir="ltr"
                        class="w-full border rounded-xl px-4 pr-11 py-3 text-center text-lg font-bold text-gray-800 tracking-wide transition-all duration-200 @error('phone') border-red-400 bg-red-50 ring-1 ring-red-400 @else border-gray-200 focus:ring-2 focus:ring-rose-400 focus:border-transparent @enderror"
                        placeholder="5xxxxxxx">
                </div>
                @error('phone')
                <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1.5 @if(app()->getLocale() === 'ar') text-right @endif">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
                @enderror
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
