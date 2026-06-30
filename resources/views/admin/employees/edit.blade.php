@extends('layouts.admin')

@section('page-title', __('Edit Employee'))

@section('content')
{{-- Edit employee form: name, email, phone, password (leave blank to keep), status, services --}}
<form method="POST" action="{{ route('admin.employees.update', $employee) }}" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @csrf
    @method('PUT')

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Edit Employee Data') }}</h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" required value="{{ old('name', $employee->name) }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('New Password') }}</label>
                <input type="password" name="password"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <p class="text-xs text-gray-400 mt-1">{{ __('Leave Empty To Keep') }}</p>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" {{ $employee->is_active ? 'checked' : '' }}
                class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
            <label for="is_active" class="text-sm font-medium text-gray-700">{{ __('Active') }}</label>
        </div>

        <div class="mt-6">
            <label class="block text-gray-600 text-sm font-medium mb-2">{{ __('Services') }}</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($services as $service)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                        {{ $employee->services->contains($service->id) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span class="text-sm text-gray-700">{{ $service->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-1 bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ __('Update Employee') }}
            </button>
            <a href="{{ route('admin.employees.index') }}" class="text-gray-500 px-4 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium transition-colors">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>
@endsection
