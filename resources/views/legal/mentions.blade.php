@extends('layouts.app')

@section('title', 'Mentions legales - EpiDrive')
@section('meta_description', 'Mentions legales du site EpiDrive.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Mentions legales</h1>

    <div class="prose prose-emerald max-w-none space-y-8">
        <section>
            <h2 class="text-xl font-bold text-gray-800">1. Editeur du site</h2>
            <p class="text-gray-600 leading-relaxed">
                Le site EpiDrive est edite par :<br>
                <strong>M. Brian Ribeiro</strong> - Entrepreneur individuel<br>
                Siege social : 64 Chemin de Saint-Pardoux, 63600 Ambert, France<br>
                SIRET : 903 003 549 00024<br>
                N° TVA intracommunautaire : FR 91 903003549<br>
                Code NAF : 4639B - Commerce de gros alimentaire non specialise<br>
                Directeur de la publication : M. Brian Ribeiro<br>
                Email : <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a>
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">2. Hebergement</h2>
            <p class="text-gray-600 leading-relaxed">
                Le site est heberge par :<br>
                <strong>OVHcloud</strong><br>
                2 rue Kellermann, 59100 Roubaix, France<br>
                SAS au capital de 10 174 560 EUR<br>
                RCS Lille Metropole 424 761 419 00045<br>
                Telephone : +33 9 72 10 10 07<br>
                <a href="https://www.ovhcloud.com" class="text-emerald-600 hover:underline" target="_blank" rel="noopener">www.ovhcloud.com</a>
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">3. Propriete intellectuelle</h2>
            <p class="text-gray-600 leading-relaxed">
                L'ensemble des elements figurant sur le site EpiDrive (textes, images, logos, icones, sons, logiciels, etc.)
                sont proteges par les dispositions du Code de la Propriete Intellectuelle. Toute reproduction, representation,
                modification, publication, adaptation de tout ou partie des elements du site est interdite sans l'autorisation
                ecrite prealable d'EpiDrive.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">4. Donnees personnelles</h2>
            <p class="text-gray-600 leading-relaxed">
                Conformement au Reglement General sur la Protection des Donnees (RGPD) et a la loi Informatique et Libertes,
                vous disposez d'un droit d'acces, de rectification, de portabilite et d'effacement de vos donnees.
                Pour toute demande, contactez-nous a : <a href="mailto:contact@epidrive.fr" class="text-emerald-600 hover:underline">contact@epidrive.fr</a>.<br><br>
                Responsable du traitement des donnees : M. Brian Ribeiro<br>
                Pour en savoir plus, consultez notre <a href="{{ route('legal.privacy') }}" class="text-emerald-600 hover:underline">Politique de confidentialite</a>.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">5. Cookies</h2>
            <p class="text-gray-600 leading-relaxed">
                Le site utilise uniquement des cookies strictement necessaires a son fonctionnement (session, panier, securite CSRF).
                Aucun cookie publicitaire ou de tracking n'est utilise.
                Consultez notre <a href="{{ route('legal.cookies') }}" class="text-emerald-600 hover:underline">Politique cookies</a> pour plus de details.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">6. Limitation de responsabilite</h2>
            <p class="text-gray-600 leading-relaxed">
                EpiDrive ne saurait etre tenu responsable des dommages directs ou indirects causes au materiel de l'utilisateur
                lors de l'acces au site. EpiDrive decline toute responsabilite quant a l'utilisation qui pourrait etre faite
                des informations et contenus presents sur le site.
            </p>
        </section>
    </div>
</div>
@endsection
