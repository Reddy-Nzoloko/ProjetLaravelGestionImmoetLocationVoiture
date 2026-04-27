<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListingController extends Controller
{
    // methode store pour enregistrer une nouvelle annonce
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|in:auto,immo',
        'offer_type' => 'required|in:vente,location',
        'price' => 'required|numeric',
        'description' => 'required',
    ]);

    // On lie l'annonce à l'utilisateur ET à son entreprise
    auth()->user()->company->listings()->create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'category' => $request->category,
        'offer_type' => $request->offer_type,
        'price' => $request->price,
        'description' => $request->description,
        'status' => 'disponible',
    ]);

    return redirect()->route('dashboard')->with('success', 'Annonce publiée avec succès !');
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
