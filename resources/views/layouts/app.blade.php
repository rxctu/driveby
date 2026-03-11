<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'EpiDrive - Votre épicerie de quartier, livrée chez vous. Fruits, légumes, produits frais et bien plus encore.')">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EpiDrive - Épicerie en ligne, livraison à domicile')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'EpiDrive - Épicerie en ligne')">
    <meta property="og:description" content="@yield('meta_description', 'Votre épicerie de quartier, livrée chez vous.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="EpiDrive">

    @yield('meta')

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-700 font-sans antialiased min-h-screen flex flex-col" x-data="{ mobileMenu: false, cartPulse: false }">

    {{-- Delivery Banner --}}
    @php
        $bannerTexts = json_decode(\App\Models\Setting::getValue('banner_texts', ''), true) ?: [
            ['emoji' => '🚀', 'text' => 'Livraison en 30min dans votre quartier'],
            ['emoji' => '⚡', 'text' => 'Livraison GRATUITE dès 25€ d\'achat'],
            ['emoji' => '🎉', 'text' => '-20% sur votre 1ère commande avec le code BIENVENUE'],
            ['emoji' => '🛒', 'text' => '+ de 2000 produits disponibles'],
        ];
        $activeBanners = collect($bannerTexts)->filter(fn($b) => !empty($b['text']));
    @endphp
    @if($activeBanners->isNotEmpty())
    <div class="bg-gradient-accent text-emerald-900 py-2 relative overflow-hidden">
        <div class="marquee-container">
            <div class="marquee-content text-sm font-bold tracking-wide">
                @foreach($activeBanners as $banner)
                    <span class="mx-8">{{ $banner['emoji'] ?? '' }} {{ $banner['text'] }}</span>
                @endforeach
                @foreach($activeBanners as $banner)
                    <span class="mx-8">{{ $banner['emoji'] ?? '' }} {{ $banner['text'] }}</span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Sticky Header --}}
    <header class="sticky top-0 z-50 glass-dark shadow-lg shadow-emerald-900/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <span class="text-3xl transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">🛒</span>
                    <span class="text-2xl font-extrabold text-white tracking-tight">
                        Epi<span class="text-amber-400">Drive</span>
                    </span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-emerald-100 hover:text-amber-400 transition-colors duration-200 font-semibold text-sm uppercase tracking-wider">Accueil</a>
                    <a href="{{ route('catalog.index') }}" class="text-emerald-100 hover:text-amber-400 transition-colors duration-200 font-semibold text-sm uppercase tracking-wider">Catalogue</a>
                    <a href="{{ route('community.index') }}" class="text-emerald-100 hover:text-amber-400 transition-colors duration-200 font-semibold text-sm uppercase tracking-wider">Communaut&eacute;</a>
                    <a href="{{ route('partners.index') }}" class="text-emerald-100 hover:text-amber-400 transition-colors duration-200 font-semibold text-sm uppercase tracking-wider">Partenaires</a>
                </nav>

                {{-- Right: Cart + User --}}
                <div class="flex items-center space-x-4">

                    {{-- Cart Icon --}}
                    @php $cartCount = array_sum(session('cart', [])); @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-white hover:text-amber-400 transition-colors duration-200 group" data-cart-count="{{ $cartCount }}">
                        <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        <span x-show="$store.cart.count > 0"
                              x-text="$store.cart.count"
                              x-transition:enter="transition ease-out duration-300"
                              x-transition:enter-start="scale-0"
                              x-transition:enter-end="scale-100"
                              :class="{ 'animate-cart-bounce': $store.cart.justAdded }"
                              class="absolute -top-1 -right-1 bg-amber-400 text-emerald-900 text-xs font-extrabold rounded-full w-5 h-5 flex items-center justify-center shadow-lg">
                        </span>
                    </a>

                    {{-- User Menu (Desktop) --}}
                    <div class="hidden md:block relative" x-data="{ userMenu: false }">
                        @auth
                            <button @click="userMenu = !userMenu" class="flex items-center space-x-2 text-emerald-100 hover:text-amber-400 transition-colors duration-200">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-emerald-400 flex items-center justify-center text-emerald-900 font-bold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                            </button>
                            <div x-show="userMenu" @click.away="userMenu = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden">
                                <a href="{{ route('account.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-150">
                                    <span class="mr-3">👤</span> Mon compte
                                </a>
                                <a href="{{ route('account.orders') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-150">
                                    <span class="mr-3">📦</span> Mes commandes
                                </a>
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-amber-600 hover:bg-amber-50 hover:text-amber-700 transition-colors duration-150 font-semibold">
                                        <span class="mr-3">⚙️</span> Administration
                                    </a>
                                @endif
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                        <span class="mr-3">🚪</span> Se déconnecter
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition-all duration-200 text-sm font-semibold border border-white/20 hover:border-white/40">
                                Connexion
                            </a>
                        @endauth
                    </div>

                    {{-- Mobile Hamburger --}}
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-white hover:text-amber-400 transition-colors duration-200">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-gradient-to-b from-emerald-900 to-emerald-950 border-t border-emerald-700/30">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-200 font-semibold">
                    <span>🏠</span><span>Accueil</span>
                </a>
                <a href="{{ route('catalog.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-200 font-semibold">
                    <span>🛍️</span><span>Catalogue</span>
                </a>
                <a href="{{ route('community.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-200 font-semibold">
                    <span>👥</span><span>Communaut&eacute;</span>
                </a>
                <a href="{{ route('partners.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-200 font-semibold">
                    <span>🤝</span><span>Partenaires</span>
                </a>
                @auth
                    <a href="{{ route('account.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-200 font-semibold">
                        <span>👤</span><span>Mon compte</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-colors duration-200 font-semibold">
                        <span>📦</span><span>Mes commandes</span>
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-400 hover:bg-amber-400/10 transition-colors duration-200 font-semibold">
                            <span>⚙️</span><span>Administration</span>
                        </a>
                    @endif
                    <div class="border-t border-emerald-700/30 my-2"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 w-full text-left px-4 py-3 rounded-xl text-red-300 hover:bg-red-900/20 transition-colors duration-200 font-semibold">
                            <span>🚪</span><span>Se déconnecter</span>
                        </button>
                    </form>
                @else
                    <div class="border-t border-emerald-700/30 my-2"></div>
                    <a href="{{ route('login') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-400 hover:bg-amber-400/10 transition-colors duration-200 font-semibold">
                        <span>🔑</span><span>Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-400 hover:bg-amber-400/10 transition-colors duration-200 font-semibold">
                        <span>✨</span><span>Inscription</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed top-24 right-4 z-50 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-emerald-600/30 max-w-md">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">✅</span>
                <p class="font-semibold">{{ session('success') }}</p>
                <button @click="show = false" class="ml-2 text-white/70 hover:text-white text-xl">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed top-24 right-4 z-50 bg-gradient-to-r from-red-600 to-rose-600 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-red-600/30 max-w-md">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">❌</span>
                <p class="font-semibold">{{ session('error') }}</p>
                <button @click="show = false" class="ml-2 text-white/70 hover:text-white text-xl">&times;</button>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gradient-footer text-gray-300 mt-16">
        {{-- Newsletter Section --}}
        <div class="border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center max-w-2xl mx-auto">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
                        🔔 Restez informé de nos offres
                    </h3>
                    <p class="text-emerald-200/70 mb-6">
                        Recevez nos promotions exclusives et nos nouveautés directement dans votre boîte mail.
                    </p>
                    <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                        <input type="email" placeholder="votre@email.fr"
                               class="flex-1 px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all duration-200">
                        <button type="submit" class="px-6 py-3 bg-gradient-accent text-emerald-900 font-bold rounded-xl hover:shadow-lg hover:shadow-amber-400/30 transition-all duration-200 hover:scale-105">
                            S'inscrire
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- Store Info --}}
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-3xl">🛒</span>
                        <span class="text-2xl font-extrabold text-white">Epi<span class="text-amber-400">Drive</span></span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Votre épicerie de quartier en ligne. Des produits frais et de qualité, livrés directement chez vous en 30 minutes.
                    </p>
                    {{-- Social Links --}}
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/epidrive63/" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-[#1877F2] transition-all duration-200 hover:scale-110" title="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/epidrive63" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-gradient-to-br hover:from-[#f09433] hover:via-[#dc2743] hover:to-[#bc1888] transition-all duration-200 hover:scale-110" title="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://www.snapchat.com/add/epidrive63" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-[#FFFC00] hover:text-black transition-all duration-200 hover:scale-110" title="Snapchat">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.299 4.847l-.003.06c-.012.18-.022.345-.03.51.075.045.203.09.401.09.3-.016.659-.12 1.033-.301.165-.088.344-.104.464-.104.182 0 .359.029.509.09.45.149.734.479.734.838.015.449-.39.839-1.213 1.168-.089.029-.209.075-.344.119-.45.135-1.139.36-1.333.81-.09.21-.061.524.12.868l.015.015c.06.136 1.526 3.475 4.791 4.014.255.044.435.27.42.509 0 .075-.015.149-.045.225-.24.569-1.273.988-3.146 1.271-.059.091-.12.375-.164.57-.029.179-.074.36-.134.553-.076.271-.27.405-.555.405h-.03c-.135 0-.313-.031-.538-.076-.375-.09-.84-.181-1.468-.181-.195 0-.399.015-.6.045-.601.09-1.048.46-1.545.855-.9.719-1.832 1.461-3.51 1.461h-.06c-1.68 0-2.611-.742-3.51-1.461-.496-.396-.943-.765-1.545-.855-.2-.03-.404-.045-.6-.045-.63 0-1.093.091-1.468.18-.225.044-.404.076-.538.076-.299 0-.48-.119-.57-.404-.059-.195-.104-.375-.134-.554-.046-.195-.105-.479-.165-.57-1.873-.283-2.905-.701-3.146-1.271-.029-.075-.044-.149-.044-.225-.015-.24.165-.465.42-.509 3.264-.54 4.73-3.879 4.791-4.02l.016-.029c.18-.345.224-.645.119-.869-.195-.434-.884-.658-1.332-.809-.121-.029-.24-.074-.346-.119-.809-.33-1.224-.72-1.212-1.169 0-.359.284-.689.733-.838.165-.06.33-.09.509-.09.12 0 .3.015.449.104.39.18.747.301 1.048.301.181 0 .3-.045.374-.09-.007-.165-.018-.33-.03-.51l-.002-.06c-.105-1.628-.23-3.654.3-4.847C7.86 1.069 11.216.793 12.206.793z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Navigation</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-amber-400 transition-colors duration-200">Accueil</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="text-gray-400 hover:text-amber-400 transition-colors duration-200">Catalogue</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-amber-400 transition-colors duration-200">Mon panier</a></li>
                    </ul>
                </div>

                {{-- Hours --}}
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">⏰ Horaires</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex justify-between"><span>Lundi - Samedi</span><span class="text-emerald-400 font-semibold">des 18h</span></li>
                        <li class="flex justify-between"><span>Dimanche</span><span class="text-emerald-400 font-semibold">des 16h</span></li>
                    </ul>
                    <p class="text-xs text-gray-500 mt-3">🚚 Livraison Ambert & 15-20km</p>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">📍 Contact</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center space-x-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <span>contact@epidrive.fr</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            <span>14 Boulevard Henri IV, 63600 Ambert</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-10 pt-8">
                <div class="flex flex-wrap justify-center gap-x-2 gap-y-2 text-sm mb-6">
                    <a href="{{ route('legal.mentions') }}" class="px-4 py-2 rounded-lg bg-white/5 text-gray-400 hover:bg-white/10 hover:text-amber-400 transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1.5 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Mentions legales
                    </a>
                    <a href="{{ route('legal.privacy') }}" class="px-4 py-2 rounded-lg bg-white/5 text-gray-400 hover:bg-white/10 hover:text-amber-400 transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1.5 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        Confidentialite
                    </a>
                    <a href="{{ route('legal.cgv') }}" class="px-4 py-2 rounded-lg bg-white/5 text-gray-400 hover:bg-white/10 hover:text-amber-400 transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1.5 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        CGV
                    </a>
                    <a href="{{ route('legal.cookies') }}" class="px-4 py-2 rounded-lg bg-white/5 text-gray-400 hover:bg-white/10 hover:text-amber-400 transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-1.5 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                        Cookies
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} EpiDrive. Tous droits reserves.</p>
                    <p class="mt-2 sm:mt-0">Fait avec <span class="text-red-400">&#10084;</span> a Epi</p>
                </div>
            </div>
        </div>
    </footer>

    {{-- RGPD Cookie Consent Banner --}}
    <div x-data="cookieConsent()" x-show="showBanner" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-0 left-0 right-0 z-[9999] p-4 sm:p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl border border-gray-200 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start gap-4">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Respect de votre vie privee</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Nous utilisons des cookies strictement necessaires au fonctionnement du site (session, panier, securite).
                        Aucun cookie publicitaire ou de tracking n'est utilise.
                        <a href="{{ route('legal.cookies') }}" class="text-emerald-600 hover:text-emerald-700 underline">En savoir plus</a>.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 flex-shrink-0">
                    <button @click="acceptAll()"
                            class="px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition text-sm">
                        Tout accepter
                    </button>
                    <button @click="acceptEssential()"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition text-sm">
                        Essentiels uniquement
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div x-data x-show="$store.toast.visible" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="fixed bottom-6 right-6 z-[9999] max-w-sm"
         :class="{
             'bg-gradient-to-r from-emerald-600 to-teal-600 shadow-emerald-600/30': $store.toast.type === 'success',
             'bg-gradient-to-r from-red-600 to-rose-600 shadow-red-600/30': $store.toast.type === 'error',
             'bg-gradient-to-r from-blue-600 to-indigo-600 shadow-blue-600/30': $store.toast.type === 'info'
         }"
         style="border-radius: 1rem; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3);">
        <div class="flex items-center px-5 py-3.5 text-white">
            <span class="text-xl mr-3" x-text="$store.toast.type === 'success' ? '&#10003;' : $store.toast.type === 'error' ? '&#10007;' : '&#8505;'"></span>
            <p class="font-semibold text-sm flex-1" x-text="$store.toast.message"></p>
            <button @click="$store.toast.visible = false" class="ml-3 text-white/70 hover:text-white text-lg leading-none">&times;</button>
        </div>
    </div>

    <script>
        function cookieConsent() {
            return {
                showBanner: false,
                init() {
                    this.showBanner = !this.getCookie('cookie_consent');
                },
                acceptAll() {
                    this.setCookie('cookie_consent', 'all', 365);
                    this.showBanner = false;
                },
                acceptEssential() {
                    this.setCookie('cookie_consent', 'essential', 365);
                    this.showBanner = false;
                },
                setCookie(name, value, days) {
                    const d = new Date();
                    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                    document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Strict';
                },
                getCookie(name) {
                    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                    return match ? match[2] : null;
                }
            };
        }
    </script>

</body>
</html>
