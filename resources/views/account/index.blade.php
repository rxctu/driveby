@extends('layouts.app')

@section('title', 'Mon compte - EpiDrive')
@section('meta_description', 'Gerez votre compte EpiDrive, consultez vos commandes et vos informations.')

@section('content')

    {{-- Welcome Header with gradient --}}
    <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 relative overflow-hidden">
        {{-- Decorative elements --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/5 rounded-full"></div>
            <div class="absolute top-8 right-1/3 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 relative z-10">
            <nav class="text-sm text-emerald-200 mb-4">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
                    <li><span class="text-emerald-300/50">/</span></li>
                    <li class="text-white font-medium">Mon compte</li>
                </ol>
            </nav>
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <span class="text-3xl sm:text-4xl font-extrabold text-amber-400">
                        {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
                        Bonjour, {{ Auth::user()->name ?? 'Client' }} !
                    </h1>
                    <p class="text-emerald-100 mt-1">Bienvenue sur votre espace personnel EpiDrive</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20 pb-12">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
            {{-- Total Orders --}}
            <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300"
                 x-data="{ count: 0, target: {{ $totalOrders ?? 0 }} }"
                 x-init="
                    let step = Math.ceil(target / 20);
                    let interval = setInterval(() => {
                        count = Math.min(count + step, target);
                        if (count >= target) clearInterval(interval);
                    }, 50);
                 ">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900" x-text="count">0</p>
                        <p class="text-sm text-gray-500 font-medium">Total commandes</p>
                    </div>
                </div>
            </div>

            {{-- Pending Orders --}}
            <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300"
                 x-data="{ count: 0, target: {{ $pendingOrders ?? 0 }} }"
                 x-init="
                    let step = Math.ceil(target / 20);
                    let interval = setInterval(() => {
                        count = Math.min(count + step, target);
                        if (count >= target) clearInterval(interval);
                    }, 50);
                 ">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-400/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900" x-text="count">0</p>
                        <p class="text-sm text-gray-500 font-medium">En cours</p>
                    </div>
                </div>
            </div>

            {{-- Delivered Orders --}}
            <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300"
                 x-data="{ count: 0, target: {{ $deliveredOrders ?? 0 }} }"
                 x-init="
                    let step = Math.ceil(target / 20);
                    let interval = setInterval(() => {
                        count = Math.min(count + step, target);
                        if (count >= target) clearInterval(interval);
                    }, 50);
                 ">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900" x-text="count">0</p>
                        <p class="text-sm text-gray-500 font-medium">Livrees</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('catalog.index') }}"
               class="group flex items-center space-x-4 bg-gradient-to-r from-emerald-700 to-emerald-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/40 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                <div class="w-12 h-12 bg-white/15 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:bg-white/25 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Nouvelle commande</p>
                    <p class="text-emerald-100 text-sm">Parcourir le catalogue</p>
                </div>
            </a>
            <a href="{{ route('account.orders') }}"
               class="group flex items-center space-x-4 bg-white border-2 border-gray-200 rounded-2xl p-5 text-gray-900 shadow-lg shadow-gray-200/50 hover:border-emerald-300 hover:shadow-emerald-100/50 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Mes commandes</p>
                    <p class="text-gray-500 text-sm">Voir l'historique complet</p>
                </div>
            </a>
        </div>

        {{-- Password Change --}}
        <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-extrabold text-gray-900 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    <span>Modifier mon mot de passe</span>
                </h2>
            </div>

            <form method="POST" action="{{ route('account.password.update') }}" class="p-6">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                        <input type="password" name="current_password" id="current_password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('current_password') border-red-500 @enderror"
                               required>
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                        Mettre a jour le mot de passe
                    </button>
                </div>
            </form>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h2 class="text-lg font-extrabold text-gray-900">Commandes recentes</h2>
                <a href="{{ route('account.orders') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-bold flex items-center space-x-1 transition">
                    <span>Voir tout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </a>
            </div>

            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('account.order.detail', $order->order_number) }}"
                           class="flex items-center justify-between p-4 sm:p-6 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-transparent transition-all duration-200 group">
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 text-sm sm:text-base group-hover:text-emerald-700 transition">#{{ $order->order_number }}</p>
                                <p class="text-xs sm:text-sm text-gray-400 mt-1">{{ $order->created_at->format('d/m/Y a H:i') }}</p>
                            </div>

                            <div class="text-right ml-4 flex items-center space-x-4">
                                <div>
                                    <p class="font-extrabold text-gray-900 text-sm sm:text-base">{{ number_format($order->total, 2, ',', ' ') }} &euro;</p>
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
                                    @endphp
                                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-bold ring-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 ring-gray-200' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </div>

                                <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-500 transition hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium mb-1">Aucune commande pour le moment</p>
                    <p class="text-gray-400 text-sm mb-6">Decouvrez nos produits frais et passez votre premiere commande !</p>
                    <a href="{{ route('catalog.index') }}"
                       class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-700 to-emerald-600 text-white font-bold px-6 py-3 rounded-xl hover:from-emerald-800 hover:to-emerald-700 transition-all shadow-lg shadow-emerald-500/25">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z"/>
                        </svg>
                        <span>Decouvrir nos produits</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
