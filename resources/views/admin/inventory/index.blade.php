@extends('layouts.admin')

@section('title', 'Inventaire')
@section('page_title', 'Scanner & Inventaire')

@section('content')
<div x-data="inventoryScanner()" x-init="initScanner()" class="space-y-6">

    {{-- Stats rapides --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Entrees aujourd'hui</p>
                    <p class="text-xl font-bold text-gray-900">{{ $todayIn }} <span class="text-xs text-gray-400 font-normal">unites</span></p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Sorties aujourd'hui</p>
                    <p class="text-xl font-bold text-gray-900">{{ $todayOut }} <span class="text-xs text-gray-400 font-normal">unites</span></p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Scans aujourd'hui</p>
                    <p class="text-xl font-bold text-gray-900">{{ $todayScans }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Scanner --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Scanner un code-barres</h3>
                <a href="{{ route('admin.inventory.stats') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Stats &rarr;</a>
            </div>
            <div class="p-5 space-y-4">
                {{-- Camera toggle --}}
                <div class="flex items-center justify-between">
                    <button @click="toggleCamera()" type="button"
                            :class="cameraActive ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700'"
                            class="text-sm font-medium px-4 py-2 rounded-lg transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                        <span x-text="cameraActive ? 'Eteindre camera' : 'Activer camera'"></span>
                    </button>
                    <span class="text-xs text-gray-400">ou douchette USB</span>
                </div>

                {{-- Camera preview --}}
                <div x-show="cameraActive" x-cloak class="relative rounded-xl overflow-hidden bg-black aspect-video">
                    <div id="scanner-preview" class="w-full h-full"></div>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-64 h-16 border-2 border-emerald-400 rounded-lg opacity-60"></div>
                    </div>
                </div>

                {{-- Manual input (also catches barcode scanner keyboard input) --}}
                <div class="relative">
                    <input type="text" x-model="manualBarcode" @keydown.enter.prevent="scanBarcode(manualBarcode)"
                           x-ref="barcodeInput"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 pr-24 font-mono text-lg tracking-wider"
                           placeholder="Code-barres (scan ou saisie manuelle)..."
                           autofocus>
                    <button @click="scanBarcode(manualBarcode)" type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Scanner
                    </button>
                </div>

                {{-- Status --}}
                <div x-show="loading" x-cloak class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    <span>Recherche...</span>
                </div>
            </div>
        </div>

        {{-- Action panel --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800" x-text="panelTitle">En attente d'un scan...</h3>
            </div>
            <div class="p-5">
                {{-- Unknown barcode: register it --}}
                <template x-if="scanResult === 'unknown'">
                    <div class="space-y-4">
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                            <p class="text-sm text-amber-800 font-medium">Code inconnu : <span class="font-mono" x-text="currentBarcode"></span></p>
                            <p class="text-xs text-amber-600 mt-1">Associez ce code a un produit. La prochaine fois, il sera reconnu automatiquement.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Produit</label>
                            <select x-model="registerForm.product_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Choisir un produit --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Type d'unite</label>
                                <select x-model="registerForm.unit_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="unite">Unite</option>
                                    <option value="pack">Pack</option>
                                    <option value="carton">Carton</option>
                                    <option value="palette">Palette</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Qte par <span x-text="registerForm.unit_type"></span></label>
                                <input type="number" x-model.number="registerForm.quantity_per_unit" min="1"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Etiquette (optionnel)</label>
                            <input type="text" x-model="registerForm.label" placeholder="Ex: Jus d'orange lot fournisseur"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        {{-- Photo capture for new product --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Photo du produit (optionnel)</label>
                            <div class="flex items-start gap-3">
                                <div class="flex-1">
                                    <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed rounded-xl cursor-pointer transition"
                                           :class="registerPhotoPreview ? 'border-emerald-300 bg-emerald-50' : 'border-gray-300 hover:border-emerald-400 hover:bg-gray-50'">
                                        <template x-if="!registerPhotoPreview">
                                            <div class="flex flex-col items-center justify-center py-3">
                                                <svg class="w-8 h-8 text-gray-400 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                                                <span class="text-xs text-gray-500">Prendre une photo</span>
                                                <span class="text-[10px] text-gray-400">ou choisir un fichier</span>
                                            </div>
                                        </template>
                                        <template x-if="registerPhotoPreview">
                                            <img :src="registerPhotoPreview" class="w-full h-full object-contain rounded-lg p-1">
                                        </template>
                                        <input type="file" accept="image/*" capture="environment" class="hidden"
                                               x-ref="registerPhotoInput"
                                               @change="handlePhotoSelect($event, 'register')">
                                    </label>
                                </div>
                                <button x-show="registerPhotoPreview" x-cloak @click="clearPhoto('register')" type="button"
                                        class="mt-2 p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Supprimer la photo">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        <button @click="registerBarcode()" type="button"
                                :disabled="!registerForm.product_id || registerLoading"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-300 text-white font-medium py-2.5 rounded-lg transition text-sm flex items-center justify-center gap-2">
                            <svg x-show="registerLoading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Enregistrer ce code-barres
                        </button>
                    </div>
                </template>

                {{-- Known barcode: add/remove stock --}}
                <template x-if="scanResult === 'known'">
                    <div class="space-y-4">
                        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                {{-- Product photo thumbnail --}}
                                <div class="relative flex-shrink-0 group">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-emerald-200 bg-white">
                                        <template x-if="currentMapping.product_image">
                                            <img :src="currentMapping.product_image" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!currentMapping.product_image">
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                            </div>
                                        </template>
                                    </div>
                                    {{-- Camera overlay button --}}
                                    <label class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition cursor-pointer"
                                           title="Changer la photo">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                                        <input type="file" accept="image/*" capture="environment" class="hidden"
                                               x-ref="knownPhotoInput"
                                               @change="handlePhotoSelect($event, 'known')">
                                    </label>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-emerald-900" x-text="currentMapping.product_name"></p>
                                            <p class="text-xs text-emerald-600 mt-0.5">
                                                <span class="font-mono" x-text="currentBarcode"></span>
                                                &bull;
                                                1 <span x-text="currentMapping.unit_label"></span> = <span x-text="currentMapping.quantity_per_unit"></span> unites
                                            </p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-xs text-gray-500">Stock actuel</p>
                                            <p class="text-2xl font-bold text-gray-900" x-text="currentMapping.current_stock"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Photo upload feedback --}}
                            <div x-show="photoUploading" x-cloak class="mt-2 flex items-center gap-2 text-xs text-emerald-600">
                                <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Upload de la photo...
                            </div>
                            <div x-show="photoSuccess" x-cloak x-transition class="mt-2 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded px-2 py-1 inline-block">
                                Photo mise a jour !
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-2">
                                Nombre de <span x-text="currentMapping.unit_label" class="font-semibold"></span>(s)
                            </label>
                            <div class="flex items-center space-x-3">
                                <button @click="movementForm.unit_count = Math.max(1, movementForm.unit_count - 1)" type="button"
                                        class="w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition text-lg font-bold">-</button>
                                <input type="number" x-model.number="movementForm.unit_count" min="1"
                                       class="w-20 text-center border border-gray-300 rounded-lg py-2 text-lg font-bold focus:ring-emerald-500 focus:border-emerald-500">
                                <button @click="movementForm.unit_count++" type="button"
                                        class="w-10 h-10 rounded-lg border border-gray-300 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition text-lg font-bold">+</button>
                                <span class="text-sm text-gray-500">
                                    = <span class="font-bold text-gray-900" x-text="movementForm.unit_count * currentMapping.quantity_per_unit"></span> unites
                                </span>
                            </div>
                        </div>

                        {{-- DLC / DLUO / Lot --}}
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">DLC</label>
                                <input type="date" x-model="movementForm.dlc"
                                       class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">DLUO</label>
                                <input type="date" x-model="movementForm.dluo"
                                       class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">N° Lot</label>
                                <input type="text" x-model="movementForm.lot_number" placeholder="LOT..."
                                       class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Note (optionnel)</label>
                            <input type="text" x-model="movementForm.note" placeholder="Ex: Livraison Metro..."
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        {{-- Action buttons --}}
                        <div class="grid grid-cols-2 gap-3">
                            <button @click="addMovement('in')" type="button"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition text-sm flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                <span>Entree stock</span>
                            </button>
                            <button @click="addMovement('out')" type="button"
                                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition text-sm flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                <span>Sortie stock</span>
                            </button>
                        </div>
                    </div>
                </template>

                {{-- Success feedback --}}
                <template x-if="scanResult === 'success'">
                    <div class="text-center py-6 space-y-3">
                        <div class="w-16 h-16 mx-auto bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <p class="font-semibold text-gray-900" x-text="successMessage"></p>
                        <p class="text-sm text-gray-500">Nouveau stock : <span class="font-bold text-emerald-600" x-text="newStock"></span></p>
                        <p class="text-xs text-gray-400">Scannez le prochain code-barres...</p>
                    </div>
                </template>

                {{-- Idle state --}}
                <template x-if="scanResult === null">
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/></svg>
                        <p class="text-sm">Scannez un code-barres ou saisissez-le manuellement</p>
                        <p class="text-xs mt-1">Camera, douchette USB, ou saisie clavier</p>
                    </div>
                </template>

                {{-- Error --}}
                <div x-show="errorMessage" x-cloak class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-700" x-text="errorMessage"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent movements --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-800">Derniers mouvements</h3>
            <a href="{{ route('admin.inventory.stats') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Voir les stats &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Type</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Produit</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Quantite</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Unite</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Code</th>
                        <th class="text-left px-5 py-3 text-xs font-medium text-gray-400 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentMovements as $m)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-5 py-3">
                                @if($m->type === 'in')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">+ Entree</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">- Sortie</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $m->product->name }}</td>
                            <td class="px-5 py-3">
                                <span class="font-bold {{ $m->type === 'in' ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $m->type === 'in' ? '+' : '-' }}{{ $m->total_quantity }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $m->unit_count }} {{ $m->unit_type }}(s)</td>
                            <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $m->barcode }}</td>
                            <td class="px-5 py-3 text-gray-400 text-xs">{{ $m->created_at->format('d/m H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">Aucun mouvement. Scannez votre premier code-barres !</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- html5-qrcode CDN --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
function inventoryScanner() {
    return {
        cameraActive: false,
        scanner: null,
        manualBarcode: '',
        loading: false,
        scanResult: null, // null, 'unknown', 'known', 'success'
        currentBarcode: '',
        currentMapping: {},
        errorMessage: '',
        successMessage: '',
        newStock: 0,
        registerForm: { product_id: '', unit_type: 'unite', quantity_per_unit: 1, label: '' },
        movementForm: { unit_count: 1, note: '', dlc: '', dluo: '', lot_number: '' },
        registerPhotoPreview: null,
        registerPhotoFile: null,
        registerLoading: false,
        photoUploading: false,
        photoSuccess: false,

        get panelTitle() {
            if (this.scanResult === 'unknown') return 'Nouveau code-barres detecte';
            if (this.scanResult === 'known') return 'Produit reconnu';
            if (this.scanResult === 'success') return 'Mouvement enregistre !';
            return 'En attente d\'un scan...';
        },

        initScanner() {
            // Auto-focus barcode input for USB scanner support
            this.$refs.barcodeInput?.focus();
            // Re-focus when clicking anywhere on the page (so USB scanner always works)
            document.addEventListener('click', (e) => {
                if (!e.target.closest('input, select, textarea, button')) {
                    this.$refs.barcodeInput?.focus();
                }
            });
        },

        async toggleCamera() {
            if (this.cameraActive) {
                if (this.scanner) {
                    try { await this.scanner.stop(); } catch(e) {}
                    this.scanner = null;
                }
                this.cameraActive = false;
                return;
            }

            this.cameraActive = true;
            await this.$nextTick();

            this.scanner = new Html5Qrcode('scanner-preview');
            try {
                await this.scanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 250, height: 80 }, aspectRatio: 16/9 },
                    (code) => {
                        // Debounce: don't re-scan same code within 2s
                        if (this._lastScanned === code && Date.now() - this._lastScanTime < 2000) return;
                        this._lastScanned = code;
                        this._lastScanTime = Date.now();
                        this.scanBarcode(code);
                    },
                    () => {}
                );
            } catch (e) {
                this.errorMessage = 'Camera non disponible : ' + e;
                this.cameraActive = false;
            }
        },

        async scanBarcode(code) {
            code = code?.trim();
            if (!code) return;

            this.loading = true;
            this.errorMessage = '';
            this.scanResult = null;
            this.manualBarcode = '';

            try {
                const resp = await fetch('{{ route("admin.inventory.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ barcode: code }),
                });
                const data = await resp.json();

                this.currentBarcode = code;

                if (data.status === 'unknown') {
                    this.scanResult = 'unknown';
                    this.registerForm = { product_id: '', unit_type: 'unite', quantity_per_unit: 1, label: '' };
                    this.clearPhoto('register');
                    this.photoSuccess = false;
                } else {
                    this.scanResult = 'known';
                    this.currentMapping = data.mapping;
                    this.movementForm = { unit_count: 1, note: '' };
                }
            } catch (e) {
                this.errorMessage = 'Erreur de connexion';
            }
            this.loading = false;
            this.$refs.barcodeInput?.focus();
        },

        async registerBarcode() {
            this.loading = true;
            this.registerLoading = true;
            this.errorMessage = '';

            try {
                const formData = new FormData();
                formData.append('barcode', this.currentBarcode);
                formData.append('product_id', this.registerForm.product_id);
                formData.append('unit_type', this.registerForm.unit_type);
                formData.append('quantity_per_unit', this.registerForm.quantity_per_unit);
                if (this.registerForm.label) formData.append('label', this.registerForm.label);
                if (this.registerPhotoFile) formData.append('product_photo', this.registerPhotoFile);

                const resp = await fetch('{{ route("admin.inventory.register") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                const data = await resp.json();

                if (data.status === 'registered') {
                    this.scanResult = 'known';
                    this.currentMapping = data.mapping;
                    this.movementForm = { unit_count: 1, note: '', dlc: '', dluo: '', lot_number: '' };
                    this.clearPhoto('register');
                } else if (resp.status === 422) {
                    const errors = data.errors || {};
                    this.errorMessage = Object.values(errors).flat().join(', ');
                }
            } catch (e) {
                this.errorMessage = 'Erreur de connexion';
            }
            this.loading = false;
            this.registerLoading = false;
        },

        handlePhotoSelect(event, context) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                if (context === 'register') {
                    this.registerPhotoPreview = e.target.result;
                    this.registerPhotoFile = file;
                } else if (context === 'known') {
                    // Immediately upload for known products
                    this.uploadProductPhoto(file);
                }
            };
            reader.readAsDataURL(file);
        },

        clearPhoto(context) {
            if (context === 'register') {
                this.registerPhotoPreview = null;
                this.registerPhotoFile = null;
                if (this.$refs.registerPhotoInput) this.$refs.registerPhotoInput.value = '';
            }
        },

        async uploadProductPhoto(file) {
            this.photoUploading = true;
            this.photoSuccess = false;

            const formData = new FormData();
            formData.append('product_id', this.currentMapping.product_id);
            formData.append('photo', file);

            try {
                const resp = await fetch('{{ route("admin.inventory.upload-photo") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                const data = await resp.json();

                if (data.status === 'success') {
                    this.currentMapping.product_image = data.product_image;
                    this.photoSuccess = true;
                    setTimeout(() => { this.photoSuccess = false; }, 3000);
                } else {
                    this.errorMessage = data.message || 'Erreur upload photo';
                }
            } catch (e) {
                this.errorMessage = 'Erreur de connexion (photo)';
            }
            this.photoUploading = false;
            if (this.$refs.knownPhotoInput) this.$refs.knownPhotoInput.value = '';
        },

        async addMovement(type) {
            this.loading = true;
            this.errorMessage = '';

            try {
                const resp = await fetch('{{ route("admin.inventory.movement") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        barcode_mapping_id: this.currentMapping.id,
                        type: type,
                        unit_count: this.movementForm.unit_count,
                        note: this.movementForm.note || null,
                        dlc: this.movementForm.dlc || null,
                        dluo: this.movementForm.dluo || null,
                        lot_number: this.movementForm.lot_number || null,
                    }),
                });
                const data = await resp.json();

                if (data.status === 'success') {
                    const m = data.movement;
                    this.successMessage = `${type === 'in' ? '+' : '-'}${m.total_quantity} ${m.product_name} (${m.unit_count} ${m.unit_label}${m.unit_count > 1 ? 's' : ''})`;
                    this.newStock = m.new_stock;
                    this.scanResult = 'success';

                    // Auto-reset after 3s
                    setTimeout(() => {
                        if (this.scanResult === 'success') {
                            this.scanResult = null;
                            this.$refs.barcodeInput?.focus();
                        }
                    }, 3000);
                }
            } catch (e) {
                this.errorMessage = 'Erreur de connexion';
            }
            this.loading = false;
        },
    };
}
</script>
@endsection
