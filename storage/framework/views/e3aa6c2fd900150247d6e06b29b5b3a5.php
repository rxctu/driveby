<?php $__env->startSection('title', 'Connexion - EpiDrive'); ?>
<?php $__env->startSection('meta_description', 'Connectez-vous a votre compte EpiDrive pour passer commande et suivre vos livraisons.'); ?>

<?php $__env->startSection('content'); ?>

    <div class="min-h-[calc(100vh-4rem)] flex flex-col lg:flex-row">

        
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-500 overflow-hidden">
            
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <span class="absolute text-5xl top-[10%] left-[10%] animate-bounce" style="animation-delay: 0s; animation-duration: 3s;">🥑</span>
                <span class="absolute text-4xl top-[25%] right-[15%] animate-bounce" style="animation-delay: 0.5s; animation-duration: 3.5s;">🍊</span>
                <span class="absolute text-5xl bottom-[30%] left-[20%] animate-bounce" style="animation-delay: 1s; animation-duration: 2.8s;">🥖</span>
                <span class="absolute text-4xl top-[60%] right-[25%] animate-bounce" style="animation-delay: 1.5s; animation-duration: 3.2s;">🍎</span>
                <span class="absolute text-5xl bottom-[15%] left-[50%] animate-bounce" style="animation-delay: 0.8s; animation-duration: 2.5s;">🥕</span>
                <span class="absolute text-4xl top-[15%] left-[60%] animate-bounce" style="animation-delay: 1.2s; animation-duration: 3.8s;">🧀</span>
                <span class="absolute text-5xl bottom-[45%] right-[10%] animate-bounce" style="animation-delay: 0.3s; animation-duration: 2.9s;">🍋</span>
                <span class="absolute text-4xl top-[45%] left-[40%] animate-bounce" style="animation-delay: 1.8s; animation-duration: 3.3s;">🫐</span>
            </div>

            
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-white/5 rounded-full"></div>
            <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-white/5 rounded-full"></div>

            
            <div class="relative z-10 flex flex-col items-center justify-center w-full px-12 text-white">
                <div class="text-center space-y-6" x-data x-init="$el.classList.add('animate-fade-in')">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-4">
                        <span class="text-4xl">🛒</span>
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-extrabold leading-tight">
                        Bienvenue sur<br>
                        <span class="text-amber-400">EpiDrive</span>
                    </h1>
                    <p class="text-lg text-emerald-100 max-w-md leading-relaxed">
                        Votre epicerie de quartier en ligne. Des produits frais et de qualite, livres directement chez vous.
                    </p>
                    <div class="flex items-center justify-center space-x-6 pt-4">
                        <div class="flex items-center space-x-2 text-emerald-100">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">Livraison rapide</span>
                        </div>
                        <div class="flex items-center space-x-2 text-emerald-100">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">Produits frais</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="flex-1 flex flex-col">

            
            <div class="lg:hidden bg-gradient-to-r from-emerald-700 to-teal-500 px-6 py-8 text-white text-center">
                <h1 class="text-2xl font-extrabold">
                    Connexion a <span class="text-amber-400">EpiDrive</span>
                </h1>
                <p class="text-emerald-100 text-sm mt-2">Votre epicerie en ligne, livree chez vous</p>
            </div>

            <div class="flex-1 flex items-center justify-center px-4 sm:px-8 py-8 lg:py-12">
                <div class="w-full max-w-md" x-data="{ showPassword: false }" x-init="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-4'), 50)"
                     class="opacity-0 translate-y-4 transition-all duration-700 ease-out">

                    
                    <div class="hidden lg:block text-center mb-8">
                        <h2 class="text-3xl font-extrabold text-gray-900">Connexion</h2>
                        <p class="text-gray-500 mt-2">Connectez-vous a votre compte EpiDrive</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-6 sm:p-8">

                        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                            <?php echo csrf_field(); ?>

                            
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse e-mail</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                                           placeholder="votre@email.fr"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span><?php echo e($message); ?></span>
                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                           placeholder="Votre mot de passe"
                                           class="w-full pl-11 pr-12 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                        </svg>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span><?php echo e($message); ?></span>
                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer" x-data="{ checked: false }">
                                    <input type="checkbox" name="remember" class="sr-only" x-model="checked">
                                    <div class="relative w-10 h-6 rounded-full transition-colors duration-200"
                                         :class="checked ? 'bg-emerald-600' : 'bg-gray-300'"
                                         @click="checked = !checked">
                                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                                             :class="checked ? 'translate-x-4' : 'translate-x-0'"></div>
                                    </div>
                                    <span class="ml-3 text-sm text-gray-600">Se souvenir de moi</span>
                                </label>
                                <?php if(Route::has('password.request')): ?>
                                    <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium transition">
                                        Mot de passe oublie ?
                                    </a>
                                <?php endif; ?>
                            </div>

                            
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-emerald-700 to-emerald-600 text-white font-bold py-3.5 rounded-xl hover:from-emerald-800 hover:to-emerald-700 transition-all duration-200 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 active:scale-[0.98]">
                                Se connecter
                            </button>
                        </form>

                        
                        <div class="my-6 flex items-center">
                            <div class="flex-1 border-t border-gray-200"></div>
                            <span class="px-4 text-sm text-gray-400 font-medium">ou</span>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>

                        
                        <a href="<?php echo e(route('auth.google')); ?>"
                           class="flex items-center justify-center w-full bg-white border-2 border-gray-200 rounded-xl py-3.5 px-4 hover:border-gray-300 hover:shadow-md transition-all duration-200 group active:scale-[0.98]">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">Se connecter avec Google</span>
                        </a>
                    </div>

                    <p class="text-center text-sm text-gray-500 mt-6">
                        Pas encore de compte ?
                        <a href="<?php echo e(route('register')); ?>" class="text-emerald-600 hover:text-emerald-700 font-bold transition">Creer un compte</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(1rem); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/auth/login.blade.php ENDPATH**/ ?>