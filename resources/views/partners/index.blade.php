@extends('layouts.app')

@section('title', 'Nos Partenaires - EpiDrive livre pour eux aussi !')
@section('meta_description', 'Decouvrez nos partenaires locaux. EpiDrive livre les commandes de vos restaurants et commercants preferes a Ambert.')

@section('content')

    {{-- Hero --}}
    <section class="relative bg-gradient-hero overflow-hidden">
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <span class="emoji-hero animate-float text-5xl top-[12%] left-[6%] opacity-25">🤝</span>
            <span class="emoji-hero animate-float-2 text-6xl top-[18%] right-[10%] opacity-20">🏪</span>
            <span class="emoji-hero animate-float-3 text-4xl top-[55%] left-[12%] opacity-20">🚚</span>
            <span class="emoji-hero animate-float text-5xl bottom-[20%] right-[12%] opacity-20" style="animation-delay: 1s;">🍕</span>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-5 py-2 mb-6 animate-fade-in-up">
                    <span class="text-lg">🤝</span>
                    <span class="text-emerald-200 font-semibold text-sm">Nos partenaires</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white text-shadow-lg animate-fade-in-up" style="animation-delay: 0.1s;">
                    On livre aussi
                    <span class="text-gradient-brand block sm:inline">pour eux !</span>
                </h1>

                <p class="text-lg sm:text-xl text-emerald-100/80 mb-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                    EpiDrive ne livre pas que ses propres produits. Nous assurons aussi la livraison pour vos commercants et restaurants preferes a Ambert et alentours.
                </p>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 40L48 36C96 32 192 24 288 28C384 32 480 48 576 52C672 56 768 48 864 40C960 32 1056 24 1152 28C1248 32 1344 48 1392 56L1440 64V80H1392C1344 80 1248 80 1152 80C1056 80 960 80 864 80C768 80 672 80 576 80C480 80 384 80 288 80C192 80 96 80 48 80H0V40Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- How it works --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">📱</span>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Commandez chez eux</h3>
                <p class="text-sm text-gray-500">Passez votre commande directement aupres du partenaire par telephone ou sur place.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🚚</span>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">On recupere pour vous</h3>
                <p class="text-sm text-gray-500">EpiDrive se charge de recuperer votre commande aupres du partenaire.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🏠</span>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Livre chez vous</h3>
                <p class="text-sm text-gray-500">Votre commande est livree a votre porte dans Ambert et alentours (15-20km).</p>
            </div>
        </div>
    </section>

    {{-- Partners Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @php
            $typeIcons = [
                'kebab' => '🥙', 'pizza' => '🍕', 'boulangerie' => '🥖',
                'restaurant' => '🍽️', 'boucherie' => '🥩', 'traiteur' => '🧑‍🍳', 'autre' => '🏪',
            ];
            $typeColors = [
                'kebab' => 'from-orange-500 to-red-500',
                'pizza' => 'from-red-500 to-yellow-500',
                'boulangerie' => 'from-amber-400 to-yellow-400',
                'restaurant' => 'from-emerald-500 to-teal-500',
                'boucherie' => 'from-red-600 to-rose-500',
                'traiteur' => 'from-purple-500 to-indigo-500',
                'autre' => 'from-gray-500 to-gray-600',
            ];
        @endphp

        @if($partners->count() > 0)
            @foreach($types as $type => $group)
                <div class="mb-12">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="text-3xl">{{ $typeIcons[$type] ?? '🏪' }}</span>
                        <h2 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Partner::$types[$type] ?? ucfirst($type) }}{{ $group->count() > 1 ? 's' : '' }}</h2>
                        <span class="text-sm text-gray-400 font-medium">({{ $group->count() }})</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($group as $partner)
                            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1">
                                <div class="h-2 bg-gradient-to-r {{ $typeColors[$partner->type] ?? 'from-gray-400 to-gray-500' }}"></div>
                                <div class="p-6">
                                    <div class="flex items-start space-x-4">
                                        @if($partner->logo)
                                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                                                 class="w-16 h-16 object-contain rounded-xl border border-gray-100 flex-shrink-0">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br {{ $typeColors[$partner->type] ?? 'from-gray-400 to-gray-500' }} rounded-xl flex items-center justify-center text-white text-2xl flex-shrink-0">
                                                {{ $typeIcons[$partner->type] ?? '🏪' }}
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-emerald-700 transition-colors truncate">
                                                {{ $partner->name }}
                                            </h3>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 mt-1">
                                                {{ $partner->type_label }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($partner->description)
                                        <p class="text-sm text-gray-500 mt-4 line-clamp-2">{{ $partner->description }}</p>
                                    @endif

                                    <div class="mt-4 space-y-2 text-sm text-gray-500">
                                        @if($partner->address)
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                                <span class="truncate">{{ $partner->address }}</span>
                                            </div>
                                        @endif
                                        @if($partner->phone)
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                                <span>{{ $partner->phone }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($partner->website)
                                        <a href="{{ $partner->website }}" target="_blank" rel="noopener"
                                           class="inline-flex items-center space-x-1 text-sm text-emerald-600 hover:text-emerald-700 font-medium mt-4">
                                            <span>Voir le site</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-6">🤝</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Bientot nos partenaires ici !</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Nous travaillons avec des commercants locaux pour vous proposer encore plus de choix. Revenez bientot !
                </p>
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-16 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-8 sm:p-12 text-center text-white">
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-4">Vous etes commercant a Ambert ?</h2>
            <p class="text-emerald-100 mb-6 max-w-xl mx-auto">
                Rejoignez EpiDrive et proposez la livraison a vos clients sans aucune logistique a gerer. On s'occupe de tout !
            </p>
            <a href="mailto:contact@epidrive.fr?subject=Devenir partenaire EpiDrive"
               class="inline-flex items-center space-x-2 bg-white text-emerald-700 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-lg">
                <span>Nous contacter</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            </a>
        </div>
    </section>

@endsection
