@extends('layouts.app')

@section('title', 'Mes listes de courses - Communauté EpiDrive')
@section('meta_description', 'Gérez vos listes de courses partagées sur EpiDrive.')

@section('content')

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ deleteTarget: null, showDeleteModal: false }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-3">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Accueil</a>
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('community.index') }}" class="hover:text-emerald-700 transition-colors">Communauté</a>
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-700 font-medium">Mes listes</span>
                </nav>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">📋 Mes listes de courses</h1>
                <p class="text-gray-500 mt-1">Gérez et suivez vos listes partagées</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('community.index') }}"
                   class="inline-flex items-center space-x-2 border border-gray-200 text-gray-600 font-semibold px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200">
                    <span>👥</span>
                    <span>Voir la communauté</span>
                </a>
                <a href="{{ route('community.create') }}"
                   class="inline-flex items-center space-x-2 bg-gradient-accent text-emerald-900 font-bold px-6 py-2.5 rounded-xl hover:shadow-lg hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105">
                    <span>✨</span>
                    <span>Nouvelle liste</span>
                </a>
            </div>
        </div>

        {{-- Delete confirmation modal --}}
        <div x-show="showDeleteModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-black/50" @click="showDeleteModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-md w-full z-10"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="text-center">
                    <div class="text-5xl mb-4">🗑️</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Supprimer cette liste ?</h3>
                    <p class="text-gray-500 mb-6">Cette action est irréversible. Votre liste et tous ses commentaires seront supprimés définitivement.</p>
                    <div class="flex items-center justify-center gap-3">
                        <button @click="showDeleteModal = false"
                                class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors duration-200">
                            Annuler
                        </button>
                        <form :action="deleteTarget" method="POST" x-ref="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors duration-200 shadow-md shadow-red-200">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1 animate-fade-in-up"
                         style="animation-delay: {{ $index * 0.05 }}s;">
                        {{-- Color stripe --}}
                        <div class="h-2 bg-gradient-to-r {{ $cardColors[$index % count($cardColors)] }}"></div>

                        <a href="{{ route('community.show', $list) }}" class="block p-5">
                            {{-- Title + visibility badge --}}
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-emerald-700 transition-colors duration-200 flex-1">
                                    {{ $list->title }}
                                </h3>
                                <span class="flex-shrink-0 inline-flex items-center space-x-1 text-xs font-semibold px-2.5 py-1 rounded-full
                                            {{ $list->is_public ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    <span>{{ $list->is_public ? '🌍' : '🔒' }}</span>
                                    <span>{{ $list->is_public ? 'Publique' : 'Privée' }}</span>
                                </span>
                            </div>

                            {{-- Description --}}
                            @if($list->description)
                                <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $list->description }}</p>
                            @endif

                            {{-- Tags --}}
                            @if($list->tags)
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    @foreach(is_array($list->tags) ? $list->tags : explode(',', $list->tags) as $tag)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Stats --}}
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="inline-flex items-center space-x-1">
                                    <span>📦</span>
                                    <span>{{ $list->items_count ?? $list->items->count() ?? 0 }} articles</span>
                                </span>
                                @if(isset($list->total_price))
                                    <span class="inline-flex items-center space-x-1 text-emerald-700 font-bold">
                                        {{ number_format($list->total_price, 2, ',', ' ') }}&nbsp;&euro;
                                    </span>
                                @endif
                            </div>

                            {{-- Date --}}
                            <p class="text-xs text-gray-400 mt-3">Créée {{ $list->created_at->diffForHumans() }}</p>
                        </a>

                        {{-- Actions bar --}}
                        <div class="border-t border-gray-100 px-5 py-3 flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-sm text-gray-500">
                                <span class="inline-flex items-center space-x-1">
                                    <span>👍</span>
                                    <span>{{ $list->likes_count ?? $list->likes ?? 0 }}</span>
                                </span>
                                <span class="inline-flex items-center space-x-1">
                                    <span>💬</span>
                                    <span>{{ $list->comments_count ?? 0 }}</span>
                                </span>
                            </div>

                            <button @click.prevent="deleteTarget = '{{ route('community.destroy', $list) }}'; showDeleteModal = true"
                                    class="inline-flex items-center space-x-1 text-xs font-semibold text-red-500 hover:text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                    title="Supprimer cette liste">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Supprimer</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $lists->links() }}
            </div>
        @else
            {{-- Empty state --}}
            <div class="text-center py-20 animate-fade-in-up">
                <div class="text-6xl mb-6">📋</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Vous n'avez pas encore de liste</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Créez votre première liste de courses et partagez-la avec la communauté EpiDrive !
                </p>
                <a href="{{ route('community.create') }}"
                   class="inline-flex items-center space-x-2 bg-gradient-accent text-emerald-900 font-bold px-8 py-4 rounded-2xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 text-lg">
                    <span>✨</span>
                    <span>Créer ma première liste</span>
                </a>
            </div>
        @endif

    </section>

@endsection
