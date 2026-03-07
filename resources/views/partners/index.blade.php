@extends('layouts.app')

@section('title', 'Nos Partenaires - EpiDrive livre pour eux aussi !')
@section('meta_description', 'Decouvrez nos partenaires locaux. EpiDrive livre les commandes de vos restaurants et commercants preferes a Ambert.')

@section('content')

    @php
        $typeIcons = [
            'kebab' => '🥙', 'pizza' => '🍕', 'boulangerie' => '🥖',
            'restaurant' => '🍽️', 'boucherie' => '🥩', 'traiteur' => '🧑‍🍳', 'autre' => '🏪',
        ];
        $typeBg = [
            'kebab' => 'from-orange-500 to-red-500',
            'pizza' => 'from-red-500 to-yellow-500',
            'boulangerie' => 'from-amber-400 to-yellow-400',
            'restaurant' => 'from-emerald-500 to-teal-500',
            'boucherie' => 'from-red-600 to-rose-500',
            'traiteur' => 'from-purple-500 to-indigo-500',
            'autre' => 'from-gray-500 to-gray-600',
        ];
        $typeBadge = [
            'kebab' => 'bg-orange-100 text-orange-700',
            'pizza' => 'bg-red-100 text-red-700',
            'boulangerie' => 'bg-amber-100 text-amber-700',
            'restaurant' => 'bg-emerald-100 text-emerald-700',
            'boucherie' => 'bg-rose-100 text-rose-700',
            'traiteur' => 'bg-purple-100 text-purple-700',
            'autre' => 'bg-gray-100 text-gray-700',
        ];
        $allPartners = collect();
        foreach ($types as $type => $group) {
            foreach ($group as $partner) {
                $allPartners->push($partner);
            }
        }
    @endphp

    {{-- ============================================
         HERO SECTION
         ============================================ --}}
    <section class="relative bg-gradient-hero overflow-hidden">
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <span class="emoji-hero animate-float text-5xl top-[12%] left-[6%] opacity-25">🤝</span>
            <span class="emoji-hero animate-float-2 text-6xl top-[18%] right-[10%] opacity-20">🍕</span>
            <span class="emoji-hero animate-float-3 text-4xl top-[55%] left-[12%] opacity-20">🚚</span>
            <span class="emoji-hero animate-float text-5xl bottom-[20%] right-[12%] opacity-20" style="animation-delay: 1s;">🥙</span>
            <span class="emoji-hero animate-float-2 text-4xl top-[35%] left-[75%] opacity-15" style="animation-delay: 2s;">🥖</span>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-5 py-2 mb-6 animate-fade-in-up">
                    <span class="text-lg">🤝</span>
                    <span class="text-emerald-200 font-semibold text-sm">Nos partenaires locaux</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white text-shadow-lg animate-fade-in-up" style="animation-delay: 0.1s;">
                    On livre aussi
                    <span class="text-gradient-brand block sm:inline">pour eux !</span>
                </h1>

                <p class="text-lg sm:text-xl text-emerald-100/80 mb-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                    EpiDrive assure la livraison pour vos commercants et restaurants preferes a Ambert et alentours.
                </p>

                <div class="flex items-center justify-center gap-6 text-sm text-white/70 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <span class="flex items-center gap-1.5"><span class="text-lg">🚚</span> Livraison rapide</span>
                    <span class="flex items-center gap-1.5"><span class="text-lg">💰</span> 0 frais pour eux</span>
                    <span class="flex items-center gap-1.5"><span class="text-lg">📍</span> 15-20km</span>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 40L48 36C96 32 192 24 288 28C384 32 480 48 576 52C672 56 768 48 864 40C960 32 1056 24 1152 28C1248 32 1344 48 1392 56L1440 64V80H1392C1344 80 1248 80 1152 80C1056 80 960 80 864 80C768 80 672 80 576 80C480 80 384 80 288 80C192 80 96 80 48 80H0V40Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- ============================================
         COMMENT CA MARCHE
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="text-center mb-10" x-show="shown" x-transition.duration.600ms>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Comment ca marche ?</h2>
            <p class="text-gray-500 text-lg">Trois etapes simples pour vous faire livrer</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
            @foreach([
                ['delay' => '0ms', 'emoji' => '📱', 'color' => 'amber', 'title' => 'Commandez chez eux', 'desc' => 'Passez votre commande directement aupres du partenaire, par telephone ou sur place.'],
                ['delay' => '150ms', 'emoji' => '🚚', 'color' => 'emerald', 'title' => 'On recupere pour vous', 'desc' => 'EpiDrive se deplace et recupere votre commande chez le partenaire.'],
                ['delay' => '300ms', 'emoji' => '🏠', 'color' => 'blue', 'title' => 'Livre chez vous', 'desc' => 'Votre commande arrive a votre porte, dans Ambert et alentours (15-20km).'],
            ] as $step)
                <div x-show="shown"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-6"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="transition-delay: {{ $step['delay'] }}"
                     class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-{{ $step['color'] }}-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl">{{ $step['emoji'] }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================================
         NOS PARTENAIRES
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="text-center mb-10" x-show="shown" x-transition.duration.600ms>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Nos partenaires</h2>
            <p class="text-gray-500 text-lg">{{ $allPartners->count() }} commercant{{ $allPartners->count() > 1 ? 's' : '' }} de confiance a Ambert</p>
        </div>

        @if($allPartners->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($allPartners as $index => $partner)
                    @php
                        $gradient = $typeBg[$partner->type] ?? 'from-gray-400 to-gray-500';
                        $badge = $typeBadge[$partner->type] ?? 'bg-gray-100 text-gray-700';
                        $icon = $typeIcons[$partner->type] ?? '🏪';
                    @endphp
                    <div x-show="shown"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="transition-delay: {{ $index * 100 }}ms"
                         class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

                        {{-- Top gradient band with icon --}}
                        <div class="relative h-32 bg-gradient-to-br {{ $gradient }} flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-black/5"></div>
                            <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full"></div>
                            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white/10 rounded-full"></div>
                            @if($partner->logo)
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                                     class="relative z-10 w-20 h-20 object-contain rounded-2xl bg-white/90 p-2 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            @else
                                <span class="relative z-10 text-6xl drop-shadow-lg group-hover:scale-110 transition-transform duration-300">{{ $icon }}</span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-emerald-700 transition-colors truncate">
                                    {{ $partner->name }}
                                </h3>
                                <span class="flex-shrink-0 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $icon }} {{ $partner->type_label }}
                                </span>
                            </div>

                            @if($partner->description)
                                <p class="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-2">{{ $partner->description }}</p>
                            @endif

                            <div class="space-y-2 text-sm text-gray-500">
                                @if($partner->address)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                        <span class="truncate">{{ $partner->address }}</span>
                                    </div>
                                @endif
                                @if($partner->phone)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                        <span>{{ $partner->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Bottom action --}}
                        @if($partner->phone)
                            <div class="px-5 pb-5">
                                <a href="tel:{{ preg_replace('/[^+0-9]/', '', $partner->phone) }}"
                                   class="flex items-center justify-center gap-2 w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold py-2.5 rounded-xl transition-colors duration-200 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                    Appeler {{ $partner->name }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-6 animate-float">🤝</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Bientot nos partenaires ici !</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Nous travaillons avec des commercants locaux pour vous proposer encore plus de choix. Revenez bientot !
                </p>
            </div>
        @endif
    </section>

    {{-- ============================================
         CTA COMMERCANT
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div x-show="shown"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 rounded-3xl overflow-hidden">

            {{-- Animated floating shapes --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full animate-float"></div>
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-white/10 rounded-full animate-float-2"></div>
                <div class="absolute top-1/2 left-2/3 w-20 h-20 bg-white/5 rounded-full animate-float-3"></div>
                <div class="absolute top-4 right-1/4 w-12 h-12 bg-white/5 rounded-full animate-float" style="animation-delay: 1.5s;"></div>
            </div>

            <div class="relative z-10 p-8 sm:p-12 lg:p-14 flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                {{-- Text --}}
                <div class="flex-1 text-center lg:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3 leading-tight">
                        Vous etes commercant ?
                    </h2>
                    <p class="text-white/80 text-lg leading-relaxed mb-6 max-w-lg mx-auto lg:mx-0">
                        Rejoignez EpiDrive et proposez la livraison a vos clients.
                        <strong class="text-white">Aucun frais, aucun engagement.</strong> On s'occupe de tout.
                    </p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-3">
                        <span class="inline-flex items-center gap-1.5 text-white bg-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                            Livraison rapide
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-white bg-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                            Zone 15-20km
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-white bg-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                            Cle en main
                        </span>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="flex-shrink-0">
                    <a href="mailto:contact@epidrive.fr?subject=Devenir partenaire EpiDrive"
                       class="inline-flex items-center gap-3 bg-gradient-accent text-emerald-900 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 text-lg animate-pulse-glow">
                        <span>Devenir partenaire</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
