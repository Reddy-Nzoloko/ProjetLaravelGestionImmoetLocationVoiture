<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Redirection WhatsApp pour un produit spécifique
     * Récupère le numéro WhatsApp de l'entreprise et redirige vers le contact
     */
    public function sendProductMessage($listingId)
    {
        try {
            // Récupérer l'annonce et l'entreprise associée
            $listing = Listing::with('company')->findOrFail($listingId);
            
            // Vérifier que l'entreprise a un numéro WhatsApp
            if (!$listing->company || !$listing->company->whatsapp_number) {
                return redirect()->back()->with('error', 'Le numéro WhatsApp de cette entreprise n\'est pas disponible.');
            }

            // Construire le message
            $message = "Bonjour,\n\n";
            $message .= "Je suis intéressé par l'annonce suivante:\n\n";
            $message .= "📍 " . $listing->title . "\n";
            $message .= "💰 Prix: " . number_format($listing->price, 2) . " $\n";
            $message .= "📌 Localisation: " . $listing->location . "\n";
            $message .= "🏷️ Catégorie: " . $listing->category . "\n";
            
            if ($listing->offer_type) {
                $message .= "📋 Type d'offre: " . $listing->offer_type . "\n";
            }
            
            $message .= "\nPouvez-vous me fournir plus d'informations?\n";
            $message .= "Merci!";

            // Normaliser le numéro WhatsApp pour ouvrir directement le chat
            $whatsapp_number = $this->normalizeWhatsappNumber($listing->company->whatsapp_number);
            if (!$whatsapp_number) {
                return redirect()->back()->with('error', 'Le numéro WhatsApp de cette entreprise n\'est pas disponible ou est mal formaté.');
            }

            // Créer le lien WhatsApp direct
            $whatsapp_link = "https://api.whatsapp.com/send?phone=" . $whatsapp_number . "&text=" . urlencode($message);

            // Redirection vers WhatsApp
            return redirect($whatsapp_link);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Redirection WhatsApp pour le panier (multiple produits)
     * Récupère les numéros WhatsApp des entreprises et envoie un message consolidé
     */
    public function sendCartMessage(Request $request)
    {
        try {
            $listingIds = $request->input('listing_ids', []);
            
            if (empty($listingIds)) {
                return redirect()->back()->with('error', 'Aucun produit sélectionné.');
            }

            // Récupérer les annonces et grouper par entreprise
            $listings = Listing::with('company')
                ->whereIn('id', $listingIds)
                ->get();

            if ($listings->isEmpty()) {
                return redirect()->back()->with('error', 'Annonces non trouvées.');
            }

            // Grouper par entreprise
            $byCompany = $listings->groupBy('company_id');

            // Si plusieurs entreprises, on envoie un message pour chaque
            if ($byCompany->count() > 1) {
                return redirect()->back()->with('error', 'Veuillez sélectionner des produits de la même entreprise pour envoyer un message groupé.');
            }

            // Récupérer la première (et unique) entreprise
            $company = $listings->first()->company;

            if (!$company || !$company->whatsapp_number) {
                return redirect()->back()->with('error', 'Le numéro WhatsApp de cette entreprise n\'est pas disponible.');
            }

            // Construire le message consolidé
            $message = "Bonjour,\n\n";
            $message .= "Je suis intéressé par les annonces suivantes:\n\n";
            
            $total = 0;
            foreach ($listings as $listing) {
                $message .= "📍 " . $listing->title . "\n";
                $message .= "   💰 Prix: " . number_format($listing->price, 2) . " $\n";
                $message .= "   📌 Localisation: " . $listing->location . "\n\n";
                $total += $listing->price;
            }

            $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "💼 Total: " . number_format($total, 2) . " $\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
            $message .= "Pouvez-vous me fournir plus d'informations?\n";
            $message .= "Merci!";

            // Normaliser le numéro WhatsApp pour ouvrir directement le chat
            $whatsapp_number = $this->normalizeWhatsappNumber($company->whatsapp_number);
            if (!$whatsapp_number) {
                return redirect()->back()->with('error', 'Le numéro WhatsApp de cette entreprise n\'est pas disponible ou est mal formaté.');
            }

            // Créer le lien WhatsApp direct
            $whatsapp_link = "https://api.whatsapp.com/send?phone=" . $whatsapp_number . "&text=" . urlencode($message);

            // Redirection vers WhatsApp
            return redirect($whatsapp_link);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    private function normalizeWhatsappNumber(string $rawNumber): ?string
    {
        $digits = preg_replace('/[^0-9]/', '', $rawNumber);
        if (!$digits) {
            return null;
        }

        // Si numéro local commence par 0, remplacer par l'indicatif du pays DR Congo par défaut
        if (str_starts_with($digits, '0')) {
            $digits = '243' . substr($digits, 1);
        }

        // Si numéro sans indicatif et 9 chiffres, on ajoute 243 par défaut
        if (strlen($digits) === 9) {
            $digits = '243' . $digits;
        }

        return $digits;
    }
}
