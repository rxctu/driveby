@extends('layouts.app')

@section('title', 'Mentions legales - EpiDrive')
@section('meta_description', 'Mentions legales du site EpiDrive.')

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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Mentions legales</h1>
            <p class="text-emerald-200 text-lg">Informations legales relatives au site EpiDrive</p>
        </div>
    </div>

    {{-- Navigation rapide --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 flex flex-wrap justify-center gap-2 sm:gap-3">
            <a href="{{ route('legal.mentions') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl">Mentions legales</a>
            <a href="{{ route('legal.privacy') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Confidentialite</a>
            <a href="{{ route('legal.cgv') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">CGV</a>
            <a href="{{ route('legal.cookies') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Cookies</a>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">

        {{-- Editeur --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Editeur du site</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Raison sociale</span>
                            <p class="text-gray-800 font-semibold mt-0.5">M. Brian Ribeiro</p>
                            <p class="text-gray-500 text-xs">Entrepreneur individuel</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Siege social</span>
                            <p class="text-gray-700 mt-0.5">64 Chemin de Saint-Pardoux<br>63600 Ambert, France</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Directeur de la publication</span>
                            <p class="text-gray-700 mt-0.5">M. Brian Ribeiro</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">SIRET</span>
                            <p class="text-gray-700 font-mono mt-0.5">903 003 549 00024</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">TVA intracommunautaire</span>
                            <p class="text-gray-700 font-mono mt-0.5">FR 91 903003549</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Code NAF</span>
                            <p class="text-gray-700 mt-0.5">4639B - Commerce de gros alimentaire</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Contact</span>
                            <p class="mt-0.5"><a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:text-emerald-700 font-medium">contact@epidrive.fr</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hebergeur --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Hebergement</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Hebergeur</span>
                            <p class="text-gray-800 font-semibold mt-0.5">OVHcloud</p>
                            <p class="text-gray-500 text-xs">SAS au capital de 10 174 560 EUR</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Adresse</span>
                            <p class="text-gray-700 mt-0.5">2 rue Kellermann<br>59100 Roubaix, France</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">RCS</span>
                            <p class="text-gray-700 font-mono mt-0.5">Lille Metropole 424 761 419 00045</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Telephone</span>
                            <p class="text-gray-700 mt-0.5">+33 9 72 10 10 07</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs uppercase tracking-wider font-semibold">Site web</span>
                            <p class="mt-0.5"><a href="https://www.ovhcloud.com" class="text-blue-600 hover:text-blue-700 font-medium" target="_blank" rel="noopener">www.ovhcloud.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Propriete intellectuelle --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Propriete intellectuelle</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    L'ensemble des elements figurant sur le site EpiDrive (textes, images, logos, icones, sons, logiciels, etc.)
                    sont proteges par les dispositions du Code de la Propriete Intellectuelle. Toute reproduction, representation,
                    modification, publication, adaptation de tout ou partie des elements du site est interdite sans l'autorisation
                    ecrite prealable d'EpiDrive.
                </p>
            </div>
        </div>

        {{-- Donnees personnelles --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-purple-100">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Donnees personnelles</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed space-y-3">
                <p>
                    Conformement au Reglement General sur la Protection des Donnees (RGPD) et a la loi Informatique et Libertes,
                    vous disposez d'un droit d'acces, de rectification, de portabilite et d'effacement de vos donnees.
                </p>
                <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-xl">
                    <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    <div>
                        <span class="text-gray-500 text-xs">Responsable du traitement</span>
                        <p class="text-gray-800 font-medium">M. Brian Ribeiro - <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a></p>
                    </div>
                </div>
                <p>
                    Pour en savoir plus, consultez notre <a href="{{ route('legal.privacy') }}" class="text-emerald-600 hover:underline font-medium">Politique de confidentialite</a>.
                </p>
            </div>
        </div>

        {{-- Cookies --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100">
                <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Cookies</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed space-y-3">
                <p>
                    Le site utilise uniquement des cookies strictement necessaires a son fonctionnement (session, panier, securite CSRF).
                    Aucun cookie publicitaire ou de tracking n'est utilise.
                </p>
                <p>
                    Consultez notre <a href="{{ route('legal.cookies') }}" class="text-emerald-600 hover:underline font-medium">Politique cookies</a> pour plus de details.
                </p>
            </div>
        </div>

        {{-- Limitation de responsabilite --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-200">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Limitation de responsabilite</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    EpiDrive ne saurait etre tenu responsable des dommages directs ou indirects causes au materiel de l'utilisateur
                    lors de l'acces au site. EpiDrive decline toute responsabilite quant a l'utilisation qui pourrait etre faite
                    des informations et contenus presents sur le site.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
