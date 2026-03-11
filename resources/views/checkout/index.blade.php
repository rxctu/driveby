@extends('layouts.app')

@section('title', 'Commander - EpiDrive')
@section('meta_description', 'Finalisez votre commande EpiDrive. Livraison rapide a domicile.')

@section('content')

    {{-- Page Header --}}
    <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-white rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 relative">
            <nav class="mb-4">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white/90 hover:bg-white/30 transition backdrop-blur-sm">Accueil</a>
                    </li>
                    <li><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li>
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white/90 hover:bg-white/30 transition backdrop-blur-sm">Panier</a>
                    </li>
                    <li><svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></li>
                    <li><span class="inline-flex items-center px-3 py-1 rounded-full bg-white/30 text-white font-medium backdrop-blur-sm">Commander</span></li>
                </ol>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Finaliser la commande</h1>
        </div>
    </div>

    {{-- Step Indicator --}}
    <div class="bg-white border-b border-gray-100 sticky top-16 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4" x-data="{ step: 1 }">
            <div class="flex items-center justify-center space-x-4 sm:space-x-8">
                {{-- Step 1 --}}
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-sm font-bold shadow-md shadow-emerald-200">1</div>
                    <span class="hidden sm:inline text-sm font-semibold text-emerald-700">Livraison</span>
                </div>
                <div class="w-8 sm:w-16 h-0.5 bg-gray-200 rounded-full"></div>
                {{-- Step 2 --}}
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">2</div>
                    <span class="hidden sm:inline text-sm font-medium text-gray-500">Paiement</span>
                </div>
                <div class="w-8 sm:w-16 h-0.5 bg-gray-200 rounded-full"></div>
                {{-- Step 3 --}}
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">3</div>
                    <span class="hidden sm:inline text-sm font-medium text-gray-500">Confirmation</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        <form method="POST" action="{{ route('checkout.store') }}" x-data="checkoutForm()" @submit="handleSubmit($event)" class="lg:grid lg:grid-cols-3 lg:gap-8">
            @csrf

            {{-- Checkout Form --}}
            <div class="lg:col-span-2 space-y-6" style="animation: fadeInUp 0.5s ease-out both;">

                {{-- Delivery Information --}}
                <div id="delivery-address-section" class="bg-white rounded-2xl shadow-sm border overflow-hidden transition-all duration-300"
                     :class="addressError ? 'border-red-300 ring-2 ring-red-200' : (addressValid ? 'border-emerald-300 ring-2 ring-emerald-100' : 'border-gray-100')">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-emerald-100">
                        <h2 class="text-lg font-bold text-emerald-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Informations de livraison
                            {{-- Address status indicator --}}
                            <span x-show="addressValid" x-cloak class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Adresse validee
                            </span>
                            <span x-show="addressError && !addressValid" x-cloak class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                Hors zone
                            </span>
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="relative">
                                <label for="delivery_name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet</label>
                                <input type="text" id="delivery_name" name="delivery_name" value="{{ old('delivery_name', $user->name ?? '') }}" required
                                       class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition"
                                       placeholder="Jean Dupont">
                                @error('delivery_name')
                                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="delivery_email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                                <input type="email" id="delivery_email" name="delivery_email" value="{{ old('delivery_email', $user->email ?? '') }}" required
                                       class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition"
                                       placeholder="jean@exemple.fr">
                                @error('delivery_email')
                                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="delivery_phone" class="block text-sm font-semibold text-gray-700 mb-1.5">Telephone</label>
                            <input type="tel" id="delivery_phone" name="delivery_phone" value="{{ old('delivery_phone', $user->phone ?? '') }}" required
                                   placeholder="+33 6 12 34 56 78"
                                   class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                            @error('delivery_phone')
                                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="delivery_address" class="block text-sm font-semibold text-gray-700">Adresse de livraison</label>
                                <button type="button" @click="useGPS()"
                                        :disabled="gpsLoading"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition border"
                                        :class="gpsLoading ? 'bg-gray-100 text-gray-400 border-gray-200 cursor-wait' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100'">
                                    <svg x-show="!gpsLoading" class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    <svg x-show="gpsLoading" x-cloak class="w-3.5 h-3.5 mr-1.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    <span x-text="gpsLoading ? 'Localisation...' : 'Me localiser'"></span>
                                </button>
                            </div>
                            <input type="text" id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" required
                                   placeholder="12 Rue du Commerce"
                                   @input.debounce.800ms="recalcDelivery()"
                                   class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                            <p x-show="gpsError" x-cloak x-text="gpsError" class="mt-1 text-xs text-red-500 font-medium"></p>
                            @error('delivery_address')
                                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="delivery_city" class="block text-sm font-semibold text-gray-700 mb-1.5">Ville</label>
                                <input type="text" id="delivery_city" name="delivery_city" value="{{ old('delivery_city') }}" required
                                       placeholder="Ambert"
                                       @input.debounce.800ms="recalcDelivery()"
                                       class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                                @error('delivery_city')
                                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="delivery_postal_code" class="block text-sm font-semibold text-gray-700 mb-1.5">Code postal</label>
                                <input type="text" id="delivery_postal_code" name="delivery_postal_code" value="{{ old('delivery_postal_code') }}" required
                                       placeholder="63600" maxlength="5"
                                       @input.debounce.800ms="recalcDelivery()"
                                       class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                                @error('delivery_postal_code')
                                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Address validation error --}}
                        <div x-show="addressError" x-cloak class="flex items-center p-3 bg-red-50 rounded-xl border border-red-200">
                            <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                            <p class="text-sm text-red-600 font-semibold" x-text="addressError"></p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Instructions de livraison <span class="text-gray-400 font-normal">(optionnel)</span></label>
                            <textarea id="notes" name="notes" rows="3"
                                      placeholder="Digicode, etage, sonnette..."
                                      class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Delivery Slot --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 px-6 py-4 border-b border-amber-100">
                        <h2 class="text-lg font-bold text-amber-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Creneau de livraison
                        </h2>
                    </div>
                    <div class="p-6">
                        @if(isset($deliverySlots) && $deliverySlots->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($deliverySlots as $slot)
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="delivery_slot_id" value="{{ $slot->id }}"
                                               class="peer sr-only" {{ old('delivery_slot_id') == $slot->id ? 'checked' : '' }}>
                                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300 transition-all duration-200 group-hover:shadow-md">
                                            <p class="font-bold text-gray-800 text-sm">{{ $slot->date ? \Carbon\Carbon::parse($slot->date)->translatedFormat('l d M') : $slot->day_name ?? '' }}</p>
                                            <p class="text-emerald-600 font-semibold text-sm mt-0.5">
                                                {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                            </p>
                                            @if(isset($slot->remaining_capacity))
                                                <p class="text-xs text-gray-400 mt-1">{{ $slot->remaining_capacity }} place{{ $slot->remaining_capacity > 1 ? 's' : '' }}</p>
                                            @endif
                                        </div>
                                        <div class="absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all duration-200 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Aucun creneau de livraison disponible pour le moment.</p>
                        @endif
                        @error('delivery_slot_id')
                            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror

                        {{-- Delivery Fee Info (dynamic) --}}
                        <div class="mt-4 p-4 rounded-xl border transition-all duration-300"
                             :class="deliveryError ? 'bg-red-50 border-red-200' : 'bg-emerald-50 border-emerald-100'">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium flex items-center" :class="deliveryError ? 'text-red-700' : 'text-emerald-700'">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                    Frais de livraison
                                </span>
                                <span class="text-sm font-bold">
                                    <template x-if="deliveryLoading">
                                        <span class="text-gray-400">Calcul...</span>
                                    </template>
                                    <template x-if="!deliveryLoading && !deliveryError">
                                        <span class="text-emerald-700" x-text="deliveryFee == 0 ? 'Gratuite !' : deliveryFee.toFixed(2).replace('.', ',') + ' \u20AC'"></span>
                                    </template>
                                    <template x-if="!deliveryLoading && deliveryError">
                                        <span class="text-red-600">Indisponible</span>
                                    </template>
                                </span>
                            </div>
                            <p x-show="distanceKm > 0 && !deliveryError" x-cloak class="text-xs text-emerald-600 mt-1" x-text="distanceKm + ' km depuis le magasin'"></p>
                            <p x-show="deliveryError" x-cloak class="text-xs text-red-600 mt-1 font-medium" x-text="deliveryError"></p>
                            <p x-show="!deliveryError && deliveryFee > 0" x-cloak class="text-xs text-emerald-600 mt-1">Livraison gratuite a partir de {{ number_format($freeDeliveryThreshold, 0) }} &euro; d'achats</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-violet-50 px-6 py-4 border-b border-purple-100">
                        <h2 class="text-lg font-bold text-purple-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Mode de paiement
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        {{-- Cash on delivery --}}
                        <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                               :class="paymentMethod === 'cash' ? 'border-emerald-500 bg-emerald-50 shadow-md shadow-emerald-100' : 'border-gray-200 hover:border-emerald-300'">
                            <input type="radio" name="payment_method" value="cash" x-model="paymentMethod"
                                   class="text-emerald-600 focus:ring-emerald-500" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}>
                            <div class="ml-4 flex items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <span class="text-xl">&#x1F4B5;</span>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-800">Paiement a la livraison</span>
                                    <p class="text-xs text-gray-500">Especes ou carte bancaire (terminal de paiement)</p>
                                </div>
                            </div>
                        </label>

                        @if($onlinePaymentsEnabled)
                        {{-- Card --}}
                        <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                               :class="paymentMethod === 'stripe' ? 'border-emerald-500 bg-emerald-50 shadow-md shadow-emerald-100' : 'border-gray-200 hover:border-emerald-300'">
                            <input type="radio" name="payment_method" value="stripe" x-model="paymentMethod"
                                   class="text-emerald-600 focus:ring-emerald-500" {{ old('payment_method') == 'stripe' ? 'checked' : '' }}>
                            <div class="ml-4 flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-xl">&#x1F4B3;</span>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-800">Carte bancaire</span>
                                    <p class="text-xs text-gray-500">Paiement securise par carte</p>
                                </div>
                            </div>
                        </label>

                        {{-- PayPal --}}
                        <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                               :class="paymentMethod === 'paypal' ? 'border-emerald-500 bg-emerald-50 shadow-md shadow-emerald-100' : 'border-gray-200 hover:border-emerald-300'">
                            <input type="radio" name="payment_method" value="paypal" x-model="paymentMethod"
                                   class="text-emerald-600 focus:ring-emerald-500" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                            <div class="ml-4 flex items-center">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                    <span class="text-lg font-bold text-indigo-600">P</span>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-800">PayPal</span>
                                    <p class="text-xs text-gray-500">Payez avec votre compte PayPal</p>
                                </div>
                            </div>
                        </label>
                        @endif

                        @error('payment_method')
                            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror

                        @if($onlinePaymentsEnabled)
                        {{-- Stripe Card Placeholder --}}
                        <div x-show="paymentMethod === 'stripe'" x-transition x-cloak class="mt-4">
                            <div id="stripe-card-element" class="p-4 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                                <p class="text-sm text-gray-500 text-center">Le formulaire de paiement par carte se chargera ici.</p>
                            </div>
                        </div>
                        @else
                        <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-xl">
                            <p class="text-sm text-amber-700 flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Le paiement s'effectue a la livraison (especes ou CB via terminal).
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Terms --}}
                <div id="terms-section"
                     class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 @error('terms_accepted') border-red-300 ring-2 ring-red-200 animate-shake @enderror"
                     x-data="{ accepted: {{ old('terms_accepted') ? 'true' : 'false' }} }">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" name="terms_accepted" value="1" x-model="accepted"
                               class="mt-0.5 text-emerald-600 focus:ring-emerald-500 rounded" {{ old('terms_accepted') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-600">J'accepte les <a href="{{ route('legal.cgv') }}" target="_blank" class="text-emerald-600 underline hover:text-emerald-700">conditions generales de vente</a></span>
                    </label>
                    @error('terms_accepted')
                        <div class="mt-3 flex items-center p-3 bg-red-50 rounded-xl border border-red-200">
                            <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                            <p class="text-sm text-red-600 font-semibold">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Order Summary Sidebar --}}
            <div class="mt-8 lg:mt-0" style="animation: fadeInUp 0.5s ease-out 0.15s both;">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-36">
                    {{-- Gradient Header --}}
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            Votre commande
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                            @foreach($cartItems ?? [] as $item)
                                @php $p = $item['product']; @endphp
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-800 truncate font-medium">{{ $p->name }}</p>
                                        <p class="text-xs text-gray-400">x{{ $item['quantity'] }}</p>
                                    </div>
                                    <span class="text-gray-700 font-bold ml-2">
                                        {{ number_format($item['subtotal'], 2, ',', ' ') }} &euro;
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Promo Code --}}
                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <div x-show="!promoApplied" class="space-y-2">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Code promo</label>
                                <div class="flex gap-2">
                                    <input type="text" x-model="promoCode" name="promo_code" placeholder="Ex: BIENVENUE"
                                           class="flex-1 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5 px-3 uppercase"
                                           :class="promoError ? 'border-red-300 ring-1 ring-red-200' : ''"
                                           @keydown.enter.prevent="applyPromo()">
                                    <button type="button" @click="applyPromo()"
                                            :disabled="promoLoading || !promoCode.trim()"
                                            class="px-4 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span x-show="!promoLoading">OK</span>
                                        <svg x-show="promoLoading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    </button>
                                </div>
                                <p x-show="promoError" x-text="promoError" x-cloak class="text-xs text-red-500 font-medium"></p>
                            </div>
                            <div x-show="promoApplied" x-cloak class="flex items-center justify-between bg-emerald-50 rounded-xl px-3 py-2.5 border border-emerald-200">
                                <div class="flex items-center">
                                    <span class="text-emerald-600 mr-2">&#127881;</span>
                                    <div>
                                        <span class="text-sm font-bold text-emerald-700" x-text="promoCode.toUpperCase()"></span>
                                        <span class="text-xs text-emerald-600 ml-1" x-text="promoLabel"></span>
                                    </div>
                                </div>
                                <button type="button" @click="removePromo()" class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <input type="hidden" name="promo_discount" :value="promoDiscount">
                            <input type="hidden" name="promo_code_applied" :value="promoApplied ? promoCode : ''">
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Sous-total</span>
                                <span class="font-semibold">{{ number_format($subtotal ?? 0, 2, ',', ' ') }} &euro;</span>
                            </div>
                            <div x-show="promoApplied" x-cloak class="flex justify-between text-emerald-600">
                                <span>Reduction</span>
                                <span class="font-semibold" x-text="'-' + promoDiscount.toFixed(2).replace('.', ',') + ' \u20AC'"></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>
                                    Livraison
                                    <span x-show="distanceKm > 0" x-cloak class="text-xs text-gray-400" x-text="'(' + distanceKm + ' km)'"></span>
                                </span>
                                <span class="font-semibold">
                                    <span x-show="deliveryLoading" x-cloak class="text-gray-400">...</span>
                                    <span x-show="!deliveryLoading && !deliveryError" :class="deliveryFee == 0 ? 'text-emerald-600' : ''" x-text="deliveryFee == 0 ? 'Gratuite' : deliveryFee.toFixed(2).replace('.', ',') + ' \u20AC'"></span>
                                    <span x-show="!deliveryLoading && deliveryError" x-cloak class="text-red-500 text-xs">Hors zone</span>
                                </span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between text-lg font-extrabold text-gray-900">
                                    <span>Total</span>
                                    <span class="text-emerald-600" x-text="computedTotal()"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                                :disabled="!addressValid || deliveryError"
                                class="mt-6 w-full py-4 rounded-xl font-bold text-lg text-white transition-all duration-300"
                                :class="(!addressValid || deliveryError) ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-emerald-600 to-teal-500 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 active:translate-y-0'">
                            Confirmer la commande
                        </button>

                        <p class="text-xs text-gray-400 text-center mt-3">
                            Paiement securise. Vos donnees sont protegees.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        [x-cloak] { display: none !important; }
    </style>

    <script>
        function checkoutForm() {
            return {
                paymentMethod: '{{ old('payment_method', 'cash') }}',
                promoCode: '{{ old('promo_code_applied', '') }}',
                promoDiscount: {{ old('promo_discount', 0) }},
                promoApplied: {{ old('promo_code_applied') ? 'true' : 'false' }},
                promoLabel: '',
                promoError: '',
                promoLoading: false,
                subtotal: {{ $subtotal ?? 0 }},
                deliveryFee: {{ $deliveryFee ?? 0 }},
                deliveryLoading: false,
                deliveryError: '',
                distanceKm: 0,
                addressValid: false,
                addressError: '',
                gpsLoading: false,
                gpsError: '',
                _deliveryTimeout: null,

                computedTotal() {
                    if (this.deliveryError) {
                        const total = Math.max(0, this.subtotal - this.promoDiscount);
                        return total.toFixed(2).replace('.', ',') + ' \u20AC';
                    }
                    const total = Math.max(0, this.subtotal - this.promoDiscount) + this.deliveryFee;
                    return total.toFixed(2).replace('.', ',') + ' \u20AC';
                },

                async useGPS() {
                    if (!navigator.geolocation) {
                        this.gpsError = 'La geolocalisation n\'est pas supportee par votre navigateur.';
                        return;
                    }

                    this.gpsLoading = true;
                    this.gpsError = '';

                    navigator.geolocation.getCurrentPosition(
                        async (position) => {
                            try {
                                const res = await fetch('{{ route("checkout.reverse-geocode") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                    },
                                    body: JSON.stringify({
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    })
                                });

                                if (!res.ok) {
                                    const err = await res.json();
                                    this.gpsError = err.error || 'Impossible de determiner l\'adresse.';
                                    this.gpsLoading = false;
                                    return;
                                }

                                const data = await res.json();

                                if (data.address) {
                                    document.getElementById('delivery_address').value = data.address;
                                }
                                if (data.city) {
                                    document.getElementById('delivery_city').value = data.city;
                                }
                                if (data.postal_code) {
                                    document.getElementById('delivery_postal_code').value = data.postal_code;
                                }

                                this.gpsLoading = false;
                                this.recalcDelivery();
                            } catch (err) {
                                this.gpsError = 'Erreur lors de la localisation.';
                                this.gpsLoading = false;
                            }
                        },
                        (error) => {
                            this.gpsLoading = false;
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    this.gpsError = 'Vous avez refuse l\'acces a la localisation.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    this.gpsError = 'Position indisponible.';
                                    break;
                                case error.TIMEOUT:
                                    this.gpsError = 'Delai de localisation depasse.';
                                    break;
                                default:
                                    this.gpsError = 'Erreur de geolocalisation.';
                            }
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
                    );
                },

                async recalcDelivery() {
                    const address = document.getElementById('delivery_address')?.value?.trim();
                    const city = document.getElementById('delivery_city')?.value?.trim();
                    const postalCode = document.getElementById('delivery_postal_code')?.value?.trim();

                    if (!address || !city || !postalCode || postalCode.length < 5) {
                        this.addressValid = false;
                        return;
                    }

                    // Quick pre-filter: postal code must start with 63
                    if (!postalCode.startsWith('63')) {
                        this.addressValid = false;
                        this.addressError = '';
                        this.deliveryError = 'Nous livrons uniquement dans le departement 63 (Puy-de-Dome)';
                        this.deliveryFee = 0;
                        this.distanceKm = 0;
                        return;
                    }

                    this.deliveryLoading = true;
                    this.deliveryError = '';
                    this.addressError = '';

                    try {
                        const res = await fetch('{{ route("checkout.delivery.estimate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ address, city, postal_code: postalCode })
                        });

                        const data = await res.json();

                        if (data.available) {
                            this.deliveryFee = data.delivery_fee;
                            this.distanceKm = data.distance_km;
                            this.deliveryError = '';
                            this.addressValid = true;
                            this.addressError = '';
                        } else {
                            this.deliveryError = data.message || 'Livraison indisponible.';
                            this.deliveryFee = 0;
                            this.distanceKm = data.distance_km || 0;
                            this.addressValid = false;
                            this.addressError = this.deliveryError;
                        }
                    } catch (err) {
                        this.deliveryError = 'Erreur lors du calcul de la livraison.';
                        this.addressValid = false;
                        this.addressError = this.deliveryError;
                    }

                    this.deliveryLoading = false;
                },

                async applyPromo() {
                    if (!this.promoCode.trim()) return;
                    this.promoLoading = true;
                    this.promoError = '';

                    try {
                        const res = await fetch('{{ route("checkout.apply-promo") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({
                                code: this.promoCode.trim().toUpperCase(),
                                subtotal: this.subtotal
                            })
                        });

                        const data = await res.json();

                        if (data.valid) {
                            this.promoDiscount = data.discount;
                            this.promoLabel = data.label;
                            this.promoApplied = true;
                            this.promoError = '';
                        } else {
                            this.promoError = data.message || 'Code promo invalide.';
                            this.promoDiscount = 0;
                            this.promoApplied = false;
                        }
                    } catch (err) {
                        this.promoError = 'Erreur lors de la verification du code.';
                    }

                    this.promoLoading = false;
                },

                removePromo() {
                    this.promoCode = '';
                    this.promoDiscount = 0;
                    this.promoApplied = false;
                    this.promoLabel = '';
                    this.promoError = '';
                },

                handleSubmit(e) {
                    // Check address validation
                    if (!this.addressValid || this.deliveryError) {
                        e.preventDefault();
                        this.addressError = this.deliveryError || 'Veuillez saisir une adresse de livraison valide dans notre zone de livraison.';
                        const addressSection = document.getElementById('delivery-address-section');
                        if (addressSection) {
                            addressSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            addressSection.classList.add('animate-shake', 'border-red-300', 'ring-2', 'ring-red-200');
                            setTimeout(() => {
                                addressSection.classList.remove('animate-shake');
                            }, 800);
                        }
                        return false;
                    }

                    const checkbox = this.$el.querySelector('input[name="terms_accepted"]');
                    if (!checkbox || !checkbox.checked) {
                        e.preventDefault();
                        const section = document.getElementById('terms-section');
                        if (section) {
                            section.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            section.classList.add('animate-shake', 'border-red-300', 'ring-2', 'ring-red-200');
                            setTimeout(() => {
                                section.classList.remove('animate-shake');
                            }, 800);
                        }
                        return false;
                    }
                    return true;
                }
            }
        }
    </script>

@endsection
