@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', __('Appointments'))

@section('content')
<div class="mb-4 flex gap-4">
    <a href="{{ route('admin.appointments.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">
        + {{ __('New Booking') }}
    </a>
</div>

<!-- Filters -->
<form method="GET" class="bg-white p-4 rounded-xl shadow-sm mb-4">
    <div class="flex flex-wrap items-center gap-3">
        <select name="status" data-auto-submit class="border rounded-lg px-3 py-2 text-sm" style="padding-right: 30px;">
            <option value="">{{ __('All Statuses') }}</option>
            <option value="{{ Appointment::STATUS_PENDING }}" {{ request('status') === Appointment::STATUS_PENDING ? 'selected' : '' }}>{{ __('Pending') }}</option>
            <option value="{{ Appointment::STATUS_EXPIRED }}" {{ request('status') === Appointment::STATUS_EXPIRED ? 'selected' : '' }}>{{ __('Expired') }}</option>
            <option value="{{ Appointment::STATUS_ASSIGNED }}" {{ request('status') === Appointment::STATUS_ASSIGNED ? 'selected' : '' }}>{{ __('Assigned') }}</option>
            <option value="{{ Appointment::STATUS_IN_PROGRESS }}" {{ request('status') === Appointment::STATUS_IN_PROGRESS ? 'selected' : '' }}>{{ __('In Progress') }}</option>
            <option value="{{ Appointment::STATUS_COMPLETED }}" {{ request('status') === Appointment::STATUS_COMPLETED ? 'selected' : '' }}>{{ __('Completed') }}</option>
            <option value="{{ Appointment::STATUS_CANCELLED }}" {{ request('status') === Appointment::STATUS_CANCELLED ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
        </select>
        <select name="priority" data-auto-submit class="border rounded-lg px-3 py-2 text-sm" style="padding-right: 30px;">
            <option value="">{{ __('All Priorities') }}</option>
            <option value="{{ Appointment::PRIORITY_NORMAL }}" {{ request('priority') === Appointment::PRIORITY_NORMAL ? 'selected' : '' }}>{{ __('Normal') }}</option>
            <option value="{{ Appointment::PRIORITY_URGENT }}" {{ request('priority') === Appointment::PRIORITY_URGENT ? 'selected' : '' }}>{{ __('Urgent') }}</option>
            <option value="{{ Appointment::PRIORITY_VIP }}" {{ request('priority') === Appointment::PRIORITY_VIP ? 'selected' : '' }}>{{ __('Vip') }}</option>
        </select>
        <select name="employee_id" data-auto-submit class="border rounded-lg px-3 py-2 text-sm" style="padding-right: 30px;">
            <option value="">{{ __('All Employees') }}</option>
            @foreach($employees as $emp)
            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}" data-auto-submit class="border rounded-lg px-3 py-2 text-sm">
        <div class="flex gap-1">
            <a href="{{ route('admin.appointments.index', array_merge(request()->only('status', 'priority', 'employee_id'), ['date' => now()->format('Y-m-d')])) }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request('date') === now()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ __('Today') }}</a>
            <a href="{{ route('admin.appointments.index', array_merge(request()->only('status', 'priority', 'employee_id'), ['date' => now()->addDay()->format('Y-m-d')])) }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request('date') === now()->addDay()->format('Y-m-d') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ __('Tomorrow') }}</a>
        </div>
        @if(request('status') || request('priority') || request('employee_id') || request('date'))
            <a href="{{ route('admin.appointments.index') }}" class="bg-white text-gray-500 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">{{ __('Clear Filter') }}</a>
        @endif
    </div>
</form>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Ticket') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Customer') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Employee') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Price') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Payment') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Date') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Shift') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Priority') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Status') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Rating') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @forelse($appointments as $apt)
            <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-mono font-medium text-gray-500">{{ $apt->ticket_number }}</span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-medium text-gray-800">{{ $apt->customer_name ?? $apt->customer?->name ?? '—' }}</span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="text-gray-600">{{ $apt->employee?->name ?? '—' }}</span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-bold text-amber-700">{{ formatCurrency($apt->total_price) }}</span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    @php $_p = $apt->payment; @endphp
                    @if($_p && $_p->isPaid())
                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-lg text-xs font-bold leading-none border border-emerald-200/50">{{ __('Paid') }}</span>
                    @elseif($_p)
                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2 py-0.5 rounded-lg text-xs font-bold leading-none border border-amber-200/50">{{ $_p->method === \App\Models\Payment::METHOD_CASH ? __('Cash') : __('Unpaid') }}</span>
                    @else
                    <span class="text-xs text-gray-400">—</span>
                    @endif
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span dir="ltr">{{ $apt->appointment_date?->format('Y-m-d') }}</span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <span>{{ $apt->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</span>
                </td>
                <td class="text-start px-5 py-4 text-sm">
@if($apt->display_priority === Appointment::PRIORITY_VIP)
                    <span class="bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded-lg text-xs font-bold">{{ __('Vip') }}</span>
                    @elseif($apt->display_priority === Appointment::PRIORITY_URGENT)
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50">{{ __('Urgent') }}</span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-slate-200/50">{{ __('Normal') }}</span>
                    @endif
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    @switch($apt->status)
                        @case(Appointment::STATUS_PENDING)
                            @if($apt->appointment_date?->isPast())
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none">{{ __('Missed') }}</span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-yellow-200/50">{{ __('Pending') }}</span>
                            @endif
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
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    @if($apt->status === Appointment::STATUS_COMPLETED && $apt->rating)
                    <span class="text-yellow-500 font-bold whitespace-nowrap">{{ $apt->rating->rating }}★</span>
                    @else
                    <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <div class="flex items-center gap-2 justify-start">
                        <a href="{{ route('admin.appointments.show', $apt) }}" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ __('View') }}
                        </a>
                        @if($apt->status === Appointment::STATUS_PENDING)
                        <a href="{{ route('admin.appointments.assign', $apt) }}" class="inline-flex items-center gap-1 text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            {{ __('Assign') }}
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center px-5 py-16 text-sm text-gray-400">{{ __('No Appointments') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $appointments->links() }}
</div>
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
