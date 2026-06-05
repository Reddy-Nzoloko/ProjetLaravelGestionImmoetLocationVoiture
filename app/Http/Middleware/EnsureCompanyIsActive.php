<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si l'utilisateur n'existe pas, le laisser passer (sera géré par auth middleware)
        if (!$user) {
            return $next($request);
        }

        // Les superadmins peuvent toujours accéder
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Vérifier si l'utilisateur appartient à une entreprise
        if (!$user->company) {
            return $next($request);
        }

        // Vérifier si l'entreprise est active
        if ($user->company->is_active === false) {
            // Déconnecter l'utilisateur
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Rediriger vers la page de connexion avec un message court et clair
            return redirect()->route('login')->withErrors([
                'email' => 'Vous êtes bloqué, veuillez contacter le super admin.',
            ]);
        }

        return $next($request);
    }
}
