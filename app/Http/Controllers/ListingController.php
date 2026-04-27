<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{
    // methode store pour enregistrer une nouvelle annonce
    public function store(Request $request)
{
    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // On stocke chaque image et on ajoute le chemin au tableau
            $path = $image->store('listings', 'public');
            $imagePaths[] = $path;
        }
    }

    Listing::create([
        'user_id' => auth()->id(),
        'company_id' => auth()->user()->company_id,
        'title' => $request->title,
        'category' => $request->category,
        'price' => $request->price,
        // On enregistre le tableau des chemins en JSON
        'images' => $imagePaths, 
        'features' => [
            'brand' => $request->brand,
            'rooms' => $request->rooms,
            // ...
        ],
        'description' => $request->description,
        'status' => 'disponible',
    ]);

    return back()->with('status', 'Annonce publiée avec succès !');
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
