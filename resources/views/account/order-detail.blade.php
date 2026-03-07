@extends('layouts.app')

@section('title', 'Commande #' . ($order->order_number ?? '') . ' - EpiDrive')
@section('meta_description', 'Details de votre commande EpiDrive.')

@section('content')

    @php
        $statusColors = [
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'confirmed' => 'bg-blue-100 text-blue-700 ring-blue-200',
            'processing' => 'bg-orange-100 text-orange-700 ring-orange-200',
            'shipped' => 'bg-purple-100 text-purple-700 ring-purple-200',
            'delivered' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
        ];
        $statusLabels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmee',
            'processing' => 'En preparation',
            'shipped' => 'En livraison',
            'delivered' => 'Livree',
            'cancelled' => 'Annulee',
        ];

        // Steps for the timeline
        $steps = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
        $currentStepIndex = array_search($order->status ?? 'pending', $steps);
        if ($currentStepIndex === false) $currentStepIndex = -1;
        $isCancelled = ($order->status ?? '') === 'cancelled';

        $stepLabels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmee',
            'processing' => 'Preparation',
            'shipped' => 'Livraison',
            'delivered' => 'Livree',
        ];
        $stepIcons = [
            'pending' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'confirmed' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'processing' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>',
            'shipped' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0H6.375m11.25-3V7.5a.75.75 0 00-.75-.75H8.25m8.625 3.75l2.587 1.293A.75.75 0 0120.25 12v3h-.375m-8.625-3h5.625"/>',
            'delivered' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
        ];
    @endphp

    {{-- Header with gradient --}}
    <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/5 rounded-full"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 relative z-10">
            <nav class="text-sm text-emerald-200 mb-4">
                <ol class="flex items-center space-x-2 flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
                    <li><span class="text-emerald-300/50">/</span></li>
                    <li><a href="{{ route('account.index') }}" class="hover:text-white transition">Mon compte</a></li>
                    <li><span class="text-emerald-300/50">/</span></li>
                    <li><a href="{{ route('account.orders') }}" class="hover:text-white transition">Mes commandes</a></li>
                    <li><span class="text-emerald-300/50">/</span></li>
                    <li class="text-white font-medium">#{{ $order->order_number ?? '' }}</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Commande #{{ $order->order_number ?? '' }}</h1>
                    <p class="text-emerald-100 mt-1">Passee le {{ $order->created_at->format('d/m/Y a H:i') ?? '' }}</p>
                </div>
                <span class="inline-flex items-center self-start px-4 py-1.5 rounded-full text-sm font-bold ring-1 bg-white/15 text-white ring-white/25 backdrop-blur-sm">
                    {{ $statusLabels[$order->status] ?? $order->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20 pb-12">

        {{-- Status Timeline --}}
        <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 sm:p-8 mb-6">
            @if($isCancelled)
                <div class="flex items-center justify-center space-x-3 py-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-red-700 text-lg">Commande annulee</p>
                        <p class="text-red-500 text-sm">Cette commande a ete annulee</p>
                    </div>
                </div>
            @else
                {{-- Desktop timeline --}}
                <div class="hidden sm:block">
                    <div class="flex items-center justify-between relative">
                        {{-- Progress bar background --}}
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 rounded-full mx-8"></div>
                        {{-- Progress bar fill --}}
                        @if($currentStepIndex >= 0)
                            <div class="absolute top-5 left-0 h-1 bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-full mx-8 transition-all duration-1000"
                                 style="width: calc({{ ($currentStepIndex / (count($steps) - 1)) * 100 }}% - 4rem);"></div>
                        @endif

                        @foreach($steps as $i => $step)
                            <div class="relative z-10 flex flex-col items-center" style="width: 20%;">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-500
                                    {{ $i <= $currentStepIndex ? 'bg-gradient-to-br from-emerald-600 to-emerald-500 shadow-lg shadow-emerald-500/30' : 'bg-gray-200' }}">
                                    <svg class="w-5 h-5 {{ $i <= $currentStepIndex ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        {!! $stepIcons[$step] !!}
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs font-bold {{ $i <= $currentStepIndex ? 'text-emerald-700' : 'text-gray-400' }}">
                                    {{ $stepLabels[$step] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Mobile timeline (vertical) --}}
                <div class="sm:hidden space-y-3">
                    @foreach($steps as $i => $step)
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center
                                    {{ $i <= $currentStepIndex ? 'bg-gradient-to-br from-emerald-600 to-emerald-500' : 'bg-gray-200' }}">
                                    <svg class="w-4 h-4 {{ $i <= $currentStepIndex ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        {!! $stepIcons[$step] !!}
                                    </svg>
                                </div>
                                @if(!$loop->last)
                                    <div class="absolute top-8 left-1/2 -translate-x-1/2 w-0.5 h-3
                                        {{ $i < $currentStepIndex ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>
                                @endif
                            </div>
                            <span class="text-sm font-bold {{ $i <= $currentStepIndex ? 'text-emerald-700' : 'text-gray-400' }}">
                                {{ $stepLabels[$step] }}
                            </span>
                            @if($i == $currentStepIndex)
                                <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-bold">En cours</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="space-y-6">

            {{-- Order Items --}}
            <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-extrabold text-gray-900">Articles commandes</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items ?? [] as $item)
                        <div class="flex items-center p-4 sm:p-6 space-x-4 hover:bg-gray-50/50 transition">
                            <div class="flex-shrink-0">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}"
                                         class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl shadow-sm">
                                @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">{{ $item->product_name }}</h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    {{ number_format($item->unit_price, 2, ',', ' ') }} &euro; x {{ $item->quantity }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-extrabold text-gray-900">{{ number_format($item->total_price, 2, ',', ' ') }} &euro;</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="bg-gradient-to-r from-gray-50 to-gray-50/50 p-6 space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Sous-total</span>
                        <span class="font-semibold">{{ number_format($order->subtotal ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Frais de livraison</span>
                        <span class="font-semibold">{{ number_format($order->delivery_fee ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                    <div class="flex justify-between text-lg font-extrabold text-gray-900 pt-3 border-t border-gray-200">
                        <span>Total</span>
                        <span class="text-emerald-600">{{ number_format($order->total ?? 0, 2, ',', ' ') }} &euro;</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Delivery Info --}}
                <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0H6.375m11.25-3V7.5a.75.75 0 00-.75-.75H8.25m8.625 3.75l2.587 1.293A.75.75 0 0120.25 12v3h-.375m-8.625-3h5.625"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-extrabold text-gray-900">Livraison</h2>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Adresse</p>
                            <p class="text-gray-700 font-medium">{{ $order->customer_address ?? 'Non renseignee' }}</p>
                        </div>
                        @if($order->delivery_instructions ?? false)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Instructions</p>
                                <p class="text-gray-700 font-medium">{{ $order->delivery_instructions }}</p>
                            </div>
                        @endif
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Creneau</p>
                            <p class="text-gray-700 font-medium">{{ $order->delivery_slot ?? 'Non defini' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-extrabold text-gray-900">Paiement</h2>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Methode</p>
                            @php
                                $paymentLabels = [
                                    'cash' => 'Paiement a la livraison',
                                    'stripe' => 'Carte bancaire (Stripe)',
                                    'paypal' => 'PayPal',
                                ];
                            @endphp
                            <p class="text-gray-700 font-medium">{{ $paymentLabels[$order->payment_method] ?? $order->payment_method ?? 'Non defini' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Statut du paiement</p>
                            @if(($order->payment_status ?? '') === 'paid')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Paye
                                </span>
                            @elseif(($order->payment_status ?? '') === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 ring-1 ring-amber-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    En attente
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 ring-1 ring-gray-200">
                                    {{ $order->payment_status ?? 'Inconnu' }}
                                </span>
                            @endif
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Contact</p>
                            <p class="text-gray-700 font-medium">{{ $order->customer_phone ?? Auth::user()->phone ?? 'Non renseigne' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back Link --}}
        <div class="mt-8">
            <a href="{{ route('account.orders') }}"
               class="inline-flex items-center space-x-2 text-emerald-600 hover:text-emerald-700 font-bold text-sm transition group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
                <span>Retour a mes commandes</span>
            </a>
        </div>
    </div>

@endsection
