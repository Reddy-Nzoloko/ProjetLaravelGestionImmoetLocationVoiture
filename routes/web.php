<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController; // Regroupement des imports
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BadgeRequestController;
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

    // Badge Requests
    Route::get('/badge-requests/create', [BadgeRequestController::class, 'create'])->name('badge-requests.create');
    Route::post('/badge-requests', [BadgeRequestController::class, 'store'])->name('badge-requests.store');
    
});
// Route pour afficher une annonce spécifique (optionnel)
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
    // route pour acceder aux prix
    Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// Route pour la connexion du super admin
// --- ZONE SUPER ADMIN ---
// On utilise le middleware 'role:superadmin' pour verrouiller l'accès
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    // Page de gestion des entreprises
    Route::get('/admin/companies', [AdminController::class, 'index'])->name('admin.companies');
    Route::post('/admin/companies/{company}/update-rank', [AdminController::class, 'updateRank'])->name('admin.updateRank');
    Route::delete('/admin/companies/{company}', [AdminController::class, 'destroy'])->name('admin.companies.destroy');
    Route::patch('/admin/companies/{company}/toggle-active', [AdminController::class, 'toggleActive'])->name('admin.companies.toggleActive');

    // Superadmin list and profile access
    Route::get('/admin/superadmins', [AdminController::class, 'superadmins'])->name('admin.superadmins');

    // Statistiques et rapports
    Route::get('/admin/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

    // Badge Requests
    Route::get('/admin/badge-requests', [BadgeRequestController::class, 'index'])->name('admin.badge-requests');
    Route::patch('/admin/badge-requests/{badgeRequest}/approve', [BadgeRequestController::class, 'approve'])->name('admin.badge-requests.approve');
    Route::patch('/admin/badge-requests/{badgeRequest}/reject', [BadgeRequestController::class, 'reject'])->name('admin.badge-requests.reject');
});
require __DIR__.'/auth.php';