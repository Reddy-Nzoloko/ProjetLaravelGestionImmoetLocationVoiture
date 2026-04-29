<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        // 1. Redirection forcée pour le SuperAdmin
        // On n'utilise PAS intended() pour lui, car il doit aller gérer les entreprises
        if ($user->role === 'superadmin') {
            return redirect()->route('admin.companies');
        }

        // 2. Redirection pour les Agents / Admins d'entreprise
        // On essaie de les renvoyer là où ils allaient, sinon vers leur dashboard
        if ($user->role === 'admin' || $user->role === 'agent') {
            return redirect()->intended(route('dashboard'));
        }

        // 3. Cas par défaut (Redirection vers l'accueil si le rôle est inconnu)
        // Note : j'utilise 'acceuil' car c'est le nom dans ton web.php
        return redirect()->intended(route('acceuil'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}