<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Tableau de bord Administrateur') }}
                </h2>
                <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <span class="inline-block w-2 h-2 rounded-full bg-indigo-500 me-2"></span>
                    Secteur : <span class="font-medium ms-1 uppercase">{{ auth()->user()->company->activity_sector ?? 'Non défini' }}</span>
                </div>
            </div>
            
            <button 
                x-data="" 
                x-on:click.prevent="$dispatch('open-modal', 'create-listing')"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Publier une annonce
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 mb-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg me-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Bienvenue sur Immo Auto Plus</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Gérez vos publications immobilières et automobiles en toute simplicité.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-400 uppercase tracking-wider">Mes publications récentes</h3>
                <div class="flex-grow ms-4 h-px bg-gray-200 dark:bg-gray-700"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($listings as $listing)
                    <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="relative h-52 bg-gray-200 dark:bg-gray-900">
                            @if($listing->images && count($listing->images) > 0)
                                <img src="{{ asset('storage/' . $listing->images[0]) }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-indigo-600 text-white px-3 py-1 rounded-lg font-bold shadow-lg text-sm">
                                    {{ number_format($listing->price, 0, '.', ' ') }} $
                                </span>
                            </div>

                            <div class="absolute top-4 right-4">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded-md {{ $listing->category === 'auto' ? 'bg-blue-500 text-white' : 'bg-emerald-500 text-white' }}">
                                    {{ $listing->category === 'auto' ? 'Véhicule' : 'Immobilier' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-900 dark:text-white truncate flex-1">{{ $listing->title }}</h4>
                            </div>

                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center mb-4">
                                <svg class="w-4 h-4 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $listing->location ?? 'DRC' }}
                            </p>

                            <div class="flex items-center gap-4 py-3 border-t border-gray-50 dark:border-gray-700 mb-4">
                                @if($listing->category === 'auto')
                                    <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                                        {{ $listing->features['brand'] ?? 'Auto' }}
                                    </div>
                                @else
                                    <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 0V4h5"></path></svg>
                                        {{ $listing->features['property_type'] ?? 'Immo' }}
                                    </div>
                                @endif
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400 uppercase">
                                    <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $listing->offer_type }}
                                </div>
                            </div>

                            <!-- Nombre de vues dans la dashboard -->
                             <div class="mt-2 flex items-center text-gray-500 text-xs font-semibold">
    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
    <span>{{ $listing->views_count }} vues</span>
</div>

                            <div class="flex justify-between items-center gap-2">
                                <button 
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'edit-listing-{{ $listing->id }}')"
    class="flex-grow inline-flex justify-center items-center px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
    Modifier
</button>
                                
                                <form method="POST" action="{{ route('listings.destroy', $listing) }}" onsubmit="return confirm('Supprimer cette publication ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modale pour la modification -->
                  <x-modal name="edit-listing-{{ $listing->id }}" focusable>
    <form method="post" action="{{ route('listings.update', $listing->id) }}" class="p-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
            Modifier : {{ $listing->title }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-2">
                <x-input-label value="Titre de l'annonce" />
                <x-text-input name="title" type="text" class="mt-1 block w-full" value="{{ $listing->title }}" required />
            </div>

            <div class="col-span-2">
                <x-input-label value="Description détaillée" />
                <textarea name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ $listing->description }}</textarea>
            </div>

            <div>
                <x-input-label value="Prix ($)" />
                <x-text-input name="price" type="number" class="mt-1 block w-full" value="{{ $listing->price }}" required />
            </div>

            <div>
                <x-input-label value="Adresse / Quartier" />
                <x-text-input name="location" type="text" class="mt-1 block w-full" value="{{ $listing->location }}" />
            </div>

            <div>
                <x-input-label value="Catégorie" />
                <select name="category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="immo" {{ $listing->category == 'immo' ? 'selected' : '' }}>Immobilier</option>
                    <option value="auto" {{ $listing->category == 'auto' ? 'selected' : '' }}>Véhicule</option>
                </select>
            </div>

            <div>
                <x-input-label value="Type d'offre" />
                <select name="offer_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="vente" {{ $listing->offer_type == 'vente' ? 'selected' : '' }}>Vente</option>
                    <option value="location" {{ $listing->offer_type == 'location' ? 'selected' : '' }}>Location</option>
                </select>
            </div>

            <div class="col-span-2">
                <x-input-label value="Remplacer les photos (laisser vide pour garder les anciennes)" />
                <input type="file" name="images[]" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">Annuler</x-secondary-button>
            <x-primary-button>Mettre à jour l'annonce</x-primary-button>
        </div>
    </form>
</x-modal>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-100 dark:border-gray-700">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Aucune publication trouvée dans votre catalogue.</p>
                        <button x-on:click.prevent="$dispatch('open-modal', 'create-listing')" class="mt-4 text-indigo-600 font-bold hover:underline text-sm uppercase tracking-tight">Commencer à vendre</button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @include('listings.partials.listing-modal')
</x-app-layout>