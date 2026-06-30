@php use App\Models\Appointment; @endphp
@extends('layouts.employee')

@section('page-title', __('My Bookings'))

@section('content')
<form method="GET" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <select name="status" data-auto-submit class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none" style="padding-right: 30px;">
            <option value="">{{ __('All Statuses') }}</option>
            <option value="{{ Appointment::STATUS_PENDING }}" {{ request('status') === Appointment::STATUS_PENDING ? 'selected' : '' }}>{{ __('Pending') }}</option>
            <option value="{{ Appointment::STATUS_EXPIRED }}" {{ request('status') === Appointment::STATUS_EXPIRED ? 'selected' : '' }}>{{ __('Expired') }}</option>
            <option value="{{ Appointment::STATUS_ASSIGNED }}" {{ request('status') === Appointment::STATUS_ASSIGNED ? 'selected' : '' }}>{{ __('Assigned') }}</option>
            <option value="{{ Appointment::STATUS_IN_PROGRESS }}" {{ request('status') === Appointment::STATUS_IN_PROGRESS ? 'selected' : '' }}>{{ __('In Progress') }}</option>
            <option value="{{ Appointment::STATUS_COMPLETED }}" {{ request('status') === Appointment::STATUS_COMPLETED ? 'selected' : '' }}>{{ __('Completed') }}</option>
            <option value="{{ Appointment::STATUS_CANCELLED }}" {{ request('status') === Appointment::STATUS_CANCELLED ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
        </select>
        <select name="priority" data-auto-submit class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none" style="padding-right: 30px;">
            <option value="">{{ __('All Priorities') }}</option>
            <option value="{{ Appointment::PRIORITY_NORMAL }}" {{ request('priority') === Appointment::PRIORITY_NORMAL ? 'selected' : '' }}>{{ __('Normal') }}</option>
            <option value="{{ Appointment::PRIORITY_URGENT }}" {{ request('priority') === Appointment::PRIORITY_URGENT ? 'selected' : '' }}>{{ __('Urgent') }}</option>
            <option value="{{ Appointment::PRIORITY_VIP }}" {{ request('priority') === Appointment::PRIORITY_VIP ? 'selected' : '' }}>{{ __('Vip') }}</option>
        </select>
        <input type="date" name="date" value="{{ request('date') }}" data-auto-submit class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition outline-none">
        <div class="flex gap-2">
            <a href="{{ route('employee.appointments', array_merge(request()->only('status', 'priority'), ['date' => now()->format('Y-m-d')])) }}" class="px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request('date') === now()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ __('Today') }}</a>
            <a href="{{ route('employee.appointments', array_merge(request()->only('status', 'priority'), ['date' => now()->addDay()->format('Y-m-d')])) }}" class="px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request('date') === now()->addDay()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ __('Tomorrow') }}</a>
        </div>
        @if(request('status') || request('priority') || request('date'))
            <a href="{{ route('employee.appointments') }}" class="bg-white text-gray-500 px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm transition">{{ __('Clear Filter') }}</a>
        @endif
    </div>
</form>

<div class="space-y-3">
    @forelse($appointments as $apt)
    <a href="{{ route('employee.appointment.show', $apt) }}" class="flex items-stretch gap-2 md:gap-4 group">
        <div class="w-16 md:w-20 shrink-0 flex flex-col items-center justify-center rounded-xl md:rounded-2xl text-center leading-tight text-xs md:text-base
            @switch($apt->status)
                @case(Appointment::STATUS_COMPLETED) bg-teal-50 text-teal-700 @break
                @case(Appointment::STATUS_IN_PROGRESS) bg-purple-50 text-purple-700 @break
                @case(Appointment::STATUS_CANCELLED) bg-red-50 text-red-700 @break
                @default bg-amber-50 text-amber-700 @endswitch">
            <span class="text-sm md:text-lg font-bold">{{ $apt->appointment_date?->format('d') }}</span>
            <span class="text-[9px] md:text-[10px] font-medium opacity-75">{{ $apt->appointment_date?->format('M') }}</span>
            <span class="text-[9px] md:text-[10px] font-medium opacity-75">{{ $apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
        </div>
        <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between bg-white border border-gray-100 rounded-xl md:rounded-2xl px-3 md:px-5 py-2.5 md:py-3.5 group-hover:shadow-md group-hover:border-gray-200 transition-all gap-1.5 md:gap-0">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="font-mono text-xs text-gray-400">{{ $apt->ticket_number }}</span>
                    @if($apt->display_priority === Appointment::PRIORITY_VIP)
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-emerald-200/50">{{ __('Vip') }}</span>
                    @elseif($apt->display_priority === Appointment::PRIORITY_URGENT)
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2 py-0.5 rounded-lg text-[10px] font-bold leading-none border border-rose-200/50">{{ __('Urgent') }}</span>
                    @endif
                </div>
                <div class="font-bold text-gray-800 truncate">{{ $apt->customer_name ?? $apt->customer?->name ?? '—' }}</div>
                <div class="text-xs text-gray-500 truncate">{{ $apt->display_services ?: '—' }}</div>
            </div>
            <div class="shrink-0 md:mr-3 flex items-center gap-2 self-stretch md:self-auto">
                @if($apt->rating?->rating)
                <span class="text-yellow-500 text-sm font-bold">{{ $apt->rating->rating }}★</span>
                @endif
                @switch($apt->status)
                    @case(Appointment::STATUS_ASSIGNED) <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-blue-200/50">{{ __('Assigned') }}</span> @break
                    @case(Appointment::STATUS_IN_PROGRESS) <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-purple-200/50">{{ __('In Progress') }}</span> @break
                    @case(Appointment::STATUS_COMPLETED) <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-teal-200/50">{{ __('Completed') }}</span> @break
                    @case(Appointment::STATUS_CANCELLED) <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold leading-none border border-red-200/50">{{ __('Cancelled') }}</span> @break
                @endswitch
            </div>
        </div>
    </a>
    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <p class="text-gray-500 text-lg">{{ __('No Bookings') }}</p>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $appointments->links() }}</div>
@endsection

@push('scripts')
<script>
document.addEventListener('change', function(e) {
    if (e.target.matches('[data-auto-submit]')) {
        e.target.form.submit();
    }
});
</script>
@endpush