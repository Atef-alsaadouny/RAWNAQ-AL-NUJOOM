@extends('layouts.admin')

@section('page-title', __('Edit Service'))

@section('content')
<div class="max-w-2xl mx-auto bg-white/90 backdrop-blur-sm rounded-[2.5rem] shadow-xl shadow-rose-200/40 border border-rose-100/50 overflow-hidden">
    <div class="bg-gradient-to-l from-rose-50 to-white px-6 py-5 border-b border-rose-100">
        <h2 class="text-xl font-bold text-gray-800">{{ __('Edit Service') }}: {{ $service->name }}</h2>
    </div>
    <form method="POST" action="{{ route('admin.services.update', $service) }}" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name (arabic)') }} <span class="text-rose-500">*</span></label>
            <input type="text" name="name_ar" required value="{{ old('name_ar', $service->name_ar) }}"
                class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name (english)') }}</label>
            <input type="text" name="name_en" value="{{ old('name_en', $service->name_en) }}"
                class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Category') }} <span class="text-rose-500">*</span></label>
            <select name="category" required class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
                <option value="">{{ __('Select Category') }}</option>
                <option value="شعر" {{ old('category', $service->category) == 'شعر' ? 'selected' : '' }}>{{ __('Hair') }}</option>
                <option value="مكياج" {{ old('category', $service->category) == 'مكياج' ? 'selected' : '' }}>{{ __('Makeup') }}</option>
                <option value="بشرة" {{ old('category', $service->category) == 'بشرة' ? 'selected' : '' }}>{{ __('Skin') }}</option>
                <option value="أظافر" {{ old('category', $service->category) == 'أظافر' ? 'selected' : '' }}>{{ __('Nails') }}</option>
                <option value="مساج" {{ old('category', $service->category) == 'مساج' ? 'selected' : '' }}>{{ __('Massage') }}</option>
                <option value="عناية" {{ old('category', $service->category) == 'عناية' ? 'selected' : '' }}>{{ __('Care') }}</option>
                <option value="أخرى" {{ old('category', $service->category) == 'أخرى' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description (arabic)') }}</label>
            <textarea name="description_ar" rows="3" class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none">{{ old('description_ar', $service->description_ar) }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description (english)') }}</label>
            <textarea name="description_en" rows="3" class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 resize-none">{{ old('description_en', $service->description_en) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Price') }} <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="number" step="0.001" name="price" required value="{{ old('price', $service->price) }}"
                        class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 pr-14">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">{{ __('KWD') }}</span>
                </div>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Duration') }} <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="number" name="duration_minutes" required value="{{ old('duration_minutes', $service->duration_minutes) }}"
                        class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200 pr-14">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">{{ __('Min') }}</span>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }}
                    class="w-5 h-5 rounded-lg border-2 border-gray-200 text-rose-600 focus:ring-rose-500/20 transition-all">
                <span class="text-sm font-bold text-gray-700">{{ __('Active') }}</span>
            </label>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Sort Order') }}</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}"
                class="w-full rounded-xl px-4 py-3 text-sm border-2 border-gray-100 focus:ring-0 focus:border-rose-300 focus:bg-rose-50/20 transition-all duration-200">
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-gradient-to-l from-rose-500 to-rose-600 text-white px-7 py-3 rounded-xl font-bold shadow-lg shadow-rose-200/40 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 transition-all duration-200 text-sm">
                {{ __('Update Service') }}
            </button>
            <a href="{{ route('admin.services.index') }}" class="bg-white text-gray-700 px-7 py-3 rounded-xl border-2 border-gray-100 hover:border-rose-200 hover:text-rose-700 text-sm font-bold transition-all duration-200">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
