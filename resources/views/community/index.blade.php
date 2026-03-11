@extends('layouts.app')

@section('title', 'Communauté EpiDrive - Listes de courses partagées')
@section('meta_description', 'Découvrez et partagez vos listes de courses préférées avec la communauté EpiDrive.')

@section('content')

    {{-- ============================================
         HERO SECTION
         ============================================ --}}
    <section class="relative bg-gradient-hero overflow-hidden">
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <span class="emoji-hero animate-float text-5xl top-[12%] left-[6%] opacity-25">📋</span>
            <span class="emoji-hero animate-float-2 text-6xl top-[18%] right-[10%] opacity-20">🛒</span>
            <span class="emoji-hero animate-float-3 text-4xl top-[55%] left-[12%] opacity-20">💬</span>
            <span class="emoji-hero animate-float text-5xl bottom-[20%] right-[12%] opacity-20" style="animation-delay: 1s;">👍</span>
            <span class="emoji-hero animate-float-2 text-4xl top-[35%] left-[75%] opacity-15" style="animation-delay: 2s;">🔥</span>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-5 py-2 mb-6 animate-fade-in-up">
                    <span class="text-lg">👥</span>
                    <span class="text-emerald-200 font-semibold text-sm">Espace communautaire</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white text-shadow-lg animate-fade-in-up" style="animation-delay: 0.1s;">
                    Communauté
                    <span class="text-gradient-brand block sm:inline">EpiDrive</span>
                </h1>

                <p class="text-lg sm:text-xl text-emerald-100/80 mb-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                    Découvrez et partagez vos listes de courses préférées. Inspirez-vous des autres et partagez vos meilleures trouvailles !
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('community.create') }}"
                       class="inline-flex items-center space-x-2 bg-gradient-accent text-emerald-900 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 text-lg">
                        <span>✨</span>
                        <span>Créer ma liste</span>
                    </a>
                    @auth
                        <a href="{{ route('community.my-lists') }}"
                           class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold px-6 py-3 rounded-xl hover:bg-white/20 transition-all duration-200">
                            <span>📋</span>
                            <span>Mes listes</span>
                        </a>
                    @endauth
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
         FILTERS & SORT BAR
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-4" x-data="{ searchQuery: '{{ request('search', '') }}' }">
        {{-- Sort tabs + Search --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            {{-- Sort tabs - segmented control style --}}
            <div class="inline-flex items-center bg-gray-100 rounded-xl p-1">
                @php
                    $sorts = [
                        'popular' => ['label' => 'Populaire', 'icon' => '🔥'],
                        'recent'  => ['label' => 'Récent', 'icon' => '🕐'],
                        'trending' => ['label' => 'Tendance', 'icon' => '📈'],
                    ];
                @endphp
                @foreach($sorts as $sortKey => $sortData)
                    <a href="{{ route('community.index', array_merge(request()->except('sort', 'page'), ['sort' => $sortKey])) }}"
                       class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                              {{ ($sort ?? 'popular') === $sortKey
                                  ? 'bg-white text-gray-900 shadow-sm'
                                  : 'text-gray-500 hover:text-gray-700' }}">
                        <span>{{ $sortData['icon'] }}</span>
                        <span>{{ $sortData['label'] }}</span>
                    </a>
                @endforeach
            </div>

            {{-- Search --}}
            <form action="{{ route('community.index') }}" method="GET" class="w-full sm:w-auto">
                @if($sort ?? false)
                    <input type="hidden" name="sort" value="{{ $sort }}">
                @endif
                @if($tag ?? request('tag'))
                    <input type="hidden" name="tag" value="{{ $tag ?? request('tag') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" x-model="searchQuery" placeholder="Rechercher une liste..."
                           class="w-full sm:w-72 pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
        </div>

        {{-- Tag filter bar --}}
        <div class="flex overflow-x-auto pb-3 -mx-4 px-4 sm:mx-0 sm:px-0 gap-2 scrollbar-hide">
            @php
                $activeTag = $tag ?? request('tag');
                $allTags = isset($availableTags) && $availableTags->count() > 0 ? $availableTags->toArray() : ['Budget', 'Famille', 'Apéro', 'Healthy', 'Étudiant', 'Fêtes', 'Végétarien', 'Rapide'];
                if (!is_array($allTags) && method_exists($allTags, 'toArray')) {
                    $allTags = $allTags->toArray();
                }
                $tagEmojis = [
                    'Budget' => '💰', 'Famille' => '👨‍👩‍👧‍👦', 'Apéro' => '🥂', 'Healthy' => '🥗',
                    'Étudiant' => '🎓', 'Fêtes' => '🎉', 'Végétarien' => '🌱', 'Rapide' => '⚡',
                ];
            @endphp
            <a href="{{ route('community.index', array_merge(request()->except('tag', 'page'))) }}"
               class="flex-shrink-0 inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200
                      {{ !$activeTag
                          ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30'
                          : 'bg-white text-gray-600 border border-gray-200 hover:border-emerald-300 hover:text-emerald-700' }}">
                Tous
            </a>
            @foreach($allTags as $tagItem)
                <a href="{{ route('community.index', array_merge(request()->except('tag', 'page'), ['tag' => $tagItem])) }}"
                   class="flex-shrink-0 inline-flex items-center space-x-1 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200
                          {{ $activeTag === $tagItem
                              ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30'
                              : 'bg-white text-gray-600 border border-gray-200 hover:border-emerald-300 hover:text-emerald-700' }}">
                    <span>{{ $tagEmojis[$tagItem] ?? '🏷️' }}</span>
                    <span>{{ $tagItem }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ============================================
         LISTS GRID
         ============================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
             x-data="{ shown: false }" x-intersect.once="shown = true">
        @php
            $cardColors = [
                'from-emerald-500 to-teal-500',
                'from-amber-400 to-orange-500',
                'from-purple-500 to-indigo-500',
                'from-pink-500 to-rose-500',
                'from-blue-500 to-cyan-500',
                'from-red-500 to-orange-400',
            ];
        @endphp

        @if($lists->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lists as $index => $list)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-400 overflow-hidden hover:-translate-y-1.5"
                         style="transition-delay: {{ min($index * 60, 400) }}ms"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         x-data="{ copying: false, copied: false }">

                        {{-- Gradient header strip --}}
                        <div class="h-1.5 bg-gradient-to-r {{ $cardColors[$index % count($cardColors)] }}"></div>

                        <a href="{{ route('community.show', $list) }}" class="block p-5">
                            {{-- User info row --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $cardColors[$index % count($cardColors)] }} flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                        {{ mb_strtoupper(mb_substr($list->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $list->user->name ?? 'Anonyme' }}</p>
                                        <p class="text-xs text-gray-400">{{ $list->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                {{-- Item count badge --}}
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 text-xs font-semibold text-gray-600">
                                    📦 {{ $list->items_count ?? 0 }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-emerald-700 transition-colors duration-200 mb-1.5">
                                {{ $list->title }}
                            </h3>
                            @if($list->description)
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4 leading-relaxed">{{ $list->description }}</p>
                            @endif

                            {{-- Tags --}}
                            @if($list->tags)
                                <div class="flex flex-wrap gap-1.5 mb-1">
                                    @foreach(is_array($list->tags) ? $list->tags : explode(',', $list->tags) as $tag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </a>

                        {{-- Bottom action bar --}}
                        <div class="border-t border-gray-100 px-5 py-3 flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-sm">
                                <span class="inline-flex items-center space-x-1 text-gray-500" title="Likes">
                                    <span class="text-base">👍</span>
                                    <span class="font-semibold">{{ $list->likes_count ?? $list->likes ?? 0 }}</span>
                                </span>
                                <span class="inline-flex items-center space-x-1 text-gray-500" title="Dislikes">
                                    <span class="text-base">👎</span>
                                    <span class="font-semibold">{{ $list->dislikes_count ?? $list->dislikes ?? 0 }}</span>
                                </span>
                                @if(isset($list->total_price))
                                    <span class="inline-flex items-center space-x-1 text-emerald-700 font-bold" title="Prix total estimé">
                                        {{ number_format($list->total_price, 2, ',', ' ') }}&nbsp;&euro;
                                    </span>
                                @endif
                            </div>

                            <button
                                @click.prevent="
                                    if (copied) return;
                                    copying = true;
                                    fetch('{{ route('community.copy', $list) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                            'Accept': 'application/json'
                                        }
                                    }).then(r => r.json()).then(d => {
                                        copying = false;
                                        copied = true;
                                        $dispatch('cart-updated');
                                        setTimeout(() => { copied = false; }, 3000);
                                    }).catch(() => { copying = false; });
                                "
                                :disabled="copying"
                                class="inline-flex items-center space-x-1.5 text-xs font-semibold px-3.5 py-2 rounded-xl transition-all duration-300"
                                :class="copied ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white'"
                                title="Copier dans mon panier">
                                <svg x-show="!copying && !copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                </svg>
                                <svg x-show="copying" x-cloak class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                <svg x-show="copied" x-cloak class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span x-text="copied ? 'Copié !' : 'Copier'"></span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $lists->withQueryString()->links() }}
            </div>
        @else
            {{-- Empty state --}}
            <div class="text-center py-20">
                <div class="text-6xl mb-6 animate-float">📋</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucune liste trouvée</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Soyez le premier à partager une liste de courses avec la communauté !
                </p>
                <a href="{{ route('community.create') }}"
                   class="inline-flex items-center space-x-2 bg-gradient-accent text-emerald-900 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 text-lg">
                    <span>✨</span>
                    <span>Créer ma liste</span>
                </a>
            </div>
        @endif
    </section>

@endsection
