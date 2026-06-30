@extends('layouts.public')

@section('title', __('503 - Maintenance'))

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-gray-400 mb-4">503</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Under Maintenance') }}</h2>
        <p class="text-gray-600 mb-8">{{ __('We are currently performing maintenance. Please check back soon.') }}</p>
        <a href="{{ url('/') }}" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-lg transition">
            {{ __('Refresh') }}
        </a>
    </div>
</div>
@endsection
