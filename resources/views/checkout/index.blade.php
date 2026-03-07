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

        <form method="POST" action="{{ route('checkout.store') }}" x-data="checkoutForm()" class="lg:grid lg:grid-cols-3 lg:gap-8">
            @csrf

            {{-- Checkout Form --}}
            <div class="lg:col-span-2 space-y-6" style="animation: fadeInUp 0.5s ease-out both;">

                {{-- Delivery Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-emerald-100">
                        <h2 class="text-lg font-bold text-emerald-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Informations de livraison
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
                            <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse de livraison</label>
                            <input type="text" id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" required
                                   placeholder="12 Rue du Commerce"
                                   class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                            @error('delivery_address')
                                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="delivery_city" class="block text-sm font-semibold text-gray-700 mb-1.5">Ville</label>
                                <input type="text" id="delivery_city" name="delivery_city" value="{{ old('delivery_city') }}" required
                                       placeholder="Paris"
                                       class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                                @error('delivery_city')
                                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="delivery_postal_code" class="block text-sm font-semibold text-gray-700 mb-1.5">Code postal</label>
                                <input type="text" id="delivery_postal_code" name="delivery_postal_code" value="{{ old('delivery_postal_code') }}" required
                                       placeholder="75015" maxlength="5"
                                       class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3 px-4 transition">
                                @error('delivery_postal_code')
                                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
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

                        {{-- Delivery Fee Info --}}
                        <div class="mt-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-emerald-700 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                    Frais de livraison
                                </span>
                                <span class="text-sm font-bold text-emerald-700">
                                    @if(($deliveryFee ?? 0) == 0)
                                        <span class="text-emerald-600">Gratuite !</span>
                                    @else
                                        {{ number_format($deliveryFee ?? 4.99, 2, ',', ' ') }} &euro;
                                    @endif
                                </span>
                            </div>
                            @if(isset($freeDeliveryThreshold) && ($deliveryFee ?? 0) > 0)
                                <p class="text-xs text-emerald-600 mt-1">Livraison gratuite a partir de {{ number_format($freeDeliveryThreshold, 0) }} &euro; d'achats</p>
                            @endif
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
                                    <p class="text-xs text-gray-500">Payez en especes a la reception</p>
                                </div>
                            </div>
                        </label>

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

                        @error('payment_method')
                            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror

                        {{-- Stripe Card Placeholder --}}
                        <div x-show="paymentMethod === 'stripe'" x-transition x-cloak class="mt-4">
                            <div id="stripe-card-element" class="p-4 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                                <p class="text-sm text-gray-500 text-center">Le formulaire de paiement par carte se chargera ici.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" name="terms_accepted" value="1" class="mt-0.5 text-emerald-600 focus:ring-emerald-500 rounded" {{ old('terms_accepted') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-600">J'accepte les <a href="{{ route('legal.cgv') }}" target="_blank" class="text-emerald-600 underline hover:text-emerald-700">conditions generales de vente</a></span>
                    </label>
                    @error('terms_accepted')
                        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
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

                        <div class="border-t border-gray-200 mt-4 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Sous-total</span>
                                <span class="font-semibold">{{ number_format($subtotal ?? 0, 2, ',', ' ') }} &euro;</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Livraison</span>
                                <span class="font-semibold">
                                    @if(($deliveryFee ?? 0) == 0)
                                        <span class="text-emerald-600">Gratuite</span>
                                    @else
                                        {{ number_format($deliveryFee ?? 4.99, 2, ',', ' ') }} &euro;
                                    @endif
                                </span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between text-lg font-extrabold text-gray-900">
                                    <span>Total</span>
                                    <span class="text-emerald-600">{{ number_format($total ?? 0, 2, ',', ' ') }} &euro;</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                                class="mt-6 w-full py-4 rounded-xl font-bold text-lg text-white bg-gradient-to-r from-emerald-600 to-teal-500 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
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
                paymentMethod: '{{ old('payment_method', 'cash') }}'
            }
        }
    </script>

@endsection
