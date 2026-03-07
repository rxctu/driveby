@extends('layouts.app')

@section('title', 'Créer une liste de courses - Communauté EpiDrive')
@section('meta_description', 'Créez et partagez votre liste de courses avec la communauté EpiDrive.')

<style>.hide-spinners::-webkit-outer-spin-button,.hide-spinners::-webkit-inner-spin-button{-webkit-appearance:none;margin:0;}</style>
@section('content')

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12"
             x-data="createListForm()">

        {{-- Toast notification --}}
        <div x-show="toast.show" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed bottom-6 right-6 z-50 flex items-center space-x-3 px-5 py-3 rounded-xl shadow-lg text-sm font-semibold"
             :class="toast.type === 'add' ? 'bg-emerald-600 text-white' : 'bg-red-500 text-white'">
            <span x-text="toast.type === 'add' ? '✅' : '🗑️'"></span>
            <span x-text="toast.message"></span>
        </div>

        {{-- Header --}}
        <div class="mb-8 animate-fade-in-up">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Accueil</a>
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('community.index') }}" class="hover:text-emerald-700 transition-colors">Communauté</a>
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-700 font-medium">Créer une liste</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
                ✨ Créer une liste de courses
            </h1>
            <p class="text-gray-500 mt-2">Composez votre liste et partagez-la avec la communauté</p>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6">
                <div class="flex items-center space-x-2 text-red-700 font-semibold mb-2">
                    <span>❌</span>
                    <span>Veuillez corriger les erreurs suivantes :</span>
                </div>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('community.store') }}" id="createListForm">
            @csrf
            <input type="hidden" name="tags" :value="selectedTags.join(',')">
            <input type="hidden" name="is_public" :value="isPublic ? 1 : 0">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ============================================
                     LEFT COLUMN: Form fields
                     ============================================ --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Title & Description --}}
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in-up">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">📝 Informations</h2>

                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Titre de la liste *</label>
                                <input type="text" id="title" name="title" x-model="listTitle" required maxlength="100"
                                       placeholder="Ex: Courses de la semaine, Apéro entre amis..."
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 @error('title') border-red-400 ring-2 ring-red-200 @enderror">
                                @error('title')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" x-model="listDescription" rows="3" maxlength="500"
                                          placeholder="Décrivez votre liste en quelques mots..."
                                          class="w-full px-4 py-3 rounded-xl border border-gray-200 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 resize-none @error('description') border-red-400 ring-2 ring-red-200 @enderror"></textarea>
                                @error('description')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tags --}}
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in-up" style="animation-delay: 0.05s;">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">🏷️ Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $availableTags = ['Budget', 'Famille', 'Apéro', 'Healthy', 'Étudiant', 'Fêtes', 'Végétarien', 'Rapide'];
                                $tagEmojis = [
                                    'Budget' => '💰', 'Famille' => '👨‍👩‍👧‍👦', 'Apéro' => '🥂', 'Healthy' => '🥗',
                                    'Étudiant' => '🎓', 'Fêtes' => '🎉', 'Végétarien' => '🌱', 'Rapide' => '⚡',
                                ];
                            @endphp
                            @foreach($availableTags as $tag)
                                <button type="button"
                                        @click="toggleTag('{{ $tag }}')"
                                        class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border-2"
                                        :class="hasTag('{{ $tag }}')
                                            ? 'bg-emerald-700 text-white border-emerald-700 shadow-md shadow-emerald-200'
                                            : 'bg-white text-gray-600 border-gray-200 hover:border-emerald-300 hover:text-emerald-700'">
                                    <span>{{ $tagEmojis[$tag] ?? '🏷️' }}</span>
                                    <span>{{ $tag }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Visibility toggle --}}
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">🌍 Visibilité</h2>
                                <p class="text-sm text-gray-500 mt-0.5" x-text="isPublic ? 'Visible par toute la communauté' : 'Visible uniquement par vous'"></p>
                            </div>
                            <button type="button" @click="isPublic = !isPublic"
                                    class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                    :class="isPublic ? 'bg-emerald-600' : 'bg-gray-200'"
                                    role="switch" :aria-checked="isPublic">
                                <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                      :class="isPublic ? 'translate-x-5' : 'translate-x-0'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Product selector --}}
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in-up" style="animation-delay: 0.15s;">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">🛒 Sélection des produits</h2>

                        {{-- Search --}}
                        <div class="relative mb-5">
                            <input type="text" x-model="search" placeholder="Rechercher un produit..."
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        {{-- Categories with products --}}
                        <div class="space-y-3">
                            @foreach($categories as $category)
                                <div class="border border-gray-100 rounded-xl overflow-hidden"
                                     x-show="search === '' || {{ json_encode($category->products->pluck('name')->toArray()) }}.some(n => n.toLowerCase().includes(search.toLowerCase()))">
                                    {{-- Category header --}}
                                    <button type="button"
                                            @click="toggleCategory({{ $category->id }})"
                                            class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors duration-150 text-left">
                                        <span class="font-semibold text-gray-800">{{ $category->name }}</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-gray-400">{{ $category->products->count() }} produits</span>
                                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                                 :class="isCategoryOpen({{ $category->id }}) && 'rotate-180'"
                                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </button>

                                    {{-- Products list --}}
                                    <div x-show="isCategoryOpen({{ $category->id }}) || search !== ''" x-cloak
                                         x-transition>
                                        <div class="divide-y divide-gray-50">
                                            @foreach($category->products as $product)
                                                <div class="flex items-center gap-3 px-4 py-3 transition-all duration-300"
                                                     :class="getQuantity({{ $product->id }}) > 0 ? 'bg-emerald-50 border-l-4 border-emerald-500' : 'hover:bg-emerald-50/30 border-l-4 border-transparent'"
                                                     x-show="matchesSearch('{{ addslashes($product->name) }}')"
                                                     data-product-price="{{ $product->id }}" data-price="{{ $product->price }}">
                                                    {{-- Image --}}
                                                    <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-gradient-to-br from-emerald-100 to-teal-50">
                                                        @if($product->image)
                                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center"><span class="text-lg opacity-50">🛒</span></div>
                                                        @endif
                                                    </div>

                                                    {{-- Name + price --}}
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                                                        <p class="text-xs text-emerald-600 font-bold">{{ number_format($product->price, 2, ',', ' ') }}&nbsp;&euro;</p>
                                                    </div>

                                                    {{-- Quantity --}}
                                                    <div class="flex items-center space-x-1 flex-shrink-0">
                                                        <button type="button"
                                                                @click="setQuantity({{ $product->id }}, getQuantity({{ $product->id }}) - 1)"
                                                                class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-colors duration-150"
                                                                :class="getQuantity({{ $product->id }}) > 0 ? 'opacity-100' : 'opacity-30 cursor-not-allowed'"
                                                                :disabled="getQuantity({{ $product->id }}) <= 0">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M20 12H4"/></svg>
                                                        </button>
                                                        <input type="number" min="0" max="99"
                                                               :value="getQuantity({{ $product->id }})"
                                                               @input="setQuantity({{ $product->id }}, $event.target.value)"
                                                               style="-moz-appearance: textfield; -webkit-appearance: none; appearance: textfield;"
                                                               class="w-12 h-8 text-center text-sm font-semibold rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent hide-spinners">
                                                        <button type="button"
                                                                @click="setQuantity({{ $product->id }}, getQuantity({{ $product->id }}) + 1)"
                                                                class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-colors duration-150">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 4v16m8-8H4"/></svg>
                                                        </button>
                                                    </div>

                                                    {{-- Note (only if selected) --}}
                                                    <div x-show="getQuantity({{ $product->id }}) > 0" x-cloak class="flex-shrink-0">
                                                        <input type="text" placeholder="Note..."
                                                               :value="getNote({{ $product->id }})"
                                                               @input="setNote({{ $product->id }}, $event.target.value)"
                                                               class="w-24 sm:w-32 text-xs px-2 py-1.5 rounded-lg border border-gray-200 text-gray-600 placeholder-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ============================================
                     RIGHT COLUMN: Preview & Submit
                     ============================================ --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        {{-- Preview --}}
                        <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">📋 Aperçu</h2>

                            <div class="mb-4">
                                <h3 class="font-bold text-gray-800 truncate" x-text="listTitle || 'Sans titre'"></h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2" x-text="listDescription || 'Aucune description'"></p>
                            </div>

                            {{-- Selected tags --}}
                            <div class="flex flex-wrap gap-1.5 mb-4" x-show="selectedTags.length > 0">
                                <template x-for="tag in selectedTags" :key="tag">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100" x-text="tag"></span>
                                </template>
                            </div>

                            {{-- Visibility badge --}}
                            <div class="mb-4">
                                <span class="inline-flex items-center space-x-1 text-xs font-semibold px-2.5 py-1 rounded-full"
                                      :class="isPublic ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600'">
                                    <span x-text="isPublic ? '🌍' : '🔒'"></span>
                                    <span x-text="isPublic ? 'Publique' : 'Privée'"></span>
                                </span>
                            </div>

                            {{-- Selected products mini list --}}
                            <div x-show="selectedItems.length > 0" class="border-t border-gray-100 pt-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">
                                    Produits sélectionnés (<span x-text="selectedItems.length"></span>)
                                </p>
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    <template x-for="id in selectedItems" :key="id">
                                        <div class="flex items-center justify-between text-sm bg-emerald-50/50 rounded-lg px-3 py-2">
                                            <span class="text-gray-700 truncate flex-1"
                                                  x-text="document.querySelector('[data-product-price=\"' + id + '\"]')?.closest('[data-product-price]')?.querySelector('.text-gray-800')?.textContent?.trim() || 'Produit #' + id">
                                            </span>
                                            <span class="text-emerald-700 font-bold flex-shrink-0 ml-2" x-text="'x' + items[id]?.quantity"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div x-show="selectedItems.length === 0" class="border-t border-gray-100 pt-4">
                                <p class="text-sm text-gray-400 text-center py-4">Aucun produit sélectionné</p>
                            </div>
                        </div>

                        {{-- Total + Submit --}}
                        <div class="bg-gradient-to-br from-emerald-700 to-teal-700 rounded-2xl shadow-lg p-6 text-white animate-fade-in-up" style="animation-delay: 0.25s;">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-emerald-100 font-semibold">Articles</span>
                                <span class="font-bold text-lg" x-text="totalCount"></span>
                            </div>
                            <div class="flex items-center justify-between mb-5 pb-4 border-b border-white/20">
                                <span class="text-emerald-100 font-semibold">Total estimé</span>
                                <span class="font-extrabold text-2xl" x-text="formatPrice(totalPrice) + ' \u20AC'"></span>
                            </div>

                            {{-- Hidden inputs for items --}}
                            <template x-for="id in selectedItems" :key="'input-' + id">
                                <div>
                                    <input type="hidden" :name="'items[' + id + '][product_id]'" :value="id">
                                    <input type="hidden" :name="'items[' + id + '][quantity]'" :value="items[id]?.quantity">
                                    <input type="hidden" :name="'items[' + id + '][note]'" :value="items[id]?.note || ''">
                                </div>
                            </template>

                            <button type="submit"
                                    :disabled="selectedItems.length === 0 || !listTitle.trim()"
                                    class="w-full inline-flex items-center justify-center space-x-2 bg-gradient-accent text-emerald-900 font-bold px-6 py-4 rounded-xl hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:hover:shadow-none text-lg">
                                <span>🚀</span>
                                <span>Publier ma liste</span>
                            </button>

                            <p class="text-xs text-emerald-200 text-center mt-3" x-show="selectedItems.length === 0 || !listTitle.trim()">
                                Ajoutez un titre et au moins un produit pour publier
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    </section>

<script>
function createListForm() {
    return {
        listTitle: @json(old('title', '')),
        listDescription: @json(old('description', '')),
        selectedTags: @json(old('tags') ? explode(',', old('tags')) : []),
        isPublic: {{ old('is_public', 1) ? 'true' : 'false' }},
        items: {},
        search: '',
        openCategories: {},
        toast: { show: false, message: '', type: 'add' },
        toastTimeout: null,

        toggleTag(tag) {
            const index = this.selectedTags.indexOf(tag);
            if (index > -1) {
                this.selectedTags.splice(index, 1);
            } else {
                this.selectedTags.push(tag);
            }
        },

        hasTag(tag) {
            return this.selectedTags.includes(tag);
        },

        getProductName(productId) {
            const el = document.querySelector('[data-product-price="' + productId + '"]');
            return el?.querySelector('.text-gray-800')?.textContent?.trim() || 'Produit';
        },

        showToast(message, type) {
            clearTimeout(this.toastTimeout);
            this.toast = { show: true, message, type };
            this.toastTimeout = setTimeout(() => { this.toast.show = false; }, 2000);
        },

        setQuantity(productId, qty) {
            qty = parseInt(qty) || 0;
            const wasSelected = !!this.items[productId]?.quantity;
            if (qty > 0) {
                if (!this.items[productId]) {
                    this.items[productId] = { quantity: qty, note: '' };
                } else {
                    this.items[productId].quantity = qty;
                }
                if (!wasSelected) {
                    this.showToast(this.getProductName(productId) + ' ajouté à la liste', 'add');
                }
            } else {
                if (wasSelected) {
                    this.showToast(this.getProductName(productId) + ' retiré de la liste', 'remove');
                }
                delete this.items[productId];
            }
        },

        setNote(productId, note) {
            if (this.items[productId]) {
                this.items[productId].note = note;
            }
        },

        getQuantity(productId) {
            return this.items[productId]?.quantity || 0;
        },

        getNote(productId) {
            return this.items[productId]?.note || '';
        },

        get selectedItems() {
            return Object.keys(this.items).filter(id => this.items[id]?.quantity > 0);
        },

        get totalCount() {
            return this.selectedItems.reduce((sum, id) => sum + (this.items[id]?.quantity || 0), 0);
        },

        get totalPrice() {
            let total = 0;
            for (const id of this.selectedItems) {
                const el = document.querySelector('[data-product-price="' + id + '"]');
                const price = parseFloat(el?.dataset.price || 0);
                total += price * (this.items[id]?.quantity || 0);
            }
            return total;
        },

        formatPrice(price) {
            return price.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        },

        matchesSearch(name) {
            if (!this.search) return true;
            return name.toLowerCase().includes(this.search.toLowerCase());
        },

        toggleCategory(catId) {
            this.openCategories[catId] = !this.openCategories[catId];
        },

        isCategoryOpen(catId) {
            return this.openCategories[catId] ?? false;
        }
    };
}
</script>
@endsection
