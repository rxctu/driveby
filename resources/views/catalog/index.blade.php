@extends('layouts.app')

@section('title', $metaTitle ?? 'Catalogue - EpiDrive')
@section('meta_description', $metaDescription ?? 'Parcourez toutes les categories de produits EpiDrive.')

@section('content')

    {{-- Page Header with Gradient --}}
    <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-500 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-white rounded-full"></div>
            <div class="absolute -bottom-20 -left-10 w-96 h-96 bg-white rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 relative">
            {{-- Breadcrumb Pills --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white/90 hover:bg-white/30 transition backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </li>
                    <li>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/30 text-white font-medium backdrop-blur-sm">Catalogue</span>
                    </li>
                </ol>
            </nav>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Nos categories</h1>
            <p class="mt-2 text-emerald-100 text-lg max-w-xl">Parcourez nos rayons et trouvez vos produits favoris</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        @php
            $emojiMap = [
                'Boissons' => "\xF0\x9F\xA5\xA4",
                'Conserves' => "\xF0\x9F\xA5\xAB",
                'P\xC3\xA2tes & Riz' => "\xF0\x9F\x8D\x9D",
                'Snacks' => "\xF0\x9F\x8D\xBF",
                'Produits du quotidien' => "\xF0\x9F\xA7\xB4",
            ];
            $defaultEmoji = "\xF0\x9F\x93\xA6";

            $pastelColors = [
                'bg-amber-50 hover:bg-amber-100',
                'bg-rose-50 hover:bg-rose-100',
                'bg-sky-50 hover:bg-sky-100',
                'bg-violet-50 hover:bg-violet-100',
                'bg-lime-50 hover:bg-lime-100',
                'bg-orange-50 hover:bg-orange-100',
                'bg-cyan-50 hover:bg-cyan-100',
                'bg-pink-50 hover:bg-pink-100',
                'bg-teal-50 hover:bg-teal-100',
                'bg-indigo-50 hover:bg-indigo-100',
            ];
        @endphp

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($categories ?? [] as $index => $category)
                <a href="{{ route('catalog.category', $category->slug) }}"
                   class="group relative rounded-2xl {{ $pastelColors[$index % count($pastelColors)] }} p-6 sm:p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:scale-[1.02] overflow-hidden"
                   style="animation: fadeInUp 0.5s ease-out {{ $index * 0.08 }}s both;">
                    {{-- Decorative circle --}}
                    <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-white/30 group-hover:scale-150 transition-transform duration-500"></div>

                    {{-- Emoji --}}
                    <div class="text-5xl sm:text-6xl mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                        {{ $emojiMap[$category->name] ?? $defaultEmoji }}
                    </div>

                    {{-- Name --}}
                    <h2 class="font-bold text-gray-800 text-base sm:text-lg relative z-10">{{ $category->name }}</h2>

                    {{-- Product count --}}
                    <p class="text-sm text-gray-500 mt-1 relative z-10">
                        {{ $category->products_count ?? 0 }} produit{{ ($category->products_count ?? 0) > 1 ? 's' : '' }}
                    </p>

                    {{-- Arrow icon --}}
                    <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-white/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="text-6xl mb-4">{{ $defaultEmoji }}</div>
                    <p class="text-gray-500 text-lg">Aucune categorie disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

@endsection
