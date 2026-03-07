@extends('layouts.app')

@section('title', 'Conditions Generales de Vente - EpiDrive')
@section('meta_description', 'Conditions generales de vente du site EpiDrive.')

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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Conditions Generales de Vente</h1>
            <p class="text-emerald-200 text-lg">Regles applicables a vos achats sur EpiDrive</p>
            <p class="text-emerald-300 text-sm mt-2">Derniere mise a jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>

    {{-- Navigation rapide --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 flex flex-wrap justify-center gap-2 sm:gap-3">
            <a href="{{ route('legal.mentions') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Mentions legales</a>
            <a href="{{ route('legal.privacy') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Confidentialite</a>
            <a href="{{ route('legal.cgv') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl">CGV</a>
            <a href="{{ route('legal.cookies') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-xl hover:bg-emerald-50 hover:text-emerald-700 transition">Cookies</a>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">

        {{-- Objet --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-lg font-bold text-emerald-700">1</div>
                <h2 class="text-lg font-bold text-gray-900">Objet</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    Les presentes CGV regissent les ventes de produits alimentaires et de consommation courante
                    effectuees sur le site EpiDrive (ci-apres "le Site") par <strong class="text-gray-800">M. Brian Ribeiro</strong>,
                    entrepreneur individuel, SIRET <span class="font-mono">903 003 549 00024</span>,
                    64 Chemin de Saint-Pardoux, 63600 Ambert (ci-apres "le Vendeur"), aupres de ses clients.
                </p>
            </div>
        </div>

        {{-- Prix --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-lg font-bold text-blue-700">2</div>
                <h2 class="text-lg font-bold text-gray-900">Prix</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    Les prix sont indiques en euros TTC (TVA intracommunautaire : <span class="font-mono">FR 91 903003549</span>).
                    Le Vendeur se reserve le droit de modifier ses prix a tout moment.
                    Les produits sont factures au prix en vigueur au moment de la validation de la commande.
                </p>
            </div>
        </div>

        {{-- Commande --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-lg font-bold text-amber-700">3</div>
                <h2 class="text-lg font-bold text-gray-900">Commande</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    La validation de la commande par le client vaut acceptation des presentes CGV.
                    EpiDrive se reserve le droit de refuser toute commande pour motif legitime.
                </p>
            </div>
        </div>

        {{-- Paiement --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-violet-50 to-purple-50 border-b border-violet-100">
                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center text-lg font-bold text-violet-700">4</div>
                <h2 class="text-lg font-bold text-gray-900">Paiement</h2>
            </div>
            <div class="px-6 py-5">
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Les moyens de paiement acceptes :</p>
                <div class="grid sm:grid-cols-3 gap-3">
                    <div class="flex items-center space-x-3 p-3 bg-violet-50/50 rounded-xl">
                        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">Carte bancaire</p>
                            <p class="text-gray-400 text-xs">Via Stripe (PCI-DSS)</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-violet-50/50 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xs">PP</span>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">PayPal</p>
                            <p class="text-gray-400 text-xs">Paiement securise</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-violet-50/50 rounded-xl">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">Especes</p>
                            <p class="text-gray-400 text-xs">A la livraison</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Livraison --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-cyan-50 to-sky-50 border-b border-cyan-100">
                <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center text-lg font-bold text-cyan-700">5</div>
                <h2 class="text-lg font-bold text-gray-900">Livraison</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    La livraison est effectuee a l'adresse indiquee par le client. Les frais de livraison sont
                    indiques avant la validation de la commande. La livraison est gratuite a partir du seuil indique sur le site.
                </p>
            </div>
        </div>

        {{-- Retractation --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100">
                <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-lg font-bold text-rose-700">6</div>
                <h2 class="text-lg font-bold text-gray-900">Droit de retractation</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed space-y-3">
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-start space-x-3">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                    <p>
                        Conformement a l'article <strong>L221-28</strong> du Code de la consommation, le droit de retractation
                        <strong>ne s'applique pas</strong> aux denrees perissables ou aux produits descelles apres la livraison.
                    </p>
                </div>
                <p>
                    Pour les produits non perissables et non ouverts, le droit de retractation s'exerce dans un delai
                    de <strong>14 jours</strong> a compter de la reception.
                </p>
            </div>
        </div>

        {{-- Reclamations --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-200">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-lg font-bold text-gray-700">7</div>
                <h2 class="text-lg font-bold text-gray-900">Reclamations</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    Pour toute reclamation, contactez notre service client a
                    <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline font-semibold">contact@epidrive.fr</a>.
                </p>
            </div>
        </div>

        {{-- Mediateur --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-indigo-100">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-lg font-bold text-indigo-700">8</div>
                <h2 class="text-lg font-bold text-gray-900">Mediateur</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    En cas de litige non resolu, le client peut saisir gratuitement un mediateur de la consommation.
                </p>
                <div class="mt-3 p-3 bg-indigo-50/50 rounded-xl">
                    <p class="font-semibold text-gray-800 text-sm">Plateforme europeenne de reglement en ligne des litiges</p>
                    <a href="https://ec.europa.eu/consumers/odr" class="text-emerald-600 hover:underline text-sm" target="_blank" rel="noopener">https://ec.europa.eu/consumers/odr</a>
                </div>
            </div>
        </div>

        {{-- Droit applicable --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center space-x-3 px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-emerald-100">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-lg font-bold text-emerald-700">9</div>
                <h2 class="text-lg font-bold text-gray-900">Droit applicable</h2>
            </div>
            <div class="px-6 py-5 text-sm text-gray-600 leading-relaxed">
                <p>
                    Les presentes CGV sont soumises au droit francais. En cas de litige, les tribunaux competents
                    du ressort du siege social du Vendeur seront competents.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
