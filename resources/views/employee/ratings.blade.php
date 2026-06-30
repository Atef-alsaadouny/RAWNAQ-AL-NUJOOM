@extends('layouts.employee')

@section('page-title', __('My Ratings'))

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="bg-gradient-to-l from-amber-50 to-white px-4 md:px-6 py-3 md:py-4 border-b border-gray-100">
        <h2 class="text-sm md:text-lg font-bold text-gray-800">{{ __('Average Rating') }}</h2>
    </div>
    <div class="p-4 md:p-6 text-center">
        <div class="text-5xl font-bold text-amber-600">{{ number_format($avgRating, 1) }}</div>
        <div class="text-gray-500 text-sm mt-1">{{ __('out of 5') }}</div>
        <div class="flex justify-center gap-1 mt-3">
            @for($i = 1; $i <= 5; $i++)
                <svg class="w-6 h-6 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
        </div>
    </div>
</div>

<div class="space-y-4">
    @forelse($ratings as $rating)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-2">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="font-bold text-gray-700">{{ $rating->rating }}/5</span>
                    </div>
                    @if($rating->customer)
                    <div class="text-sm text-gray-500 mt-1">{{ $rating->customer->name }}</div>
                    @endif
                    @if($rating->comment)
                    <p class="text-gray-700 mt-2 bg-gray-50 rounded-lg p-3 text-sm">"{{ $rating->comment }}"</p>
                    @endif
                </div>
                <div class="text-xs text-gray-400 shrink-0" dir="ltr">{{ $rating->created_at->format('Y-m-d') }}</div>
            </div>
            <div class="mt-3 text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2M3 8V6a1 1 0 011-1h16a1 1 0 011 1v2M5 8h14l-1.5 8H6.5L5 8z"/></svg>
                {{ $rating->appointment?->display_services ?: '—' }}
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        <p class="text-gray-500 text-lg">{{ __('No Ratings') }}</p>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $ratings->links() }}</div>
@endsection