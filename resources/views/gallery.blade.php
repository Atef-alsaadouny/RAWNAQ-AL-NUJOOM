@extends('layouts.public')

@section('title', __('site_name') . ' — ' . __('Gallery'))
@section('meta_description', __('See photos of alnjoom salon — a tour of the salon atmosphere, our work, and services in Kuwait.'))

@section('content')
<div class="max-w-7xl mx-auto px-4">

    {{-- عنوان الصفحة --}}
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
            <span class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></span>
            {{ __('Salon Tour') }}
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-3">{{ __('Gallery') }}</h1>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">{{ __("See for yourself — a tour of the salon and some of our work") }}</p>
    </div>

    {{-- شبكة الصور --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">

        @php
            $images = [
                ['src' => asset('images/gallery/salon-interior.webp'), 'emoji' => '💇‍♀️', 'title' => __('Beauty Salon'), 'cat' => 'salon'],
                ['src' => asset('images/gallery/manicure.webp'), 'emoji' => '💅', 'title' => __('Pedicure & Manicure'), 'cat' => 'work'],
                ['src' => asset('images/gallery/makeup.webp'), 'emoji' => '💄', 'title' => __('Professional Makeup'), 'cat' => 'work'],
                ['src' => asset('images/gallery/salon-atmosphere.webp'), 'emoji' => '✨', 'title' => __('Salon Atmosphere'), 'cat' => 'salon'],
                ['src' => asset('images/gallery/skin-care.webp'), 'emoji' => '💆‍♀️', 'title' => __('Skin Care'), 'cat' => 'work'],
                ['src' => asset('images/gallery/hair-styling.webp'), 'emoji' => '💇‍♀️', 'title' => __('Styling Sessions'), 'cat' => 'salon'],
                ['src' => asset('images/gallery/relaxation.webp'), 'emoji' => '💫', 'title' => __('Relaxation Corner'), 'cat' => 'salon'],
                ['src' => asset('images/gallery/products.webp'), 'emoji' => '🧴', 'title' => __('Care Products'), 'cat' => 'products'],
                ['src' => asset('images/gallery/hair-cut.webp'), 'emoji' => '💇‍♀️', 'title' => __('Modern Cuts'), 'cat' => 'salon'],
                ['src' => asset('images/gallery/modern-styling.webp'), 'emoji' => '💇‍♀️', 'title' => __('Hair Styling'), 'cat' => 'work'],
                ['src' => asset('images/gallery/night-makeup.webp'), 'emoji' => '💄', 'title' => __('Night Makeup'), 'cat' => 'work'],
                ['src' => asset('images/gallery/massage.webp'), 'emoji' => '💆‍♀️', 'title' => __('Massage & Relaxation'), 'cat' => 'salon'],
            ];
        @endphp

        @foreach($images as $img)
        <div class="group relative overflow-hidden rounded-[2rem] shadow-sm border border-rose-100/60 aspect-square cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-500 bg-gradient-to-br from-rose-100 to-amber-50 flex items-center justify-center"
             onclick="openModal('{{ $img['src'] }}', '{{ $img['title'] }}')">
            <span class="text-6xl opacity-20 group-hover:opacity-30 transition-opacity duration-300 select-none">{{ $img['emoji'] }}</span>
            <img src="{{ $img['src'] }}"
                 alt="{{ $img['title'] }}"
                 loading="lazy"
                 onerror="this.style.display='none'"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-0 left-0 right-0 p-5">
                    <p class="text-white font-bold text-sm">{{ $img['title'] }}</p>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

{{-- Modal --}}
<div id="imageModal" class="fixed inset-0 z-[200] bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4" onclick="closeModal(event)">
    <div class="relative max-w-3xl w-full" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute -top-12 right-0 text-white/70 hover:text-white text-sm font-bold transition-colors">{{ __('Close') }} ✕</button>
        <img id="modalImage" src="" alt="Gallery image" class="w-full rounded-2xl shadow-2xl max-h-[80vh] object-cover">
        <p id="modalCaption" class="text-white/80 text-center mt-4 text-sm font-medium"></p>
    </div>
</div>

<script>
function openModal(src, title) {
    const img = document.getElementById('modalImage');
    img.src = src;
    img.alt = title ? 'Gallery: ' + title : 'Gallery image';
    document.getElementById('modalCaption').textContent = title;
    const modal = document.getElementById('imageModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeModal(e) {
    if (e && e.target !== e.currentTarget) return;
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
@endsection