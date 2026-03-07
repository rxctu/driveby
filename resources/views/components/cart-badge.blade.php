{{-- Cart icon with count badge — reads from Alpine store('cart') --}}
<a
    href="{{ route('panier') }}"
    class="relative inline-flex items-center p-2 text-gray-600 hover:text-primary-600 transition-colors"
    x-data
    aria-label="Panier"
>
    {{-- Cart icon --}}
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
    </svg>

    {{-- Count badge --}}
    <span
        x-show="$store.cart.count > 0"
        x-text="$store.cart.count"
        x-transition
        class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-xs font-bold text-white bg-primary-600 rounded-full"
        data-cart-count="{{ $cartCount ?? 0 }}"
        style="display: none;"
    ></span>
</a>
