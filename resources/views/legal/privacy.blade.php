@extends('layouts.app')

@section('title', 'Politique de confidentialite - EpiDrive')
@section('meta_description', 'Decouvrez comment EpiDrive protege vos donnees personnelles conformement au RGPD.')

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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Politique de confidentialite</h1>
            <p class="text-emerald-200 text-lg">Protection de vos donnees personnelles</p>
            <p class="text-emerald-300 text-sm mt-2">Derniere mise a jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>

    {{-- Navigation rapide --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 flex flex-wrap justify-center gap-2 sm:gap-3">
            <a href="{{ route('legal.mentions') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Mentions legales</a>
            <a href="{{ route('legal.privacy') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl">Confidentialite</a>
            <a href="{{ route('legal.cgv') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">CGV</a>
            <a href="{{ route('legal.cookies') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Cookies</a>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">

        {{-- Responsable du traitement --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">1. Responsable du traitement</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    <strong class="text-gray-800">M. Brian Ribeiro</strong> - Entrepreneur individuel<br>
                    14 Boulevard Henri IV, 63600 Ambert, France<br>
                    SIRET : <span class="font-mono">903 003 549 00024</span><br>
                    Email : <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline font-medium">contact@epidrive.fr</a>
                </p>
            </div>
        </div>

        {{-- Donnees collectees --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">2. Donnees collectees</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3 p-3 bg-blue-50/50 rounded-xl">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">Inscription</p>
                            <p class="text-gray-500 mt-0.5">Nom, email, telephone (optionnel), mot de passe (chiffre)</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-blue-50/50 rounded-xl">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">Commande</p>
                            <p class="text-gray-500 mt-0.5">Nom, telephone, adresse de livraison, instructions</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-blue-50/50 rounded-xl">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">Paiement</p>
                            <p class="text-gray-500 mt-0.5">Methode choisie (donnees bancaires traitees par Stripe, PCI-DSS)</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-blue-50/50 rounded-xl">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">Navigation</p>
                            <p class="text-gray-500 mt-0.5">Cookies de session strictement necessaires</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Finalites & Base legale --}}
        <div class="grid sm:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">3. Finalites</h2>
                </div>
                <ul class="px-6 py-5 text-sm text-gray-600 space-y-2">
                    <li class="flex items-start space-x-2"><span class="text-emerald-500 mt-0.5">&#10003;</span><span>Gestion de votre compte utilisateur</span></li>
                    <li class="flex items-start space-x-2"><span class="text-emerald-500 mt-0.5">&#10003;</span><span>Traitement et livraison de vos commandes</span></li>
                    <li class="flex items-start space-x-2"><span class="text-emerald-500 mt-0.5">&#10003;</span><span>Communication relative a vos commandes</span></li>
                    <li class="flex items-start space-x-2"><span class="text-emerald-500 mt-0.5">&#10003;</span><span>Amelioration de nos services</span></li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-violet-50 to-purple-50 border-b border-violet-100">
                    <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">4. Base legale</h2>
                </div>
                <ul class="px-6 py-5 text-sm text-gray-600 space-y-2">
                    <li class="flex items-start space-x-2"><span class="text-violet-500 mt-0.5">&#9679;</span><span><strong>Contrat :</strong> traitement des commandes</span></li>
                    <li class="flex items-start space-x-2"><span class="text-violet-500 mt-0.5">&#9679;</span><span><strong>Obligation legale :</strong> factures (10 ans)</span></li>
                    <li class="flex items-start space-x-2"><span class="text-violet-500 mt-0.5">&#9679;</span><span><strong>Consentement :</strong> newsletter</span></li>
                    <li class="flex items-start space-x-2"><span class="text-violet-500 mt-0.5">&#9679;</span><span><strong>Interet legitime :</strong> securite, anti-fraude</span></li>
                </ul>
            </div>
        </div>

        {{-- Duree de conservation --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-cyan-50 to-sky-50 border-b border-cyan-100">
                <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">5. Duree de conservation</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="flex items-center space-x-3 p-3 bg-cyan-50/50 rounded-xl text-sm">
                        <span class="text-2xl">&#128100;</span>
                        <div>
                            <p class="font-semibold text-gray-800">Donnees de compte</p>
                            <p class="text-gray-500">Duree de l'inscription + 3 ans</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-cyan-50/50 rounded-xl text-sm">
                        <span class="text-2xl">&#128230;</span>
                        <div>
                            <p class="font-semibold text-gray-800">Donnees de commande</p>
                            <p class="text-gray-500">10 ans (obligation comptable)</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-cyan-50/50 rounded-xl text-sm">
                        <span class="text-2xl">&#127850;</span>
                        <div>
                            <p class="font-semibold text-gray-800">Cookies de session</p>
                            <p class="text-gray-500">2 heures d'inactivite</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-cyan-50/50 rounded-xl text-sm">
                        <span class="text-2xl">&#128220;</span>
                        <div>
                            <p class="font-semibold text-gray-800">Logs de securite</p>
                            <p class="text-gray-500">12 mois</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Securite --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">6. Securite des donnees</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid sm:grid-cols-2 gap-2">
                    @php
                        $securityItems = [
                            ['Chiffrement AES-256-CBC', 'Donnees sensibles chiffrees en base'],
                            ['Argon2id', 'Mots de passe haches de facon irreversible'],
                            ['Sessions chiffrees', 'Cookies HttpOnly, SameSite Strict'],
                            ['Protection CSRF', 'Token unique par formulaire'],
                            ['En-tetes HTTP', 'CSP, HSTS, X-Frame-Options'],
                            ['Rate limiting', 'Protection anti-brute-force'],
                            ['Docker isole', 'Secrets chiffres, privileges minimaux'],
                        ];
                    @endphp
                    @foreach($securityItems as $item)
                        <div class="flex items-start space-x-2 p-2 text-sm">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-800">{{ $item[0] }}</span>
                                <span class="text-gray-500"> - {{ $item[1] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sous-traitants --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">7. Sous-traitants</h2>
            </div>
            <div class="px-6 py-5">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="p-4 border border-gray-100 rounded-xl">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="font-bold text-gray-800 text-sm">Stripe</span>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">PCI-DSS</span>
                        </div>
                        <p class="text-xs text-gray-500">Paiement en ligne - Etats-Unis (clauses contractuelles types)</p>
                    </div>
                    <div class="p-4 border border-gray-100 rounded-xl">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="font-bold text-gray-800 text-sm">Google</span>
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">OAuth 2.0</span>
                        </div>
                        <p class="text-xs text-gray-500">Authentification - Etats-Unis (clauses contractuelles types)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vos droits RGPD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-purple-100">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15M6.9 7.575a1.575 1.575 0 10-3.15 0v8.175a6.75 6.75 0 006.75 6.75h2.018a5.25 5.25 0 003.712-1.538l1.732-1.732a5.25 5.25 0 001.538-3.712l.003-2.024a.668.668 0 00-.668-.668 1.667 1.667 0 01-1.667-1.667V7.575"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">8. Vos droits (RGPD)</h2>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div class="grid sm:grid-cols-2 gap-3">
                    @php
                        $rights = [
                            ['Droit d\'acces', 'Obtenir une copie de vos donnees', '#8B5CF6'],
                            ['Droit de rectification', 'Corriger vos donnees inexactes', '#8B5CF6'],
                            ['Droit a l\'effacement', 'Supprimer votre compte et vos donnees', '#8B5CF6'],
                            ['Droit a la portabilite', 'Exporter vos donnees en JSON', '#8B5CF6'],
                            ['Droit d\'opposition', 'Vous opposer au traitement', '#8B5CF6'],
                            ['Droit a la limitation', 'Limiter le traitement', '#8B5CF6'],
                        ];
                    @endphp
                    @foreach($rights as $right)
                        <div class="flex items-start space-x-3 p-3 bg-purple-50/50 rounded-xl">
                            <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-semibold text-gray-800">{{ $right[0] }}</p>
                                <p class="text-gray-500 text-xs mt-0.5">{{ $right[1] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <p class="text-sm text-gray-600">
                        @auth
                            Exercez vos droits directement depuis votre
                            <a href="{{ route('account.privacy') }}" class="text-emerald-600 hover:underline font-semibold">espace personnel</a>
                            ou contactez-nous a <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline font-semibold">contact@epidrive.fr</a>.
                        @else
                            Contactez-nous a <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline font-semibold">contact@epidrive.fr</a>
                            ou <a href="{{ route('login') }}" class="text-emerald-600 hover:underline font-semibold">connectez-vous</a> pour acceder a votre espace de gestion des donnees.
                        @endauth
                    </p>
                </div>
            </div>
        </div>

        {{-- Reclamation --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100">
                <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">9. Reclamation</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    Si vous estimez que le traitement de vos donnees constitue une violation du RGPD, vous avez le droit
                    d'introduire une reclamation aupres de la CNIL :
                </p>
                <div class="mt-3 p-3 bg-rose-50/50 rounded-xl flex items-center space-x-3">
                    <span class="text-2xl">&#127987;</span>
                    <div>
                        <p class="font-semibold text-gray-800">Commission Nationale de l'Informatique et des Libertes</p>
                        <p class="text-gray-500">3 Place de Fontenoy, 75007 Paris - <a href="https://www.cnil.fr" class="text-emerald-600 hover:underline" target="_blank" rel="noopener">www.cnil.fr</a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
