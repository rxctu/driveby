<?php $__env->startSection('title', 'Mes donnees personnelles - EpiDrive'); ?>
<?php $__env->startSection('meta_description', 'Gerez vos donnees personnelles conformement au RGPD.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ showDeleteModal: false }">

    <nav class="text-sm text-gray-500 mb-6">
        <a href="<?php echo e(route('account.index')); ?>" class="hover:text-emerald-700 transition">Mon compte</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">Mes donnees personnelles</span>
    </nav>

    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Mes donnees personnelles</h1>
    <p class="text-gray-500 mb-8">Conformement au RGPD, vous pouvez consulter, exporter et supprimer vos donnees.</p>

    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Informations stockees</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nom</p>
                <p class="text-gray-700 font-medium"><?php echo e($user->name); ?></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                <p class="text-gray-700 font-medium"><?php echo e($user->email); ?></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Telephone</p>
                <p class="text-gray-700 font-medium"><?php echo e($user->phone ?? 'Non renseigne'); ?></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Adresse</p>
                <p class="text-gray-700 font-medium"><?php echo e($user->address ?? 'Non renseignee'); ?></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Date d'inscription</p>
                <p class="text-gray-700 font-medium"><?php echo e($user->created_at->format('d/m/Y')); ?></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre de commandes</p>
                <p class="text-gray-700 font-medium"><?php echo e($orders->count()); ?></p>
            </div>
        </div>

        <div class="mt-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
            <p class="text-sm text-emerald-700">
                <strong>Chiffrement :</strong> Vos donnees sensibles (telephone, adresse) sont chiffrees en AES-256-CBC
                dans notre base de donnees. Vos mots de passe sont haches avec Argon2id (irreversible).
            </p>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Exporter mes donnees</h2>
        <p class="text-sm text-gray-500 mb-4">
            Droit a la portabilite (Article 20 RGPD) : telechargez l'ensemble de vos donnees personnelles au format JSON.
        </p>
        <form action="<?php echo e(route('account.export-data')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit"
                    class="inline-flex items-center space-x-2 bg-emerald-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-emerald-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Telecharger mes donnees (JSON)</span>
            </button>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6 sm:p-8">
        <h2 class="text-lg font-bold text-red-700 mb-2">Supprimer mon compte</h2>
        <p class="text-sm text-gray-500 mb-4">
            Droit a l'effacement (Article 17 RGPD) : cette action est irreversible. Vos donnees personnelles seront
            supprimees et vos commandes anonymisees (conservees pour des raisons comptables legales).
        </p>
        <button @click="showDeleteModal = true"
                class="inline-flex items-center space-x-2 bg-red-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-red-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span>Supprimer mon compte</span>
        </button>
    </div>

    
    <div x-show="showDeleteModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-transition>
        <div class="fixed inset-0 bg-black/50" @click="showDeleteModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-md w-full z-10">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Confirmer la suppression</h3>
            <p class="text-sm text-gray-500 mb-6">
                Cette action est irreversible. Entrez votre mot de passe pour confirmer.
            </p>
            <form action="<?php echo e(route('account.delete-account')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="mb-6">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="confirm_delete" value="1" required
                               class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm text-gray-600">Je comprends que cette action est irreversible</span>
                    </label>
                </div>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="showDeleteModal = false"
                            class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                        Supprimer definitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/account/privacy.blade.php ENDPATH**/ ?>