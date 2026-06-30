@extends('layouts.admin')

@section('page-title', __('Add Employee'))

@section('content')
{{-- Add employee form: name (required), email, phone, password (required), services --}}
<form method="POST" action="{{ route('admin.employees.store') }}" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @csrf

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Add New Employee') }}</h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" required value="{{ old('name') }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Password') }} <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-gray-600 text-sm font-medium mb-2">{{ __('Services') }}</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($services as $service)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                        class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">{{ $service->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-1 bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                {{ __('Create Employee') }}
            </button>
            <a href="{{ route('admin.employees.index') }}" class="text-gray-500 px-4 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium transition-colors">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>
@endsection
