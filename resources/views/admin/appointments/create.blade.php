@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', __('New Booking'))

@section('content')
<form method="POST" action="{{ route('admin.appointments.store') }}" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" id="adminBookingForm">
    @csrf

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('New Booking') }}</h2>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Customer Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" required value="{{ old('customer_name') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Customer Phone') }} <span class="text-red-500">*</span></label>
                <input type="text" name="customer_phone" required value="{{ old('customer_phone') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition @error('customer_phone') border-red-300 bg-red-50 @enderror">
                @error('customer_phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @if($packages->isNotEmpty())
        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Package') }}</label>
            <p class="text-xs text-gray-400 mb-2">{{ __('Select Multiple Packages') }}</p>
            <div class="space-y-2" id="adminPackageContainer">
                @foreach($packages as $pkg)
                <label class="flex items-center border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition admin-package-label {{ in_array($pkg->id, old('package_ids', [])) ? 'border-amber-400 bg-amber-50/50' : '' }}">
                    <input type="checkbox" name="package_ids[]" value="{{ $pkg->id }}" class="ml-3 admin-package-checkbox"
                        {{ in_array($pkg->id, old('package_ids', [])) ? 'checked' : '' }}
                        data-services="{{ $pkg->services->pluck('id')->join(',') }}"
                        onchange="adminUpdatePackages()">
                    <span class="text-sm">{{ $pkg->name }} <span class="text-gray-400">({{ formatCurrency($pkg->price) }})</span></span>
                </label>
                @endforeach
            </div>
        </div>
        @endif

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Services') }}</label>
            <div class="space-y-1.5" id="adminServicesContainer">
                @foreach($services as $svc)
                <label class="flex items-center border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition service-label"
                    data-service-id="{{ $svc->id }}">
                    <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" class="ml-3 service-checkbox" {{ in_array($svc->id, old('service_ids', [])) ? 'checked' : '' }}>
                    <span class="text-sm">{{ $svc->name }} <span class="text-gray-400">({{ formatCurrency($svc->price) }})</span></span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Booking Date') }} <span class="text-red-500">*</span></label>
                <input type="date" name="appointment_date" required value="{{ old('appointment_date') }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Shift') }} <span class="text-red-500">*</span></label>
                <select name="shift" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="{{ Appointment::SHIFT_MORNING }}" {{ old('shift') === Appointment::SHIFT_MORNING ? 'selected' : '' }}>{{ __('Morning') }}</option>
                    <option value="{{ Appointment::SHIFT_EVENING }}" {{ old('shift') === Appointment::SHIFT_EVENING ? 'selected' : '' }}>{{ __('Evening') }}</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Priority') }} <span class="text-red-500">*</span></label>
            <select name="priority" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <option value="{{ Appointment::PRIORITY_NORMAL }}" {{ old('priority') === Appointment::PRIORITY_NORMAL ? 'selected' : '' }}>{{ __('Normal') }}</option>
                <option value="{{ Appointment::PRIORITY_URGENT }}" {{ old('priority') === Appointment::PRIORITY_URGENT ? 'selected' : '' }}>{{ __('Urgent') }}</option>
                <option value="{{ Appointment::PRIORITY_VIP }}" {{ old('priority') === Appointment::PRIORITY_VIP ? 'selected' : '' }}>{{ __('Vip') }}</option>
            </select>
        </div>

        @if(isset($employees) && $employees->isNotEmpty())
        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Employee Optional') }}</label>
            <select name="employee_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                <option value="">{{ __('No Assignment') }}</option>
                @foreach($employees as $emp)
                <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Notes') }}</label>
            <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition resize-none">{{ old('notes') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                {{ __('Create Booking') }}
            </button>
            <a href="{{ route('admin.appointments.index') }}" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors">
                {{ __('Cancel') }}
            </a>
        </div>
    </div>
</form>

@if($packages->isNotEmpty())
<script>
function adminUpdatePackages() {
    let allServiceIds = [];
    document.querySelectorAll('.admin-package-checkbox:checked').forEach(cb => {
        const ids = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allServiceIds = allServiceIds.concat(ids);
    });

    document.querySelectorAll('#adminServicesContainer .service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackage = allServiceIds.includes(sid);
        if (isPackage) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-label').style.backgroundColor = '#fdf2f4';
        } else {
            cb.disabled = false;
            cb.closest('.service-label').style.backgroundColor = '';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.admin-package-checkbox:checked')) {
        adminUpdatePackages();
    }
});
</script>
@endif
@endsection