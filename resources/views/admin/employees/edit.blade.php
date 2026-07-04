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
                <div class="relative">
                    <input type="password" name="password" id="empPassword"
                        class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition pr-10">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 end-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
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
            <label class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-100">
                <input type="checkbox" id="selectAllServices" {{ $employee->services->count() === $services->count() ? 'checked' : '' }}
                    class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                <span class="text-sm font-medium text-gray-700">{{ __('All Services') }}</span>
            </label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($services as $service)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                        {{ $employee->services->contains($service->id) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 service-checkbox">
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

@push('scripts')
<script>
function togglePassword() {
    var input = document.getElementById('empPassword');
    var icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('viewBox', '0 0 24 24');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>';
    } else {
        input.type = 'password';
        icon.setAttribute('viewBox', '0 0 24 24');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var selectAll = document.getElementById('selectAllServices');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.service-checkbox').forEach(function(cb) {
                cb.checked = selectAll.checked;
            });
        });
        document.querySelectorAll('.service-checkbox').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var all = document.querySelectorAll('.service-checkbox');
                var checked = document.querySelectorAll('.service-checkbox:checked');
                selectAll.checked = all.length === checked.length;
            });
        });
    }
});
</script>
@endpush
@endsection
