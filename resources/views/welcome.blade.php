<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Immo Auto Plus | Trouvez votre bonheur</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-900">

        <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center">
                        <span class="text-2xl font-extrabold text-indigo-600 tracking-tighter">IMMO AUTO PLUS</span>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-bold text-gray-700 hover:text-indigo-600 transition">Mon Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-bold text-gray-700 hover:text-indigo-600 transition">Connexion</a>
                                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                    Créer mon entreprise
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <header class="relative py-16 overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-[1.1] mb-6">
                    Trouvez une voiture ou une maison à RDC
                </h1>
                
                <div class="max-w-2xl mx-auto mt-10">
                    <form action="{{ route('acceuil') }}" method="GET" id="searchForm" class="relative group">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Une Mercedes ? Un appartement à Goma ?" 
                               class="w-full px-8 py-6 bg-gray-100 border-none rounded-2xl text-lg focus:ring-4 focus:ring-indigo-100 transition-all outline-none"
                               onkeypress="if(event.key === 'Enter') this.form.submit();">
                        
                        <button type="submit" class="absolute right-3 top-3 bottom-3 px-6 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-md">
                            Rechercher
                        </button>
                    </form>
                    <p class="mt-4 text-sm text-gray-400 font-medium italic">Appuyez sur Entrée pour lancer la recherche</p>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">
                        {{ request('search') ? 'Résultats pour "' . request('search') . '"' : 'Dernières pépites' }}
                    </h2>
                    <p class="text-gray-500 mt-2">Les meilleures offres sélectionnées pour vous.</p>
                </div>
            </div>

            @if($listings->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                    <p class="text-gray-500 text-lg">Désolé, aucune annonce ne correspond à votre recherche pour le moment.</p>
                    <a href="{{ route('acceuil') }}" class="text-indigo-600 font-bold mt-4 inline-block underline">Voir toutes les annonces</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($listings as $listing)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ (!empty($listing->images) && isset($listing->images[0])) ? asset('storage/' . $listing->images[0]) : asset('images/default-placeholder.png') }}" 
                                 alt="{{ $listing->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur text-[10px] font-bold uppercase rounded-lg shadow-sm">
                                    {{ $listing->offer_type }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $listing->title }}</h3>
                            
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-indigo-600 font-bold text-xl">{{ number_format($listing->price, 0, '.', ' ') }} $</span>
                                <span class="text-gray-400 text-[10px] flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    {{ $listing->views_count }} vues
                                </span>
                            </div>

                            <p class="text-gray-500 text-sm flex items-center mt-3 mb-6">
                                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $listing->location }}
                            </p>
                            
                            <a href="{{ route('listings.show', $listing->id) }}" class="w-full inline-flex justify-center items-center py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-indigo-600 transition shadow-lg">
                                Voir l'annonce
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if(!request('search'))
                <div class="mt-16 text-center">
                    <a href="{{ route('acceuil', ['all' => 1]) }}" class="inline-flex items-center px-10 py-5 bg-white border-2 border-gray-100 text-gray-900 font-bold rounded-2xl hover:border-indigo-600 hover:text-indigo-600 transition shadow-sm">
    Voir toutes les annonces disponibles
    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
</a>
                </div>
                @endif
            @endif
        </main>

        <footer class="bg-white border-t border-gray-100 py-12 mt-20 text-center">
            <p class="text-gray-400 text-sm">© RedDev 2026 Immo Auto Plus. Tous droits réservés.</p>
        </footer>

    </body>
</html>