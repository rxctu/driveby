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
        <div class="bg-white rounded-lg shadow overflow-hidden">
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
                    // Toggle active state via Alpine
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
