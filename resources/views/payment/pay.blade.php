@php use App\Models\Payment; @endphp
@extends('layouts.public')

@section('title', __('Payment'))

@section('content')
<div class="max-w-lg mx-auto px-4 py-6">
    <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-10">

        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-rose-400 to-amber-400 rounded-full flex items-center justify-center shadow-lg shadow-rose-200/50 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('Payment') }}</h1>
            <p class="text-gray-400 text-sm mt-1">{{ __('Ticket Number') }}: <strong class="text-rose-600">{{ $appointment->ticket_number }}</strong></p>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 mb-6 border border-rose-100/50 space-y-4 shadow-sm">
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-500">{{ __('Services') }}</span>
                <span class="text-gray-700 font-medium">{{ $appointment->display_services ?: '—' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-t border-gray-50">
                <span class="text-gray-500">{{ __('Total') }}</span>
                <span class="text-2xl font-extrabold text-rose-700">{{ formatCurrency($appointment->total_price) }}</span>
            </div>
        </div>

        <form action="{{ route('payment.process', $appointment) }}" method="POST">
            @csrf
            @if($appointment->guest_token)<input type="hidden" name="token" value="{{ $appointment->guest_token }}">@endif
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-sm mb-3">{{ __('Choose Payment Method') }}</label>
                <div class="grid grid-cols-3 gap-3" id="payMethodContainer">
                    <label class="pay-option rounded-2xl px-4 py-4 cursor-pointer transition-all duration-200 text-sm font-medium border-2 flex flex-col items-center justify-center gap-2 border-rose-300 bg-rose-50/70 text-rose-700 shadow-sm">
                        <input type="radio" name="method" value="{{ Payment::METHOD_KNET }}" class="pay-radio hidden" checked onchange="updatePayMethod()">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><text x="12" y="16" text-anchor="middle" class="text-xs font-bold" fill="currentColor">K</text></svg>
                        <span>{{ __('KNET') }}</span>
                    </label>
                    <label class="pay-option rounded-2xl px-4 py-4 cursor-pointer transition-all duration-200 text-sm font-medium border-2 flex flex-col items-center justify-center gap-2 border-gray-100 bg-white text-gray-500 hover:border-amber-200 hover:text-amber-600">
                        <input type="radio" name="method" value="{{ Payment::METHOD_APPLE_PAY }}" class="pay-radio hidden" onchange="updatePayMethod()">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor"><path d="M17.05 12.7c-.03-2.33 1.9-3.45 1.98-3.5-.74-1.08-1.88-1.23-2.3-1.25-.98-.1-1.9.58-2.4.58-.5 0-1.28-.56-2.1-.55-1.08.02-2.07.63-2.63 1.6-1.12 1.95-.3 4.83.8 6.41.54.78 1.18 1.66 2.02 1.63.81-.03 1.12-.53 2.1-.53.98 0 1.26.53 2.12.51.88-.01 1.43-.8 1.96-1.58.42-.62.8-1.3 1.28-1.98.34-.62.76-1.3.75-1.98-.02-.3-.3-.6-.56-.74-.5-.22-1.28-.52-1.3-.52zM14.67 9.12c.35-.42.6-1.02.53-1.62-.5.02-1.14.33-1.5.75-.33.38-.63.98-.55 1.56.58.04 1.18-.28 1.52-.69z"/></svg>
                        <span>{{ __('Apple Pay') }}</span>
                    </label>
                    <label class="pay-option rounded-2xl px-4 py-4 cursor-pointer transition-all duration-200 text-sm font-medium border-2 flex flex-col items-center justify-center gap-2 border-gray-100 bg-white text-gray-500 hover:border-amber-200 hover:text-amber-600">
                        <input type="radio" name="method" value="{{ Payment::METHOD_GOOGLE_PAY }}" class="pay-radio hidden" onchange="updatePayMethod()">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor"><path d="M22.01 11.91c0-.69-.06-1.36-.18-2H11.99v3.78h5.6a4.25 4.25 0 01-1.84 2.8v2.32h2.97c1.74-1.6 2.74-3.96 2.74-6.9z"/><path d="M11.99 23c2.49 0 4.58-.82 6.1-2.22l-2.97-2.3c-.83.55-1.88.88-3.13.88-2.4 0-4.44-1.62-5.17-3.8H3.77v2.38A9.23 9.23 0 0011.99 23z"/><path d="M6.82 14.56a5.56 5.56 0 010-3.56V8.62H3.77a9.23 9.23 0 000 8.32l3.05-2.38z"/><path d="M11.99 5.26c1.35 0 2.57.47 3.53 1.38l2.65-2.65A9.22 9.22 0 006.82 8.62l3.05 2.38c.73-2.18 2.77-3.74 5.17-3.74z"/></svg>
                        <span>{{ __('Google Pay') }}</span>
                    </label>
                </div>
            </div>

            <div id="payWarningBox" class="hidden bg-amber-50 border border-amber-200/60 rounded-2xl p-4 mb-6">
                <p class="text-sm text-amber-800 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ __('Payment Warning') }}
                </p>
            </div>

            <button type="submit" id="payBtn" class="w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ __('Confirm Payment') }}
            </button>
        </form>
    </div>
</div>

<script>
function updatePayMethod() {
    document.querySelectorAll('.pay-option').forEach(function(el) {
        var input = el.querySelector('.pay-radio:checked');
        if (input) {
            el.classList.add('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            el.classList.remove('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
        } else {
            el.classList.remove('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            el.classList.add('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-amber-200', 'hover:text-amber-600');
        }
    });
}
updatePayMethod();
</script>
@endsection
