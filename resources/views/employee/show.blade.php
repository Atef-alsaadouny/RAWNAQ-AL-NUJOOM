@php use App\Models\Appointment; @endphp
@extends('layouts.employee')

@section('page-title', __('Booking') . ': ' . $appointment->ticket_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-l from-amber-50 to-white px-4 md:px-6 py-3 md:py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <div class="flex flex-col items-center justify-center bg-amber-100 text-amber-700 rounded-xl px-3 py-1.5 text-center leading-tight">
                    <span class="text-lg font-bold">{{ $appointment->appointment_date?->format('d') }}</span>
                    <span class="text-[10px] font-medium opacity-75">{{ $appointment->appointment_date?->format('M') }}</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-sm text-gray-400">{{ $appointment->ticket_number }}</span>
                        @if($appointment->display_priority === Appointment::PRIORITY_VIP)
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-emerald-200/50">{{ __('Vip') }}</span>
                        @elseif($appointment->display_priority === Appointment::PRIORITY_URGENT)
                            <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-rose-200/50">{{ __('Urgent') }}</span>
                        @endif
                    </div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $appointment->customer_name ?? $appointment->customer?->name ?? '—' }}</h1>
                    <div class="text-sm text-gray-500">{{ $appointment->customer_phone }}</div>
                </div>
            </div>
            <div class="shrink-0">
                @switch($appointment->status)
                    @case(Appointment::STATUS_ASSIGNED) <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50">{{ __('Assigned') }}</span> @break
                    @case(Appointment::STATUS_IN_PROGRESS) <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-purple-200/50">{{ __('In Progress') }}</span> @break
                    @case(Appointment::STATUS_COMPLETED) <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-teal-200/50">{{ __('Completed') }}</span> @break
                    @case(Appointment::STATUS_CANCELLED) <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50">{{ __('Cancelled') }}</span> @break
                @endswitch
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Details card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-l from-amber-50 to-white px-4 md:px-5 py-3 md:py-3.5 border-b border-gray-100">
                @if($appointment->appointment_date?->isBefore(now()->startOfDay()) && in_array($appointment->status, Appointment::EDITABLE_STATUSES))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4 mb-4 text-sm font-bold">
                {{ __('This booking date has passed') }}
            </div>
            @endif

            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('Booking Details') }}
                </h2>
            </div>
            <div class="p-4 md:p-5 divide-y divide-gray-50">
                <div class="py-2.5">
                    <span class="text-gray-500 text-sm block mb-1">{{ __('Services & Packages') }}</span>
                    <div class="space-y-1.5">
                        @foreach($appointment->packages as $pkg)
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
                            <span class="font-medium text-gray-800">{{ $pkg->name }}</span>
                            <span class="text-[10px] bg-amber-50 text-amber-700 px-1.5 py-0.5 rounded font-bold">{{ __('Package') }}</span>
                        </div>
                        @endforeach
                        @foreach($appointment->services as $svc)
                        @php $inPackage = $appointment->packages->contains(fn($p) => $p->services->contains($svc->id)); @endphp
                        @if(!$inPackage)
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                            <span class="font-medium text-gray-800">{{ $svc->name }}</span>
                        </div>
                        @endif
                        @endforeach
                        @if($appointment->packages->isEmpty() && $appointment->services->isEmpty())
                        <span class="text-gray-400">{{ __('Not Specified') }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-gray-500 text-sm">{{ __('Date') }}</span>
                    <span class="font-medium text-gray-800 text-left" dir="ltr">{{ $appointment->appointment_date?->format('Y-m-d') }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-gray-500 text-sm">{{ __('Shift') }}</span>
                    <span class="font-medium text-gray-800">{{ $appointment->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5">
                    <span class="text-gray-500 text-sm">{{ __('Time') }}</span>
                    <span class="font-bold text-gray-800">{{ $appointment->assigned_time ?? __('Not Specified') }}</span>
                </div>
                @if($appointment->notes)
                <div class="py-2.5">
                    <span class="text-gray-500 text-sm block mb-1">{{ __('Notes') }}</span>
                    <p class="text-gray-700 bg-gray-50 rounded-lg p-3 text-sm">{{ $appointment->notes }}</p>
                </div>
                @endif
                @if($appointment->cancel_reason)
                <div class="py-2.5">
                    <span class="text-gray-500 text-sm block mb-1">{{ __('Cancel Reason') }}</span>
                    <p class="text-red-700 bg-red-50 rounded-lg p-3 text-sm">{{ $appointment->cancel_reason }}</p>
                </div>
                @endif
            </div>

            @if($appointment->status === Appointment::STATUS_ASSIGNED && $appointment->appointment_date?->isToday())
            <div class="px-4 md:px-5 py-3 md:py-4 border-t border-gray-100 bg-gray-50/30">
                <form method="POST" action="{{ route('employee.appointment.status', $appointment) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ Appointment::STATUS_IN_PROGRESS }}">
                    <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2.5 rounded-xl font-bold hover:bg-purple-700 active:scale-[0.98] transition-all">{{ __('Start Service') }}</button>
                </form>
            </div>
            @elseif($appointment->status === Appointment::STATUS_IN_PROGRESS)
            <div class="px-4 md:px-5 py-3 md:py-4 border-t border-gray-100 bg-gray-50/30">
                <form method="POST" action="{{ route('employee.appointment.status', $appointment) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ Appointment::STATUS_COMPLETED }}">
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2.5 rounded-xl font-bold hover:bg-green-700 active:scale-[0.98] transition-all">{{ __('Finish Service') }}</button>
                </form>
            </div>
            @endif
        </div>

        <div class="space-y-6">

            {{-- Rating card --}}
            @if($appointment->rating)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-yellow-50 to-white px-4 md:px-5 py-3 md:py-3.5 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ __('Customer Rating') }}
                    </h2>
                </div>
                <div class="p-4 md:p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-4xl font-bold text-amber-600">{{ $appointment->rating->rating }}</span>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $appointment->rating->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                    @if($appointment->rating->comment)
                    <p class="text-gray-600 bg-gray-50 rounded-lg p-3 text-sm">"{{ $appointment->rating->comment }}"</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Activity log --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-l from-amber-50 to-white px-5 py-3.5 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Activity Log') }}
                    </h2>
                </div>
                <div class="p-5">
                    <div class="space-y-0">
                        @forelse($appointment->logs as $log)
                        <div class="flex gap-3 py-3 border-b border-gray-50 last:border-0">
                            <div class="flex flex-col items-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-400 mt-1.5"></div>
                                <div class="w-px flex-1 bg-gray-100 {{ $loop->last ? 'opacity-0' : '' }}"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-sm text-gray-800">{{ $log->actionBy?->name }}</span>
                                    <span class="text-xs text-gray-400" dir="ltr">{{ $log->created_at->format('H:i') }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    @php
                                        $statusMap = [Appointment::STATUS_PENDING => __('Pending'), Appointment::STATUS_ASSIGNED => __('Assigned'), Appointment::STATUS_IN_PROGRESS => __('In Progress'), Appointment::STATUS_COMPLETED => __('Completed'), Appointment::STATUS_CANCELLED => __('Cancelled')];
                                    @endphp
                                    {{ $statusMap[$log->old_status] ?? $log->old_status }}
                                    <span class="mx-1">←</span>
                                    <span class="font-bold text-amber-700">{{ $statusMap[$log->new_status] ?? $log->new_status }}</span>
                                </div>
                                @if($log->notes)
                                <div class="text-xs text-gray-400 mt-0.5">{{ $log->notes }}</div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center gap-2 py-8 text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm">{{ __('No Activity') }}</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection