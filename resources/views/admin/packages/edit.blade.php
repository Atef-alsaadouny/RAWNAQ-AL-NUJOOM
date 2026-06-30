@extends('layouts.admin')

@section('page-title', __('Edit Package'))

@section('content')
<form method="POST" action="{{ route('admin.packages.update', $package) }}" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @csrf
    @method('PUT')

    <div class="bg-gradient-to-l from-amber-50 to-white px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">{{ __('Edit Package') }}</h2>
    </div>

    <div class="p-6 space-y-6">
        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Name (arabic)') }} <span class="text-red-500">*</span></label>
            <input type="text" name="name_ar" required value="{{ old('name_ar', $package->name_ar) }}"
                class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Name (english)') }}</label>
            <input type="text" name="name_en" value="{{ old('name_en', $package->name_en) }}"
                class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Description (arabic)') }}</label>
            <textarea name="description_ar" rows="3" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">{{ old('description_ar', $package->description_ar) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Description (english)') }}</label>
            <textarea name="description_en" rows="3" class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">{{ old('description_en', $package->description_en) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Package Price (kwd)') }} <span class="text-red-500">*</span></label>
                <input type="number" step="0.001" name="price" required value="{{ old('price', $package->price) }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
            <div>
                <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Original Price (kwd)') }}</label>
                <input type="number" step="0.001" name="original_price" value="{{ old('original_price', $package->original_price) }}"
                    class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 gap-x-2">
                <input type="checkbox" name="is_active" value="1" {{ $package->is_active ? 'checked' : '' }}
                    class="rounded border-gray-300 text-amber-600">
                <span class="text-sm font-medium">{{ __('Active') }}</span>
            </label>
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Services') }} <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-400 mb-2">{{ __('Select Services Included') }}</p>
            <div class="grid grid-cols-2 gap-2">
                @foreach($services as $service)
                <label class="flex items-center gap-2 rounded-xl border border-gray-200 p-3.5 cursor-pointer hover:border-amber-400 transition">
                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                        {{ in_array($service->id, old('service_ids', $package->services->pluck('id')->toArray())) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-amber-600">
                    <div>
                        <span class="text-sm font-medium">{{ $service->name }}</span>
                        <span class="text-xs text-gray-400 block">{{ $service->name_en }}</span>
                    </div>
                </label>
                @endforeach
            </div>
            @error('service_ids')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('Sort Order') }}</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}"
                class="w-full rounded-xl px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-xl hover:bg-amber-700 text-sm font-medium transition-colors">
                {{ __('Update Package') }}
            </button>
            <a href="{{ route('admin.packages.index') }}" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors">
                {{ __('Cancel') }}
            </a>
        </div>
    </div>
</form>
@endsection
