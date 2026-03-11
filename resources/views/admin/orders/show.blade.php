@extends('layouts.admin')

@section('title', 'Commande #' . $order->order_number)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Retour aux commandes
        </a>
    </div>

    <div x-data="orderPage()" class="space-y-4 lg:grid lg:grid-cols-3 lg:gap-6 lg:space-y-0">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Order Header + Status --}}
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">#{{ $order->order_number }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('d/m/Y a H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl sm:text-2xl font-extrabold text-green-700">{{ number_format($order->total, 2, ',', ' ') }} &euro;</p>
                        <p class="text-xs text-gray-400">{{ $order->payment_method === 'cash' ? 'Especes/CB' : ($order->payment_method === 'stripe' ? 'Carte' : 'PayPal') }}
                            @if(($order->payment_status ?? 'pending') === 'paid')
                                <span class="text-green-600 font-semibold">- Paye</span>
                            @else
                                <span class="text-amber-600 font-semibold">- En attente</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Status Pipeline - Mobile friendly --}}
                @php
                    $statusFlow = [
                        'pending'    => [
                            'label' => 'En attente',
                            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                            'active_dot' => 'bg-amber-500 text-white ring-4 ring-amber-100',
                            'active_label' => 'text-amber-700',
                            'next_btn' => 'bg-amber-500 text-white hover:bg-amber-600 shadow-md shadow-amber-200 ring-2 ring-amber-300',
                        ],
                        'confirmed'  => [
                            'label' => 'Confirmee',
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'active_dot' => 'bg-blue-500 text-white ring-4 ring-blue-100',
                            'active_label' => 'text-blue-700',
                            'next_btn' => 'bg-blue-500 text-white hover:bg-blue-600 shadow-md shadow-blue-200 ring-2 ring-blue-300',
                        ],
                        'preparing'  => [
                            'label' => 'Preparation',
                            'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                            'active_dot' => 'bg-orange-500 text-white ring-4 ring-orange-100',
                            'active_label' => 'text-orange-700',
                            'next_btn' => 'bg-orange-500 text-white hover:bg-orange-600 shadow-md shadow-orange-200 ring-2 ring-orange-300',
                        ],
                        'delivering' => [
                            'label' => 'En livraison',
                            'icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0',
                            'active_dot' => 'bg-purple-500 text-white ring-4 ring-purple-100',
                            'active_label' => 'text-purple-700',
                            'next_btn' => 'bg-purple-500 text-white hover:bg-purple-600 shadow-md shadow-purple-200 ring-2 ring-purple-300',
                        ],
                        'delivered'  => [
                            'label' => 'Livree',
                            'icon' => 'M5 13l4 4L19 7',
                            'active_dot' => 'bg-green-500 text-white ring-4 ring-green-100',
                            'active_label' => 'text-green-700',
                            'next_btn' => 'bg-green-500 text-white hover:bg-green-600 shadow-md shadow-green-200 ring-2 ring-green-300',
                        ],
                    ];
                    $currentStatus = $order->status;
                    $statusKeys = array_keys($statusFlow);
                    $currentIndex = array_search($currentStatus, $statusKeys);
                @endphp

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Statut de la commande</p>

                    @if($currentStatus === 'cancelled')
                        <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-center">
                            <span class="text-red-700 font-bold text-sm">Commande annulee</span>
                        </div>
                    @else
                        {{-- Progress bar --}}
                        <div class="hidden sm:flex items-center mb-4">
                            @foreach($statusFlow as $key => $st)
                                @php
                                    $idx = array_search($key, $statusKeys);
                                    $isActive = $key === $currentStatus;
                                    $isPast = $currentIndex !== false && $idx < $currentIndex;
                                @endphp
                                @if($idx > 0)
                                    <div class="flex-1 h-1 mx-1 rounded-full {{ $isPast || $isActive ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                                @endif
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                        {{ $isActive ? $st['active_dot'] : ($isPast ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400') }}">
                                        @if($isPast)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        @else
                                            {{ $idx + 1 }}
                                        @endif
                                    </div>
                                    <span class="text-[10px] mt-1 font-medium {{ $isActive ? $st['active_label'] : ($isPast ? 'text-green-600' : 'text-gray-400') }}">{{ $st['label'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Action buttons - big touch targets --}}
                        <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:gap-2">
                            @foreach($statusFlow as $key => $st)
                                @php
                                    $idx = array_search($key, $statusKeys);
                                    $isActive = $key === $currentStatus;
                                    $isNext = $currentIndex !== false && $idx === $currentIndex + 1;
                                @endphp
                                @if($key !== $currentStatus)
                                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="{{ $isNext ? 'col-span-2 sm:col-span-1' : '' }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $key }}">
                                        <button type="submit"
                                                class="w-full flex items-center justify-center gap-2 px-3 py-3 sm:py-2.5 rounded-xl text-sm font-semibold transition-all
                                                {{ $isNext
                                                    ? $st['next_btn']
                                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-200'
                                                }}">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $st['icon'] }}"/></svg>
                                            {{ $st['label'] }}
                                        </button>
                                    </form>
                                @endif
                            @endforeach

                            {{-- Cancel button --}}
                            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}"
                                  onsubmit="return confirm('Annuler cette commande ? Le stock sera restaure.')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 px-3 py-3 sm:py-2.5 rounded-xl text-sm font-semibold bg-white text-red-600 border-2 border-red-200 hover:bg-red-50 hover:border-red-300 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Annuler
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200">
                    <h4 class="text-base font-semibold text-gray-800">Articles ({{ $order->items->count() }})</h4>
                </div>
                {{-- Mobile: card layout --}}
                <div class="sm:hidden divide-y divide-gray-100">
                    @foreach($order->items ?? [] as $item)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center min-w-0 flex-1">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 object-cover rounded mr-3 flex-shrink-0">
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product_name ?? $item->product->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ number_format($item->unit_price, 2, ',', ' ') }} &euro; x {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-800 ml-3">{{ number_format($item->unit_price * $item->quantity, 2, ',', ' ') }} &euro;</span>
                        </div>
                    @endforeach
                </div>
                {{-- Desktop: table layout --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Produit</th>
                                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Prix unitaire</th>
                                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Quantite</th>
                                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items ?? [] as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 object-cover rounded mr-3">
                                            @endif
                                            <span class="font-medium text-gray-800">{{ $item->product_name ?? $item->product->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">{{ number_format($item->unit_price, 2, ',', ' ') }} &euro;</td>
                                    <td class="px-6 py-4">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-medium">{{ number_format($item->unit_price * $item->quantity, 2, ',', ' ') }} &euro;</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Totals --}}
                <div class="bg-gray-50 p-4 space-y-1 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Sous-total</span>
                        <span class="font-medium">{{ number_format($order->subtotal ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>
                            Livraison
                            @if($order->delivery_distance)
                                <span class="text-xs text-gray-400">({{ number_format($order->delivery_distance, 1, ',', '') }} km)</span>
                            @endif
                        </span>
                        <span class="font-medium">{{ number_format($order->delivery_fee ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                    @if($order->promo_code)
                    <div class="flex justify-between text-emerald-600">
                        <span>Promo <span class="font-mono bg-emerald-50 px-1 py-0.5 rounded text-xs">{{ $order->promo_code }}</span></span>
                        <span class="font-medium">-{{ number_format($order->promo_discount ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-gray-900 font-bold text-base pt-2 border-t border-gray-200">
                        <span>Total</span>
                        <span class="text-green-700">{{ number_format($order->total, 2, ',', ' ') }} &euro;</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-4">
            {{-- QR Code Validation --}}
            <div class="bg-white rounded-lg shadow p-4 space-y-3">
                <h4 class="text-sm font-bold text-gray-800 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    Validation retrait
                </h4>

                @if($order->isValidated())
                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-center">
                        <svg class="w-8 h-8 mx-auto text-emerald-500 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-bold text-emerald-700">Retrait valide</p>
                        <p class="text-xs text-emerald-600 mt-0.5">{{ $order->validated_at->format('d/m/Y a H:i') }}</p>
                    </div>
                @else
                    <div x-data="{ code: '', scanning: false, result: null }" class="space-y-2">
                        <form @submit.prevent="
                            if (!code || code.length < 1) return;
                            scanning = true;
                            result = null;
                            fetch('{{ route('admin.orders.validate-pickup') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({ validation_code: code })
                            })
                            .then(r => r.json())
                            .then(data => {
                                scanning = false;
                                result = data;
                                if (data.success) setTimeout(() => location.reload(), 1500);
                            })
                            .catch(() => {
                                scanning = false;
                                result = { success: false, message: 'Erreur reseau.' };
                            });
                        ">
                            <div class="flex gap-2">
                                <input type="text" x-model="code" maxlength="8" placeholder="Code 8 caracteres"
                                       class="flex-1 px-3 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono uppercase tracking-wider text-center">
                                <button type="submit" :disabled="scanning || !code"
                                        class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition disabled:opacity-50">
                                    <svg x-show="!scanning" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <svg x-show="scanning" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                </button>
                            </div>
                        </form>
                        <div x-show="result" x-cloak>
                            <div x-show="result && result.success" class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-700 text-center" x-text="result?.message"></div>
                            <div x-show="result && !result.success" class="p-2.5 bg-red-50 border border-red-200 rounded-xl text-sm font-semibold text-red-700 text-center" x-text="result?.message"></div>
                        </div>
                        @if($order->validation_code)
                            <p class="text-xs text-gray-400 text-center">Code attendu : <span class="font-mono font-bold">{{ $order->validation_code }}</span></p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Customer Trust Badge --}}
            @if($order->user)
                <div class="bg-white rounded-lg shadow p-4 space-y-3">
                    <h4 class="text-sm font-bold text-gray-800 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Confiance client
                    </h4>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $order->user->trustColor() }}">
                            {{ $order->user->trustBadge() }}
                        </span>
                        @if($order->user->is_verified)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Verifie
                            </span>
                        @endif
                        @if($order->user->isNewCustomer())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                Nouveau
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">{{ $order->user->orders()->count() }} commande(s) au total</div>
                    @if($order->user->admin_notes)
                        <div class="text-xs text-gray-600 bg-yellow-50 px-3 py-2 rounded-lg border border-yellow-100">
                            <span class="font-semibold text-yellow-700">Notes :</span> {{ $order->user->admin_notes }}
                        </div>
                    @endif

                    {{-- Quick trust update form --}}
                    <form method="POST" action="{{ route('admin.users.update-trust', $order->user) }}" class="space-y-2 pt-2 border-t border-gray-100">
                        @csrf
                        @method('PATCH')
                        <div class="flex gap-2">
                            <select name="trust_level" class="flex-1 text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-emerald-500">
                                @for($i = 0; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $order->user->trust_level === $i ? 'selected' : '' }}>
                                        {{ ['Nouveau', 'A surveiller', 'Normal', 'Fiable', 'Tres fiable', 'VIP'][$i] }}
                                    </option>
                                @endfor
                            </select>
                            <label class="flex items-center gap-1 text-xs text-gray-600">
                                <input type="checkbox" name="is_verified" value="1" {{ $order->user->is_verified ? 'checked' : '' }} class="rounded text-emerald-600">
                                Verifie
                            </label>
                        </div>
                        <textarea name="admin_notes" rows="2" placeholder="Notes admin..." class="w-full text-xs border border-gray-300 rounded-lg px-2.5 py-1.5 focus:ring-2 focus:ring-emerald-500">{{ $order->user->admin_notes }}</textarea>
                        <button type="submit" class="w-full px-3 py-2 bg-gray-800 text-white rounded-lg text-xs font-bold hover:bg-gray-700 transition">
                            Mettre a jour
                        </button>
                    </form>
                </div>
            @endif

            {{-- Quick Actions: Call + Navigate --}}
            <div class="bg-white rounded-lg shadow p-4">
                <div class="grid grid-cols-2 gap-2">
                    <a href="tel:{{ $order->customer_phone }}"
                       class="flex items-center justify-center gap-2 px-3 py-3 bg-blue-500 text-white rounded-xl font-semibold text-sm hover:bg-blue-600 transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Appeler
                    </a>
                    <a href="sms:{{ $order->customer_phone }}"
                       class="flex items-center justify-center gap-2 px-3 py-3 bg-green-500 text-white rounded-xl font-semibold text-sm hover:bg-green-600 transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        SMS
                    </a>
                </div>
            </div>

            {{-- Customer & Delivery --}}
            <div class="bg-white rounded-lg shadow p-4 space-y-3">
                <h4 class="text-sm font-bold text-gray-800 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $order->customer_name }}
                </h4>
                <p class="text-sm text-gray-600">{{ $order->customer_address }}</p>
                @if($order->delivery_distance)
                    <p class="text-xs text-gray-400">{{ number_format($order->delivery_distance, 1, ',', '') }} km depuis le magasin</p>
                @endif
                @if($order->delivery_slot)
                    <div class="flex items-center gap-1.5 text-xs text-amber-700 bg-amber-50 px-2.5 py-1.5 rounded-lg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $order->delivery_slot }}
                    </div>
                @endif
                @if($order->delivery_instructions)
                    <div class="text-xs text-gray-600 bg-gray-50 px-3 py-2 rounded-lg border border-gray-100">
                        <span class="font-semibold text-gray-500">Notes :</span> {{ $order->delivery_instructions }}
                    </div>
                @endif
            </div>

            {{-- Navigation --}}
            @php
                $storeAddress = \App\Models\Setting::getValue('store_address', 'Ambert, 63600');
                $storeLat = \App\Models\Setting::getValue('store_lat', '45.5495');
                $storeLng = \App\Models\Setting::getValue('store_lng', '3.7428');
                $encodedStoreAddress = urlencode($storeAddress);
                $encodedAddress = urlencode($order->customer_address);
            @endphp
            <div class="bg-white rounded-lg shadow p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-gray-800">Navigation</h4>
                    <button type="button" @click="locateMe()"
                            :disabled="gpsLoading"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg transition border"
                            :class="gpsLoading ? 'bg-gray-100 text-gray-400 border-gray-200 cursor-wait' : 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100'">
                        <svg x-show="!gpsLoading" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <svg x-show="gpsLoading" x-cloak class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <span x-text="gpsLoading ? 'GPS...' : (myPosition ? 'Position OK' : 'Ma position')"></span>
                    </button>
                </div>

                {{-- GPS status --}}
                <div x-show="gpsError" x-cloak class="text-xs text-red-600 bg-red-50 px-2.5 py-1.5 rounded-lg" x-text="gpsError"></div>
                <div x-show="myPosition" x-cloak class="text-xs text-blue-600 bg-blue-50 px-2.5 py-1.5 rounded-lg flex items-center justify-between">
                    <span>Depart : <strong x-text="myPosition ? 'Position GPS actuelle' : ''"></strong></span>
                    <button @click="resetOrigin()" class="text-gray-400 hover:text-red-500 ml-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div x-show="!myPosition" class="text-xs text-gray-400">
                    Depart : {{ $storeAddress }}
                </div>

                {{-- Nav buttons to customer --}}
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Vers le client</p>
                <div class="grid grid-cols-3 gap-2">
                    <a :href="googleMapsUrl" target="_blank"
                       class="flex flex-col items-center gap-1 px-2 py-3 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition border border-blue-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <span class="text-[10px] font-bold">Google</span>
                    </a>
                    <a :href="wazeUrl" target="_blank"
                       class="flex flex-col items-center gap-1 px-2 py-3 bg-cyan-50 text-cyan-700 rounded-xl hover:bg-cyan-100 transition border border-cyan-200">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20.54 6.63c.69 1.41 1.07 2.97 1.07 4.6 0 4.41-2.57 8.21-6.28 10.01-.53.26-1.12-.17-1.02-.76.13-.72.2-1.47.2-2.23 0-2.62-.94-4.97-2.46-6.71a.496.496 0 01.36-.84c2.04-.07 3.58-.98 4.33-2.48.28-.57 1.1-.7 1.56-.27l2.24 2.68zM12 2C6.48 2 2 6.48 2 12c0 1.74.45 3.38 1.24 4.8l2.64-2.64C5.33 13.14 5 12.11 5 11c0-3.87 3.13-7 7-7 1.86 0 3.55.73 4.8 1.91l2.52-2.52C17.46 1.49 14.86.5 12 .5 5.66.5.5 5.66.5 12S5.66 23.5 12 23.5c2.81 0 5.38-.96 7.43-2.57l-2.52-2.52A6.97 6.97 0 0112 20c-1.11 0-2.14-.33-3.01-.88L6.35 21.77C8.21 23.18 10.5 24 13 24c6.08 0 11-4.92 11-11S18.08 2 12 2z"/></svg>
                        <span class="text-[10px] font-bold">Waze</span>
                    </a>
                    <a :href="appleMapsUrl" target="_blank"
                       class="flex flex-col items-center gap-1 px-2 py-3 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition border border-gray-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <span class="text-[10px] font-bold">Apple</span>
                    </a>
                </div>

                {{-- Return to store button --}}
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider pt-1">Retour magasin</p>
                <div class="grid grid-cols-3 gap-2">
                    <a :href="googleMapsReturnUrl" target="_blank"
                       class="flex flex-col items-center gap-1 px-2 py-2.5 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition border border-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                        <span class="text-[10px] font-bold">Google</span>
                    </a>
                    <a :href="wazeReturnUrl" target="_blank"
                       class="flex flex-col items-center gap-1 px-2 py-2.5 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition border border-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                        <span class="text-[10px] font-bold">Waze</span>
                    </a>
                    <a :href="appleMapsReturnUrl" target="_blank"
                       class="flex flex-col items-center gap-1 px-2 py-2.5 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition border border-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                        <span class="text-[10px] font-bold">Apple</span>
                    </a>
                </div>
            </div>

            {{-- Map --}}
            <div class="bg-white rounded-lg shadow" id="map-container">
                <div class="p-3 border-b border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-800 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Carte
                        <span id="route-info" class="ml-2 text-xs font-normal text-gray-500"></span>
                    </h4>
                </div>
                <div id="delivery-map" class="h-56 sm:h-64 rounded-b-lg"></div>
            </div>
        </div>
    </div>

    {{-- Status update notification (WebSocket via Echo) --}}
    <div x-data="{ statusChanged: false }" x-init="
        if (window.Echo) {
            window.Echo.channel('order.{{ $order->order_number }}')
                .listen('OrderStatusUpdated', (e) => {
                    statusChanged = true;
                    if (navigator.vibrate) navigator.vibrate([200, 100, 200]);
                    setTimeout(() => window.location.reload(), 2000);
                });
        }
    ">
        <div x-show="statusChanged" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-4 px-4 py-3 bg-blue-50 border border-blue-300 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span class="text-sm font-semibold text-blue-800">Cette commande a ete mise a jour. Rechargement en cours...</span>
        </div>
    </div>

    <script>
        function orderPage() {
            const storeAddress = @json($storeAddress);
            const storeLat = {{ $storeLat }};
            const storeLng = {{ $storeLng }};
            const customerAddress = @json($order->customer_address);
            const encodedCustomer = encodeURIComponent(customerAddress);
            const encodedStore = encodeURIComponent(storeAddress);

            return {
                gpsLoading: false,
                gpsError: '',
                myPosition: null, // { lat, lng }

                get originParam() {
                    if (this.myPosition) {
                        return this.myPosition.lat + ',' + this.myPosition.lng;
                    }
                    return encodedStore;
                },

                get originIsGps() {
                    return !!this.myPosition;
                },

                // --- To customer ---
                get googleMapsUrl() {
                    const origin = this.originIsGps
                        ? this.myPosition.lat + ',' + this.myPosition.lng
                        : encodedStore;
                    return 'https://www.google.com/maps/dir/?api=1&origin=' + origin + '&destination=' + encodedCustomer + '&travelmode=driving';
                },
                get wazeUrl() {
                    return 'https://waze.com/ul?q=' + encodedCustomer + '&navigate=yes';
                },
                get appleMapsUrl() {
                    const origin = this.originIsGps
                        ? this.myPosition.lat + ',' + this.myPosition.lng
                        : encodedStore;
                    return 'https://maps.apple.com/?saddr=' + origin + '&daddr=' + encodedCustomer + '&dirflg=d';
                },

                // --- Return to store ---
                get googleMapsReturnUrl() {
                    return 'https://www.google.com/maps/dir/?api=1&origin=' + encodedCustomer + '&destination=' + encodedStore + '&travelmode=driving';
                },
                get wazeReturnUrl() {
                    return 'https://waze.com/ul?q=' + encodedStore + '&navigate=yes';
                },
                get appleMapsReturnUrl() {
                    return 'https://maps.apple.com/?saddr=' + encodedCustomer + '&daddr=' + encodedStore + '&dirflg=d';
                },

                locateMe() {
                    if (!navigator.geolocation) {
                        this.gpsError = 'GPS non supporte par votre navigateur.';
                        return;
                    }
                    this.gpsLoading = true;
                    this.gpsError = '';

                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            this.myPosition = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                            this.gpsLoading = false;
                            this.gpsError = '';
                        },
                        (err) => {
                            this.gpsLoading = false;
                            switch (err.code) {
                                case err.PERMISSION_DENIED:
                                    this.gpsError = 'Acces GPS refuse.';
                                    break;
                                case err.POSITION_UNAVAILABLE:
                                    this.gpsError = 'Position indisponible.';
                                    break;
                                case err.TIMEOUT:
                                    this.gpsError = 'Delai GPS depasse.';
                                    break;
                                default:
                                    this.gpsError = 'Erreur GPS.';
                            }
                        },
                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 30000 }
                    );
                },

                resetOrigin() {
                    this.myPosition = null;
                }
            };
        }

        document.addEventListener('DOMContentLoaded', async function() {
            if (typeof L === 'undefined') return;

            const customerAddress = @json($order->customer_address);

            try {
                const geoRes = await fetch('{{ route("admin.orders.geocode") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ address: customerAddress })
                });

                if (!geoRes.ok) {
                    document.getElementById('delivery-map').innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Adresse introuvable</div>';
                    return;
                }

                const geo = await geoRes.json();
                const custLat = geo.lat;
                const custLng = geo.lng;
                const storeLat = geo.store_lat;
                const storeLng = geo.store_lng;

                const map = L.map('delivery-map').fitBounds([
                    [storeLat, storeLng],
                    [custLat, custLng]
                ], { padding: [30, 30] });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OSM',
                    maxZoom: 18
                }).addTo(map);

                const storeIcon = L.divIcon({
                    html: '<div style="background:#059669;width:28px;height:28px;border-radius:50%;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center"><svg width="14" height="14" fill="white" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg></div>',
                    className: '',
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                });
                L.marker([storeLat, storeLng], { icon: storeIcon }).addTo(map).bindPopup('<strong>EpiDrive</strong>');

                const custIcon = L.divIcon({
                    html: '<div style="background:#dc2626;width:28px;height:28px;border-radius:50%;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center"><svg width="14" height="14" fill="white" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg></div>',
                    className: '',
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                });
                L.marker([custLat, custLng], { icon: custIcon }).addTo(map).bindPopup('<strong>Client</strong><br>' + customerAddress);

                L.polyline([[storeLat, storeLng], [custLat, custLng]], {
                    color: '#059669', weight: 3, opacity: 0.7, dashArray: '10,8'
                }).addTo(map);

                @if($order->delivery_distance)
                    document.getElementById('route-info').textContent = '({{ number_format($order->delivery_distance, 1, ",", "") }} km)';
                @endif
            } catch (e) {
                document.getElementById('delivery-map').innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Impossible de charger la carte</div>';
            }
        });
    </script>
    <style>[x-cloak] { display: none !important; }</style>
@endsection
