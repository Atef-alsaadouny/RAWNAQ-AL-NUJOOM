@extends('layouts.public')

@section('title', __('site_name') . ' — ' . __('Our Services'))

@section('content')
<div class="max-w-7xl mx-auto px-4">

    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
            <span class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></span>
            {{ __('Ladies Care Services') }}
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-3">{{ __('Our Services') }}</h1>
        <p class="text-gray-500 text-lg">{{ __("Choose the service that suits you and book your appointment") }}</p>
    </div>

    {{-- Notice about selecting multiple services --}}
    <div class="bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 border border-rose-200/60 rounded-2xl p-5 mb-10 text-center">
        <div class="flex items-center justify-center gap-3 flex-wrap">
            <span class="text-2xl">💡</span>
            <div>
                <p class="text-gray-700 font-medium">
                    {{ __("You can select multiple services in one booking") }}
                </p>
                <p class="text-gray-500 text-sm mt-0.5">
                    {{ __("Save time — choose all the services you want and enjoy a complete experience") }}
                </p>
            </div>
        </div>
    </div>

    @if($services->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">💅</div>
            <p class="text-gray-400 text-lg">{{ __('No services available at the moment') }}</p>
        </div>
    @else
        {{-- Service categories --}}
        @if($categories->isNotEmpty() && $categories->count() > 1)
        <div class="flex flex-wrap justify-center gap-2 mb-8" id="categoryFilter">
            <button class="cat-btn active px-5 py-2 rounded-full text-sm font-bold border-2 border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 transition-all" data-cat="all">
                {{ __('All') }}
            </button>
            @foreach($categories as $cat => $catServices)
            <button class="cat-btn px-5 py-2 rounded-full text-sm font-medium border-2 border-gray-200 text-gray-600 hover:border-rose-200 hover:text-rose-600 transition-all" data-cat="{{ $cat }}">
                {{ $cat }}
            </button>
            @endforeach
        </div>
        @endif

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="servicesGrid">
            @foreach($services as $service)
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 hover:border-rose-200 transition-all duration-300 hover:-translate-y-1 p-8 flex flex-col items-center text-center service-card" data-category="{{ $service->category ?? __('Uncategorized') }}">
                <div class="w-20 h-20 bg-gradient-to-br from-rose-100 to-amber-100 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:from-rose-200 group-hover:to-amber-200 transition-all duration-300 shadow-sm">
                    <span class="text-3xl">
                        @php
                            $emojiMap = ['شعر'=>'💇‍♀️','مكياج'=>'💄','مساج'=>'💆‍♀️','أظافر'=>'💅','بشرة'=>'✨','عناية'=>'✨','أخرى'=>'💫'];
                        @endphp
                        {{ $emojiMap[$service->category] ?? '💫' }}
                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>

                @if($service->description)
                    <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-2">{{ $service->description }}</p>
                @endif

                <div class="mt-auto w-full">
                    <div class="flex justify-center items-baseline gap-1.5 mb-5">
                        <span class="text-3xl font-extrabold text-rose-600">{{ formatCurrency($service->price) }}</span>
                    </div>

                    <a href="{{ route('book', ['service_id' => $service->id]) }}"
                       class="block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 transition-all duration-200 text-[15px]">
                        {{ __('Book Now') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @if($categories->isNotEmpty() && $categories->count() > 1)
        <script>
        document.querySelectorAll('.cat-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.cat-btn').forEach(function(b) {
                    b.classList.remove('active', 'bg-rose-50', 'text-rose-700', 'border-rose-200');
                    b.classList.add('border-gray-200', 'text-gray-600');
                });
                this.classList.add('active', 'bg-rose-50', 'text-rose-700', 'border-rose-200');
                this.classList.remove('border-gray-200', 'text-gray-600');
                var cat = this.dataset.cat;
                document.querySelectorAll('.service-card').forEach(function(card) {
                    if (cat === 'all' || card.dataset.category === cat) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        </script>
        @endif
    @endif

    {{-- Offers and packages section --}}
    @if($packages->isNotEmpty())
    <div class="mt-16 mb-16">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-amber-100/60 text-amber-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
                🎁 {{ __('Our Special Offers') }}
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ __('Packages & Offers') }}</h2>
            <p class="text-gray-500">{{ __("Benefit from our special offers and exclusive packages") }}</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $package)
            @php
                $discount = $package->original_price && $package->original_price > $package->price
                    ? round((1 - $package->price / $package->original_price) * 100)
                    : 0;
                $icons = ['💇‍♀️', '💄', '✨', '💅', '💆‍♀️', '🧴', '🎀', '💫'];
                $bgColors = ['from-rose-50 to-amber-50', 'from-purple-50 to-pink-50', 'from-teal-50 to-emerald-50', 'from-blue-50 to-indigo-50'];
            @endphp
            <div class="bg-gradient-to-br {{ $bgColors[$loop->index % count($bgColors)] }} border-2 border-rose-200/60 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                @if($discount > 0)
                <div class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-3 py-1 rounded-full">{{ __('Discount') }} {{ $discount }}%</div>
                @endif
                <div class="text-4xl mb-4 mt-4">{{ $icons[$loop->index % count($icons)] }}</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $package->name }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ $package->description ?: $package->services->pluck('name')->implode(' + ') }}</p>
                <div class="flex justify-center items-baseline gap-3 mb-5">
                    @if($package->original_price && $package->original_price > $package->price)
                    <span class="text-lg text-gray-400 line-through">{{ formatCurrency($package->original_price) }}</span>
                    @endif
                    <span class="text-3xl font-extrabold text-rose-600">{{ formatCurrency($package->price) }}</span>
                </div>
                <a href="{{ route('book', ['package_ids[]' => $package->id]) }}"
                   class="block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                    {{ __('Book Package') }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
