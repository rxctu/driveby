@extends('layouts.admin')

@section('title', 'Livraison')

@section('content')
    <div class="space-y-8">
        {{-- Delivery Pricing --}}
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Tarification de la livraison</h3>
                <p class="text-sm text-gray-500 mt-1">Configurez les prix et la distance maximale de livraison</p>
            </div>
            <form method="POST" action="{{ route('admin.delivery.update-pricing') }}" class="p-6">
                @csrf

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="base_delivery_price" class="block text-sm font-medium text-gray-700 mb-1">Prix de base (&euro;)</label>
                        <input type="number" name="base_delivery_price" id="base_delivery_price" step="0.01" min="0"
                               value="{{ old('base_delivery_price', $settings->base_delivery_price ?? 10) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                        <p class="mt-1 text-xs text-gray-400">Prix minimum de livraison</p>
                    </div>
                    <div>
                        <label for="price_per_km" class="block text-sm font-medium text-gray-700 mb-1">Prix par km (&euro;)</label>
                        <input type="number" name="price_per_km" id="price_per_km" step="0.01" min="0"
                               value="{{ old('price_per_km', $settings->price_per_km ?? 3) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                        <p class="mt-1 text-xs text-gray-400">Cout additionnel par kilometre</p>
                    </div>
                    <div>
                        <label for="max_distance_km" class="block text-sm font-medium text-gray-700 mb-1">Distance maximale (km)</label>
                        <input type="number" name="max_distance_km" id="max_distance_km" step="0.1" min="0"
                               value="{{ old('max_distance_km', $settings->max_distance_km ?? 20) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                        <p class="mt-1 text-xs text-gray-400">Rayon de livraison maximum</p>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Enregistrer les tarifs
                    </button>
                </div>
            </form>
        </div>

        {{-- Delivery Slots --}}
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Creneaux de livraison</h3>
                <p class="text-sm text-gray-500 mt-1">Gerez les creneaux horaires disponibles pour la livraison</p>
            </div>

            {{-- Existing Slots Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Jour</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Heure debut</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Heure fin</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Max commandes</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($slots ?? [] as $slot)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $slot->day_name }}</td>
                                <td class="px-6 py-4">{{ $slot->start_time }}</td>
                                <td class="px-6 py-4">{{ $slot->end_time }}</td>
                                <td class="px-6 py-4">{{ $slot->max_orders }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.delivery.toggle-slot', $slot) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer transition
                                            {{ $slot->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            {{ $slot->is_active ? 'Actif' : 'Inactif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('admin.delivery.delete-slot', $slot) }}" class="inline"
                                          onsubmit="return confirm('Supprimer ce creneau ?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Aucun creneau configure</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Add New Slot Form --}}
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <h4 class="text-sm font-semibold text-gray-700 mb-4">Ajouter un creneau</h4>
                <form method="POST" action="{{ route('admin.delivery.store-slot') }}" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jour</label>
                        <select name="day" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                            <option value="">Choisir</option>
                            <option value="lundi">Lundi</option>
                            <option value="mardi">Mardi</option>
                            <option value="mercredi">Mercredi</option>
                            <option value="jeudi">Jeudi</option>
                            <option value="vendredi">Vendredi</option>
                            <option value="samedi">Samedi</option>
                            <option value="dimanche">Dimanche</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heure debut</label>
                        <input type="time" name="start_time" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heure fin</label>
                        <input type="time" name="end_time" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max commandes</label>
                        <input type="number" name="max_orders" min="1" value="10" class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                            <span class="ml-2 text-sm text-gray-700">Actif</span>
                        </label>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
