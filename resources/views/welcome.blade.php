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

        <header class="relative py-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-[1.1] mb-6">
                        La plateforme n°1 à Goma pour l'Immo et l'Auto
                    </h1>
                    <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                        Trouvez la maison de vos rêves ou votre prochain véhicule en quelques clics. Contactez directement les entreprises via WhatsApp.
                    </p>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Dernières pépites</h2>
                    <p class="text-gray-500 mt-2">Les offres les plus récentes sur le marché.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($listings as $listing)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $listing->images[0]) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur text-[10px] font-bold uppercase rounded-lg shadow-sm">
                                {{ $listing->offer_type }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900">{{ $listing->title }}</h3>
                            <span class="text-indigo-600 font-black">{{ number_format($listing->price, 0, '.', ' ') }}$</span>
                        </div>
                        <p class="text-gray-500 text-sm flex items-center mb-6">
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
        </main>

        <footer class="bg-white border-t border-gray-100 py-12 mt-20 text-center">
            <p class="text-gray-400 text-sm">© RedDev 2026 Immo Auto Plus. Tous droits réservés.</p>
        </footer>

    </body>
</html>