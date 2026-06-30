@extends('layouts.public')

@section('title', __('419 - Session Expired'))

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-amber-500 mb-4">419</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Session Expired') }}</h2>
        <p class="text-gray-600 mb-8">{{ __('Your session has expired. Please refresh the page and try again.') }}</p>
        <a href="{{ url()->previous() }}" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-lg transition">
            {{ __('Try Again') }}
        </a>
    </div>
</div>
@endsection
