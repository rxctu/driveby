@extends('layouts.app')

@section('title', 'Mon panier - EpiDrive')
@section('meta_description', 'Consultez votre panier EpiDrive et passez votre commande.')

@section('content')

    {{-- Page Header --}}
    <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-white rounded-full"></div>
            <div class="absolute -bottom-20 -left-10 w-96 h-96 bg-white rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12 relative">
            <nav class="mb-4">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white/90 hover:bg-white/30 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                            Accueil
                        </a>
                    </li>
                    <li><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-white/30 text-white font-medium backdrop-blur-sm">Panier</span></li>
                </ol>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Mon panier</h1>
            @if(isset($itemCount) && $itemCount > 0)
                <p class="mt-1 text-emerald-100">{{ $itemCount }} article{{ $itemCount > 1 ? 's' : '' }}</p>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        @if(isset($cartItems) && count($cartItems) > 0)
            <div class="lg:grid lg:grid-cols-3 lg:gap-8" style="animation: fadeInUp 0.5s ease-out both;">

                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $index => $item)
                        @php
                            $product = $item['product'];
                            $qty = $item['quantity'];
                            $lineTotal = $item['subtotal'];
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 flex items-start sm:items-center space-x-4 hover:shadow-md transition-all duration-300"
                             x-data="{ qty: {{ $qty }}, updating: false }"
                             style="animation: fadeInUp 0.4s ease-out {{ $index * 0.08 }}s both;">

                            {{-- Product Image --}}
                            <div class="flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-xl">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-emerald-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-400 mt-0.5">{{ number_format($product->price, 2, ',', ' ') }} &euro; / unite</p>

                                {{-- Quantity Controls --}}
                                <div class="flex items-center space-x-2 mt-3">
                                    <button @click="if(qty > 1) { qty--; updating = true; fetch('{{ route('cart.update') }}', {
                                                method: 'PATCH',
                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                                                body: JSON.stringify({ product_id: {{ $product->id }}, quantity: qty })
                                            }).then(() => location.reload()); }"
                                            class="w-8 h-8 rounded-full bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 flex items-center justify-center transition-all duration-200 active:scale-90 text-sm font-bold">
                                        -
                                    </button>
                                    <span class="w-8 text-center font-bold text-gray-800 text-sm" x-text="qty"></span>
                                    <button @click="qty++; updating = true; fetch('{{ route('cart.update') }}', {
                                                method: 'PATCH',
                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                                                body: JSON.stringify({ product_id: {{ $product->id }}, quantity: qty })
                                            }).then(() => location.reload());"
                                            class="w-8 h-8 rounded-full bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 flex items-center justify-center transition-all duration-200 active:scale-90 text-sm font-bold">
                                        +
                                    </button>
                                </div>
                            </div>

                            {{-- Line Total + Remove --}}
                            <div class="text-right flex-shrink-0 flex flex-col items-end space-y-2">
                                <p class="font-extrabold text-emerald-600 text-base sm:text-lg">
                                    {{ number_format($lineTotal, 2, ',', ' ') }} &euro;
                                </p>
                                <form method="POST" action="{{ route('cart.remove', $product->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 flex items-center justify-center transition-all duration-200 active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Cart Summary --}}
                <div class="mt-8 lg:mt-0">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-24">
                        {{-- Gradient Header --}}
                        <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                                Resume du panier
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Sous-total</span>
                                    <span class="font-semibold">{{ number_format($total ?? 0, 2, ',', ' ') }} &euro;</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Livraison</span>
                                    <span class="text-gray-400 italic text-xs">Calcule a la commande</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between text-lg font-extrabold text-gray-900">
                                        <span>Total</span>
                                        <span class="text-emerald-600">{{ number_format($total ?? 0, 2, ',', ' ') }} &euro;</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}"
                               class="mt-6 block w-full text-center font-bold py-3.5 rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-500 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                                Commander
                            </a>

                            <a href="{{ route('catalog.index') }}"
                               class="mt-3 block w-full text-center text-emerald-600 hover:text-emerald-700 font-medium text-sm transition">
                                Continuer vos achats
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky mobile CTA --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:hidden z-40 shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Total</span>
                    <span class="text-lg font-extrabold text-emerald-600">{{ number_format($total ?? 0, 2, ',', ' ') }} &euro;</span>
                </div>
                <a href="{{ route('checkout.index') }}"
                   class="block w-full text-center font-bold py-3.5 rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-500 active:scale-[0.98] transition-all duration-200">
                    Commander
                </a>
            </div>
            {{-- Spacer for sticky button on mobile --}}
            <div class="h-28 lg:hidden"></div>

        @else
            {{-- Empty Cart --}}
            <div class="text-center py-20" style="animation: fadeInUp 0.5s ease-out both;">
                <div class="text-8xl mb-6 animate-bounce">
                    &#x1F6D2;
                </div>
                <h2 class="text-2xl font-extrabold text-gray-800 mb-3">Votre panier est vide</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Parcourez notre catalogue et ajoutez des produits delicieux a votre panier.</p>
                <a href="{{ route('catalog.index') }}"
                   class="inline-flex items-center px-8 py-3.5 rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Decouvrir nos produits
                </a>
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

@endsection
