@props(['product'])

<div class="product-card bg-white rounded-2xl shadow-md overflow-hidden group"
     x-data="{ adding: false, added: false }">

    {{-- Product image --}}
    <a href="{{ route('produit', $product->slug) }}" class="block relative aspect-square overflow-hidden">
        @if($product->image)
            <img
                src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                loading="lazy"
            >
        @else
            <div class="w-full h-full bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 flex items-center justify-center">
                <span class="text-5xl opacity-50">🛒</span>
            </div>
        @endif

        {{-- Category badge --}}
        @if(isset($product->category) && $product->category)
            <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-sm text-xs font-semibold text-emerald-800 px-3 py-1 rounded-full shadow-sm">
                {{ $product->category->name }}
            </span>
        @endif
    </a>

    {{-- Product info --}}
    <div class="p-4">
        <a href="{{ route('produit', $product->slug) }}" class="block">
            <h3 class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-emerald-700 transition-colors duration-200">
                {{ $product->name }}
            </h3>
        </a>

        @if($product->unit)
            <p class="mt-1 text-xs text-gray-400 font-medium">{{ $product->unit }}</p>
        @endif

        <div class="mt-3 flex items-center justify-between">
            {{-- Price pill --}}
            <span class="inline-flex items-center bg-emerald-100 text-emerald-800 font-extrabold px-3 py-1 rounded-xl text-lg">
                {{ number_format($product->price, 2, ',', ' ') }}&nbsp;&euro;
            </span>

            {{-- Add to cart button with morph animation --}}
            <button
                type="button"
                @click="
                    if (added) return;
                    adding = true;
                    if (typeof addToCart === 'function') {
                        addToCart({{ $product->id }});
                        adding = false;
                        added = true;
                        setTimeout(() => { added = false; }, 2000);
                    } else {
                        adding = false;
                    }
                "
                :disabled="adding"
                class="add-to-cart-btn w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 cursor-pointer"
                :class="added ? 'bg-emerald-500 text-white scale-110' : 'bg-emerald-700 text-white hover:bg-emerald-600'"
                :aria-label="added ? 'Ajouté' : 'Ajouter au panier'"
            >
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
