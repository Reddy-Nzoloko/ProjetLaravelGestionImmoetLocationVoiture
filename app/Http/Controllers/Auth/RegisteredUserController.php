<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company; // Importation correcte à la racine
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; 

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'company_name' => ['required', 'string', 'max:255'],
        'activity_sector' => ['required', 'in:auto,immo'], // Très important !
        'whatsapp_number' => ['required', 'string'],
    ]);

    // 1. On crée l'entreprise d'abord avec le bon secteur
    $company = Company::create([
        'name' => $request->company_name,
        'activity_sector' => $request->activity_sector,
        'whatsapp_number' => $request->whatsapp_number,
        'city' => 'Goma',
    ]);

    // 2. On crée l'utilisateur lié à cette entreprise
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'company_id' => $company->id,
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}

