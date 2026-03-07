@extends('layouts.admin')

@section('title', isset($partner) ? 'Modifier le partenaire' : 'Ajouter un partenaire')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.partners.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Retour a la liste
            </a>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ isset($partner) ? 'Modifier le partenaire' : 'Nouveau partenaire' }}
                </h3>
            </div>

            <form method="POST"
                  action="{{ isset($partner) ? route('admin.partners.update', $partner) : route('admin.partners.store') }}"
                  enctype="multipart/form-data"
                  class="p-6 space-y-6">
                @csrf
                @if(isset($partner))
                    @method('PUT')
                @endif

                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm font-medium text-red-800 mb-2">Des erreurs ont ete detectees :</p>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $partner->name ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug"
                           value="{{ old('slug', $partner->slug ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:ring-green-500 focus:border-green-500"
                           placeholder="Genere automatiquement">
                </div>

                {{-- Type --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                    <select name="type" id="type"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500 @error('type') border-red-500 @enderror"
                            required>
                        <option value="">Selectionner un type</option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ old('type', $partner->type ?? '') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">{{ old('description', $partner->description ?? '') }}</textarea>
                </div>

                {{-- Address & Phone --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <input type="text" name="address" id="address"
                               value="{{ old('address', $partner->address ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $partner->phone ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                {{-- Website --}}
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Site web</label>
                    <input type="url" name="website" id="website"
                           value="{{ old('website', $partner->website ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500"
                           placeholder="https://...">
                </div>

                {{-- Logo Upload --}}
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 file:text-sm file:font-medium hover:file:bg-green-100"
                           onchange="previewLogo(event)">
                    <div class="mt-3">
                        @if(isset($partner) && $partner->logo)
                            <img id="logo-preview" src="{{ asset('storage/' . $partner->logo) }}" alt="Preview"
                                 class="w-24 h-24 object-contain rounded-lg border">
                        @else
                            <img id="logo-preview" src="#" alt="Preview"
                                 class="w-24 h-24 object-contain rounded-lg border hidden">
                        @endif
                    </div>
                </div>

                {{-- Sort Order & Active --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                        <input type="number" name="sort_order" id="sort_order" min="0"
                               value="{{ old('sort_order', $partner->sort_order ?? 0) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   class="sr-only peer"
                                   {{ old('is_active', $partner->is_active ?? 1) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Partenaire actif</span>
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> {{ isset($partner) ? 'Mettre a jour' : 'Enregistrer' }}
                    </button>
                    <a href="{{ route('admin.partners.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium transition">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('name').addEventListener('input', function() {
            const slug = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
            document.getElementById('slug').value = slug;
        });
        function previewLogo(event) {
            const preview = document.getElementById('logo-preview');
            const file = event.target.files[0];
            if (file) { preview.src = URL.createObjectURL(file); preview.classList.remove('hidden'); }
        }
    </script>
@endsection
