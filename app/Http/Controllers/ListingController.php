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
    // 1. On vérifie si l'utilisateur est bien lié à une entreprise
    if (!auth()->user()->company_id) {
        return back()->withErrors(['error' => 'Vous devez créer ou rejoindre une entreprise avant de publier.']);
    }

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'offer_type' => 'required', 
        'category' => 'required',
        'description' => 'nullable|string',
        'location' => 'nullable|string',
        // On accepte explicitement les formats les plus courants
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
    ]);

    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imagePaths[] = $file->store('listings', 'public');
        }
    }

    Listing::create([
        'user_id' => auth()->id(),
        'company_id' => auth()->user()->company_id, // L'ID de l'entreprise
        'title' => $request->title,
        'description' => $request->description ?? 'Aucune description fournie',
        'price' => $request->price,
        'offer_type' => $request->offer_type,
        'category' => $request->category,
        'images' => $imagePaths,
        'location' => $request->location ?? 'Goma',
        'status' => 'disponible',
    ]);

    return redirect()->route('dashboard')->with('success', 'Annonce publiée avec succès !');
}
// methode pour la mise à jour d'une annonce
public function update(Request $request, Listing $listing)
{
    // Sécurité : Seul le propriétaire peut modifier
    if ($listing->user_id !== auth()->id()) { abort(403); }

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'location' => 'required|string',
        'offer_type' => 'required',
        'category' => 'required',
    ]);

    // Gestion des nouvelles images (optionnel)
    if ($request->hasFile('images')) {
        $imagePaths = [];
        foreach ($request->file('images') as $file) {
            $imagePaths[] = $file->store('listings', 'public');
        }
        $data['images'] = $imagePaths;
    }

    $listing->update($data);

    return back()->with('success', 'Annonce mise à jour avec succès !');
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

// Affichage d'une annonce spécifique (optionnel)
// Affichage d'une annonce spécifique
public function show(Listing $listing)
{
    // 1. D'ABORD : On augmente la vue en base de données
    // On utilise increment() qui est plus rapide et propre
    $listing->timestamps = false; // Empêche de modifier la date 'updated_at'
    $listing->increment('views_count');

    // 2. ENSUITE : On charge l'entreprise liée
    $listing->load('company'); 
    
    // 3. ENFIN : On retourne la vue (le return doit TOUJOURS être à la fin)
    return view('listings.show', compact('listing'));
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

// Fonction pour toutes les annonces optiponelle et recherche d'une annonce
public function welcome(Request $request)
{
    $query = Listing::query();

    // Logique de recherche
    if ($request->filled('search')) {
        $search = $request->get('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Gestion de l'affichage
    if ($request->filled('search') || $request->has('all')) {
        // Si recherche ou clic sur "Voir tout", on prend tout sans limite
        $listings = $query->latest()->get();
    } else {
        // Par défaut sur l'accueil, on limite à 12
        $listings = $query->latest()->take(12)->get();
    }

    return view('welcome', compact('listings'));
}
}
