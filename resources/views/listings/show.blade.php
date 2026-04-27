<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $listing->title }}
            </h2>
            <a href="{{ route('acceuil') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 transition">
                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour au catalogue
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                    
                    <div>
                        <div class="rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-900 mb-4 h-[450px] shadow-inner">
                            @if(!empty($listing->images) && count($listing->images) > 0)
                                <img src="{{ asset('storage/' . $listing->images[0]) }}" 
                                     class="w-full h-full object-cover transition-opacity duration-300" 
                                     id="mainImage">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-4 gap-3">
                            @if(!empty($listing->images))
                                @foreach($listing->images as $image)
                                    <div class="h-20 rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-indigo-500 transition shadow-sm">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             class="w-full h-full object-cover"
                                             onclick="changeImage(this.src)">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest {{ $listing->category === 'auto' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $listing->category === 'auto' ? 'Véhicule' : 'Immobilier' }}
                                </span>
                                <div class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                                    <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 p-1 rounded-md me-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                    </span>
                                    Publié par : <span class="font-bold text-gray-900 dark:text-gray-100 ms-1 italic underline">
                                        {{ $listing->company?->name ?? 'Partenaire Immo Auto Plus' }}
                                    </span>
                                </div>
                            </div>

                            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-4">{{ $listing->title }}</h1>
                            
                            <div class="mt-4 flex items-baseline">
                                <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">
                                    {{ number_format($listing->price, 0, '.', ' ') }} $
                                </span>
                                <span class="ms-2 text-sm text-gray-500 uppercase font-bold tracking-tighter">
                                    / {{ $listing->offer_type }}
                                </span>
                            </div>

                            <div class="mt-8 space-y-6">
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg me-3 text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    </div>
                                    <span class="font-medium">{{ $listing->location }}</span>
                                </div>

                                <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                                    <h4 class="text-xs font-bold uppercase text-gray-400 tracking-widest mb-3">Description du bien</h4>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed italic">
                                        {{ $listing->description ?? 'Aucune description fournie.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @php
                            // Récupération sécurisée des données de l'entreprise
                            $company = $listing->company;
                            $companyName = $company?->name ?? 'le vendeur';
                            $phone = $company?->whatsapp_numero ?? '243000000000'; // Numéro par défaut (ex: ton support)
                            
                            // Nettoyage du numéro
                            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                            
                            // Message personnalisé
                            $text = "Bonjour " . $companyName . ", je suis intéressé par l'annonce : " . $listing->title . " (" . number_format($listing->price, 0, '.', ' ') . "$). Est-elle toujours disponible ?";
                            $whatsappUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($text);
                        @endphp

                        <div class="mt-10">
                            <a href="{{ $whatsappUrl }}" target="_blank" 
                               class="w-full inline-flex justify-center items-center px-8 py-5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl transition-all shadow-xl hover:shadow-green-500/20 active:scale-[0.98] group">
                                <svg class="w-7 h-7 me-3 transition-transform group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Contacter l'entreprise sur WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeImage(src) {
            const mainImg = document.getElementById('mainImage');
            mainImg.style.opacity = '0.3';
            setTimeout(() => {
                mainImg.src = src;
                mainImg.style.opacity = '1';
            }, 150);
        }
    </script>
</x-app-layout>