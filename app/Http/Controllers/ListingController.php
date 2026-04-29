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
    // 1. On augmente les vues de manière sécurisée
    // increment() sauvegarde directement en base de données, pas besoin de désactiver les timestamps manuellement ici
    $listing->increment('views_count');

    // 2. On charge l'entreprise avec ses infos
    $listing->load('company'); 
    
    // 3. On retourne la vue
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
    // On initialise la requête AVEC la jointure immédiatement
    $query = Listing::join('companies', 'listings.company_id', '=', 'companies.id')
                    ->select('listings.*', 'companies.rank as company_rank');

    // Logique de recherche
    if ($request->filled('search')) {
        $search = $request->get('search');
        
        $query->where(function($q) use ($search) {
            // Important : On précise 'listings.champ' pour éviter les ambiguïtés
            $q->where('listings.title', 'like', '%' . $search . '%')
              ->orWhere('listings.category', 'like', '%' . $search . '%')
              ->orWhere('listings.location', 'like', '%' . $search . '%')
              ->orWhere('listings.description', 'like', '%' . $search . '%');
        });
    }

    // Le tri fonctionne maintenant car le JOIN n'a pas été écrasé
    $query->orderBy('companies.rank', 'desc')
          ->orderBy('listings.created_at', 'desc');

    if ($request->filled('search') || $request->has('all')) {
        $listings = $query->get();
    } else {
        $listings = $query->take(12)->get();
    }

    return view('welcome', compact('listings'));
}
}
