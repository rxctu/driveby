@extends('layouts.app')

@section('title', 'Nos Partenaires - EpiDrive livre pour eux aussi !')
@section('meta_description', 'Decouvrez nos partenaires locaux. EpiDrive livre les commandes de vos restaurants et commercants preferes a Ambert.')

@section('content')

    {{-- Hero compact --}}
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

    {{-- How it works - horizontal stepper --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="relative flex flex-col sm:flex-row items-center sm:items-start justify-between gap-8 sm:gap-4">
            {{-- Connecting line --}}
            <div class="hidden sm:block absolute top-7 left-[calc(16.66%+28px)] right-[calc(16.66%+28px)] h-0.5 bg-gradient-to-r from-amber-300 via-emerald-400 to-blue-400"></div>

            <div class="flex flex-col items-center text-center flex-1 relative z-10">
                <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mb-3 ring-4 ring-white shadow-lg">
                    <span class="text-2xl">📱</span>
                </div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Etape 1</span>
                <h3 class="font-bold text-gray-800 text-sm">Commandez chez eux</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-[180px]">Par telephone ou sur place, directement aupres du partenaire.</p>
            </div>
            <div class="flex flex-col items-center text-center flex-1 relative z-10">
                <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mb-3 ring-4 ring-white shadow-lg">
                    <span class="text-2xl">🚚</span>
                </div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Etape 2</span>
                <h3 class="font-bold text-gray-800 text-sm">On recupere pour vous</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-[180px]">EpiDrive se charge de recuperer votre commande.</p>
            </div>
            <div class="flex flex-col items-center text-center flex-1 relative z-10">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-3 ring-4 ring-white shadow-lg">
                    <span class="text-2xl">🏠</span>
                </div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Etape 3</span>
                <h3 class="font-bold text-gray-800 text-sm">Livre chez vous</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-[180px]">Livree a votre porte dans Ambert et alentours (15-20km).</p>
            </div>
        </div>
    </section>

    {{-- Partners List --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        @php
            $typeIcons = [
                'kebab' => '🥙', 'pizza' => '🍕', 'boulangerie' => '🥖',
                'restaurant' => '🍽️', 'boucherie' => '🥩', 'traiteur' => '🧑‍🍳', 'autre' => '🏪',
            ];
            $typeColors = [
                'kebab' => ['from-orange-500 to-red-500', 'bg-orange-50 text-orange-700 border-orange-200'],
                'pizza' => ['from-red-500 to-yellow-500', 'bg-red-50 text-red-700 border-red-200'],
                'boulangerie' => ['from-amber-400 to-yellow-400', 'bg-amber-50 text-amber-700 border-amber-200'],
                'restaurant' => ['from-emerald-500 to-teal-500', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                'boucherie' => ['from-red-600 to-rose-500', 'bg-rose-50 text-rose-700 border-rose-200'],
                'traiteur' => ['from-purple-500 to-indigo-500', 'bg-purple-50 text-purple-700 border-purple-200'],
                'autre' => ['from-gray-500 to-gray-600', 'bg-gray-50 text-gray-700 border-gray-200'],
            ];
            $allPartners = collect();
            foreach ($types as $type => $group) {
                foreach ($group as $partner) {
                    $allPartners->push($partner);
                }
            }
        @endphp

        @if($allPartners->count() > 0)
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-2">Nos partenaires locaux</h2>
                <p class="text-gray-500">{{ $allPartners->count() }} commercant{{ $allPartners->count() > 1 ? 's' : '' }} de confiance a Ambert</p>
            </div>

            <div class="space-y-5">
                @foreach($allPartners as $partner)
                    @php
                        $gradient = $typeColors[$partner->type][0] ?? 'from-gray-400 to-gray-500';
                        $badge = $typeColors[$partner->type][1] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                        $icon = $typeIcons[$partner->type] ?? '🏪';
                    @endphp
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 overflow-hidden">
                        <div class="flex flex-col sm:flex-row">
                            {{-- Left accent + logo --}}
                            <div class="relative flex-shrink-0 sm:w-48 h-32 sm:h-auto bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                                @if($partner->logo)
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                                         class="w-20 h-20 sm:w-24 sm:h-24 object-contain rounded-2xl bg-white/90 p-2 shadow-lg">
                                @else
                                    <span class="text-5xl sm:text-6xl drop-shadow-lg">{{ $icon }}</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 p-5 sm:p-6 flex flex-col justify-center">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">
                                        {{ $partner->name }}
                                    </h3>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badge }}">
                                        {{ $icon }} {{ $partner->type_label }}
                                    </span>
                                </div>

                                @if($partner->description)
                                    <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $partner->description }}</p>
                                @endif

                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500">
                                    @if($partner->address)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                            <span>{{ $partner->address }}</span>
                                        </div>
                                    @endif
                                    @if($partner->phone)
                                        <a href="tel:{{ preg_replace('/[^+0-9]/', '', $partner->phone) }}" class="flex items-center gap-2 hover:text-emerald-600 transition-colors">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                            <span>{{ $partner->phone }}</span>
                                        </a>
                                    @endif
                                    @if($partner->website)
                                        <a href="{{ $partner->website }}" target="_blank" rel="noopener"
                                           class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                            <span>Site web</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- CTA right side --}}
                            <div class="flex-shrink-0 flex items-center px-5 pb-5 sm:pb-0 sm:pr-6">
                                @if($partner->phone)
                                    <a href="tel:{{ preg_replace('/[^+0-9]/', '', $partner->phone) }}"
                                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 hover:shadow-lg text-sm whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                        Appeler
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-6">🤝</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Bientot nos partenaires ici !</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Nous travaillons avec des commercants locaux pour vous proposer encore plus de choix. Revenez bientot !
                </p>
            </div>
        @endif
    </section>

    {{-- CTA Commercant --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="relative bg-white rounded-3xl border-2 border-emerald-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-amber-50 to-transparent rounded-tr-full"></div>

            <div class="relative z-10 p-8 sm:p-12 flex flex-col lg:flex-row items-center gap-8">
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 font-semibold text-xs uppercase tracking-wider px-4 py-2 rounded-full mb-4">
                        <span>🏪</span> Devenez partenaire
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">
                        Vous etes commercant a Ambert ?
                    </h2>
                    <p class="text-gray-500 leading-relaxed max-w-lg">
                        Proposez la livraison a vos clients sans logistique a gerer.
                        EpiDrive recupere et livre vos commandes dans tout Ambert et alentours.
                        <strong class="text-gray-700">Aucun frais d'inscription.</strong>
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 mt-6 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            <span>Livraison rapide</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            <span>Zone 15-20km</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            <span>Simple et flexible</span>
                        </div>
                    </div>
                </div>

                <div class="flex-shrink-0 flex flex-col items-center gap-3">
                    <a href="mailto:contact@epidrive.fr?subject=Devenir partenaire EpiDrive"
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        Nous contacter
                    </a>
                    <span class="text-xs text-gray-400">contact@epidrive.fr</span>
                </div>
            </div>
        </div>
    </section>

@endsection
