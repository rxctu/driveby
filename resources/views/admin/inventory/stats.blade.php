@extends('layouts.admin')

@section('title', 'Stats Inventaire')
@section('page_title', 'Statistiques Inventaire')

@section('content')
<div class="space-y-6">

    {{-- Back + summary --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.inventory.index') }}" class="text-sm text-gray-500 hover:text-emerald-600 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            <span>Retour au scanner</span>
        </a>
    </div>

    {{-- Month summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase">Entrees ce mois</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1">+{{ $totalInThisMonth }}</p>
            <p class="text-xs text-gray-400 mt-1">unites ajoutees au stock</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase">Sorties ce mois</p>
            <p class="text-3xl font-bold text-red-500 mt-1">-{{ $totalOutThisMonth }}</p>
            <p class="text-xs text-gray-400 mt-1">unites retirees du stock</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase">Solde net</p>
            <p class="text-3xl font-bold {{ $totalInThisMonth - $totalOutThisMonth >= 0 ? 'text-emerald-600' : 'text-red-500' }} mt-1">
                {{ $totalInThisMonth - $totalOutThisMonth >= 0 ? '+' : '' }}{{ $totalInThisMonth - $totalOutThisMonth }}
            </p>
            <p class="text-xs text-gray-400 mt-1">variation nette du stock</p>
        </div>
    </div>

    {{-- DLC Alerts --}}
    @if($expiredDlc->isNotEmpty() || $expiringDlc->isNotEmpty())
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @if($expiredDlc->isNotEmpty())
        <div class="bg-white rounded-xl border border-red-200 shadow-sm">
            <div class="p-4 border-b border-red-100 bg-red-50 rounded-t-xl">
                <h3 class="text-sm font-semibold text-red-800 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
                    <span>DLC depassees ({{ $expiredDlc->count() }})</span>
                </h3>
            </div>
            <div class="divide-y divide-red-50 max-h-48 overflow-y-auto">
                @foreach($expiredDlc as $m)
                <div class="px-4 py-2.5 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $m->product->name }}</p>
                        <p class="text-xs text-gray-400">Lot: {{ $m->lot_number ?? '-' }}</p>
                    </div>
                    <span class="text-xs font-semibold text-red-600">{{ $m->dlc->format('d/m/Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($expiringDlc->isNotEmpty())
        <div class="bg-white rounded-xl border border-amber-200 shadow-sm">
            <div class="p-4 border-b border-amber-100 bg-amber-50 rounded-t-xl">
                <h3 class="text-sm font-semibold text-amber-800 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>DLC dans les 7 jours ({{ $expiringDlc->count() }})</span>
                </h3>
            </div>
            <div class="divide-y divide-amber-50 max-h-48 overflow-y-auto">
                @foreach($expiringDlc as $m)
                <div class="px-4 py-2.5 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $m->product->name }}</p>
                        <p class="text-xs text-gray-400">Lot: {{ $m->lot_number ?? '-' }} &bull; {{ $m->total_quantity }} unites</p>
                    </div>
                    <span class="text-xs font-semibold text-amber-600">{{ $m->dlc->format('d/m/Y') }} (J-{{ now()->diffInDays($m->dlc) }})</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- By unit type --}}
    @if($byUnitType->isNotEmpty())
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Entrees par type d'unite (ce mois)</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php $unitLabels = ['unite' => 'Unites', 'pack' => 'Packs', 'carton' => 'Cartons', 'palette' => 'Palettes']; @endphp
            @foreach(['unite', 'pack', 'carton', 'palette'] as $type)
                <div class="p-3 bg-gray-50 rounded-lg text-center">
                    <p class="text-xs text-gray-400 font-medium">{{ $unitLabels[$type] }}</p>
                    <p class="text-xl font-bold text-gray-900 mt-1">{{ $byUnitType->get($type)?->total_units ?? 0 }}</p>
                    <p class="text-xs text-gray-400">= {{ $byUnitType->get($type)?->total_items ?? 0 }} articles</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top restocked products --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Top produits reapprovisionnes (ce mois)</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($topRestocked as $item)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->scan_count }} scan(s)</p>
                        </div>
                        <span class="text-sm font-bold text-emerald-600">+{{ $item->total_in }}</span>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-gray-400 text-sm">Aucune donnee</div>
                @endforelse
            </div>
        </div>

        {{-- Registered barcodes --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Codes-barres enregistres ({{ $mappings->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-50 max-h-96 overflow-y-auto">
                @forelse($mappings as $m)
                    <div class="px-5 py-3" x-data="{ editing: false, form: { product_id: '{{ $m->product_id }}', unit_type: '{{ $m->unit_type }}', quantity_per_unit: {{ $m->quantity_per_unit }}, label: '{{ addslashes($m->label ?? '') }}' } }">
                        <div x-show="!editing">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ $m->product->name }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $m->barcode }}</p>
                                    @if($m->label)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $m->label }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        {{ ucfirst($m->unit_type) }} &times; {{ $m->quantity_per_unit }}
                                    </span>
                                    <button @click="editing = true" class="p-1 text-gray-400 hover:text-emerald-600 transition" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    </button>
                                    <button @click="if(confirm('Supprimer ce code-barres ?')) {
                                        fetch('/admin/inventaire/mapping/{{ $m->id }}', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }).then(() => location.reload());
                                    }" class="p-1 text-gray-400 hover:text-red-600 transition" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div x-show="editing" x-cloak class="space-y-2">
                            <div class="grid grid-cols-3 gap-2">
                                <select x-model="form.unit_type" class="border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="unite">Unite</option>
                                    <option value="pack">Pack</option>
                                    <option value="carton">Carton</option>
                                    <option value="palette">Palette</option>
                                </select>
                                <input type="number" x-model.number="form.quantity_per_unit" min="1" class="border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-emerald-500 focus:border-emerald-500" placeholder="Qte">
                                <input type="text" x-model="form.label" class="border border-gray-300 rounded-lg px-2 py-1.5 text-xs focus:ring-emerald-500 focus:border-emerald-500" placeholder="Etiquette">
                            </div>
                            <div class="flex space-x-2">
                                <button @click="fetch('/admin/inventaire/mapping/{{ $m->id }}', {
                                    method: 'PUT',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                    body: JSON.stringify(form)
                                }).then(() => location.reload())" class="text-xs bg-emerald-600 text-white px-3 py-1.5 rounded-lg hover:bg-emerald-700 transition">Sauver</button>
                                <button @click="editing = false" class="text-xs bg-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-300 transition">Annuler</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-gray-400 text-sm">Aucun code-barres enregistre</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- All movements this month --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Historique du mois ({{ $movementsThisMonth->count() }} mouvements)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Type</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Produit</th>
                        <th class="text-right px-5 py-3 text-xs font-medium text-gray-400 uppercase">Quantite</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Detail</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Code</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">DLC</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Note</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($movementsThisMonth as $m)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-5 py-3">
                                @if($m->type === 'in')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Entree</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">Sortie</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $m->product->name }}</td>
                            <td class="px-5 py-3 text-right font-bold {{ $m->type === 'in' ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $m->type === 'in' ? '+' : '-' }}{{ $m->total_quantity }}
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $m->unit_count }} {{ $m->unit_type }}(s) &times; {{ $m->quantity_per_unit }}</td>
                            <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $m->barcode }}</td>
                            <td class="px-5 py-3 text-xs">
                                @if($m->dlc)
                                    <span class="{{ $m->dlc->isPast() ? 'text-red-600 font-semibold' : ($m->dlc->diffInDays(now()) <= 7 ? 'text-amber-600' : 'text-gray-500') }}">
                                        {{ $m->dlc->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs">{{ $m->note ?? '-' }}</td>
                            <td class="px-5 py-3 text-gray-400 text-xs">{{ $m->created_at->format('d/m H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-8 text-center text-gray-400">Aucun mouvement ce mois</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
