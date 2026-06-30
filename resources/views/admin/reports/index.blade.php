@extends('layouts.admin')

@section('page-title', __('Reports'))

@section('content')
<form method="GET" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Filter Date Range') }}</h2>
    </div>
    <div class="p-6">
        <div class="flex gap-4 items-end">
            <div>
                <label class="block text-gray-700 mb-1 text-sm font-medium">{{ __('From') }}</label>
                <input type="date" name="from" value="{{ request('from') }}"
                    class="rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 text-sm font-medium">{{ __('To') }}</label>
                <input type="date" name="to" value="{{ request('to') }}"
                    class="rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <button type="submit" class="bg-amber-600 text-white px-4 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                    {{ __('Filter') }}
                </button>
            </div>
        </div>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-amber-600">{{ $totalAppointments }}</div>
                <div class="text-gray-500 text-sm">{{ __('Total') }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600">{{ $completed }}</div>
                <div class="text-gray-500 text-sm">{{ __('Completed') }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-yellow-600">{{ $pending }}</div>
                <div class="text-gray-500 text-sm">{{ __('Pending Active') }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-red-600">{{ $cancelled }}</div>
                <div class="text-gray-500 text-sm">{{ __('Cancelled') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Employee Performance') }}</h2>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Employee') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Total') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Completed') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Avg Rating') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @forelse($employeeStats as $emp)
            <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                <td class="text-start px-5 py-4 text-sm font-medium text-gray-800">{{ $emp->name }}</td>
                <td class="text-start px-5 py-4 text-sm text-gray-600">{{ $emp->assigned_appointments_count }}</td>
                <td class="text-start px-5 py-4 text-sm text-gray-600">{{ $emp->completed_count }}</td>
                <td class="text-start px-5 py-4 text-sm text-gray-600">{{ number_format($emp->avg_rating, 1) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center px-5 py-16 text-sm text-gray-400">{{ __('No Data') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($cancelReasons->isNotEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto mt-6">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Top Cancellation Reasons') }}</h2>
    </div>
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Reason') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Count') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @foreach($cancelReasons as $reason)
            <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                <td class="text-start px-5 py-4 text-sm font-medium text-gray-800">{{ $reason->cancel_reason }}</td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold">{{ $reason->total }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
