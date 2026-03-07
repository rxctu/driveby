@extends('layouts.app')

@section('title', 'Commande confirmee - EpiDrive')
@section('meta_description', 'Votre commande EpiDrive a ete confirmee avec succes.')

@section('content')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

        {{-- Confetti / Celebration Header --}}
        <div class="text-center mb-10" style="animation: fadeInUp 0.6s ease-out both;">

            {{-- Animated Checkmark --}}
            <div class="relative w-28 h-28 mx-auto mb-8">
                {{-- Outer ring --}}
                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-emerald-400 to-teal-400 animate-pulse opacity-30"></div>
                {{-- Main circle --}}
                <div class="absolute inset-2 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 shadow-xl shadow-emerald-200 flex items-center justify-center checkmark-circle">
                    <svg class="w-12 h-12 text-white checkmark-svg" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 13l4 4L19 7" class="checkmark-path"/>
                    </svg>
                </div>
                {{-- Decorative dots --}}
                <div class="absolute -top-2 -left-2 w-4 h-4 rounded-full bg-amber-400 confetti-dot" style="animation: confettiFloat 2s ease-in-out infinite;"></div>
                <div class="absolute -top-1 -right-3 w-3 h-3 rounded-full bg-purple-400 confetti-dot" style="animation: confettiFloat 2s ease-in-out 0.3s infinite;"></div>
                <div class="absolute -bottom-1 -left-3 w-3 h-3 rounded-full bg-pink-400 confetti-dot" style="animation: confettiFloat 2s ease-in-out 0.6s infinite;"></div>
                <div class="absolute -bottom-2 -right-2 w-4 h-4 rounded-full bg-yellow-400 confetti-dot" style="animation: confettiFloat 2s ease-in-out 0.9s infinite;"></div>
                <div class="absolute top-1/2 -left-4 w-2 h-2 rounded-full bg-emerald-300 confetti-dot" style="animation: confettiFloat 2s ease-in-out 1.2s infinite;"></div>
                <div class="absolute top-1/2 -right-4 w-2 h-2 rounded-full bg-teal-300 confetti-dot" style="animation: confettiFloat 2s ease-in-out 1.5s infinite;"></div>
            </div>

            {{-- Celebration emojis --}}
            <div class="flex justify-center space-x-2 text-3xl mb-4" style="animation: fadeInUp 0.6s ease-out 0.3s both;">
                <span style="animation: confettiBounce 1s ease-in-out 0.5s both;">&#x1F389;</span>
                <span style="animation: confettiBounce 1s ease-in-out 0.7s both;">&#x1F38A;</span>
                <span style="animation: confettiBounce 1s ease-in-out 0.9s both;">&#x1F389;</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3" style="animation: fadeInUp 0.6s ease-out 0.2s both;">
                Merci pour votre commande !
            </h1>
            <p class="text-gray-500 text-lg" style="animation: fadeInUp 0.6s ease-out 0.3s both;">
                Votre commande a ete enregistree avec succes.
            </p>
        </div>

        {{-- Order Details Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden" style="animation: fadeInUp 0.6s ease-out 0.4s both;">

            {{-- Order Number Header --}}
            <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 sm:px-8 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm">Numero de commande</p>
                        <p class="text-2xl font-extrabold text-white tracking-wide">#{{ $order->order_number ?? 'N/A' }}</p>
                    </div>
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-white/20 text-white backdrop-blur-sm">
                        <span class="relative mr-2 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                        </span>
                        En preparation
                    </span>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                {{-- Order Items --}}
                <div class="mb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Articles commandes
                    </h2>
                    <div class="space-y-3">
                        @foreach($order->items ?? [] as $item)
                            <div class="flex items-center justify-between text-sm bg-gray-50 rounded-xl p-3">
                                <div>
                                    <p class="text-gray-800 font-semibold">{{ $item->product_name ?? ($item->product->name ?? 'Produit') }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Quantite : {{ $item->quantity }} &times; {{ number_format($item->unit_price ?? $item->price ?? 0, 2, ',', ' ') }} &euro;</p>
                                </div>
                                <span class="font-bold text-gray-700">{{ number_format(($item->total_price ?? (($item->price ?? 0) * $item->quantity)), 2, ',', ' ') }} &euro;</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Totals --}}
                <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Sous-total</span>
                        <span class="font-semibold">{{ number_format($order->subtotal ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Livraison</span>
                        <span class="font-semibold">
                            @if(($order->delivery_fee ?? 0) == 0)
                                <span class="text-emerald-600">Gratuite</span>
                            @else
                                {{ number_format($order->delivery_fee ?? 0, 2, ',', ' ') }} &euro;
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-lg font-extrabold text-gray-900 pt-3 border-t border-gray-200">
                        <span>Total</span>
                        <span class="text-emerald-600">{{ number_format($order->total ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                </div>

                {{-- Delivery Info --}}
                <div class="mt-6 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-emerald-800">Livraison estimee</p>
                            <p class="text-sm text-emerald-700 mt-1">
                                @if($order->delivery_date ?? false)
                                    {{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('l d F Y') }}
                                @else
                                    Date a confirmer
                                @endif
                                @if($order->delivery_slot ?? false)
                                    entre {{ $order->delivery_slot }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4" style="animation: fadeInUp 0.6s ease-out 0.6s both;">
            @auth
                <a href="{{ route('account.orders') }}"
                   class="w-full sm:w-auto text-center font-bold px-8 py-3.5 rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-500 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 transition-all duration-300">
                    Voir mes commandes
                </a>
            @endauth
            <a href="{{ route('home') }}"
               class="w-full sm:w-auto text-center font-bold px-8 py-3.5 rounded-xl border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                Retour a l'accueil
            </a>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes confettiFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(180deg); }
        }

        @keyframes confettiBounce {
            0% { opacity: 0; transform: scale(0) translateY(20px); }
            60% { opacity: 1; transform: scale(1.2) translateY(-5px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .checkmark-path {
            stroke-dasharray: 30;
            stroke-dashoffset: 30;
            animation: drawCheck 0.6s ease-out 0.8s forwards;
        }

        @keyframes drawCheck {
            to { stroke-dashoffset: 0; }
        }

        .checkmark-circle {
            animation: scaleIn 0.4s ease-out 0.4s both;
        }

        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
    </style>

@endsection
