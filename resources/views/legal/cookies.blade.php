@extends('layouts.app')

@section('title', 'Politique cookies - EpiDrive')
@section('meta_description', 'Informations sur les cookies utilises par EpiDrive.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    {{-- Hero Header --}}
    <div class="relative bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-600 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-16 -left-16 w-72 h-72 bg-white/5 rounded-full"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Politique cookies</h1>
            <p class="text-emerald-200 text-lg">Transparence sur les cookies utilises</p>
            <p class="text-emerald-300 text-sm mt-2">Derniere mise a jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>

    {{-- Navigation rapide --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 flex flex-wrap justify-center gap-2 sm:gap-3">
            <a href="{{ route('legal.mentions') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Mentions legales</a>
            <a href="{{ route('legal.privacy') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Confidentialite</a>
            <a href="{{ route('legal.cgv') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">CGV</a>
            <a href="{{ route('legal.cookies') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl">Cookies</a>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">

        {{-- Qu'est-ce qu'un cookie --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Qu'est-ce qu'un cookie ?</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    Un cookie est un petit fichier texte depose sur votre navigateur lors de la visite d'un site web.
                    Il permet au site de memoriser des informations sur votre visite (session de connexion, panier d'achat, preferences).
                </p>
            </div>
        </div>

        {{-- Cookies utilises --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Cookies utilises sur EpiDrive</h2>
            </div>
            <div class="px-6 py-5">
                <div class="space-y-3">
                    {{-- epidrive_session --}}
                    <div class="flex items-start space-x-4 p-4 bg-emerald-50/50 rounded-xl border border-emerald-100/50">
                        <div class="flex-shrink-0">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">Essentiel</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <code class="text-sm font-mono font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">epidrive_session</code>
                                <span class="text-xs text-gray-400">&#8226; 2 heures</span>
                            </div>
                            <p class="text-sm text-gray-500">Maintien de votre session de connexion et du contenu de votre panier d'achat.</p>
                        </div>
                    </div>

                    {{-- XSRF-TOKEN --}}
                    <div class="flex items-start space-x-4 p-4 bg-emerald-50/50 rounded-xl border border-emerald-100/50">
                        <div class="flex-shrink-0">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">Essentiel</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <code class="text-sm font-mono font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">XSRF-TOKEN</code>
                                <span class="text-xs text-gray-400">&#8226; 2 heures</span>
                            </div>
                            <p class="text-sm text-gray-500">Protection contre les attaques CSRF (Cross-Site Request Forgery). Ce cookie securise vos formulaires.</p>
                        </div>
                    </div>

                    {{-- cookie_consent --}}
                    <div class="flex items-start space-x-4 p-4 bg-emerald-50/50 rounded-xl border border-emerald-100/50">
                        <div class="flex-shrink-0">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">Essentiel</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <code class="text-sm font-mono font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">cookie_consent</code>
                                <span class="text-xs text-gray-400">&#8226; 1 an</span>
                            </div>
                            <p class="text-sm text-gray-500">Memorisation de votre choix concernant l'acceptation des cookies.</p>
                        </div>
                    </div>
                </div>

                {{-- Resume --}}
                <div class="mt-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-emerald-800 font-medium">
                        Tous les cookies utilises par EpiDrive sont <strong>strictement necessaires</strong> au fonctionnement du site.
                        Aucun consentement supplementaire n'est requis conformement a l'article 82 de la loi Informatique et Libertes.
                    </p>
                </div>
            </div>
        </div>

        {{-- Cookies tiers --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100">
                <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Cookies tiers</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed space-y-3">
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="font-semibold text-gray-800 mb-1">Aucun cookie publicitaire ou de tracking</p>
                    <p class="text-gray-500 text-sm">
                        EpiDrive n'utilise aucun outil de type Google Analytics, Facebook Pixel ou equivalent.
                        Votre navigation n'est ni tracee ni analysee a des fins publicitaires.
                    </p>
                </div>
                <p>
                    En cas de paiement par carte bancaire, <strong>Stripe</strong> peut deposer des cookies techniques
                    necessaires au traitement securise du paiement (conformement a la norme PCI-DSS).
                </p>
            </div>
        </div>

        {{-- Gerer vos cookies --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Gerer vos cookies</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed space-y-3">
                <p>
                    Vous pouvez a tout moment supprimer les cookies depuis les parametres de votre navigateur.
                </p>
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                    <p>
                        <strong>Attention :</strong> la suppression du cookie de session entrainera la deconnexion
                        et la perte du contenu de votre panier.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
