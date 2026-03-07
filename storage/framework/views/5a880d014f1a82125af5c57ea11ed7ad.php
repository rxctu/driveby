<?php $__env->startSection('title', 'Mentions legales - EpiDrive'); ?>
<?php $__env->startSection('meta_description', 'Mentions legales du site EpiDrive.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Mentions legales</h1>

    <div class="prose prose-emerald max-w-none space-y-8">
        <section>
            <h2 class="text-xl font-bold text-gray-800">1. Editeur du site</h2>
            <p class="text-gray-600 leading-relaxed">
                Le site EpiDrive est edite par :<br>
                <strong>EpiDrive SAS</strong><br>
                Siege social : 12 Rue du Commerce, 75015 Paris, France<br>
                SIRET : [A COMPLETER]<br>
                RCS Paris : [A COMPLETER]<br>
                Capital social : [A COMPLETER]<br>
                Directeur de la publication : [A COMPLETER]<br>
                Telephone : +33 1 23 45 67 89<br>
                Email : contact@epidrive.fr
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">2. Hebergement</h2>
            <p class="text-gray-600 leading-relaxed">
                Le site est heberge par :<br>
                [A COMPLETER - Nom de l'hebergeur]<br>
                [Adresse de l'hebergeur]<br>
                [Telephone de l'hebergeur]
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
                Pour toute demande, contactez-nous a : <a href="mailto:dpo@epidrive.fr" class="text-emerald-600 hover:underline">dpo@epidrive.fr</a>.<br><br>
                Delegue a la Protection des Donnees (DPO) : [A COMPLETER]<br>
                Pour en savoir plus, consultez notre <a href="<?php echo e(route('legal.privacy')); ?>" class="text-emerald-600 hover:underline">Politique de confidentialite</a>.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">5. Cookies</h2>
            <p class="text-gray-600 leading-relaxed">
                Le site utilise uniquement des cookies strictement necessaires a son fonctionnement (session, panier, securite CSRF).
                Aucun cookie publicitaire ou de tracking n'est utilise.
                Consultez notre <a href="<?php echo e(route('legal.cookies')); ?>" class="text-emerald-600 hover:underline">Politique cookies</a> pour plus de details.
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/legal/mentions.blade.php ENDPATH**/ ?>