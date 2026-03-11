@extends('layouts.app')

@php
    $pageTitle = $product->name . ' - ' . $category->name . ' - EpiDrive';
    $pageDesc = \Illuminate\Support\Str::limit($product->description ?? 'Decouvrez ce produit sur EpiDrive.', 160);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)

@section('meta')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ e($product->description ?? '') }}",
    "image": "{{ $product->image ? asset('storage/' . $product->image) : '' }}",
    "category": "{{ $category->name }}",
    "offers": {
        "@type": "Offer",
        "price": "{{ $product->price }}",
        "priceCurrency": "EUR",
        "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "seller": {
            "@type": "Organization",
            "name": "EpiDrive"
        }
    }
}
</script>
@endsection

@section('content')

    @php
        $emojiMap = [
            'Boissons' => "\xF0\x9F\xA5\xA4",
            'Conserves' => "\xF0\x9F\xA5\xAB",
            'P\xC3\xA2tes & Riz' => "\xF0\x9F\x8D\x9D",
            'Snacks' => "\xF0\x9F\x8D\xBF",
            'Produits du quotidien' => "\xF0\x9F\xA7\xB4",
        ];
        $categoryEmoji = $emojiMap[$category->name ?? ''] ?? "\xF0\x9F\x93\xA6";
    @endphp

    {{-- Breadcrumb Bar --}}
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav>
                <ol class="flex items-center space-x-2 text-sm flex-wrap gap-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 transition shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                            Accueil
                        </a>
                    </li>
                    <li><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 transition shadow-sm">Catalogue</a>
                    </li>
                    <li><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <a href="{{ route('catalog.category', $category->slug) }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 transition shadow-sm">{{ $category->name }}</a>
                    </li>
                    <li><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium text-sm">{{ $product->name }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        {{-- Product Detail --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14" x-data="{ quantity: 1, adding: false, added: false }" style="animation: fadeInUp 0.5s ease-out both;">

            {{-- Product Image --}}
            <div class="relative">
                <div class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                             class="w-full h-72 sm:h-96 lg:h-[500px] object-cover">
                    @else
                        <div class="w-full h-72 sm:h-96 lg:h-[500px] flex items-center justify-center bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100">
                            <span class="text-9xl opacity-40">{{ $categoryEmoji }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div class="flex flex-col">
                {{-- Category Badge --}}
                <a href="{{ route('catalog.category', $category->slug) }}"
                   class="inline-flex items-center self-start px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-sm font-medium hover:bg-purple-200 transition mb-4">
                    <span class="mr-1.5">{{ $categoryEmoji }}</span>
                    {{ $category->name }}
                </a>

                {{-- Product Name --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight mb-5">{{ $product->name }}</h1>

                {{-- Price --}}
                <div class="mb-5">
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full bg-emerald-600 text-white font-extrabold text-2xl sm:text-3xl shadow-lg shadow-emerald-200">
                        {{ number_format($product->price, 2, ',', ' ') }}&nbsp;&euro;
                    </span>
                </div>

                {{-- Stock Status --}}
                <div class="mb-6">
                    @if($product->stock > 0)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700">
                            <span class="relative mr-2 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            En stock ({{ $product->stock }} disponible{{ $product->stock > 1 ? 's' : '' }})
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-50 text-red-700">
                            <span class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span>
                            Rupture de stock
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                @if($product->description)
                    <div class="bg-gray-50 rounded-2xl p-5 mb-8 border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Description</h3>
                        <div class="text-gray-600 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Add to Cart --}}
                @if($product->stock > 0)
                    <div class="mt-auto space-y-4">
                        {{-- Quantity Selector --}}
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-semibold text-gray-700">Quantite</span>
                            <div class="flex items-center space-x-2">
                                <button @click="quantity = Math.max(1, quantity - 1)"
                                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition-all duration-200 active:scale-90 text-lg font-bold">
                                    -
                                </button>
                                <input type="number" x-model.number="quantity" min="1" max="{{ $product->stock }}"
                                       class="w-14 text-center border-0 bg-transparent text-gray-800 font-bold text-lg focus:ring-0">
                                <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition-all duration-200 active:scale-90 text-lg font-bold">
                                    +
                                </button>
                            </div>
                        </div>

                        {{-- Add to Cart Button --}}
                        <button @click="
                                    if (added) return;
                                    adding = true;
                                    addToCart({{ $product->id }}, quantity).then(() => {
                                        adding = false; added = true;
                                        setTimeout(() => { added = false; }, 2500);
                                    }).catch(() => { adding = false; });"
                                :disabled="adding || added"
                                class="w-full py-4 rounded-2xl font-bold text-lg text-white transition-all duration-300 disabled:opacity-70 shadow-xl"
                                :class="added ? 'bg-emerald-500 shadow-emerald-200' : 'bg-gradient-to-r from-emerald-600 to-teal-500 hover:shadow-2xl hover:shadow-emerald-200 hover:-translate-y-0.5 active:translate-y-0'">
                            <span x-show="!adding && !added" class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Ajouter au panier
                            </span>
                            <span x-show="adding" x-cloak class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Ajout en cours...
                            </span>
                            <span x-show="added" x-cloak class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Ajoute au panier !
                            </span>
                        </button>
                    </div>
                @else
                    <div class="mt-auto">
                        <button disabled class="w-full py-4 rounded-2xl font-bold text-lg bg-gray-200 text-gray-500 cursor-not-allowed">
                            Produit indisponible
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="mt-16 sm:mt-20">
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-6">Produits similaires</h2>

                {{-- Horizontal scroll on mobile, grid on desktop --}}
                <div class="flex overflow-x-auto pb-4 -mx-4 px-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 snap-x snap-mandatory sm:snap-none scrollbar-hide">
                    @foreach($relatedProducts as $index => $related)
                        <a href="{{ route('catalog.product', [$category->slug, $related->slug]) }}"
                           class="flex-shrink-0 w-56 sm:w-auto snap-start bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:scale-[1.03] transition-all duration-300 group"
                           style="animation: fadeInUp 0.4s ease-out {{ $index * 0.1 }}s both;">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}"
                                     class="w-full h-36 sm:h-44 object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-36 sm:h-44 bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 flex items-center justify-center">
                                    <span class="text-4xl opacity-40">{{ $categoryEmoji }}</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 text-sm truncate group-hover:text-emerald-600 transition">{{ $related->name }}</h3>
                                <span class="inline-flex items-center mt-2 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-extrabold text-sm">
                                    {{ number_format($related->price, 2, ',', ' ') }}&nbsp;&euro;
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

@endsection
