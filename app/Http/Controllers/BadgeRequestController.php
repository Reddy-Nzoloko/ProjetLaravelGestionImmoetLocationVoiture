<?php

namespace App\Http\Controllers;

use App\Models\BadgeRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class BadgeRequestController extends Controller
{
    /**
     * Afficher le formulaire de demande de badge.
     */
    public function create()
    {
        return view('badge-requests.create');
    }

    /**
     * Stocker une nouvelle demande de badge.
     */
    public function store(Request $request)
    {
        $request->validate([
            'requested_badge' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        BadgeRequest::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'requested_badge' => $request->requested_badge,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Votre demande de badge a été soumise avec succès.');
    }

    /**
     * Afficher les demandes de badges pour le super admin.
     */
    public function index()
    {
        $badgeRequests = BadgeRequest::with(['user', 'company'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.badge-requests', compact('badgeRequests'));
    }

    /**
     * Approuver une demande de badge.
     */
    public function approve(BadgeRequest $badgeRequest)
    {
        $badgeRequest->update([
            'status' => 'approved',
            'responded_at' => now(),
        ]);

        // Mettre à jour le badge de l'entreprise
        $badgeRequest->company->update(['badge' => $badgeRequest->requested_badge]);

        return redirect()->route('admin.badge-requests')->with('success', 'Demande de badge approuvée.');
    }

    /**
     * Rejeter une demande de badge.
     */
    public function reject(Request $request, BadgeRequest $badgeRequest)
    {
        $request->validate([
            'admin_response' => 'nullable|string|max:1000',
        ]);

        $badgeRequest->update([
            'status' => 'rejected',
            'admin_response' => $request->admin_response,
            'responded_at' => now(),
        ]);

        return redirect()->route('admin.badge-requests')->with('success', 'Demande de badge rejetée.');
    }
}
