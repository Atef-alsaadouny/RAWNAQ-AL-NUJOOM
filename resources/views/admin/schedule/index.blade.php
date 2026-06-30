@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', __('Work Schedule'))

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Add Work Time') }}</h2>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.schedule.store') }}" class="max-w-lg">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Day') }}</label>
                    <select name="day_of_week" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                        <option value="0">{{ __('Sunday') }}</option>
                        <option value="1">{{ __('Monday') }}</option>
                        <option value="2">{{ __('Tuesday') }}</option>
                        <option value="3">{{ __('Wednesday') }}</option>
                        <option value="4">{{ __('Thursday') }}</option>
                        <option value="5">{{ __('Friday') }}</option>
                        <option value="6">{{ __('Saturday') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Shift') }}</label>
                    <select name="shift" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                        <option value="{{ Appointment::SHIFT_MORNING }}">{{ __('Morning') }}</option>
                        <option value="{{ Appointment::SHIFT_EVENING }}">{{ __('Evening') }}</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Start') }}</label>
                    <input type="time" name="start_time" required class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('End') }}</label>
                    <input type="time" name="end_time" required class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                </div>
            </div>
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                {{ __('Save Schedule') }}
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Day') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Shift') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('From') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('To') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Status') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @php $days = [__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday')]; @endphp
            @forelse($schedules as $day => $daySchedules)
                @foreach($daySchedules as $schedule)
<tr class="hover:bg-amber-50/30 transition-colors {{ $loop->parent->even ? 'bg-amber-50/20' : '' }}">
                    <td class="text-start px-5 py-4 text-sm font-medium text-gray-800">{{ $days[$day] ?? $day }}</td>
                    <td class="text-start px-5 py-4 text-sm text-gray-600">{{ $schedule->shift === Appointment::SHIFT_MORNING ? __('Morning') : __('Evening') }}</td>
                    <td class="text-start px-5 py-4 text-sm text-gray-600">{{ $schedule->start_time }}</td>
                    <td class="text-start px-5 py-4 text-sm text-gray-600">{{ $schedule->end_time }}</td>
                    <td class="text-start px-5 py-4 text-sm">
                        @if($schedule->is_active)
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-green-200/50">{{ __('Active') }}</span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50">{{ __('Inactive') }}</span>
                        @endif
                    </td>
                    <td class="text-start px-5 py-4 text-sm">
                        <form method="POST" action="{{ route('admin.schedule.destroy', $schedule) }}">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return window.inlineConfirm(this, event, '{{ __("Are you sure?") }}')" class="text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @empty
        <tr>
            <td colspan="6" class="text-center px-5 py-16 text-sm text-gray-400">{{ __('No Schedule') }}</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
