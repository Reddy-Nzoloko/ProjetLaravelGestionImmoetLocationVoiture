<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Compte bloqué</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Votre entreprise est actuellement bloquée. Vous ne pouvez pas accéder à votre dashboard tant qu'elle n'est pas réactivée.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-3xl border border-red-100 dark:border-red-700 p-8">
                <div class="flex flex-col items-center text-center gap-6">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <div class="space-y-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Votre entreprise est bloquée</h1>
                        <p class="text-gray-600 dark:text-gray-300">Veuillez réactiver votre compte auprès du super admin pour retrouver l'accès à votre tableau de bord.</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Utilisez le bouton ci-dessous pour contacter le super admin sans afficher directement son adresse.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                        <a href="{{ $supportMailto }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-4 text-white font-semibold hover:bg-indigo-700 transition">
                            Contacter le super admin
                        </a>

                        @if ($supportWhatsappUrl)
                            <a href="{{ $supportWhatsappUrl }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-2xl bg-green-600 px-6 py-4 text-white font-semibold hover:bg-green-700 transition">
                                Contacter sur WhatsApp
                            </a>
                        @else
                            <div class="rounded-2xl bg-gray-100 dark:bg-gray-900 px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                WhatsApp non disponible pour le super admin.
                            </div>
                        @endif
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">Si vous pensez qu'il s'agit d'une erreur, envoyez une demande au super admin pour réactiver votre entreprise.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
