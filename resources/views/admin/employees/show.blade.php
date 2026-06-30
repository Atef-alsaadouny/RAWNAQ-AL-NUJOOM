@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', $employee->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Employee Data') }}</h2>
        </div>
        <div class="divide-y divide-gray-50">
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Employee Id') }}</span>
                <span class="font-bold font-mono text-gray-800">{{ $employee->employee_id }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Name') }}</span>
                <span class="font-bold text-gray-800">{{ $employee->name }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Email') }}</span>
                <span class="text-gray-700">{{ $employee->email ?? '—' }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Phone') }}</span>
                <span class="text-gray-700">{{ $employee->phone ?? '—' }}</span>
            </div>
            <div class="flex justify-between px-6 py-3.5">
                <span class="text-gray-500 text-sm">{{ __('Status') }}</span>
                <span>
                    @if($employee->is_active)
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-green-200/50">{{ __('Active') }}</span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50">{{ __('Inactive') }}</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-50">
            <h3 class="text-sm font-bold text-gray-600 mb-3">{{ __('Services') }}</h3>
            <div class="flex flex-wrap gap-2">
                @forelse($employee->services as $service)
                    <span class="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-sm border border-amber-200/50">{{ $service->name }}</span>
                @empty
                    <span class="text-gray-400 text-sm">{{ __('No Services') }}</span>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Latest Appointments') }}</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($employee->assignedAppointments as $apt)
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
                    <p class="text-sm">{{ __('No Appointments') }}</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
