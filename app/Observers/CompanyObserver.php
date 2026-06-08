<?php

namespace App\Observers;

use App\Mail\CompanyBlockedNotification;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CompanyObserver
{
    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        // Si is_active passe de true à false (entreprise bloquée)
        if ($company->isDirty('is_active') && ! $company->is_active) {
            $this->notifyUsersOfBlocking($company);
        }

        // Si is_active passe de false à true (entreprise débloquée)
        if ($company->isDirty('is_active') && $company->is_active) {
            $this->notifyUsersOfUnblocking($company);
        }
    }

    /**
     * Notify all users of the company that it has been blocked.
     */
    private function notifyUsersOfBlocking(Company $company): void
    {
        // Récupérer le superadmin
        $superAdmin = User::where('role', 'superadmin')->first();

        if (!$superAdmin) {
            return;
        }

        // Récupérer tous les utilisateurs de l'entreprise
        $users = $company->users;

        // Envoyer l'email à chaque utilisateur
        foreach ($users as $user) {
            Mail::to($user->email)->send(new CompanyBlockedNotification($company, $superAdmin));
        }
    }

    /**
     * Notify all users of the company that it has been unblocked.
     */
    private function notifyUsersOfUnblocking(Company $company): void
    {
        // Vous pouvez implémenter une notification de déblocage ici
        // Pour l'instant, cette fonctionnalité n'est pas nécessaire
    }
}
