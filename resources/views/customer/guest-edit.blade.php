@php use App\Models\Appointment; @endphp
@extends('layouts.public')

@section('title', __('Edit Booking'))

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-gray-800">{{ __('Edit Booking') }}</h1>
        <div class="mt-2 text-5xl font-black tracking-widest text-transparent bg-clip-text bg-gradient-to-l from-amber-500 to-rose-600">{{ $appointment->ticket_number }}</div>
    </div>

    <div class="bg-white/90 backdrop-blur-sm rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 p-5 md:p-10">
        <form method="POST" action="{{ route('booking.guest.update', $appointment) }}" id="editForm">
            @csrf
            @method('PUT')

            <div class="mb-8 bg-gradient-to-l from-rose-50 to-amber-50/50 border border-rose-100/50 rounded-2xl px-5 py-4 text-sm text-gray-600 flex items-center justify-between">
                <span class="font-bold">{{ $appointment->customer_name }}</span>
                <span dir="ltr">{{ $phone }}</span>
            </div>
            <input type="hidden" name="phone" value="{{ $phone }}">
            @if(request('token'))<input type="hidden" name="token" value="{{ request('token') }}">@endif

            @php
                $selectedPackageIds = $appointment->packages->pluck('id')->toArray();
                $allPackageServiceIds = [];
                foreach ($appointment->packages as $pkg) {
                    $allPackageServiceIds = array_merge($allPackageServiceIds, $pkg->services->pluck('id')->toArray());
                }
            @endphp

            <input type="hidden" name="package_ids" value="">
            <input type="hidden" name="service_ids" value="">

            @if($packages->isNotEmpty())
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <label class="block text-gray-700 font-bold text-sm">{{ __('Packages & Offers') }}</label>
                </div>
                <p class="text-sm text-gray-400 mb-4 mr-7">{{ __('You can change selected packages — new package services will replace the old ones') }}</p>
                <div class="space-y-3">
                    @foreach($packages as $package)
                    <label class="package-card border-2 rounded-2xl p-5 cursor-pointer transition-all duration-200 flex items-center gap-4 {{ in_array($package->id, $selectedPackageIds) ? 'border-rose-300 bg-rose-50/40 shadow-sm' : 'border-gray-100 bg-white hover:border-rose-200 hover:shadow-sm' }}">
                        <input type="checkbox" name="package_ids[]" value="{{ $package->id }}" class="package-checkbox w-5 h-5 text-rose-500 rounded"
                            {{ in_array($package->id, $selectedPackageIds) ? 'checked' : '' }}
                            data-services="{{ $package->services->pluck('id')->join(',') }}"
                            onchange="updatePackages()">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-800">{{ $package->name }}</span>
                                @if($package->original_price && $package->original_price > $package->price)
                                <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-0.5 rounded-full font-bold">
                                    {{ __('Save') }} {{ formatCurrency($package->original_price - $package->price) }}
                                </span>
                                @endif
                            </div>
                            <div class="text-gray-400 text-sm mt-0.5 truncate">{{ $package->services->pluck('name')->implode(' + ') }}</div>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-xl font-extrabold text-rose-600">{{ formatCurrency($package->price) }}</span>
                                @if($package->original_price && $package->original_price > $package->price)
                                <span class="text-gray-300 text-sm line-through">{{ formatCurrency($package->original_price) }}</span>
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <label class="block text-gray-700 font-bold text-sm" id="servicesLabel">
                        {{ !empty($selectedPackageIds) ? __('Extra services for package') : __('Services') }}
                    </label>
                </div>

                <div id="packageServicesInfo" class="{{ !empty($selectedPackageIds) ? '' : 'hidden' }} bg-rose-50/70 border border-rose-200/60 rounded-2xl p-5 mb-4 mt-3">
                    <p class="text-sm text-rose-700 font-medium mb-2.5" id="packageServicesText">
                        {{ __('Package Services') }}: {{ $appointment->packages->pluck('name')->implode(' + ') }}
                    </p>
                    <div class="flex flex-wrap gap-2" id="packageServicesTags">
                        @foreach($appointment->packages as $pkg)
                            @foreach($pkg->services as $ps)
                            <span class="bg-rose-100 text-rose-700 text-sm px-3 py-1.5 rounded-lg">✅ {{ $ps->name }}</span>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2 mt-3" id="servicesContainer">
                    @foreach($services as $service)
                    @php
                        $isPackage = in_array($service->id, $allPackageServiceIds);
                        $hasService = $appointment->services->contains($service->id);
                    @endphp
                    <label class="service-item border-2 rounded-2xl p-4 cursor-pointer transition-all duration-200 flex justify-between items-center gap-4 {{ $isPackage ? 'border-rose-200 bg-rose-50/30' : 'border-gray-100 bg-white hover:border-rose-200 hover:shadow-sm' }}"
                        data-service-id="{{ $service->id }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" class="service-checkbox w-5 h-5 text-rose-500 rounded shrink-0"
                                {{ $isPackage ? 'checked disabled' : '' }}
                                {{ !$isPackage && $hasService ? 'checked' : '' }}>
                            <div>
                                <span class="font-bold {{ $isPackage ? 'text-rose-600' : 'text-gray-800' }}">{{ $service->name }}</span>
                                @if($isPackage)
                                <span class="package-badge text-xs text-rose-500 mr-1">{{ __('(From package)') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-left shrink-0">
                            <span class="text-rose-600 font-bold">{{ formatCurrency($service->price) }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Date') }} <span class="text-red-500">*</span></label>
                    <input type="date" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}" required min="{{ now()->format('Y-m-d') }}"
                        class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Shift') }} <span class="text-red-500">*</span></label>
                    <select name="shift" required class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                        <option value="{{ Appointment::SHIFT_MORNING }}" {{ $appointment->shift == Appointment::SHIFT_MORNING ? 'selected' : '' }}>{{ __('Morning') }}</option>
                        <option value="{{ Appointment::SHIFT_EVENING }}" {{ $appointment->shift == Appointment::SHIFT_EVENING ? 'selected' : '' }}>{{ __('Evening') }}</option>
                    </select>
                </div>
            </div>

            @if(isset($employees) && $employees->isNotEmpty())
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <label class="block text-gray-700 font-bold text-sm">{{ __('Employee') }} <span class="text-gray-400 font-normal">{{ __('(Optional)') }}</span></label>
                </div>
                <p class="text-sm text-gray-400 mb-3 mr-7">{{ __('You can change the selected employee') }}</p>
                <div class="flex flex-wrap gap-2.5" id="employeeContainer">
                    <label class="employee-option rounded-2xl px-5 py-3 cursor-pointer transition-all duration-200 text-sm font-medium border-2 flex items-center gap-2.5 {{ !$appointment->employee_id ? 'border-rose-300 bg-rose-50/70 text-rose-700 shadow-sm' : 'border-gray-100 bg-white text-gray-500 hover:border-rose-200 hover:text-rose-600' }}">
                        <input type="radio" name="employee_id" value="" class="employee-radio hidden" {{ !$appointment->employee_id ? 'checked' : '' }} onchange="updateEmployeeSelection()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ __('Unassigned') }}
                    </label>
                    @foreach($employees as $emp)
                    <label class="employee-option rounded-2xl px-5 py-3 cursor-pointer transition-all duration-200 text-sm font-medium border-2 flex items-center gap-2.5 {{ $appointment->employee_id == $emp->id ? 'border-rose-300 bg-rose-50/70 text-rose-700 shadow-sm' : 'border-gray-100 bg-white text-gray-500 hover:border-rose-200 hover:text-rose-600' }}">
                        <input type="radio" name="employee_id" value="{{ $emp->id }}" class="employee-radio hidden" {{ $appointment->employee_id == $emp->id ? 'checked' : '' }} onchange="updateEmployeeSelection()">
                        {{ $emp->name }}
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-sm mb-2">{{ __('Notes') }}</label>
                <textarea name="notes" rows="3" class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3.5 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none">{{ $appointment->notes }}</textarea>
            </div>

            <div id="priceSummary" class="hidden bg-gradient-to-br from-amber-50 to-rose-50/50 border-2 border-amber-200/40 rounded-2xl p-6 mb-6 space-y-3">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m0 0l-6-6m6 6H3"/>
                    </svg>
                    {{ __('Invoice Summary') }}
                </h3>
                <div id="summaryItems" class="space-y-1.5"></div>
                <div class="border-t border-amber-200/40 pt-3 flex justify-between items-center">
                    <span class="font-bold text-gray-700">{{ __('Total') }}</span>
                    <span class="text-2xl font-extrabold text-amber-700" id="summaryTotal">{{ formatCurrency(0) }}</span>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('track') }}"
                   class="flex-1 block text-center bg-gray-100 text-gray-700 py-4 rounded-2xl font-bold hover:bg-gray-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">{{ __('Back') }}</a>
                <button type="submit" id="submitBtn"
                   class="flex-1 bg-gradient-to-l from-rose-500 to-rose-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                    <span id="submitText" class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('Edit Booking') }}
                    </span>
                    <span id="submitSpinner" class="hidden items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        {{ __('Updating...') }}
                    </span>
                </button>
            </div>
        </form>

        @if($appointment->isEditable())
        <div class="mt-6 pt-6 border-t border-gray-100">
            <button type="button" onclick="document.getElementById('cancelBoxEdit').classList.toggle('hidden')"
               class="w-full bg-red-50 text-red-700 py-3.5 rounded-2xl font-bold border-2 border-red-200 hover:bg-red-100 hover:border-red-300 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ __('Cancel Booking') }}
            </button>
            <div id="cancelBoxEdit" class="hidden mt-3 p-5 bg-red-50/70 rounded-2xl border border-red-200">
                <form method="POST" action="{{ route('booking.guest.cancel', $appointment) }}" id="cancelFormEdit">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="phone" value="{{ $phone }}">
                    @if(request('token'))<input type="hidden" name="token" value="{{ request('token') }}">@endif
                    <textarea name="cancel_reason" id="cancelReasonEdit" rows="2" class="w-full border-2 border-red-200 rounded-xl px-4 py-3 text-sm focus:ring-0 focus:border-red-400 focus:bg-red-50/50 transition-all duration-200 resize-none" placeholder="{{ __('Is there a reason for cancellation?') }}"></textarea>
                    <div class="flex gap-3 mt-3">
                        <button type="button" onclick="confirmCancelEdit()" class="flex-1 bg-emerald-500 text-white py-2.5 rounded-xl font-bold hover:bg-emerald-600 transition text-sm">{{ __('Confirm Cancellation') }}</button>
                        <button type="button" onclick="document.getElementById('cancelBoxEdit').classList.add('hidden')" class="flex-1 bg-red-500 text-white py-2.5 rounded-xl font-bold hover:bg-red-600 transition text-sm">{{ __('Undo') }}</button>
                    </div>
                </form>
            </div>
            <script>
            function confirmCancelEdit() {
                const reason = document.getElementById('cancelReasonEdit');
                if (!reason.value.trim()) {
                    reason.classList.add('border-red-500');
                    reason.focus();
                    return;
                }
                reason.classList.remove('border-red-500');
                document.getElementById('cancelFormEdit').submit();
            }
            </script>
        </div>
    @endif
    </div>
</div>

@if($packages->isNotEmpty())
<script>
let previousPackageServiceIds = [];

function updatePriceSummary() {
    const summaryBox = document.getElementById('priceSummary');
    const itemsEl = document.getElementById('summaryItems');
    const totalEl = document.getElementById('summaryTotal');
    let items = [];
    let total = 0;

    document.querySelectorAll('.package-checkbox:checked').forEach(cb => {
        const card = cb.closest('.package-card');
        const name = card?.querySelector('.font-bold.text-gray-800')?.textContent || '';
        const price = parseFloat(card?.querySelector('.text-xl.font-extrabold')?.textContent) || 0;
        items.push({ name, price, type: 'package' });
        total += price;
    });

    document.querySelectorAll('.service-checkbox:checked:not(:disabled)').forEach(cb => {
        const item = cb.closest('.service-item');
        const name = item?.querySelector('span.font-bold')?.textContent || '';
        const priceText = item?.querySelector('.text-rose-600.font-bold')?.textContent || '0';
        const price = parseInt(priceText) || 0;
        items.push({ name, price, type: 'service' });
        total += price;
    });

    if (items.length === 0) {
        summaryBox.classList.add('hidden');
        return;
    }

    summaryBox.classList.remove('hidden');
    itemsEl.innerHTML = '';
    items.forEach(i => {
        const row = document.createElement('div');
        row.className = 'flex justify-between items-center py-1 text-sm';
        const nameSpan = document.createElement('span');
        nameSpan.className = i.type === 'package' ? 'text-rose-600' : 'text-gray-700';
        if (i.type === 'package') {
            const badge = document.createElement('span');
            badge.className = 'text-xs bg-rose-100 text-rose-700 px-1.5 py-0.5 rounded font-bold';
            badge.textContent = '{{ __("Package") }}';
            nameSpan.appendChild(badge);
            nameSpan.appendChild(document.createTextNode(' ' + i.name));
        } else {
            nameSpan.textContent = i.name;
        }
        row.appendChild(nameSpan);
        const priceSpan = document.createElement('span');
        priceSpan.className = 'font-bold';
        priceSpan.textContent = i.price + ' {{ __("KWD") }}';
        row.appendChild(priceSpan);
        itemsEl.appendChild(row);
    });
    totalEl.textContent = total + ' {{ __("KWD") }}';

    summaryBox.style.transform = 'scale(0.95)';
    summaryBox.style.opacity = '0';
    requestAnimationFrame(() => {
        summaryBox.style.transition = 'all 0.2s ease-out';
        summaryBox.style.transform = 'scale(1)';
        summaryBox.style.opacity = '1';
    });
}

function updatePackages() {
    const checkedBoxes = document.querySelectorAll('.package-checkbox:checked');
    const infoBox = document.getElementById('packageServicesInfo');
    const infoText = document.getElementById('packageServicesText');
    const tagsContainer = document.getElementById('packageServicesTags');
    const servicesLabel = document.getElementById('servicesLabel');

    let allSelectedServiceIds = [];
    let allSelectedNames = [];
    let allSelectedTags = [];

    checkedBoxes.forEach(cb => {
        const card = cb.closest('.package-card');
        const name = card ? card.querySelector('.font-bold.text-gray-800')?.textContent || '' : '';
        const tagText = card ? card.querySelector('.text-gray-400.text-sm')?.textContent || '' : '';
        const services = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        allSelectedServiceIds = allSelectedServiceIds.concat(services);
        if (name) {
            allSelectedNames.push(name);
            if (tagText) {
                allSelectedTags = allSelectedTags.concat(tagText.split(' + '));
            }
        }
    });

    document.querySelectorAll('.package-card').forEach(card => {
        const cb = card.querySelector('.package-checkbox');
        card.classList.toggle('border-rose-300', cb.checked);
        card.classList.toggle('bg-rose-50/40', cb.checked);
        card.classList.toggle('shadow-sm', cb.checked);
        card.classList.toggle('border-gray-100', !cb.checked);
    });

    document.querySelectorAll('.service-checkbox').forEach(cb => {
        const sid = parseInt(cb.value);
        const isPackageService = allSelectedServiceIds.includes(sid);
        const wasPackageService = previousPackageServiceIds.includes(sid);

        if (isPackageService) {
            cb.checked = true;
            cb.disabled = true;
            cb.closest('.service-item').classList.add('border-rose-200', 'bg-rose-50/30');
            cb.closest('.service-item').classList.remove('border-gray-100', 'bg-white', 'hover:border-rose-200', 'hover:shadow-sm');
            cb.closest('.service-item').querySelector('span.font-bold')?.classList.add('text-rose-600');
            let badge = cb.closest('.service-item').querySelector('.package-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'package-badge text-xs text-rose-500 mr-1';
                badge.textContent = '{{ __("From package") }}';
                const container = cb.closest('.service-item').querySelector('.flex.items-center.gap-3.min-w-0 div');
                if (container) container.appendChild(badge);
            }
        } else {
            if (wasPackageService && !isPackageService) {
                cb.checked = false;
            }
            cb.disabled = false;
            cb.closest('.service-item').classList.remove('border-rose-200', 'bg-rose-50/30');
            cb.closest('.service-item').classList.add('border-gray-100', 'bg-white', 'hover:border-rose-200', 'hover:shadow-sm');
            cb.closest('.service-item').querySelector('span.font-bold')?.classList.remove('text-rose-600');
            const badge = cb.closest('.service-item').querySelector('.package-badge');
            if (badge) badge.remove();
        }
    });

    previousPackageServiceIds = allSelectedServiceIds;

    if (checkedBoxes.length > 0) {
        infoText.textContent = '{{ __("Package Services") }}: ' + allSelectedNames.join(' + ');
        tagsContainer.innerHTML = '';
        [...new Set(allSelectedTags)].forEach(s => {
            const tag = document.createElement('span');
            tag.className = 'bg-rose-100 text-rose-700 text-sm px-3 py-1.5 rounded-lg';
            tag.textContent = '✅ ' + s.trim();
            tagsContainer.appendChild(tag);
        });
        infoBox.classList.remove('hidden');
        servicesLabel.textContent = '{{ __("Extra Services for Package") }}';
    } else {
        infoBox.classList.add('hidden');
        servicesLabel.textContent = '{{ __("Services") }}';
    }

    updatePriceSummary();
}

document.querySelectorAll('.service-checkbox:not(:disabled)').forEach(cb => {
    cb.addEventListener('change', updatePriceSummary);
});

document.addEventListener('DOMContentLoaded', function() {
    previousPackageServiceIds = [];
    document.querySelectorAll('.package-checkbox:checked').forEach(cb => {
        const services = cb.dataset.services ? cb.dataset.services.split(',').map(Number) : [];
        previousPackageServiceIds = previousPackageServiceIds.concat(services);
    });
    if (document.querySelector('.package-checkbox:checked')) {
        updatePackages();
    }
    updatePriceSummary();
});

function updateEmployeeSelection() {
    document.querySelectorAll('.employee-option').forEach(function(el) {
        var input = el.querySelector('.employee-radio:checked');
        if (input) {
            el.classList.add('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            el.classList.remove('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-rose-200', 'hover:text-rose-600');
        } else {
            el.classList.remove('border-rose-300', 'bg-rose-50/70', 'text-rose-700', 'shadow-sm');
            el.classList.add('border-gray-100', 'bg-white', 'text-gray-500', 'hover:border-rose-200', 'hover:text-rose-600');
        }
    });
}
</script>
@endif

<script>
document.getElementById('editForm')?.addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    btn.disabled = true;
    document.getElementById('submitText').classList.add('hidden');
    document.getElementById('submitSpinner').classList.remove('hidden');
});
</script>
@endsection
