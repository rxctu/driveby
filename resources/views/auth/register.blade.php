@extends('layouts.app')

@section('title', 'Inscription - EpiDrive')
@section('meta_description', 'Creez votre compte EpiDrive et commencez a faire vos courses en ligne avec livraison a domicile.')

@section('content')

    <div class="min-h-[calc(100vh-4rem)] flex flex-col lg:flex-row">

        {{-- Left Panel: Branding (hidden on mobile, visible on lg+) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-500 overflow-hidden">
            {{-- Floating food icons --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <span class="absolute text-5xl top-[8%] left-[15%] animate-bounce" style="animation-delay: 0.2s; animation-duration: 3s;">🥬</span>
                <span class="absolute text-4xl top-[20%] right-[20%] animate-bounce" style="animation-delay: 0.7s; animation-duration: 3.5s;">🍓</span>
                <span class="absolute text-5xl bottom-[35%] left-[25%] animate-bounce" style="animation-delay: 1.1s; animation-duration: 2.8s;">🥐</span>
                <span class="absolute text-4xl top-[55%] right-[15%] animate-bounce" style="animation-delay: 1.4s; animation-duration: 3.2s;">🍇</span>
                <span class="absolute text-5xl bottom-[12%] left-[45%] animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">🧃</span>
                <span class="absolute text-4xl top-[12%] left-[55%] animate-bounce" style="animation-delay: 1.0s; animation-duration: 3.8s;">🥝</span>
                <span class="absolute text-5xl bottom-[50%] right-[8%] animate-bounce" style="animation-delay: 0.9s; animation-duration: 2.9s;">🍅</span>
                <span class="absolute text-4xl top-[40%] left-[8%] animate-bounce" style="animation-delay: 1.6s; animation-duration: 3.3s;">🫒</span>
            </div>

            {{-- Decorative circles --}}
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-white/5 rounded-full"></div>
            <div class="absolute top-1/3 left-1/3 w-48 h-48 bg-white/5 rounded-full"></div>

            {{-- Content --}}
            <div class="relative z-10 flex flex-col items-center justify-center w-full px-12 text-white">
                <div class="text-center space-y-6" x-data x-init="$el.classList.add('animate-fade-in')">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-4">
                        <span class="text-4xl">🛍️</span>
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-extrabold leading-tight">
                        Rejoignez<br>
                        <span class="text-amber-400">EpiDrive</span>
                    </h1>
                    <p class="text-lg text-emerald-100 max-w-md leading-relaxed">
                        Creez votre compte en quelques secondes et profitez de produits frais livres a votre porte.
                    </p>
                    <div class="flex flex-col items-center space-y-3 pt-4">
                        <div class="flex items-center space-x-2 text-emerald-100">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">Inscription gratuite et rapide</span>
                        </div>
                        <div class="flex items-center space-x-2 text-emerald-100">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">Suivi de commandes en temps reel</span>
                        </div>
                        <div class="flex items-center space-x-2 text-emerald-100">
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">Livraison a domicile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel: Register Form --}}
        <div class="flex-1 flex flex-col">

            {{-- Mobile gradient header --}}
            <div class="lg:hidden bg-gradient-to-r from-emerald-700 to-teal-500 px-6 py-8 text-white text-center">
                <h1 class="text-2xl font-extrabold">
                    Rejoignez <span class="text-amber-400">EpiDrive</span>
                </h1>
                <p class="text-emerald-100 text-sm mt-2">Creez votre compte en quelques secondes</p>
            </div>

            <div class="flex-1 flex items-center justify-center px-4 sm:px-8 py-8 lg:py-12">
                <div class="w-full max-w-md" x-data="{
                    showPassword: false,
                    password: '',
                    get strength() {
                        let s = 0;
                        if (this.password.length >= 8) s++;
                        if (/[A-Z]/.test(this.password)) s++;
                        if (/[0-9]/.test(this.password)) s++;
                        if (/[^A-Za-z0-9]/.test(this.password)) s++;
                        return s;
                    },
                    get strengthLabel() {
                        const labels = ['', 'Faible', 'Moyen', 'Bon', 'Excellent'];
                        return labels[this.strength];
                    },
                    get strengthColor() {
                        const colors = ['bg-gray-200', 'bg-red-500', 'bg-amber-500', 'bg-emerald-500', 'bg-emerald-600'];
                        return colors[this.strength];
                    },
                    get strengthTextColor() {
                        const colors = ['text-gray-400', 'text-red-500', 'text-amber-500', 'text-emerald-500', 'text-emerald-600'];
                        return colors[this.strength];
                    }
                }">

                    {{-- Desktop title --}}
                    <div class="hidden lg:block text-center mb-8">
                        <h2 class="text-3xl font-extrabold text-gray-900">Creer un compte</h2>
                        <p class="text-gray-500 mt-2">Rejoignez EpiDrive et simplifiez vos courses</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-6 sm:p-8">

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                           placeholder="Jean Dupont"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                                </div>
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse e-mail</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           placeholder="votre@email.fr"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                                </div>
                                @error('email')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">Telephone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                                        </svg>
                                    </div>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                           placeholder="+33 6 12 34 56 78"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                                </div>
                                @error('phone')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                           placeholder="Minimum 8 caracteres"
                                           x-model="password"
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
                                {{-- Password strength indicator --}}
                                <div x-show="password.length > 0" x-transition class="mt-2">
                                    <div class="flex space-x-1.5 mb-1">
                                        <template x-for="i in 4" :key="i">
                                            <div class="h-1.5 flex-1 rounded-full transition-colors duration-300"
                                                 :class="i <= strength ? strengthColor : 'bg-gray-200'"></div>
                                        </template>
                                    </div>
                                    <p class="text-xs font-medium transition-colors" :class="strengthTextColor" x-text="strengthLabel"></p>
                                </div>
                                @error('password')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmer le mot de passe</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                        </svg>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                           placeholder="Repetez votre mot de passe"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                                </div>
                            </div>

                            {{-- RGPD Consent --}}
                            <div>
                                <label class="flex items-start space-x-3 cursor-pointer">
                                    <input type="checkbox" name="privacy_accepted" value="1" class="mt-0.5 text-emerald-600 focus:ring-emerald-500 rounded" {{ old('privacy_accepted') ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600">
                                        J'accepte la <a href="{{ route('legal.privacy') }}" target="_blank" class="text-emerald-600 underline hover:text-emerald-700">politique de confidentialite</a>
                                        et les <a href="{{ route('legal.cgv') }}" target="_blank" class="text-emerald-600 underline hover:text-emerald-700">conditions generales de vente</a>
                                    </span>
                                </label>
                                @error('privacy_accepted')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-emerald-700 to-emerald-600 text-white font-bold py-3.5 rounded-xl hover:from-emerald-800 hover:to-emerald-700 transition-all duration-200 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 active:scale-[0.98]">
                                Creer mon compte
                            </button>
                        </form>

                        {{-- Divider --}}
                        <div class="my-6 flex items-center">
                            <div class="flex-1 border-t border-gray-200"></div>
                            <span class="px-4 text-sm text-gray-400 font-medium">ou</span>
                            <div class="flex-1 border-t border-gray-200"></div>
                        </div>

                        {{-- Google Register --}}
                        <a href="{{ route('auth.google') }}"
                           class="flex items-center justify-center w-full bg-white border-2 border-gray-200 rounded-xl py-3.5 px-4 hover:border-gray-300 hover:shadow-md transition-all duration-200 group active:scale-[0.98]">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">S'inscrire avec Google</span>
                        </a>
                    </div>

                    <p class="text-center text-sm text-gray-500 mt-6">
                        Deja un compte ?
                        <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-bold transition">Se connecter</a>
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

@endsection
