@extends('layouts.admin')

@section('page-title', __('Customers'))

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Name') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Email') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Phone') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Total Bookings') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @forelse($customers as $customer)
            <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="font-medium text-gray-800">{{ $customer->name }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="text-gray-600">{{ $customer->email ?? '—' }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="text-gray-600">{{ $customer->phone ?? '—' }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <span class="inline-flex items-center gap-1 bg-gray-50 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium leading-none border border-gray-200/50">{{ $customer->appointments_count }}</span>
                </td>
                <td class="text-start px-4 py-3.5 text-sm">
                    <div class="flex items-center gap-2 justify-start">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ __('View') }}
                        </a>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            {{ __('Edit') }}
                        </a>
                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return window.inlineConfirm(this, event, @json(__('confirm_delete_customer', ['name' => $customer->name])))" class="inline-flex items-center gap-1 text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center px-5 py-16 text-sm text-gray-400">{{ __('No Customers') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($customers->hasPages())
    <div class="mt-4">
        {{ $customers->links() }}
    </div>
@endif
@endsection
