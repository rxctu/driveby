@extends('layouts.app')

@section('title', 'Commande confirmee - EpiDrive')
@section('meta_description', 'Votre commande EpiDrive a ete confirmee avec succes.')

@section('content')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16"
         x-data="orderTracker()"
         x-init="initEcho()">

        {{-- Confetti / Celebration Header --}}
        <div class="text-center mb-10" style="animation: fadeInUp 0.6s ease-out both;">

            {{-- Animated Checkmark (default) / Truck (delivering) / Celebration (delivered) --}}
            <div class="relative w-28 h-28 mx-auto mb-8">
                {{-- Outer ring --}}
                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-emerald-400 to-teal-400 animate-pulse opacity-30"></div>

                {{-- Default checkmark icon --}}
                <div x-show="currentStatus !== 'delivering' && currentStatus !== 'delivered'"
                     class="absolute inset-2 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 shadow-xl shadow-emerald-200 flex items-center justify-center checkmark-circle">
                    <svg class="w-12 h-12 text-white checkmark-svg" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 13l4 4L19 7" class="checkmark-path"/>
                    </svg>
                </div>

                {{-- Truck icon for delivering --}}
                <div x-show="currentStatus === 'delivering'" x-cloak
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-50"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute inset-2 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 shadow-xl shadow-purple-200 flex items-center justify-center"
                     style="animation: truckBounce 1.5s ease-in-out infinite;">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>

                {{-- Star icon for delivered --}}
                <div x-show="currentStatus === 'delivered'" x-cloak
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-50"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute inset-2 rounded-full bg-gradient-to-br from-amber-400 to-yellow-500 shadow-xl shadow-amber-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
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

            {{-- Special status messages --}}
            <div x-show="currentStatus === 'delivering'" x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mt-4 inline-flex items-center space-x-2 bg-purple-100 text-purple-800 font-bold px-6 py-3 rounded-xl"
                 style="animation: truckBounce 2s ease-in-out infinite;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                </svg>
                <span>Votre livreur est en route !</span>
            </div>

            <div x-show="currentStatus === 'delivered'" x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-75"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="mt-4 inline-flex items-center space-x-2 bg-amber-100 text-amber-800 font-extrabold px-6 py-3 rounded-xl text-lg"
                 style="animation: celebrationPulse 1s ease-in-out infinite;">
                <span>&#x1F389;</span>
                <span>Commande livree !</span>
                <span>&#x1F389;</span>
            </div>

            <div x-show="currentStatus === 'cancelled'" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 class="mt-4 inline-flex items-center space-x-2 bg-red-100 text-red-800 font-bold px-6 py-3 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>Commande annulee</span>
            </div>
        </div>

        {{-- Status Stepper --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 mb-6" style="animation: fadeInUp 0.6s ease-out 0.35s both;">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6 flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                Suivi de commande
                <span x-show="polling" class="ml-2 inline-flex items-center">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </span>
            </h2>

            {{-- Desktop stepper (horizontal) --}}
            <div class="hidden sm:block">
                <div class="flex items-center justify-between relative">
                    {{-- Progress bar background --}}
                    <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 rounded-full" style="margin-left: 40px; margin-right: 40px;"></div>
                    {{-- Progress bar fill --}}
                    <div class="absolute top-5 left-0 h-1 bg-emerald-500 rounded-full transition-all duration-700 ease-out"
                         :style="'margin-left: 40px; width: calc(' + progressPercent + '% - 80px);'"></div>

                    <template x-for="(step, index) in steps" :key="step.key">
                        <div class="flex flex-col items-center relative z-10" style="width: 80px;">
                            {{-- Step circle --}}
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-500 border-2"
                                 :class="stepClass(index)">
                                <template x-if="isStepComplete(index)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="isStepActive(index) && !isStepComplete(index)">
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                                    </span>
                                </template>
                                <template x-if="!isStepComplete(index) && !isStepActive(index)">
                                    <span x-text="index + 1"></span>
                                </template>
                            </div>
                            {{-- Step label --}}
                            <p class="text-xs font-bold mt-2 text-center transition-colors duration-300"
                               :class="isStepActive(index) || isStepComplete(index) ? 'text-emerald-700' : 'text-gray-400'"
                               x-text="step.label"></p>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Mobile stepper (vertical) --}}
            <div class="sm:hidden space-y-4">
                <template x-for="(step, index) in steps" :key="step.key">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 transition-all duration-500 border-2"
                             :class="stepClass(index)">
                            <template x-if="isStepComplete(index)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="isStepActive(index) && !isStepComplete(index)">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                </span>
                            </template>
                            <template x-if="!isStepComplete(index) && !isStepActive(index)">
                                <span x-text="index + 1"></span>
                            </template>
                        </div>
                        <p class="text-sm font-bold transition-colors duration-300"
                           :class="isStepActive(index) || isStepComplete(index) ? 'text-emerald-700' : 'text-gray-400'"
                           x-text="step.label"></p>
                        <span x-show="isStepActive(index) && !isStepComplete(index)"
                              class="ml-auto text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            En cours
                        </span>
                    </div>
                </template>
            </div>
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
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-white/20 text-white backdrop-blur-sm transition-all duration-300">
                        <span x-show="currentStatus !== 'delivered' && currentStatus !== 'cancelled'" class="relative mr-2 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                        </span>
                        <span x-text="statusLabel"></span>
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

                {{-- QR Code for Pickup Validation --}}
                @if($order->validation_code)
                    <div class="mt-6 p-5 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border border-amber-200 text-center">
                        <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wider mb-3 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            Code de retrait
                        </h3>
                        @php $qrDataUri = $order->qrCodeDataUri(); @endphp
                        @if($qrDataUri)
                            <img src="{{ $qrDataUri }}" alt="QR Code de validation" class="w-40 h-40 mx-auto mb-3 rounded-lg shadow-sm">
                        @endif
                        <p class="font-mono text-2xl font-extrabold text-amber-900 tracking-[0.3em]">{{ $order->validation_code }}</p>
                        <p class="text-xs text-amber-700 mt-2">Presentez ce code lors du retrait en magasin pour valider votre commande.</p>
                    </div>
                @endif

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
        [x-cloak] { display: none !important; }

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

        @keyframes truckBounce {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px) rotate(-2deg); }
            75% { transform: translateX(3px) rotate(2deg); }
        }

        @keyframes celebrationPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .step-highlight {
            animation: stepPop 0.5s ease-out;
        }

        @keyframes stepPop {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
    </style>

    <script>
        function orderTracker() {
            return {
                currentStatus: '{{ $order->status ?? "pending" }}',
                previousStatus: '',
                polling: true,
                paymentStatus: '{{ $order->payment_status ?? "pending" }}',
                steps: [
                    { key: 'pending', label: 'En attente' },
                    { key: 'confirmed', label: 'Confirmee' },
                    { key: 'processing', label: 'En preparation' },
                    { key: 'delivering', label: 'En livraison' },
                    { key: 'delivered', label: 'Livree' }
                ],
                statusLabels: {
                    'pending': 'En attente',
                    'confirmed': 'Confirmee',
                    'processing': 'En preparation',
                    'delivering': 'En livraison',
                    'delivered': 'Livree',
                    'cancelled': 'Annulee',
                    'shipped': 'En livraison'
                },

                get statusLabel() {
                    return this.statusLabels[this.currentStatus] || this.currentStatus;
                },

                get currentStepIndex() {
                    let idx = this.steps.findIndex(s => s.key === this.currentStatus);
                    if (this.currentStatus === 'shipped') idx = 3; // map shipped to delivering
                    return idx;
                },

                get progressPercent() {
                    let idx = this.currentStepIndex;
                    if (idx < 0) return 0;
                    return (idx / (this.steps.length - 1)) * 100;
                },

                isStepComplete(index) {
                    return index < this.currentStepIndex;
                },

                isStepActive(index) {
                    return index === this.currentStepIndex;
                },

                stepClass(index) {
                    if (this.isStepComplete(index)) {
                        return 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-200';
                    }
                    if (this.isStepActive(index)) {
                        return 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-300 step-highlight';
                    }
                    return 'bg-white border-gray-300 text-gray-400';
                },

                initEcho() {
                    // Don't listen if already at a terminal state
                    if (this.currentStatus === 'delivered' || this.currentStatus === 'cancelled') {
                        this.polling = false;
                        return;
                    }

                    if (!window.Echo) {
                        this.polling = false;
                        return;
                    }

                    window.Echo.channel('order.{{ $order->order_number }}')
                        .listen('OrderStatusUpdated', (e) => {
                            if (e.status && e.status !== this.currentStatus) {
                                this.previousStatus = this.currentStatus;
                                this.currentStatus = e.status;
                                if (e.payment_status) {
                                    this.paymentStatus = e.payment_status;
                                }

                                // Stop listening on terminal states
                                if (e.status === 'delivered' || e.status === 'cancelled') {
                                    this.polling = false;
                                }
                            }
                        });
                }
            };
        }
    </script>

@endsection
