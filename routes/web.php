<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController; // Regroupement des imports
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     $listings = \App\Models\Listing::latest()->take(12)->get(); // On prend les 6 dernières annonces
//     return view('welcome', compact('listings'));
// })->name('acceuil');
// Supprime l'ancienne route '/' et mets celle-ci à la place :
Route::get('/', [ListingController::class, 'welcome'])->name('acceuil');

// MODIFICATION ICI : On passe par le Controller pour le Dashboard
Route::get('/dashboard', [ListingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Listings (Annonces)
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
    // Route de modification de l'annonce
    Route::patch('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
});
// Route pour afficher une annonce spécifique (optionnel)
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
    // Si tu utilises le ListingController pour la page d'accueil
require __DIR__.'/auth.php';