<aside class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-900">Menu SuperAdmin</h2>
        <p class="mt-2 text-sm text-gray-600">Naviguez rapidement entre les outils de supervision.</p>
    </div>

    <nav class="space-y-2">
        <x-responsive-nav-link :href="route('admin.companies')" :active="request()->routeIs('admin.companies')">
            {{ __('Entreprises') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('admin.superadmins')" :active="request()->routeIs('admin.superadmins')">
            {{ __('SuperAdmins') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('admin.statistics')" :active="request()->routeIs('admin.statistics')">
            {{ __('Statistiques') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
            {{ __('Rapports') }}
        </x-responsive-nav-link>
    </nav>

    <div class="mt-10 pt-6 border-t border-gray-200">
        <h3 class="text-sm font-semibold text-gray-900">Mon compte</h3>
        <p class="mt-2 text-sm text-gray-600">Gérez vos identifiants et votre mot de passe.</p>
        <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
            {{ __('Mes identifiants') }}
        </a>
    </div>
</aside>
