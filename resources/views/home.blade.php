@extends('layouts.app')

@section('title', 'EpiDrive - Votre épicerie de quartier, livrée chez vous en 30 min')
@section('meta_description', 'EpiDrive, votre épicerie de quartier en ligne. Fruits, légumes, produits laitiers, épicerie fine et bien plus. Livraison rapide à domicile en 30 minutes.')

@section('content')

    {{-- ============================================
         HERO SECTION
         ============================================ --}}
    <section class="relative bg-gradient-hero overflow-hidden min-h-[520px] sm:min-h-[600px] flex items-center">
        {{-- Floating food emojis --}}
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <span class="emoji-hero animate-float text-5xl top-[10%] left-[5%] opacity-30">🍎</span>
            <span class="emoji-hero animate-float-2 text-6xl top-[20%] right-[8%] opacity-25">🥑</span>
            <span class="emoji-hero animate-float-3 text-4xl top-[60%] left-[10%] opacity-20">🥖</span>
            <span class="emoji-hero animate-float text-5xl bottom-[15%] right-[15%] opacity-25" style="animation-delay: 1s;">🧀</span>
            <span class="emoji-hero animate-float-2 text-4xl top-[40%] left-[80%] opacity-20" style="animation-delay: 2s;">🍇</span>
            <span class="emoji-hero animate-float-3 text-6xl bottom-[25%] left-[25%] opacity-15" style="animation-delay: 0.5s;">🥕</span>
            <span class="emoji-hero animate-float text-5xl top-[15%] left-[50%] opacity-20" style="animation-delay: 3s;">🍊</span>
            <span class="emoji-hero animate-float-2 text-4xl bottom-[10%] right-[40%] opacity-20" style="animation-delay: 1.5s;">🫑</span>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center max-w-3xl mx-auto">
                {{-- Delivery time badge --}}
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-5 py-2 mb-8 animate-fade-in-up">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-400"></span>
                    </span>
                    <span class="text-emerald-200 font-semibold text-sm">⚡ Livré en 30 min</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-white text-shadow-lg animate-fade-in-up" style="animation-delay: 0.1s;">
                    Vos courses livrées
                    <span class="text-gradient-brand block sm:inline">en un éclair</span>
                </h1>

                <p class="text-lg sm:text-xl text-emerald-100/80 mb-10 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                    Des produits frais et de qualité, sélectionnés avec soin et livrés rapidement à votre porte. Plus de 2000 références disponibles.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('catalog.index') }}"
                       class="inline-flex items-center space-x-2 bg-gradient-accent text-emerald-900 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 animate-pulse-glow text-lg">
                        <span>Faire mes courses</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <div class="flex items-center space-x-2 text-white/60 text-sm">
                        <span>🚚</span>
                        <span>Livraison gratuite dès 25€</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 40L48 36C96 32 192 24 288 28C384 32 480 48 576 52C672 56 768 48 864 40C960 32 1056 24 1152 28C1248 32 1344 48 1392 56L1440 64V80H1392C1344 80 1248 80 1152 80C1056 80 960 80 864 80C768 80 672 80 576 80C480 80 384 80 288 80C192 80 96 80 48 80H0V40Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- ============================================
         CATEGORIES SECTION
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="text-center mb-10" x-show="shown" x-transition.duration.600ms>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Nos rayons</h2>
            <p class="text-gray-500 text-lg">Trouvez tout ce qu'il vous faut en quelques clics</p>
        </div>

        {{-- Mobile: horizontal scroll / Desktop: grid --}}
        <div class="flex sm:grid sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 scroll-x-snap sm:overflow-visible pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0">
            @php
                $categoryEmojis = ['🥤', '🥫', '🍝', '🍿', '🧴', '🥬', '🧀', '🥖', '🍫', '🥩'];
                $categoryColors = [
                    'from-blue-100 to-blue-50',
                    'from-orange-100 to-orange-50',
                    'from-yellow-100 to-yellow-50',
                    'from-pink-100 to-pink-50',
                    'from-purple-100 to-purple-50',
                    'from-green-100 to-green-50',
                    'from-amber-100 to-amber-50',
                    'from-rose-100 to-rose-50',
                    'from-indigo-100 to-indigo-50',
                    'from-red-100 to-red-50',
                ];
            @endphp
            @forelse($categories ?? [] as $index => $category)
                <a href="{{ route('catalog.category', $category->slug) }}"
                   class="category-card flex-shrink-0 w-36 sm:w-auto bg-gradient-to-br {{ $categoryColors[$index % count($categoryColors)] }} rounded-2xl p-6 text-center group"
                   x-show="shown"
                   x-transition.duration.500ms
                   style="transition-delay: {{ $index * 80 }}ms;">
                    <div class="emoji-icon text-center mb-3">
                        {{ $categoryEmojis[$index % count($categoryEmojis)] }}
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-emerald-700 transition-colors duration-200 truncate">
                        {{ $category->name }}
                    </h3>
                    @if(isset($category->products_count))
                        <span class="inline-block mt-2 text-xs bg-white/60 text-gray-600 px-2 py-0.5 rounded-full font-medium">
                            {{ $category->products_count }} produits
                        </span>
                    @endif
                </a>
            @empty
                <div class="col-span-full text-center text-gray-400 py-8">
                    Les catégories arrivent bientôt.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ============================================
         FEATURED PRODUCTS
         ============================================ --}}
    <section class="py-12 sm:py-16 bg-white"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10" x-show="shown" x-transition.duration.600ms>
                <div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900">🔥 Produits populaires</h2>
                    <p class="text-gray-500 mt-1">Les favoris de nos clients</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="hidden sm:inline-flex items-center space-x-1 text-emerald-700 font-semibold hover:text-emerald-800 transition-colors duration-200">
                    <span>Tout voir</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse($featuredProducts ?? [] as $index => $product)
                    <div class="product-card bg-white rounded-2xl shadow-md overflow-hidden group"
                         x-data="{ adding: false, added: false }"
                         x-show="shown"
                         x-transition.duration.500ms
                         style="transition-delay: {{ $index * 100 }}ms;">
                        {{-- Image --}}
                        <a href="{{ route('catalog.product', [$product->category->slug, $product->slug]) }}" class="block relative overflow-hidden aspect-square">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 flex items-center justify-center">
                                    <span class="text-5xl opacity-50">🛒</span>
                                </div>
                            @endif
                            {{-- Category badge --}}
                            @if($product->category)
                                <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-sm text-xs font-semibold text-emerald-800 px-3 py-1 rounded-full">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </a>

                        {{-- Info --}}
                        <div class="p-4">
                            <a href="{{ route('catalog.product', [$product->category->slug, $product->slug]) }}">
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base truncate group-hover:text-emerald-700 transition-colors duration-200">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <div class="flex items-center justify-between mt-3">
                                <span class="inline-flex items-center bg-emerald-100 text-emerald-800 font-extrabold px-3 py-1 rounded-xl text-lg">
                                    {{ number_format($product->price, 2, ',', ' ') }}&nbsp;&euro;
                                </span>

                                {{-- Add to cart button with morph animation --}}
                                <button
                                    @click="
                                        if (added) return;
                                        adding = true;
                                        fetch('{{ route('cart.add') }}', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                                            body: JSON.stringify({ product_id: {{ $product->id }}, quantity: 1 })
                                        }).then(r => r.json()).then(d => {
                                            adding = false;
                                            added = true;
                                            $dispatch('cart-updated');
                                            setTimeout(() => { added = false; }, 2000);
                                        }).catch(() => { adding = false; });
                                    "
                                    :disabled="adding"
                                    class="add-to-cart-btn w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300"
                                    :class="added ? 'bg-emerald-500 text-white scale-110' : 'bg-emerald-700 text-white hover:bg-emerald-600'"
                                    :aria-label="added ? 'Ajouté' : 'Ajouter {{ $product->name }} au panier'">
                                    {{-- Plus icon --}}
                                    <svg x-show="!adding && !added" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{-- Spinner --}}
                                    <svg x-show="adding" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    {{-- Checkmark --}}
                                    <svg x-show="added" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-400 py-12">
                        <span class="text-5xl mb-4 block">🛒</span>
                        Les produits arrivent bientôt.
                    </div>
                @endforelse
            </div>

            {{-- Mobile "see all" link --}}
            <div class="sm:hidden text-center mt-8">
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center space-x-2 bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl hover:bg-emerald-800 transition-all duration-200">
                    <span>Voir tous les produits</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================
         PROMO BANNER
         ============================================ --}}
    <section class="relative overflow-hidden"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-amber-500 animate-gradient py-12 sm:py-16"
             x-show="shown" x-transition.duration.800ms>
            <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-1 text-white/90 text-sm font-semibold mb-4">
                    🎁 Offre spéciale
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-4 text-shadow">
                    Première commande ?
                </h2>
                <p class="text-xl sm:text-2xl text-white/90 mb-8 font-medium">
                    <span class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2 inline-block">
                        -20% avec le code <span class="font-black text-yellow-300">BIENVENUE</span>
                    </span>
                </p>
                <a href="{{ route('catalog.index') }}"
                   class="inline-flex items-center space-x-2 bg-white text-purple-700 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-lg">
                    <span>En profiter maintenant</span>
                    <span>🎉</span>
                </a>
            </div>
            {{-- Decorative circles --}}
            <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-48 h-48 bg-white/10 rounded-full translate-x-1/3 translate-y-1/3"></div>
            <div class="absolute top-1/2 left-1/4 w-20 h-20 bg-white/5 rounded-full"></div>
        </div>
    </section>

    {{-- ============================================
         HOW IT WORKS
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="text-center mb-14" x-show="shown" x-transition.duration.600ms>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Comment ça marche</h2>
            <p class="text-gray-500 text-lg">Simple comme bonjour</p>
        </div>

        <div class="steps-connector relative grid grid-cols-1 sm:grid-cols-3 gap-10 sm:gap-8">
            {{-- Step 1 --}}
            <div class="text-center relative z-10"
                 x-show="shown" x-transition.duration.500ms style="transition-delay: 100ms;">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-2xl font-extrabold shadow-lg shadow-emerald-500/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                    1
                </div>
                <div class="text-4xl mb-3">🔍</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Choisissez</h3>
                <p class="text-gray-500">Parcourez notre catalogue et sélectionnez vos produits préférés.</p>
            </div>

            {{-- Step 2 --}}
            <div class="text-center relative z-10"
                 x-show="shown" x-transition.duration.500ms style="transition-delay: 250ms;">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center text-white text-2xl font-extrabold shadow-lg shadow-amber-400/30 -rotate-3 hover:rotate-0 transition-transform duration-300">
                    2
                </div>
                <div class="text-4xl mb-3">🛒</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Commandez</h3>
                <p class="text-gray-500">Validez votre panier et choisissez votre créneau de livraison.</p>
            </div>

            {{-- Step 3 --}}
            <div class="text-center relative z-10"
                 x-show="shown" x-transition.duration.500ms style="transition-delay: 400ms;">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl font-extrabold shadow-lg shadow-purple-500/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                    3
                </div>
                <div class="text-4xl mb-3">🚀</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Livré !</h3>
                <p class="text-gray-500">Recevez vos courses fraîchement préparées directement chez vous.</p>
            </div>
        </div>
    </section>

    {{-- ============================================
         TRUST SECTION
         ============================================ --}}
    <section class="bg-gradient-to-br from-emerald-900 to-emerald-950 py-14 sm:py-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-6">
                {{-- Fast delivery --}}
                <div class="text-center group"
                     x-show="shown" x-transition.duration.500ms style="transition-delay: 100ms;">
                    <div class="text-5xl mb-4 group-hover:scale-125 transition-transform duration-300">⚡</div>
                    <h3 class="text-xl font-bold text-white mb-2">Livraison rapide</h3>
                    <p class="text-emerald-200/70">Vos courses livrées en 30 minutes dans votre quartier.</p>
                </div>

                {{-- Fresh products --}}
                <div class="text-center group"
                     x-show="shown" x-transition.duration.500ms style="transition-delay: 250ms;">
                    <div class="text-5xl mb-4 group-hover:scale-125 transition-transform duration-300">🥬</div>
                    <h3 class="text-xl font-bold text-white mb-2">Produits frais</h3>
                    <p class="text-emerald-200/70">Sélectionnés chaque jour pour garantir fraîcheur et qualité.</p>
                </div>

                {{-- Secure payment --}}
                <div class="text-center group"
                     x-show="shown" x-transition.duration.500ms style="transition-delay: 400ms;">
                    <div class="text-5xl mb-4 group-hover:scale-125 transition-transform duration-300">🔒</div>
                    <h3 class="text-xl font-bold text-white mb-2">Paiement sécurisé</h3>
                    <p class="text-emerald-200/70">Vos transactions protégées par un chiffrement de bout en bout.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
