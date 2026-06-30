@extends('layouts.admin')

@section('page-title', __('Profile'))

@section('content')
<div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm">
    <div class="space-y-3">
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600">{{ __('Name') }}</span>
            <span class="font-bold">{{ auth()->user()->name }}</span>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600">{{ __('Email') }}</span>
            <span>{{ auth()->user()->email }}</span>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span class="text-gray-600">{{ __('Phone') }}</span>
            <span>{{ auth()->user()->phone ?? '—' }}</span>
        </div>
    </div>
</div>
@endsection
