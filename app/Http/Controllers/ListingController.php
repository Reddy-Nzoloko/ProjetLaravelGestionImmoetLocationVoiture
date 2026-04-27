<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{
    // methode store pour enregistrer une nouvelle annonce
    // Pour l'enregistrement
public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required',
        'price' => 'required|numeric',
        'offer_type' => 'required', // Vente ou Location
        'category' => 'required',
        'images.*' => 'image|max:2048'
    ]);

    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imagePaths[] = $file->store('listings', 'public');
        }
    }

   Listing::create([
    'user_id' => auth()->id(),
    'company_id' => auth()->user()->company_id,
    'title' => $request->title,
    'description' => $request->description ?? 'Aucune description fournie', // Ajoute cette ligne
    'price' => $request->price,
    'offer_type' => $request->offer_type,
    'category' => $request->category,
    'images' => $imagePaths,
    'location' => $request->location ?? 'Goma',
    'status' => 'disponible',
]);

    return back()->with('success', 'Annonce publiée !');
}

// Pour la suppression
public function destroy(Listing $listing)
{
    // Sécurité : Seul le proprio peut supprimer
    if ($listing->user_id !== auth()->id()) {
        abort(403);
    }

    $listing->delete();
    return back()->with('success', 'Annonce supprimée.');
}

// fonction index pour afficher les annonces de l'entreprise de l'utilisateur connecté
// index
public function index()
{
    // On récupère uniquement les annonces liées à l'entreprise de l'utilisateur
    $listings = \App\Models\Listing::where('company_id', auth()->user()->company_id)
        ->latest() 
        ->get();

    return view('dashboard', compact('listings'));
}
}
