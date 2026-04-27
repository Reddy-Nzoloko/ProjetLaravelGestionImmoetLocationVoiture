<x-modal name="create-listing" focusable>
    @php
        // On récupère le secteur de l'entreprise de l'utilisateur connecté
        $sector = auth()->user()->company->activity_sector; 
    @endphp

    <form method="post" action="{{ route('listings.store') }}" enctype="multipart/form-data" class="p-6" 
          x-data="{ category: '{{ $sector }}' }">
        @csrf

        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center">
                <svg class="w-5 h-5 me-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Nouvelle Annonce') }} 
                <span class="ms-2 text-sm font-normal text-gray-500">
                    ({{ $sector === 'auto' ? 'Secteur Automobile' : 'Secteur Immobilier' }})
                </span>
            </h2>
        </header>

        <input type="hidden" name="category" value="{{ $sector }}">

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1">
                <x-input-label for="title" value="Titre de l'annonce" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                    placeholder="{{ $sector === 'auto' ? 'Ex: Toyota RAV4...' : 'Ex: Villa 5 chambres...' }}" required />
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
            
            <div x-show="category === 'auto'">
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

            <div x-show="category === 'immo'">
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
    <x-input-label for="images" value="Photos de l'annonce (Max 5)" />
    <input type="file" name="images[]" id="images" multiple 
        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:bg-gray-900"
        accept="image/*">
    <p class="mt-1 text-xs text-gray-500 italic">Vous pouvez sélectionner plusieurs photos à la fois.</p>
</div>

        <div class="mt-4">
            <x-input-label for="description" value="Description détaillée" />
            <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 transition-colors">
                Annuler
            </button>

            <x-primary-button>
                Publier l'annonce
            </x-primary-button>
        </div>
    </form>
</x-modal>