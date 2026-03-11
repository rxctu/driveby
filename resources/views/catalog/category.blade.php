@extends('layouts.app')

@section('title', $metaTitle ?? (($category->name ?? 'Categorie') . ' - EpiDrive'))
@section('meta_description', $metaDescription ?? ('Decouvrez nos produits dans la categorie ' . ($category->name ?? '') . '.'))

@section('content')

    @php
        $categoryColors = [
            'Boissons' => 'from-sky-500 to-blue-600',
            'Conserves' => 'from-orange-500 to-red-500',
            'Snacks' => 'from-amber-400 to-orange-500',
            'Produits du quotidien' => 'from-violet-500 to-purple-600',
        ];
        $gradientClass = $categoryColors[$category->name ?? ''] ?? 'from-emerald-600 to-teal-500';

        $emojiMap = [
            'Boissons' => "\xF0\x9F\xA5\xA4",
            'Conserves' => "\xF0\x9F\xA5\xAB",
            'P\xC3\xA2tes & Riz' => "\xF0\x9F\x8D\x9D",
            'Snacks' => "\xF0\x9F\x8D\xBF",
            'Produits du quotidien' => "\xF0\x9F\xA7\xB4",
        ];
        $categoryEmoji = $emojiMap[$category->name ?? ''] ?? "\xF0\x9F\x93\xA6";
    @endphp

    {{-- Category Header --}}
    <div class="bg-gradient-to-r {{ $gradientClass }} relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-white rounded-full"></div>
            <div class="absolute -bottom-20 -left-10 w-96 h-96 bg-white rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 relative">
            {{-- Breadcrumb Pills --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm flex-wrap gap-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white/90 hover:bg-white/30 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                            Accueil
                        </a>
                    </li>
                    <li><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white/90 hover:bg-white/30 transition backdrop-blur-sm">Catalogue</a>
                    </li>
                    <li><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/30 text-white font-medium backdrop-blur-sm">{{ $category->name ?? 'Categorie' }}</span>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center space-x-4">
                <span class="text-5xl">{{ $categoryEmoji }}</span>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $category->name ?? 'Categorie' }}</h1>
                    @if($category->description ?? false)
                        <p class="mt-1 text-white/80 text-lg">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products ?? [] as $index => $product)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:scale-[1.03] transition-all duration-300"
                     x-data="{ adding: false, added: false }"
                     style="animation: fadeInUp 0.4s ease-out {{ ($index % 8) * 0.06 }}s both;">

                    {{-- Product Image --}}
                    <a href="{{ route('catalog.product', [$category->slug, $product->slug]) }}" class="block relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-40 sm:h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 flex items-center justify-center">
                                <span class="text-5xl opacity-50">{{ $categoryEmoji }}</span>
                            </div>
                        @endif

                        {{-- Stock badge --}}
                        @if(($product->stock ?? 0) <= 0)
                            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg">
                                Rupture
                            </div>
                        @elseif(($product->stock ?? 0) <= 5)
                            <div class="absolute top-2 right-2 bg-amber-400 text-amber-900 text-xs font-bold px-2.5 py-1 rounded-full shadow-lg">
                                Plus que {{ $product->stock }}
                            </div>
                        @endif
                    </a>

                    <div class="p-4">
                        <a href="{{ route('catalog.product', [$category->slug, $product->slug]) }}">
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base truncate group-hover:text-emerald-600 transition">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <div class="flex items-center justify-between mt-3">
                            {{-- Price Pill --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-extrabold text-base">
                                {{ number_format($product->price, 2, ',', ' ') }}&nbsp;&euro;
                            </span>

                            {{-- Add to Cart Button --}}
                            @if(($product->stock ?? 0) > 0)
                                <button @click.prevent="
                                            if (added) return;
                                            adding = true;
                                            addToCart({{ $product->id }}).then(() => {
                                                adding = false; added = true;
                                                setTimeout(() => { added = false; }, 2000);
                                            }).catch(() => { adding = false; });"
                                        :disabled="adding || added"
                                        class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-200 active:scale-90 transition-all duration-200 disabled:opacity-60">
                                    <svg x-show="!adding && !added" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <svg x-show="adding" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    <svg x-show="added" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            @else
                                <span class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="text-7xl mb-6">{{ $categoryEmoji }}</div>
                    <h2 class="text-xl font-bold text-gray-700 mb-2">Aucun produit disponible</h2>
                    <p class="text-gray-500 mb-6">Cette categorie est vide pour le moment. Revenez bientot !</p>
                    <a href="{{ route('catalog.index') }}"
                       class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-semibold hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Retour au catalogue
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($products) && $products->hasPages())
            <div class="mt-10 flex justify-center">
                <div class="inline-flex items-center space-x-1 [&_.pagination]:flex [&_.pagination]:items-center [&_.pagination]:space-x-1 [&_.page-link]:inline-flex [&_.page-link]:items-center [&_.page-link]:justify-center [&_.page-link]:w-10 [&_.page-link]:h-10 [&_.page-link]:rounded-full [&_.page-link]:text-sm [&_.page-link]:font-medium [&_.page-link]:transition-all [&_.page-link]:duration-200 [&_.page-item.active_.page-link]:bg-emerald-600 [&_.page-item.active_.page-link]:text-white [&_.page-item:not(.active)_.page-link]:text-gray-600 [&_.page-item:not(.active)_.page-link]:hover:bg-emerald-50 [&_.page-item:not(.active)_.page-link]:hover:text-emerald-600 [&_.page-item.disabled_.page-link]:opacity-40 [&_.page-item.disabled_.page-link]:cursor-not-allowed">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        [x-cloak] { display: none !important; }
    </style>

@endsection
