@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', $customer->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Customer Data') }}</h2>
        </div>
        <div class="divide-y divide-gray-50">
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Name') }}</span>
                <span class="font-bold text-gray-800">{{ $customer->name }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Email') }}</span>
                <span class="text-gray-700">{{ $customer->email ?? '—' }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Phone') }}</span>
                <span class="text-gray-700">{{ $customer->phone ?? '—' }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Total Bookings') }}</span>
                <span class="font-bold text-gray-800">{{ $customer->appointments->count() }}</span>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-50">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center gap-1 bg-amber-600 text-white px-4 py-2 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                {{ __('Edit Customer Data') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Bookings') }}</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($customer->appointments as $apt)
            <div class="px-6 py-3.5">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-sm font-medium text-gray-500">{{ $apt->ticket_number }}</span>
                    <span>
                        @switch($apt->status)
                            @case(Appointment::STATUS_PENDING)
                                <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-yellow-200/50">{{ __('Pending') }}</span>
                                @break
                            @case(Appointment::STATUS_ASSIGNED)
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50">{{ __('Assigned') }}</span>
                                @break
                            @case(Appointment::STATUS_IN_PROGRESS)
                                <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-purple-200/50">{{ __('In Progress') }}</span>
                                @break
                            @case(Appointment::STATUS_COMPLETED)
                                <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-teal-200/50">{{ __('Completed') }}</span>
                                @break
                            @case(Appointment::STATUS_CANCELLED)
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50">{{ __('Cancelled') }}</span>
                                @break
                        @endswitch
                    </span>
                </div>
                <div class="text-sm text-gray-400 mt-1">{{ $apt->appointment_date?->format('Y-m-d') }}</div>
            </div>
            @empty
            <div class="px-6 py-8 text-center">
                <div class="flex flex-col items-center gap-2 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm">{{ __('No Bookings') }}</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
