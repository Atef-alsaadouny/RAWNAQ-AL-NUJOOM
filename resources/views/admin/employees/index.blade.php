@extends('layouts.admin')

@section('page-title', __('Employees'))

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center gap-1 bg-amber-600 text-white px-4 py-2 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        {{ __('Add Employee') }}
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Id') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Name') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Email') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Phone') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Appointments') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Status') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @forelse($employees as $emp)
            <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                <td class="text-start px-5 py-4 text-sm">
                    <span class="font-mono font-medium text-gray-500">{{ $emp->employee_id }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="font-medium text-gray-800">{{ $emp->name }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="text-gray-600">{{ $emp->email ?? '—' }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="text-gray-600">{{ $emp->phone ?? '—' }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="inline-flex items-center gap-1 bg-gray-50 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-gray-200/50">{{ $emp->assigned_appointments_count }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    @if($emp->is_active)
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-green-200/50">{{ __('Active') }}</span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-red-200/50">{{ __('Inactive') }}</span>
                    @endif
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <div class="flex items-center gap-2 justify-start">
                        <a href="{{ route('admin.employees.show', $emp) }}" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ __('View') }}
                        </a>
                        <a href="{{ route('admin.employees.edit', $emp) }}" class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            {{ __('Edit') }}
                        </a>
                        <a href="{{ route('admin.employees.performance', $emp) }}" class="inline-flex items-center gap-1 text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                {{ __('Performance') }}
                            </a>
                        <form method="POST" action="{{ route('admin.employees.destroy', $emp) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return window.inlineConfirm(this, event, @json(__('confirm_delete_employee', ['name' => $emp->name])))" class="inline-flex items-center gap-1 text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                {{ __('Delete') }}
                            </button>
                        </form>
                        </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center px-5 py-16 text-sm text-gray-400">{{ __('No Employees') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
