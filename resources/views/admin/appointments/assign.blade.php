@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', __('Assign Booking') . ': ' . $appointment->ticket_number)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Booking Details') }}</h2>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-gray-500 text-sm">{{ __('Customer') }}</span>
                <span class="font-bold text-gray-800">{{ $appointment->customer_name }}</span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm">{{ __('Service') }}</span>
                <span class="text-gray-700">{{ $appointment->display_services }}</span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm">{{ __('Date') }}</span>
                <span class="text-gray-700" dir="ltr">{{ $appointment->appointment_date?->format('Y-m-d') }}</span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm">{{ __('Shift') }}</span>
                <span class="text-gray-700">{{ $appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
            </div>
            <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                <span class="text-gray-500 text-sm">{{ __('Priority') }}</span>
                <span>
                    @if($appointment->display_priority === Appointment::PRIORITY_VIP)
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50">{{ __('Vip') }}</span>
                    @elseif($appointment->display_priority === Appointment::PRIORITY_URGENT)
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50">{{ __('Urgent') }}</span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-slate-200/50">{{ __('Normal') }}</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">{{ __('Assign To Employee') }}</h2>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.appointments.assign.store', $appointment) }}">
                @csrf
                <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Select Employee') }}</label>
                    <select name="employee_id" class="appearance-none bg-no-repeat w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition bg-[length:14px] bg-[center_right_8px] pr-8 !rtl:bg-[center_left_8px] !rtl:pr-4 !rtl:pl-8 bg-[url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22m6 9 6 6 6-6%22/%3E%3C/svg%3E')]">
                        <option value="">{{ __('Random') }}</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} ({{ $emp->employee_id }}) - {{ $emp->assigned_appointments_count }} {{ __('Active') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Time Optional') }}</label>
                    <input type="time" name="assigned_time" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <p class="text-xs text-gray-400 mt-1">{{ __('Set Suitable Time') }}</p>
                </div>
                <button type="submit" class="inline-flex items-center gap-1 bg-green-600 text-white px-6 py-2.5 rounded-xl hover:bg-green-700 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Confirm Assignment') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
