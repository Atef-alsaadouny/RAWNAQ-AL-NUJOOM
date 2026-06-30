@extends('layouts.admin')

@section('page-title', __('Packages'))

@section('content')
<div class="mb-5 flex items-center justify-end">
    <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-l from-amber-500 to-amber-600 text-white px-5 py-2.5 rounded-xl hover:from-amber-600 hover:to-amber-700 text-sm font-bold shadow-lg shadow-amber-200/40 hover:shadow-xl transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        {{ __('Add Package') }}
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-amber-100 overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-amber-100 bg-gradient-to-l from-amber-50 to-white">
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">#</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Name') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Services') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Price') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Original Price') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Status') }}</th>
                <th class="text-start px-5 py-4 text-xs font-bold text-gray-700">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-amber-50">
            @forelse($packages as $pkg)
            <tr class="hover:bg-amber-50/30 transition-colors {{ $loop->even ? 'bg-amber-50/20' : '' }}">
                <td class="text-start px-5 py-4 text-sm font-medium text-gray-500">{{ $pkg->sort_order }}</td>
                <td class="text-start px-5 py-4 text-sm font-bold text-gray-800">{{ $pkg->name }}</td>
                <td class="text-start px-5 py-4 text-sm text-gray-500">{{ $pkg->services->pluck('name')->implode(', ') }}</td>
                <td class="text-start px-5 py-4 text-sm font-bold text-amber-600">{{ formatCurrency($pkg->price) }}</td>
                <td class="text-start px-5 py-4 text-sm text-gray-400">{{ $pkg->original_price ? formatCurrency($pkg->original_price) : '—' }}</td>
                <td class="text-start px-5 py-4 text-sm">
                    @if($pkg->is_active)
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-emerald-200/50">{{ __('Active') }}</span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-bold leading-none border border-rose-200/50">{{ __('Inactive') }}</span>
                    @endif
                </td>
                <td class="text-start px-5 py-4 text-sm">
                    <div class="flex items-center justify-center gap-1.5">
                        <a href="{{ route('admin.packages.edit', $pkg) }}" class="inline-flex items-center gap-1.5 text-amber-700 bg-amber-50 hover:bg-amber-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            {{ __('Edit') }}
                        </a>
                        <form method="POST" action="{{ route('admin.packages.destroy', $pkg) }}">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return window.inlineConfirm(this, event, '{{ __("Are you sure?") }}')" class="inline-flex items-center gap-1.5 text-red-600 bg-red-50 hover:bg-red-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-start px-5 py-16 text-sm text-gray-400">{{ __('No Packages') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
