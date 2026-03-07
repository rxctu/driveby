@extends('layouts.app')

@section('title', 'Conditions Generales de Vente - EpiDrive')
@section('meta_description', 'Conditions generales de vente du site EpiDrive.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Conditions Generales de Vente</h1>
    <p class="text-gray-500 mb-8">Derniere mise a jour : {{ date('d/m/Y') }}</p>

    <div class="prose prose-emerald max-w-none space-y-8">
        <section>
            <h2 class="text-xl font-bold text-gray-800">1. Objet</h2>
            <p class="text-gray-600 leading-relaxed">
                Les presentes CGV regissent les ventes de produits alimentaires et de consommation courante
                effectuees sur le site EpiDrive (ci-apres "le Site") par M. Brian Ribeiro, entrepreneur individuel,
                SIRET 903 003 549 00024, 64 Chemin de Saint-Pardoux, 63600 Ambert (ci-apres "le Vendeur"), aupres de ses clients.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">2. Prix</h2>
            <p class="text-gray-600 leading-relaxed">
                Les prix sont indiques en euros TTC (TVA intracommunautaire : FR 91 903003549).
                Le Vendeur se reserve le droit de modifier ses prix a tout moment.
                Les produits sont factures au prix en vigueur au moment de la validation de la commande.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">3. Commande</h2>
            <p class="text-gray-600 leading-relaxed">
                La validation de la commande par le client vaut acceptation des presentes CGV.
                EpiDrive se reserve le droit de refuser toute commande pour motif legitime.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">4. Paiement</h2>
            <p class="text-gray-600 leading-relaxed">
                Le paiement s'effectue par carte bancaire (via Stripe, prestataire certifie PCI-DSS),
                PayPal ou en especes a la livraison. Le paiement par carte est securise et chiffre.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">5. Livraison</h2>
            <p class="text-gray-600 leading-relaxed">
                La livraison est effectuee a l'adresse indiquee par le client. Les frais de livraison sont
                indiques avant la validation de la commande. La livraison est gratuite a partir du seuil indique sur le site.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">6. Droit de retractation</h2>
            <p class="text-gray-600 leading-relaxed">
                Conformement a l'article L221-28 du Code de la consommation, le droit de retractation
                ne s'applique pas aux denrees perissables ou aux produits descelles apres la livraison.
                Pour les produits non perissables et non ouverts, le droit de retractation s'exerce dans un delai
                de 14 jours a compter de la reception.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">7. Reclamations</h2>
            <p class="text-gray-600 leading-relaxed">
                Pour toute reclamation, contactez notre service client a
                <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a>.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">8. Mediateur</h2>
            <p class="text-gray-600 leading-relaxed">
                En cas de litige non resolu, le client peut saisir gratuitement un mediateur de la consommation.
                Plateforme europeenne de reglement en ligne des litiges :
                <a href="https://ec.europa.eu/consumers/odr" class="text-emerald-600 hover:underline" target="_blank" rel="noopener">https://ec.europa.eu/consumers/odr</a>
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">9. Droit applicable</h2>
            <p class="text-gray-600 leading-relaxed">
                Les presentes CGV sont soumises au droit francais. En cas de litige, les tribunaux competents du ressort du siege social du Vendeur seront competents.
            </p>
        </section>
    </div>
</div>
@endsection
