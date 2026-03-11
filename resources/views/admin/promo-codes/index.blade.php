@extends('layouts.admin')

@section('title', 'Codes Promo')

@section('content')
    <div x-data="promoManager()">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Codes Promo</h2>
            <button @click="showForm = !showForm"
                    class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition">
                <span x-text="showForm ? 'Annuler' : '+ Nouveau code'"></span>
            </button>
        </div>

        {{-- Create Form --}}
        <div x-show="showForm" x-cloak x-transition class="bg-white rounded-lg shadow mb-6 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Creer un code promo</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
                    <input type="text" x-model="form.code" placeholder="Ex: BIENVENUE"
                           class="w-full rounded-lg border-gray-300 text-sm uppercase focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                    <select x-model="form.type" class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="percentage">Pourcentage (%)</option>
                        <option value="fixed">Montant fixe (EUR)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valeur *</label>
                    <input type="number" x-model="form.value" step="0.01" min="0" placeholder="20"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Commande min. (EUR)</label>
                    <input type="number" x-model="form.min_order" step="0.01" min="0" placeholder="0"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reduction max. (EUR)</label>
                    <input type="number" x-model="form.max_discount" step="0.01" min="0" placeholder="Illimite"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Utilisations max.</label>
                    <input type="number" x-model="form.max_uses" min="1" placeholder="Illimite"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expire le</label>
                    <input type="date" x-model="form.expires_at"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
            <div class="mt-4 flex items-center gap-3">
                <button @click="createPromo()" :disabled="saving"
                        class="px-5 py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-lg hover:bg-emerald-700 transition disabled:opacity-50">
                    <span x-show="!saving">Creer le code</span>
                    <span x-show="saving">Creation...</span>
                </button>
                <p x-show="formError" x-text="formError" class="text-sm text-red-600 font-medium"></p>
            </div>
        </div>

        {{-- Promo Codes Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reduction</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Conditions</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Utilise</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Expire</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($promoCodes as $promo)
                        <tr x-data="{ active: {{ $promo->is_active ? 'true' : 'false' }} }" class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $promo->code }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($promo->type === 'percentage')
                                    <span class="text-emerald-700 font-bold">-{{ intval($promo->value) }}%</span>
                                    @if($promo->max_discount)
                                        <span class="text-gray-400 text-xs">(max {{ number_format($promo->max_discount, 0) }}EUR)</span>
                                    @endif
                                @else
                                    <span class="text-emerald-700 font-bold">-{{ number_format($promo->value, 2, ',', ' ') }} EUR</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($promo->min_order)
                                    Min. {{ number_format($promo->min_order, 0) }}EUR
                                @else
                                    <span class="text-gray-400">Aucune</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="font-semibold">{{ $promo->used_count }}</span>
                                @if($promo->max_uses)
                                    <span class="text-gray-400">/ {{ $promo->max_uses }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($promo->expires_at)
                                    {{ $promo->expires_at->format('d/m/Y') }}
                                    @if($promo->expires_at->isPast())
                                        <span class="text-red-500 text-xs font-bold ml-1">EXPIRE</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">Jamais</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button @click="togglePromo({{ $promo->id }}, $el)" class="text-xs font-bold px-2.5 py-1 rounded-full transition"
                                        :class="active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500'">
                                    <span x-text="active ? 'Actif' : 'Inactif'"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="deletePromo({{ $promo->id }}, $el.closest('tr'))"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium transition">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Aucun code promo. Cliquez sur "+ Nouveau code" pour en creer un.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Scrolling Banner (top of site) --}}
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Bandeau defilant</h3>
                <p class="text-sm text-gray-500 mt-1">Les annonces qui defilent en haut du site (visible sur toutes les pages)</p>
            </div>

            <form method="POST" action="{{ route('admin.promos.update-banner') }}" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div x-data="{
                    banners: {{ Js::from($bannerTexts) }},
                    addBanner() { this.banners.push({emoji: '', text: ''}); },
                    removeBanner(index) { this.banners.splice(index, 1); }
                }">
                    <template x-for="(banner, index) in banners" :key="index">
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" :name="'banner_texts['+index+'][emoji]'" x-model="banner.emoji"
                                   class="w-16 border border-gray-300 rounded-lg px-2 py-2 text-center text-lg focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="...">
                            <input type="text" :name="'banner_texts['+index+'][text]'" x-model="banner.text"
                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Texte de l'annonce...">
                            <button type="button" @click="removeBanner(index)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addBanner()"
                            class="mt-2 text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>Ajouter une annonce</span>
                    </button>
                </div>

                <hr class="border-gray-200">

                <h4 class="text-base font-semibold text-gray-800 pt-2">Banniere promotionnelle</h4>
                <p class="text-sm text-gray-500">La grande banniere coloree sur la page d'accueil. Le texte de la promo est genere automatiquement depuis le code actif le plus recent.</p>

                <div class="flex items-center gap-4">
                    <input type="hidden" name="promo_enabled" value="0">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="promo_enabled" value="1"
                               class="sr-only peer"
                               {{ ($banner->enabled ?? '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                    <span class="text-sm font-medium text-gray-700">Afficher la banniere promo sur la page d'accueil</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Badge</label>
                        <div class="flex gap-2">
                            <input type="text" name="promo_badge_emoji" value="{{ $banner->badge_emoji ?? '' }}"
                                   class="w-14 border border-gray-300 rounded-lg px-2 py-2 text-center text-lg focus:ring-emerald-500 focus:border-emerald-500">
                            <input type="text" name="promo_badge_text" value="{{ $banner->badge_text ?? 'Offre speciale' }}"
                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="Offre speciale">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Titre principal</label>
                        <input type="text" name="promo_title" value="{{ $banner->title ?? 'Premiere commande ?' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500"
                               placeholder="Premiere commande ?">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Texte du bouton</label>
                        <input type="text" name="promo_button_text" value="{{ $banner->button_text ?? 'En profiter maintenant' }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500"
                               placeholder="En profiter maintenant">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Emoji bouton</label>
                        <input type="text" name="promo_button_emoji" value="{{ $banner->button_emoji ?? '' }}"
                               class="w-14 border border-gray-300 rounded-lg px-2 py-2 text-center text-lg focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                @php
                    $activePromo = $promoCodes->where('is_active', true)->first();
                @endphp
                <div class="p-3 rounded-lg {{ $activePromo ? 'bg-emerald-50 border border-emerald-200' : 'bg-amber-50 border border-amber-200' }}">
                    @if($activePromo)
                        <p class="text-sm text-emerald-700">
                            <span class="font-bold">Texte auto-genere :</span>
                            {{ $activePromo->getLabel() }} avec le code <span class="font-mono font-bold">{{ $activePromo->code }}</span>
                        </p>
                    @else
                        <p class="text-sm text-amber-700 font-medium">
                            Aucun code promo actif. Creez-en un ci-dessus pour que la banniere affiche automatiquement la reduction.
                        </p>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                        Enregistrer la banniere
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function promoManager() {
            return {
                showForm: false,
                saving: false,
                formError: '',
                form: {
                    code: '',
                    type: 'percentage',
                    value: '',
                    min_order: '',
                    max_discount: '',
                    max_uses: '',
                    expires_at: '',
                },

                async createPromo() {
                    this.formError = '';
                    if (!this.form.code || !this.form.value) {
                        this.formError = 'Le code et la valeur sont requis.';
                        return;
                    }
                    this.saving = true;

                    try {
                        const res = await fetch('{{ route("admin.promos.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify(this.form)
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            const errors = data.errors || {};
                            this.formError = Object.values(errors).flat()[0] || 'Erreur lors de la creation.';
                        } else {
                            location.reload();
                        }
                    } catch (err) {
                        this.formError = 'Erreur reseau.';
                    }
                    this.saving = false;
                },

                async togglePromo(id, el) {
                    await fetch(`/admin/promos/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        }
                    });
                    const scope = Alpine.$data(el.closest('tr'));
                    scope.active = !scope.active;
                },

                async deletePromo(id, row) {
                    if (!confirm('Supprimer ce code promo ?')) return;
                    await fetch(`/admin/promos/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        }
                    });
                    row.remove();
                }
            };
        }
    </script>
@endsection
