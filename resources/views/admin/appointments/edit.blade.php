@php use App\Models\Appointment; @endphp
@extends('layouts.admin')

@section('page-title', __('Edit Booking'))

@section('content')
@php
    $selectedPackageIds = $appointment->packages->pluck('id')->toArray();
    $allPackageServiceIds = [];
    foreach ($appointment->packages as $pkg) {
        $allPackageServiceIds = array_merge($allPackageServiceIds, $pkg->services->pluck('id')->toArray());
    }
@endphp

<form method="POST" action="{{ route('admin.appointments.update', $appointment) }}" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @csrf
    @method('PUT')

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Edit Booking') }}</h2>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Customer Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" required value="{{ old('customer_name', $appointment->customer_name ?? $appointment->customer?->name) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Customer Phone') }} <span class="text-red-500">*</span></label>
                <input type="text" name="customer_phone" required value="{{ old('customer_phone', $appointment->customer_phone) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition @error('customer_phone') border-red-300 bg-red-50 @enderror">
                @error('customer_phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Packages --}}
        @if($packages->isNotEmpty())
        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Package') }}</label>
            <p class="text-xs text-gray-400 mb-2">{{ __('Select Multiple Packages') }}</p>
            <input type="hidden" name="package_ids" value="">
            <div class="space-y-2" id="adminPackageContainer">
                @foreach($packages as $pkg)
                <label class="flex items-center border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-amber-400 transition admin-package-label {{ in_array($pkg->id, $selectedPackageIds) ? 'border-amber-400 bg-amber-50/50' : '' }}">
                    <input type="checkbox" name="package_ids[]" value="{{ $pkg->id }}" class="ml-3 admin-package-checkbox"
                        {{ in_array($pkg->id, $selectedPackageIds) ? 'checked' : '' }}
                        data-services="{{ $pkg->services->pluck('id')->join(',') }}"
                        onchange="adminUpdatePackages()">
                    <span class="text-sm">{{ $pkg->name }} <span class="text-gray-400">({{ formatCurrency($pkg->price) }})</span></span>
                </label>
                @endforeach
            </div>
        </div>
        @endif

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5" id="adminServicesLabel">{{ __('Services') }}</label>

            <div id="adminPackageServicesInfo" class="mb-3 {{ !empty($selectedPackageIds) ? '' : 'hidden' }} bg-rose-50/70 border border-rose-200/70 rounded-xl p-3.5">
                <p class="text-sm text-rose-700 font-medium mb-1.5" id="adminPackageServicesText">
                    @if(!empty($selectedPackageIds))
                        {{ __('Package Services') }}: {{ $appointment->packages->pluck('name')->implode(' + ') }}
                    @endif
                </p>
                <div class="flex flex-wrap gap-1.5" id="adminPackageServicesTags">
                    @foreach($appointment->packages as $pkg)
                        @foreach($pkg->services as $ps)
                        <span class="bg-rose-100 text-rose-700 text-xs px-2.5 py-1 rounded-lg">✅ {{ $ps->name }}</span>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="space-y-1.5 max-h-52 overflow-y-auto border border-gray-200 rounded-xl p-2">
                @foreach($services as $svc)
                @php
                    $isPackageService = in_array($svc->id, $allPackageServiceIds);
                    $hasService = $appointment->services->contains($svc->id);
                @endphp
                <label class="flex items-center px-3 py-2.5 hover:bg-gray-50 rounded-lg cursor-pointer transition {{ $isPackageService ? 'bg-rose-50/50' : '' }} service-label"
                    data-service-id="{{ $svc->id }}">
                    <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" class="ml-3 service-checkbox"
                        {{ $isPackageService ? 'checked disabled' : '' }}
                        {{ !$isPackageService && $hasService ? 'checked' : '' }}>
                    <span class="text-sm">{{ $svc->name }}</span>
                    @if($isPackageService)
                    <span class="text-xs text-rose-500 mr-2">{{ __('From Package') }}</span>
                    @endif
                </label>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Employee') }}</label>
                <select name="employee_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="">{{ __('Unassigned') }}</option>
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ $appointment->employee_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Time Optional') }}</label>
                <input type="time" name="assigned_time" value="{{ old('assigned_time', $appointment->assigned_time) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Date') }} <span class="text-red-500">*</span></label>
                <input type="date" name="appointment_date" required value="{{ old('appointment_date', $appointment->appointment_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Shift') }} <span class="text-red-500">*</span></label>
                <select name="shift" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="{{ Appointment::SHIFT_MORNING }}" {{ $appointment->shift === Appointment::SHIFT_MORNING ? 'selected' : '' }}>{{ __('Morning') }}</option>
                    <option value="{{ Appointment::SHIFT_EVENING }}" {{ $appointment->shift === Appointment::SHIFT_EVENING ? 'selected' : '' }}>{{ __('Evening') }}</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Priority') }}</label>
                <select name="priority" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="{{ Appointment::PRIORITY_NORMAL }}" {{ $appointment->priority === Appointment::PRIORITY_NORMAL ? 'selected' : '' }}>{{ __('Normal') }}</option>
                    <option value="{{ Appointment::PRIORITY_URGENT }}" {{ $appointment->priority === Appointment::PRIORITY_URGENT ? 'selected' : '' }}>{{ __('Urgent') }}</option>
                    <option value="{{ Appointment::PRIORITY_VIP }}" {{ $appointment->priority === Appointment::PRIORITY_VIP ? 'selected' : '' }}>{{ __('Vip') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Status') }}</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
                    <option value="{{ Appointment::STATUS_PENDING }}" {{ $appointment->status === Appointment::STATUS_PENDING ? 'selected' : '' }}>{{ __('Pending') }}</option>
                    <option value="{{ Appointment::STATUS_ASSIGNED }}" {{ $appointment->status === Appointment::STATUS_ASSIGNED ? 'selected' : '' }}>{{ __('Assigned') }}</option>
                    <option value="{{ Appointment::STATUS_IN_PROGRESS }}" {{ $appointment->status === Appointment::STATUS_IN_PROGRESS ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                    <option value="{{ Appointment::STATUS_COMPLETED }}" {{ $appointment->status === Appointment::STATUS_COMPLETED ? 'selected' : '' }}>{{ __('Completed') }}</option>
                    <option value="{{ Appointment::STATUS_CANCELLED }}" {{ $appointment->status === Appointment::STATUS_CANCELLED ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-gray-600 text-sm font-medium mb-1.5">{{ __('Customer Notes') }}</label>
            @if($appointment->notes)
            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 mb-3">{{ $appointment->notes }}</div>
            @else
            <p class="text-gray-400 text-sm mb-3">{{ __('No Notes') }}</p>
            @endif
            <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition resize-none" placeholder="{{ __('Admin Notes Optional') }}">{{ old('notes') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                {{ __('Update Booking') }}
            </button>
            <a href="{{ route('admin.appointments.show', $appointment) }}" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors">
                {{ __('Cancel') }}
            </a>
        </div>
    </div>
</form>

@if($packages->isNotEmpty())
<script>
let adminPreviousPackageServiceIds = [];

function adminUpdatePackages() {
    let allServiceIds = [];
    let allNames = [];
    let allTags = [];

    document.querySelectorAll('.admin-package-checkbox:checked').forEach(cb => {
        const ids = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allServiceIds = allServiceIds.concat(ids);
        const label = cb.closest('.admin-package-label');
        if (label) {
            const name = label.querySelector('span')?.textContent || '';
            allNames.push(name);
        }
    });

    document.querySelectorAll('#adminPackageContainer .admin-package-label').forEach(label => {
        const cb = label.querySelector('.admin-package-checkbox');
        label.classList.toggle('border-amber-400', cb.checked);
        label.classList.toggle('bg-amber-50/50', cb.checked);
    });

    document.querySelectorAll('.service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackageService = allServiceIds.includes(sid);
        const wasPackageService = adminPreviousPackageServiceIds.includes(sid);

        if (isPackageService) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-label').style.backgroundColor = '#fdf2f4';
        } else {
            if (wasPackageService && !isPackageService) {
                cb.checked = false;
            }
            cb.disabled = false;
            cb.closest('.service-label').style.backgroundColor = '';
        }
    });

    adminPreviousPackageServiceIds = allServiceIds;

    const infoBox = document.getElementById('adminPackageServicesInfo');
    const infoText = document.getElementById('adminPackageServicesText');
    const tagsContainer = document.getElementById('adminPackageServicesTags');

    if (document.querySelectorAll('.admin-package-checkbox:checked').length > 0) {
        infoText.textContent = '{{ __('Package Services') }}: ' + allNames.join(' + ');
        infoBox.classList.remove('hidden');
    } else {
        infoBox.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    adminPreviousPackageServiceIds = [];
    document.querySelectorAll('.admin-package-checkbox:checked').forEach(cb => {
        const ids = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        adminPreviousPackageServiceIds = adminPreviousPackageServiceIds.concat(ids);
    });
});
</script>
@endif
@endsection