<?php $__env->startSection('title', 'Politique cookies - EpiDrive'); ?>
<?php $__env->startSection('meta_description', 'Informations sur les cookies utilises par EpiDrive.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Politique cookies</h1>
    <p class="text-gray-500 mb-8">Derniere mise a jour : <?php echo e(date('d/m/Y')); ?></p>

    <div class="prose prose-emerald max-w-none space-y-8">
        <section>
            <h2 class="text-xl font-bold text-gray-800">1. Qu'est-ce qu'un cookie ?</h2>
            <p class="text-gray-600 leading-relaxed">
                Un cookie est un petit fichier texte depose sur votre navigateur lors de la visite d'un site web.
                Il permet au site de memoriser des informations sur votre visite.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">2. Cookies utilises sur EpiDrive</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-bold text-gray-700 border-b">Cookie</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-700 border-b">Type</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-700 border-b">Finalite</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-700 border-b">Duree</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-4 py-3 text-gray-600 font-mono text-xs">epidrive_session</td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Essentiel</span></td>
                            <td class="px-4 py-3 text-gray-600">Maintien de votre session de connexion et du panier</td>
                            <td class="px-4 py-3 text-gray-600">2 heures</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-gray-600 font-mono text-xs">XSRF-TOKEN</td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Essentiel</span></td>
                            <td class="px-4 py-3 text-gray-600">Protection contre les attaques CSRF</td>
                            <td class="px-4 py-3 text-gray-600">2 heures</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-gray-600 font-mono text-xs">cookie_consent</td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Essentiel</span></td>
                            <td class="px-4 py-3 text-gray-600">Memorisation de votre choix de cookies</td>
                            <td class="px-4 py-3 text-gray-600">1 an</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">3. Cookies tiers</h2>
            <p class="text-gray-600 leading-relaxed">
                <strong>EpiDrive n'utilise aucun cookie publicitaire, de tracking ou d'analyse comportementale.</strong>
                Aucun outil de type Google Analytics, Facebook Pixel ou equivalent n'est installe sur le site.
            </p>
            <p class="text-gray-600 leading-relaxed mt-2">
                En cas de paiement par carte bancaire, Stripe peut deposer des cookies techniques necessaires
                au traitement securise du paiement (conformement a PCI-DSS).
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-800">4. Gerer vos cookies</h2>
            <p class="text-gray-600 leading-relaxed">
                Vous pouvez a tout moment supprimer les cookies depuis les parametres de votre navigateur.
                Notez que la suppression du cookie de session entrainera la deconnexion et la perte du contenu de votre panier.
            </p>
        </section>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/legal/cookies.blade.php ENDPATH**/ ?>