@extends('layouts.app')

@section('title', 'Politique de confidentialite - EpiDrive')
@section('meta_description', 'Decouvrez comment EpiDrive protege vos donnees personnelles conformement au RGPD.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Politique de confidentialite</h1>
    <p class="text-gray-500 mb-8">Derniere mise a jour : {{ date('d/m/Y') }}</p>

    <div class="prose prose-emerald max-w-none space-y-8">
        <section>
            <h2 class="text-xl font-bold text-gray-800">1. Responsable du traitement</h2>
            <p class="text-gray-600 leading-relaxed">
                M. Brian Ribeiro - Entrepreneur individuel<br>
                64 Chemin de Saint-Pardoux, 63600 Ambert, France<br>
                SIRET : 903 003 549 00024<br>
                Email : <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a>
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">2. Donnees collectees</h2>
            <p class="text-gray-600 leading-relaxed">Nous collectons les donnees suivantes :</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li><strong>Inscription :</strong> Nom, email, telephone (optionnel), mot de passe (chiffre)</li>
                <li><strong>Commande :</strong> Nom, telephone, adresse de livraison, instructions de livraison</li>
                <li><strong>Paiement :</strong> Methode de paiement (les donnees bancaires sont traitees exclusivement par Stripe, certifie PCI-DSS)</li>
                <li><strong>Navigation :</strong> Cookies de session strictement necessaires</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">3. Finalites du traitement</h2>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li>Gestion de votre compte utilisateur</li>
                <li>Traitement et livraison de vos commandes</li>
                <li>Communication relative a vos commandes (confirmation, suivi)</li>
                <li>Amelioration de nos services</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">4. Base legale</h2>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li><strong>Execution du contrat :</strong> traitement des commandes</li>
                <li><strong>Obligation legale :</strong> conservation des factures (10 ans)</li>
                <li><strong>Consentement :</strong> newsletter (si applicable)</li>
                <li><strong>Interet legitime :</strong> securite du site, prevention des fraudes</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">5. Duree de conservation</h2>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li><strong>Donnees de compte :</strong> duree de l'inscription + 3 ans apres suppression</li>
                <li><strong>Donnees de commande :</strong> 10 ans (obligation legale comptable)</li>
                <li><strong>Cookies de session :</strong> duree de la session (2 heures d'inactivite)</li>
                <li><strong>Logs de securite :</strong> 12 mois</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">6. Securite des donnees</h2>
            <p class="text-gray-600 leading-relaxed">
                Vos donnees personnelles sont protegees par :
            </p>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li>Chiffrement AES-256-CBC des donnees sensibles en base de donnees (noms, telephones, adresses)</li>
                <li>Mots de passe haches avec Argon2id</li>
                <li>Sessions chiffrees et cookies securises (HttpOnly, SameSite Strict)</li>
                <li>Protection CSRF sur tous les formulaires</li>
                <li>En-tetes de securite HTTP (CSP, HSTS, X-Frame-Options)</li>
                <li>Limitation du debit des requetes (rate limiting)</li>
                <li>Infrastructure Docker isolee avec secrets chiffres</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">7. Sous-traitants</h2>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li><strong>Stripe</strong> (paiement en ligne) - Certifie PCI-DSS - Etats-Unis (clauses contractuelles types)</li>
                <li><strong>Google</strong> (authentification OAuth) - Etats-Unis (clauses contractuelles types)</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">8. Vos droits (RGPD)</h2>
            <p class="text-gray-600 leading-relaxed">Conformement au RGPD, vous disposez des droits suivants :</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                <li><strong>Droit d'acces :</strong> obtenir une copie de vos donnees</li>
                <li><strong>Droit de rectification :</strong> corriger vos donnees inexactes</li>
                <li><strong>Droit a l'effacement :</strong> supprimer votre compte et vos donnees personnelles</li>
                <li><strong>Droit a la portabilite :</strong> exporter vos donnees dans un format lisible (JSON)</li>
                <li><strong>Droit d'opposition :</strong> vous opposer au traitement de vos donnees</li>
                <li><strong>Droit a la limitation :</strong> limiter le traitement de vos donnees</li>
            </ul>
            <p class="text-gray-600 leading-relaxed mt-4">
                @auth
                    Exercez vos droits directement depuis votre
                    <a href="{{ route('account.privacy') }}" class="text-emerald-600 hover:underline">espace personnel</a>
                    ou contactez notre DPO a <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a>.
                @else
                    Contactez notre DPO a <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a>
                    ou connectez-vous pour acceder a votre espace de gestion des donnees.
                @endauth
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">9. Reclamation</h2>
            <p class="text-gray-600 leading-relaxed">
                Si vous estimez que le traitement de vos donnees constitue une violation du RGPD, vous avez le droit
                d'introduire une reclamation aupres de la CNIL :<br>
                <a href="https://www.cnil.fr" class="text-emerald-600 hover:underline" target="_blank" rel="noopener">www.cnil.fr</a> -
                3 Place de Fontenoy, 75007 Paris.
            </p>
        </section>
    </div>
</div>
@endsection
