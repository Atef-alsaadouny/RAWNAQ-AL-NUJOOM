@php use App\Models\Appointment; @endphp
<div id="recentSection" class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-hidden">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100 flex items-center gap-2">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Latest Appointments') }}</h2>
        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $recentAppointments->count() }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Ticket') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Customer') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Employee') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Service') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Date') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Status') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Rating') }}</th>
                    <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-amber-50">
                @forelse($recentAppointments as $apt)
                <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="font-mono font-medium text-gray-500">{{ $apt->ticket_number }}</span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="font-medium text-gray-800">{{ $apt->customer_name ?? $apt->customer?->name ?? '—' }}</span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="text-gray-600">{{ $apt->employee?->name ?? __('Unassigned') }}</span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span class="text-gray-600">{{ $apt->display_services ?: '—' }}</span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <span dir="ltr" class="whitespace-nowrap">{{ $apt->appointment_date?->format('Y-m-d') }}</span>
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        @switch($apt->status)
                            @case(Appointment::STATUS_PENDING)
                                @if($apt->appointment_date?->isPast())
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none whitespace-nowrap">{{ __('Missed') }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-yellow-200/50 whitespace-nowrap">{{ __('Pending') }}</span>
                                @endif
                                @break
                            @case(Appointment::STATUS_ASSIGNED)
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-blue-200/50 whitespace-nowrap">{{ __('Assigned') }}</span>
                                @break
                            @case(Appointment::STATUS_IN_PROGRESS)
                                <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-purple-200/50 whitespace-nowrap">{{ __('In Progress') }}</span>
                                @break
                            @case(Appointment::STATUS_COMPLETED)
                                <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-teal-200/50 whitespace-nowrap">{{ __('Completed') }}</span>
                                @break
                            @case(Appointment::STATUS_CANCELLED)
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50 whitespace-nowrap">{{ __('Cancelled') }}</span>
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
                        <a href="{{ route('admin.appointments.show', $apt) }}" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ __('View') }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center px-5 py-16 text-sm text-gray-400">{{ __('No Appointments') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
