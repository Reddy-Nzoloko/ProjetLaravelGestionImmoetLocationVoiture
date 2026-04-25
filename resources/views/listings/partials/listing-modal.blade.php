<x-modal name="create-listing" focusable>
    <form method="post" action="{{ route('listings.store') }}" class="p-6" x-data="{ category: 'auto' }">
        @csrf

        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                <svg class="w-5 h-5 me-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Nouvelle Annonce') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Remplissez les détails ci-dessous pour publier votre offre sur la plateforme.') }}
            </p>
        </header>

        <div class="mt-6 flex gap-4">
            <label class="flex-1 cursor-pointer group">
                <input type="radio" name="category" value="auto" x-model="category" class="hidden peer">
                <div class="flex flex-col items-center justify-center p-4 border-2 rounded-xl transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 dark:border-gray-700 hover:border-gray-400">
                    <svg class="w-8 h-8 mb-2 text-gray-500 group-hover:text-indigo-500 peer-checked:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <span class="text-sm font-semibold uppercase tracking-wider">{{ __('Véhicule') }}</span>
                </div>
            </label>

            <label class="flex-1 cursor-pointer group">
                <input type="radio" name="category" value="immo" x-model="category" class="hidden peer">
                <div class="flex flex-col items-center justify-center p-4 border-2 rounded-xl transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 dark:border-gray-700 hover:border-gray-400">
                    <svg class="w-8 h-8 mb-2 text-gray-500 group-hover:text-indigo-500 peer-checked:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-sm font-semibold uppercase tracking-wider">{{ __('Immobilier') }}</span>
                </div>
            </label>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1">
                <x-input-label for="title" value="Titre de l'annonce" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Ex: Toyota RAV4 ou Villa à Goma" required />
            </div>
            <div class="col-span-1">
                <x-input-label for="price" value="Prix demandé ($)" />
                <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" placeholder="0.00" required />
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="offer_type" value="Type d'offre" />
                <select name="offer_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="vente">À Vendre</option>
                    <option value="location">À Louer</option>
                </select>
            </div>
            <div>
                <x-input-label for="location" value="Quartier / Emplacement" />
                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" placeholder="Ex: Kyeshero, Himbi..." />
            </div>
        </div>

        <div class="mt-6 p-5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl">
            <div x-show="category === 'auto'" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label value="Marque" />
                        <x-text-input name="brand" type="text" class="mt-1 block w-full" placeholder="Ex: Toyota" />
                    </div>
                    <div>
                        <x-input-label value="Transmission" />
                        <select name="transmission" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            <option value="automatique">Automatique</option>
                            <option value="manuelle">Manuelle</option>
                        </select>
                    </div>
                </div>
            </div>

            <div x-show="category === 'immo'" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label value="Nombre de chambres" />
                        <x-text-input name="rooms" type="number" class="mt-1 block w-full" placeholder="Ex: 3" />
                    </div>
                    <div>
                        <x-input-label value="Type de propriété" />
                        <select name="property_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md">
                            <option value="maison">Maison</option>
                            <option value="appartement">Appartement</option>
                            <option value="terrain">Terrain</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="description" value="Description détaillée" />
            <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Décrivez les points forts de votre offre..."></textarea>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Annuler') }}
            </button>

            <x-primary-button>
                {{ __('Publier l\'annonce') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>