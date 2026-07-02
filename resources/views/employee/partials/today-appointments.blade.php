@php use App\Models\Appointment; @endphp
@forelse($todayAppointments as $apt)
<div class="flex items-stretch gap-2 md:gap-4 mb-3 last:mb-0 group">
    <div class="w-16 md:w-20 shrink-0 flex flex-col items-center justify-center rounded-xl text-center leading-tight text-xs md:text-base
        {{ $apt->status === Appointment::STATUS_COMPLETED ? 'bg-teal-50 text-teal-700' : ($apt->status === Appointment::STATUS_IN_PROGRESS ? 'bg-purple-50 text-purple-700' : 'bg-amber-50 text-amber-700') }}">
        <span class="text-sm md:text-lg font-bold">{{ $apt->assigned_time ? substr($apt->assigned_time, 0, 5) : '--:--' }}</span>
        <span class="text-[9px] md:text-[10px] font-medium opacity-75">{{ $apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
    </div>
    <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between bg-white border border-gray-100 rounded-xl px-3 md:px-4 py-2.5 md:py-3 group-hover:shadow-md group-hover:border-gray-200 transition-all gap-2">
        <a href="{{ route('employee.appointment.show', $apt) }}" class="min-w-0 hover:opacity-80 transition-opacity">
            <div class="flex items-center gap-2 mb-0.5">
                <span class="font-mono text-xs text-gray-400">{{ $apt->ticket_number }}</span>
                @if($apt->display_priority === Appointment::PRIORITY_VIP)
                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-emerald-200/50">{{ __('Vip') }}</span>
                @elseif($apt->display_priority === Appointment::PRIORITY_URGENT)
                    <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-rose-200/50">{{ __('Urgent') }}</span>
                @endif
            </div>
            <div class="font-bold text-gray-800 truncate">{{ $apt->customer_name ?? $apt->customer?->name }}</div>
            <div class="text-xs text-gray-500 truncate">{{ $apt->display_services ?: '—' }}</div>
        </a>
        <div class="shrink-0 md:mr-3 self-stretch md:self-auto flex flex-col md:flex-row items-stretch md:items-center gap-1 md:gap-2">
            <a href="{{ route('employee.appointment.show', $apt) }}" class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 hover:bg-blue-100 px-2.5 md:px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">{{ __('Show') }}</a>
            @if($apt->status === Appointment::STATUS_ASSIGNED)
                <form method="POST" action="{{ route('employee.appointment.status', $apt) }}" class="w-full md:w-auto flex-shrink-0">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ Appointment::STATUS_IN_PROGRESS }}">
                    <button type="submit" class="w-full md:w-auto bg-purple-600 text-white px-3 md:px-4 py-1.5 md:py-1.5 rounded-lg text-xs md:text-sm font-medium hover:bg-purple-700 active:scale-95 transition-all">{{ __('Start') }}</button>
                </form>
            @elseif($apt->status === Appointment::STATUS_IN_PROGRESS)
            <form method="POST" action="{{ route('employee.appointment.status', $apt) }}" class="w-full md:w-auto">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ Appointment::STATUS_COMPLETED }}">
                <button type="submit" class="w-full md:w-auto bg-green-600 text-white px-3 md:px-4 py-1.5 md:py-1.5 rounded-lg text-xs md:text-sm font-medium hover:bg-green-700 active:scale-95 transition-all">{{ __('Finish') }}</button>
            </form>
            @elseif($apt->status === Appointment::STATUS_COMPLETED)
            <span class="inline-flex items-center gap-1 text-teal-700 bg-teal-50 px-2 md:px-3 py-1 md:py-1.5 rounded-lg text-xs font-bold border border-teal-200/50 w-full md:w-auto justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                {{ __('Completed') }}
            </span>
            @endif
        </div>
    </div>
</div>
@if($apt->rating)
<div class="text-sm mr-[72px] md:mr-24 mb-2 -mt-2">
    <span class="text-yellow-500">★ {{ $apt->rating->rating }}/5</span>
    @if($apt->rating->comment)
    <span class="text-gray-400">— "{{ $apt->rating->comment }}"</span>
    @endif
</div>
@endif
@empty
<div class="flex flex-col items-center gap-2 py-10 text-gray-400">
    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    <p class="text-sm">{{ __('No Bookings Today') }}</p>
</div>
@endforelse
