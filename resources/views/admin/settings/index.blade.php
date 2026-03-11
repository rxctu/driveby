@extends('layouts.admin')

@section('title', 'Parametres')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Parametres generaux</h3>
                <p class="text-sm text-gray-500 mt-1">Configurez les informations de votre magasin</p>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Store Name --}}
                <div>
                    <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du magasin <span class="text-red-500">*</span></label>
                    <input type="text" name="store_name" id="store_name"
                           value="{{ old('store_name', $settings->store_name ?? 'EpiDrive') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500 @error('store_name') border-red-500 @enderror"
                           required>
                    @error('store_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $settings->phone ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500 @error('phone') border-red-500 @enderror"
                               placeholder="+212 6XX XXX XXX">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $settings->email ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror"
                               placeholder="contact@epidrive.ma">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <textarea name="address" id="address" rows="2"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500 @error('address') border-red-500 @enderror"
                              placeholder="Adresse complete du magasin">{{ old('address', $settings->address ?? '') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opening Hours --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Horaires d'ouverture</label>
                    <div class="space-y-3">
                        @php
                            $days = [
                                'lundi' => 'Lundi',
                                'mardi' => 'Mardi',
                                'mercredi' => 'Mercredi',
                                'jeudi' => 'Jeudi',
                                'vendredi' => 'Vendredi',
                                'samedi' => 'Samedi',
                                'dimanche' => 'Dimanche',
                            ];
                            $hours = $settings->opening_hours ?? [];
                        @endphp
                        @foreach($days as $key => $label)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                <div class="w-28">
                                    <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="time" name="opening_hours[{{ $key }}][open]"
                                           value="{{ old("opening_hours.{$key}.open", $hours[$key]['open'] ?? '08:00') }}"
                                           class="border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:ring-green-500 focus:border-green-500">
                                    <span class="text-gray-400">-</span>
                                    <input type="time" name="opening_hours[{{ $key }}][close]"
                                           value="{{ old("opening_hours.{$key}.close", $hours[$key]['close'] ?? '20:00') }}"
                                           class="border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:ring-green-500 focus:border-green-500">
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer ml-auto">
                                    <input type="hidden" name="opening_hours[{{ $key }}][closed]" value="0">
                                    <input type="checkbox" name="opening_hours[{{ $key }}][closed]" value="1"
                                           class="sr-only peer"
                                           {{ old("opening_hours.{$key}.closed", $hours[$key]['closed'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-500"></div>
                                    <span class="ml-2 text-xs text-gray-500">Ferme</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Banner Texts --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Bandeau defilant (annonces en haut du site)</label>
                    <div x-data="{
                        banners: {{ Js::from($settings->banner_texts ?: [['emoji' => '🚀', 'text' => '']]) }},
                        addBanner() { this.banners.push({emoji: '📢', text: ''}); },
                        removeBanner(index) { this.banners.splice(index, 1); }
                    }">
                        <template x-for="(banner, index) in banners" :key="index">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" :name="'banner_texts['+index+'][emoji]'" x-model="banner.emoji"
                                       class="w-16 border border-gray-300 rounded-lg px-2 py-2 text-center text-lg focus:ring-green-500 focus:border-green-500"
                                       placeholder="🔥">
                                <input type="text" :name="'banner_texts['+index+'][text]'" x-model="banner.text"
                                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500"
                                       placeholder="Texte de l'annonce...">
                                <button type="button" @click="removeBanner(index)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addBanner()"
                                class="mt-2 text-sm text-green-600 hover:text-green-700 font-medium flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            <span>Ajouter une annonce</span>
                        </button>
                    </div>
                </div>

                {{-- Online Payments toggle --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Paiement en ligne</label>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                        <input type="hidden" name="online_payments_enabled" value="0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="online_payments_enabled" value="1"
                                   class="sr-only peer"
                                   {{ old('online_payments_enabled', $settings->online_payments_enabled ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Accepter les paiements en ligne (CB, PayPal)</span>
                            <p class="text-xs text-gray-500">Si desactive, seul le paiement en especes a la livraison sera propose</p>
                        </div>
                    </div>
                </div>

                {{-- Partner CTA toggle --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Page Partenaires</label>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                        <input type="hidden" name="partner_cta_enabled" value="0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="partner_cta_enabled" value="1"
                                   class="sr-only peer"
                                   {{ old('partner_cta_enabled', $settings->partner_cta_enabled ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Formulaire "Devenir partenaire"</span>
                            <p class="text-xs text-gray-500">Afficher le bloc de contact commercant sur la page partenaires</p>
                        </div>
                    </div>
                </div>

                {{-- Save --}}
                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Enregistrer les parametres
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
