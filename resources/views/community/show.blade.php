@extends('layouts.app')

@section('title', $list->title . ' - Communauté EpiDrive')
@section('meta_description', Str::limit($list->description ?? 'Liste de courses partagée sur EpiDrive', 160))

@section('content')

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
             x-data="{
                 vote: {{ $userVote ?? 'null' }},
                 likes: {{ $list->likes_count ?? $list->likes ?? 0 }},
                 dislikes: {{ $list->dislikes_count ?? $list->dislikes ?? 0 }},
                 copying: false,
                 copied: false,
                 showDeleteModal: false,
                 commentText: '',
                 submittingComment: false,
                 toastMessage: '',
                 showToast: false,
                 sendVote(value) {
                     const oldVote = this.vote;
                     const oldLikes = this.likes;
                     const oldDislikes = this.dislikes;

                     if (this.vote === value) {
                         if (value === 1) this.likes--;
                         else this.dislikes--;
                         this.vote = null;
                     } else {
                         if (oldVote === 1) this.likes--;
                         if (oldVote === -1) this.dislikes--;
                         if (value === 1) this.likes++;
                         else this.dislikes++;
                         this.vote = value;
                     }

                     fetch('{{ route('community.vote', $list) }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({ vote: value })
                     }).catch(() => {
                         this.vote = oldVote;
                         this.likes = oldLikes;
                         this.dislikes = oldDislikes;
                     });
                 },
                 copyToCart() {
                     if (this.copied) return;
                     this.copying = true;
                     fetch('{{ route('community.copy', $list) }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                             'Accept': 'application/json'
                         }
                     }).then(r => r.json()).then(d => {
                         this.copying = false;
                         this.copied = true;
                         this.toastMessage = 'Liste copiée dans votre panier !';
                         this.showToast = true;
                         $dispatch('cart-updated');
                         setTimeout(() => { this.copied = false; this.showToast = false; }, 3000);
                     }).catch(() => { this.copying = false; });
                 },
                 submitComment() {
                     if (!this.commentText.trim() || this.submittingComment) return;
                     this.submittingComment = true;
                     fetch('{{ route('community.comment', $list) }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({ content: this.commentText })
                     }).then(r => {
                         if (r.ok) {
                             this.commentText = '';
                             window.location.reload();
                         }
                         this.submittingComment = false;
                     }).catch(() => { this.submittingComment = false; });
                 }
             }">

        {{-- Toast notification --}}
        <div x-show="showToast" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed bottom-6 right-6 z-50 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-emerald-600/30">
            <div class="flex items-center space-x-3">
                <span class="text-xl">✅</span>
                <p class="font-semibold" x-text="toastMessage"></p>
            </div>
        </div>

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Accueil</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('community.index') }}" class="hover:text-emerald-700 transition-colors">Communauté</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium truncate max-w-[200px]">{{ $list->title }}</span>
        </nav>

        {{-- ============================================
             HEADER SECTION
             ============================================ --}}
        <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 mb-6 animate-fade-in-up">
            {{-- User info --}}
            <div class="flex items-center space-x-3 mb-5">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ mb_strtoupper(mb_substr($list->user->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-gray-900">{{ $list->user->name ?? 'Anonyme' }}</p>
                    <p class="text-sm text-gray-400">Publié {{ $list->created_at->diffForHumans() }}</p>
                </div>
            </div>

            {{-- Title & description --}}
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">{{ $list->title }}</h1>
            @if($list->description)
                <p class="text-gray-600 leading-relaxed mb-5">{{ $list->description }}</p>
            @endif

            {{-- Tags --}}
            @if($list->tags)
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach(is_array($list->tags) ? $list->tags : explode(',', $list->tags) as $tag)
                        <a href="{{ route('community.index', ['tag' => trim($tag)]) }}"
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-100 hover:bg-emerald-100 transition-colors duration-200">
                            🏷️ {{ trim($tag) }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Stats row --}}
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-100">
                @if(isset($list->views))
                    <span class="inline-flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ $list->views }} vue{{ $list->views > 1 ? 's' : '' }}</span>
                    </span>
                @endif
                <span class="inline-flex items-center space-x-1.5">
                    <span>👍</span>
                    <span x-text="likes"></span>
                </span>
                <span class="inline-flex items-center space-x-1.5">
                    <span>👎</span>
                    <span x-text="dislikes"></span>
                </span>
                @if(isset($list->copies_count))
                    <span class="inline-flex items-center space-x-1.5">
                        <span>📋</span>
                        <span>{{ $list->copies_count }} copie{{ $list->copies_count > 1 ? 's' : '' }}</span>
                    </span>
                @endif
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Like button --}}
                <button @click="sendVote(1)"
                        class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 border-2"
                        :class="vote === 1
                            ? 'bg-emerald-100 border-emerald-500 text-emerald-700 shadow-md shadow-emerald-200'
                            : 'bg-white border-gray-200 text-gray-600 hover:border-emerald-300 hover:text-emerald-600'">
                    <span class="text-lg transition-transform duration-200" :class="vote === 1 && 'scale-125'">👍</span>
                    <span x-text="likes"></span>
                </button>

                {{-- Dislike button --}}
                <button @click="sendVote(-1)"
                        class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 border-2"
                        :class="vote === -1
                            ? 'bg-red-50 border-red-400 text-red-600 shadow-md shadow-red-100'
                            : 'bg-white border-gray-200 text-gray-600 hover:border-red-300 hover:text-red-500'">
                    <span class="text-lg transition-transform duration-200" :class="vote === -1 && 'scale-125'">👎</span>
                    <span x-text="dislikes"></span>
                </button>

                {{-- Copy to cart --}}
                <button @click="copyToCart()"
                        :disabled="copying"
                        class="inline-flex items-center space-x-2 px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ml-auto"
                        :class="copied
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30'
                            : 'bg-gradient-accent text-emerald-900 hover:shadow-lg hover:shadow-amber-400/30 hover:scale-105'">
                    <svg x-show="!copying && !copied" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <svg x-show="copying" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <svg x-show="copied" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span x-text="copied ? 'Copié dans le panier !' : 'Copier dans mon panier'"></span>
                </button>
            </div>

            {{-- Owner actions --}}
            @auth
                @if(Auth::id() === $list->user_id)
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                        <button @click="showDeleteModal = true"
                                class="inline-flex items-center space-x-2 text-sm text-red-500 hover:text-red-700 font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Supprimer cette liste</span>
                        </button>
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
                                <p class="text-gray-500 mb-6">Cette action est irréversible. Votre liste et tous ses commentaires seront supprimés.</p>
                                <div class="flex items-center justify-center gap-3">
                                    <button @click="showDeleteModal = false"
                                            class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors duration-200">
                                        Annuler
                                    </button>
                                    <form method="POST" action="{{ route('community.destroy', $list) }}">
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
                @endif
            @endauth
        </div>

        {{-- ============================================
             PRODUCTS LIST
             ============================================ --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">
                    📦 Produits de la liste
                    <span class="text-sm font-normal text-gray-500">({{ $list->items->count() }} article{{ $list->items->count() > 1 ? 's' : '' }})</span>
                </h2>
            </div>

            <div class="divide-y divide-gray-50">
                @php $totalPrice = 0; @endphp
                @foreach($list->items as $item)
                    @php
                        $product = $item->product;
                        $subtotal = ($product->price ?? 0) * ($item->quantity ?? 1);
                        $totalPrice += $subtotal;
                    @endphp
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/50 transition-colors duration-150">
                        {{-- Product image --}}
                        <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-emerald-100 to-teal-50">
                            @if($product && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-2xl opacity-60">🛒</span>
                                </div>
                            @endif
                        </div>

                        {{-- Product info --}}
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-800 truncate">{{ $product->name ?? 'Produit inconnu' }}</h4>
                            @if($product && $product->category)
                                <p class="text-xs text-gray-400">{{ $product->category->name }}</p>
                            @endif
                            @if($item->note)
                                <p class="text-xs text-amber-600 mt-1 italic">📝 {{ $item->note }}</p>
                            @endif
                        </div>

                        {{-- Quantity --}}
                        <div class="text-center flex-shrink-0">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-sm">
                                {{ $item->quantity ?? 1 }}
                            </span>
                            <p class="text-xs text-gray-400 mt-0.5">qté</p>
                        </div>

                        {{-- Price --}}
                        <div class="text-right flex-shrink-0">
                            @if($product)
                                <p class="text-xs text-gray-400">{{ number_format($product->price, 2, ',', ' ') }}&nbsp;&euro;/u</p>
                            @endif
                            <p class="font-bold text-gray-900">{{ number_format($subtotal, 2, ',', ' ') }}&nbsp;&euro;</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-t border-emerald-100">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">Total estimé</span>
                    <span class="text-2xl font-extrabold text-emerald-700">{{ number_format($totalPrice, 2, ',', ' ') }}&nbsp;&euro;</span>
                </div>
            </div>
        </div>

        {{-- ============================================
             COMMENTS SECTION
             ============================================ --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">
                    💬 Commentaires
                    <span class="text-sm font-normal text-gray-500">({{ $list->comments->count() }})</span>
                </h2>
            </div>

            {{-- Comment form --}}
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                @auth
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-emerald-400 flex items-center justify-center text-emerald-900 font-bold text-sm flex-shrink-0">
                            {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <textarea x-model="commentText"
                                      placeholder="Écrire un commentaire..."
                                      rows="3"
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 resize-none"></textarea>
                            <div class="flex justify-end mt-2">
                                <button @click="submitComment()"
                                        :disabled="!commentText.trim() || submittingComment"
                                        class="inline-flex items-center space-x-2 px-5 py-2 rounded-xl font-semibold text-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        :class="commentText.trim() ? 'bg-emerald-700 text-white hover:bg-emerald-800 shadow-md' : 'bg-gray-200 text-gray-500'">
                                    <svg x-show="submittingComment" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    <span>Publier</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 mb-3">Connectez-vous pour commenter</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center space-x-2 bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-emerald-800 transition-colors duration-200">
                            <span>🔑</span>
                            <span>Se connecter</span>
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Comments list --}}
            <div class="divide-y divide-gray-50">
                @forelse($list->comments->sortByDesc('created_at') as $comment)
                    <div class="px-6 py-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                {{ mb_strtoupper(mb_substr($comment->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="font-semibold text-sm text-gray-800">{{ $comment->user->name ?? 'Anonyme' }}</span>
                                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <div class="text-4xl mb-3">💬</div>
                        <p class="text-gray-400">Aucun commentaire pour le moment. Soyez le premier !</p>
                    </div>
                @endforelse
            </div>
        </div>

    </section>

@endsection
