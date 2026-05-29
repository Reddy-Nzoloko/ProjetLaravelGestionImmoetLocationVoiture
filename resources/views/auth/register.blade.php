<x-auth-layout>
    <div class="relative overflow-hidden rounded-3xl shadow-2xl ring-1 ring-black/10 bg-white max-w-5xl mx-auto w-full">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/20 via-indigo-400/15 to-violet-500/10 pointer-events-none"></div>
        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 p-8 md:p-12">
            <!-- Colonne gauche : Message accrocheur -->
            <div class="flex flex-col justify-center rounded-3xl bg-slate-900/95 p-8 text-white shadow-xl overflow-hidden">
                <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-indigo-500/30 blur-2xl animate-pulse"></div>
                <div class="absolute -left-16 bottom-0 h-56 w-56 rounded-full bg-cyan-400/20 blur-3xl"></div>
                <div class="relative z-10 space-y-6">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight">Créer un compte</h1>
                        <p class="mt-3 text-sm leading-6 text-slate-200/90">Rejoignez notre plateforme et commencez à gérer vos entreprises, vos agents et vos offres immobilières ou automobiles.</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-lg shadow-slate-900/5 ring-1 ring-white/10 backdrop-blur-sm">
                        <p class="text-sm text-cyan-200 font-semibold uppercase tracking-[0.24em]">Inscription gratuite</p>
                        <p class="mt-3 text-sm text-slate-300">Créez votre compte en quelques minutes et accédez à toutes les fonctionnalités.</p>
                        <div class="mt-6 grid gap-3 text-sm text-slate-100">
                            <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300"></span> Gestion complète de vos annonces</p>
                            <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300"></span> Interface conviviale et intuitive</p>
                            <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300"></span> Support client réactif 24/7</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Formulaire -->
            <div class="relative rounded-3xl bg-white p-8 shadow-2xl ring-1 ring-slate-200/60 overflow-hidden">
                <div class="mb-6">
                    <h2 class="text-3xl font-semibold text-slate-900">Inscription</h2>
                    <p class="mt-2 text-sm text-slate-500">Remplissez le formulaire pour créer votre compte.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nom complet -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nom complet</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="votre nom complet" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="votre@email.com" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Nom entreprise / Agence -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-slate-700">Nom de votre Entreprise / Agence</label>
                        <input id="company_name" name="company_name" type="text" value="{{ old('company_name') }}" required autocomplete="organization" placeholder="Ma Super Agence" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Secteur d'activité -->
                    <div>
                        <label for="activity_sector" class="block text-sm font-medium text-slate-700">Secteur d'activité</label>
                        <select name="activity_sector" id="activity_sector" required class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60">
                            <option value="">-- Sélectionnez un secteur --</option>
                            <option value="auto" {{ old('activity_sector') === 'auto' ? 'selected' : '' }}>Vente et Location de Véhicules</option>
                            <option value="immo" {{ old('activity_sector') === 'immo' ? 'selected' : '' }}>Agence Immobilière</option>
                            <option value="vetement" {{ old('activity_sector') === 'vetement' ? 'selected' : '' }}>Vente de Vêtements</option>
                        </select>
                        <x-input-error :messages="$errors->get('activity_sector')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Numéro WhatsApp -->
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-slate-700">Numéro WhatsApp</label>
                        <input id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number') }}" required autocomplete="tel" placeholder="243 99 123 4567" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('whatsapp_number')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Créez un mot de passe sécurisé" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmer le mot de passe</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirmez votre mot de passe" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Bouton d'inscription -->
                    <button type="submit" class="w-full rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white transition transform duration-300 hover:scale-[1.02] shadow-lg focus:outline-none focus:ring-4 focus:ring-indigo-500/30">Créer mon compte</button>
                </form>

                <!-- Lien vers connexion -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-600">Vous avez déjà un compte ? 
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 transition hover:text-indigo-700">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
