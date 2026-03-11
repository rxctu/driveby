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
        $allPartners = collect();
        foreach ($types as $type => $group) {
            foreach ($group as $partner) {
                $allPartners->push($partner);
            }
        }
    @endphp

    {{-- HERO --}}
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

    {{-- COMMENT CA MARCHE --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="text-center mb-14 transition-all duration-600"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Comment ca marche</h2>
            <p class="text-gray-500 text-lg">Simple comme bonjour</p>
        </div>

        <div class="steps-connector relative grid grid-cols-1 sm:grid-cols-3 gap-10 sm:gap-8">
            @foreach([
                ['num' => '1', 'emoji' => '📱', 'gradient' => 'from-emerald-500 to-teal-600', 'shadow' => 'shadow-emerald-500/30', 'rotate' => 'rotate-3', 'delay' => '100', 'title' => 'Commandez chez eux', 'desc' => 'Passez votre commande directement aupres du partenaire, par telephone ou sur place.'],
                ['num' => '2', 'emoji' => '🚚', 'gradient' => 'from-amber-400 to-orange-500', 'shadow' => 'shadow-amber-400/30', 'rotate' => '-rotate-3', 'delay' => '250', 'title' => 'On recupere pour vous', 'desc' => 'EpiDrive se deplace et recupere votre commande chez le partenaire.'],
                ['num' => '3', 'emoji' => '🏠', 'gradient' => 'from-purple-500 to-indigo-600', 'shadow' => 'shadow-purple-500/30', 'rotate' => 'rotate-3', 'delay' => '400', 'title' => 'Livre chez vous !', 'desc' => 'Votre commande arrive a votre porte, dans Ambert et alentours (15-20km).'],
            ] as $step)
                <div class="text-center relative z-10 transition-all duration-500"
                     style="transition-delay: {{ $step['delay'] }}ms"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                    <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br {{ $step['gradient'] }} rounded-2xl flex items-center justify-center text-white text-2xl font-extrabold shadow-lg {{ $step['shadow'] }} {{ $step['rotate'] }} hover:rotate-0 transition-transform duration-300">
                        {{ $step['num'] }}
                    </div>
                    <div class="text-4xl mb-3">{{ $step['emoji'] }}</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-gray-500">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- NOS PARTENAIRES --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 mb-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="text-center mb-12 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">Nos partenaires</h2>
            <p class="text-gray-500 text-lg">{{ $allPartners->count() }} commercant{{ $allPartners->count() > 1 ? 's' : '' }} de confiance a Ambert</p>
        </div>

        @if($allPartners->count() > 0)
            {{-- Partner grid - corporate style --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                @foreach($allPartners as $index => $partner)
                    @php
                        $icon = $typeIcons[$partner->type] ?? '🏪';
                    @endphp
                    <div style="transition-delay: {{ min($index * 50, 500) }}ms"
                         class="group relative transition-all duration-500"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">

                        {{-- Card --}}
                        <div class="relative bg-white rounded-2xl border border-gray-200/80 overflow-hidden transition-all duration-400 hover:shadow-2xl hover:shadow-gray-200/60 hover:-translate-y-2 hover:border-emerald-200">

                            {{-- Logo area - clean white, logo centered --}}
                            <div class="relative aspect-square bg-gray-50 flex items-center justify-center p-6 overflow-hidden">
                                @if($partner->logo)
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                                         class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 drop-shadow-sm">
                                @else
                                    <span class="text-7xl sm:text-8xl group-hover:scale-105 transition-transform duration-500">{{ $icon }}</span>
                                @endif

                                {{-- Hover overlay with info --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-400 flex flex-col justify-end p-4">
                                    @if($partner->description)
                                        <p class="text-white/90 text-xs leading-relaxed line-clamp-3 mb-2">{{ $partner->description }}</p>
                                    @endif
                                    @if($partner->address)
                                        <p class="text-white/60 text-[11px] truncate">{{ $partner->address }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Name + action --}}
                            <div class="px-4 py-3 border-t border-gray-100">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm truncate group-hover:text-emerald-700 transition-colors">
                                            {{ $partner->name }}
                                        </h4>
                                        <p class="text-[11px] text-gray-400 font-medium">{{ $partner->type_label }}</p>
                                    </div>
                                    @if($partner->phone)
                                        <a href="tel:{{ preg_replace('/[^+0-9]/', '', $partner->phone) }}"
                                           class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 hover:scale-110"
                                           title="Appeler {{ $partner->name }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-6 animate-float">🤝</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Bientot nos partenaires ici !</h3>
                <p class="text-gray-500 max-w-md mx-auto">Nous travaillons avec des commercants locaux pour vous proposer encore plus de choix.</p>
            </div>
        @endif
    </section>

    {{-- CTA COMMERCANT --}}
    @if(\App\Models\Setting::getValue('partner_cta_enabled', '1') === '1')
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="relative bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 rounded-3xl overflow-hidden transition-all duration-700"
             :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'">

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
                    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 leading-tight tracking-tight transition-all duration-700 delay-100"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-8'">
                        Vous etes <span class="text-amber-300">commercant</span> ?
                    </h2>
                    <p class="text-white/70 text-base leading-relaxed mb-6 max-w-lg mx-auto lg:mx-0 transition-all duration-700 delay-200"
                       :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-6'">
                        Rejoignez EpiDrive et proposez la livraison a vos clients.
                        <strong class="text-white font-semibold">Aucun frais, aucun engagement.</strong>
                    </p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-2.5">
                        @foreach(['Livraison rapide', 'Zone 15-20km', 'Cle en main'] as $i => $pill)
                            <span class="inline-flex items-center gap-1.5 text-white/90 bg-white/10 backdrop-blur-sm rounded-full px-3.5 py-1.5 text-xs font-medium tracking-wide transition-all duration-500"
                                  style="transition-delay: {{ 300 + $i * 100 }}ms"
                                  :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                                {{ $pill }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="flex-shrink-0 transition-all duration-700 delay-500"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                    <a href="mailto:contact@epidrive.fr?subject=Devenir partenaire EpiDrive"
                       class="group/btn relative inline-flex items-center gap-3 bg-gradient-accent text-emerald-900 font-bold px-7 py-3.5 rounded-2xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 text-base animate-pulse-glow overflow-hidden">
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/25 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></span>
                        <span class="relative">Devenir partenaire</span>
                        <svg class="relative w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

@endsection
