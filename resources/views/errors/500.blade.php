@extends('layouts.public')

@section('title', __('500 - Server Error'))

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <h1 class="text-8xl font-bold text-red-600 mb-4">500</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Server Error') }}</h2>
        <p class="text-gray-600 mb-8">{{ __('Something went wrong on our end. Please try again later.') }}</p>
        <a href="{{ url('/') }}" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-lg transition">
            {{ __('Back to Home') }}
        </a>
    </div>
</div>
@endsection
