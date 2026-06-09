<x-auth-layout>
    <div class="relative overflow-hidden rounded-3xl shadow-2xl ring-1 ring-black/10 bg-white max-w-4xl mx-auto">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/20 via-indigo-400/15 to-violet-500/10 pointer-events-none"></div>
        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 p-8 md:p-12">
            <div class="flex flex-col justify-center rounded-3xl bg-slate-900/95 p-8 text-white shadow-xl overflow-hidden">
                <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-indigo-500/30 blur-2xl animate-pulse"></div>
                <div class="absolute -left-16 bottom-0 h-56 w-56 rounded-full bg-cyan-400/20 blur-3xl"></div>
                <div class="relative z-10 space-y-6">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight">Bienvenue</h1>
                        <p class="mt-3 text-sm leading-6 text-slate-200/90">Connectez-vous pour accéder à votre tableau de bord et gérer vos entreprises, vos agents et vos offres.</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-lg shadow-slate-900/5 ring-1 ring-white/10 backdrop-blur-sm">
                        <p class="text-sm text-cyan-200 font-semibold uppercase tracking-[0.24em]">Connexion sécurisée</p>
                        <p class="mt-3 text-sm text-slate-300">Utilisez votre adresse email et votre mot de passe pour vous connecter.</p>
                        <div class="mt-6 grid gap-3 text-sm text-slate-100">
                            <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300"></span> Interface moderne et intuitive</p>
                            <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300"></span> Notification si votre compte est bloqué</p>
                            <p class="flex items-center gap-2"><span class="inline-flex h-2.5 w-2.5 rounded-full bg-cyan-300"></span> Support superadmin disponible</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative rounded-3xl bg-white p-8 shadow-2xl ring-1 ring-slate-200/60 overflow-hidden">
                <div class="mb-6">
                    <h2 class="text-3xl font-semibold text-slate-900">Connexion</h2>
                    <p class="mt-2 text-sm text-slate-500">Entrez vos identifiants pour continuer.</p>
                </div>

                <x-auth-session-status class="mb-4 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 text-sm text-emerald-700" :status="session('status')" />

                @if ($errors->has('email') && strpos($errors->first('email'), 'bloquée') !== false)
                    <div class="mb-6 rounded-3xl bg-red-50 border-l-4 border-red-500 p-5 shadow-md">
                        <div class="flex items-start gap-4">
                            <svg class="h-6 w-6 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-semibold text-red-800 mb-2">Accès refusé</h3>
                                <p class="text-red-700 text-sm mb-3">{{ $errors->first('email') }}</p>
                                @if (session('support_mailto'))
                                    <a href="{{ session('support_mailto') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700 transition">
                                        Contacter le superadmin
                                    </a>
                                @endif
                                <p class="text-xs text-red-600">Un email de notification a été envoyé à l'administrateur.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="votre@email.com" class="mt-3 block w-full h-14 rounded-3xl border bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-4 focus:ring-red-100/60' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60' }}" />
                        @if (!($errors->has('email') && strpos($errors->first('email'), 'bloquée') !== false))
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Entrez votre mot de passe" class="mt-3 block w-full h-14 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-slate-900 outline-none transition duration-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                            Se souvenir de moi
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 transition hover:text-indigo-700">Mot de passe oublié ?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white transition transform duration-300 hover:scale-[1.02] shadow-lg focus:outline-none focus:ring-4 focus:ring-indigo-500/30">Se connecter</button>
                </form>

                <div class="mt-8 rounded-3xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
                    <p class="font-medium text-slate-800">Besoin d’aide ?</p>
                    <p class="mt-2">Si votre entreprise est bloquée, vous recevrez un message avec l’email du superadmin.</p>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
