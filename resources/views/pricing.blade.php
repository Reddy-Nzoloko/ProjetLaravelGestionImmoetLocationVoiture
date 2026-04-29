@extends('layouts.app') @section('content')
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Boostez votre visibilité</h1>
        <p class="text-gray-600 mb-16 text-lg">Choisissez le forfait qui correspond à vos ambitions à Goma.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm">
                <h3 class="text-xl font-bold mb-4">Gratuit</h3>
                <div class="text-4xl font-black mb-6">0$ <span class="text-sm text-gray-400">/mois</span></div>
                <ul class="text-left space-y-4 mb-8 text-gray-600">
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Jusqu'à 5 annonces</li>
                    <li class="flex items-center text-gray-400"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Pas de badge vérifié</li>
                </ul>
            </div>

            <div class="bg-white p-8 rounded-3xl border-2 border-indigo-600 shadow-xl relative scale-105">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white px-4 py-1 rounded-full text-sm font-bold">RECOMMANDÉ</span>
                <h3 class="text-xl font-bold mb-4 text-indigo-600">Pro</h3>
                <div class="text-4xl font-black mb-6">20$ <span class="text-sm text-gray-400">/mois</span></div>
                <ul class="text-left space-y-4 mb-8">
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Annonces illimitées</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <b>Badge bleu vérifié</b></li>
                    <li class="flex items-center font-bold text-indigo-600"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Priorité sur les gratuits</li>
                </ul>
                <a href="https://wa.me/243xxxxxxxxx" class="block w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl">Activer par WhatsApp</a>
            </div>

            <div class="bg-gray-900 p-8 rounded-3xl text-white shadow-sm">
                <h3 class="text-xl font-bold mb-4">Elite</h3>
                <div class="text-4xl font-black mb-6">50$ <span class="text-sm text-gray-400">/mois</span></div>
                <ul class="text-left space-y-4 mb-8">
                    <li class="flex items-center"><svg class="w-5 h-5 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Support prioritaire 24/7</li>
                    <li class="flex items-center font-bold text-indigo-400"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Toujours en tête de liste</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection