<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the list of companies for the superadmin.
     */
    public function index()
    {
        $companies = Company::orderByDesc('rank')->get();

        return view('admin.companies', compact('companies'));
    }

    /**
     * Update the rank of a company.
     */
    public function updateRank(Request $request, Company $company)
    {
        $validated = $request->validate([
            'rank' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $company->update(['rank' => $validated['rank']]);

        return redirect()->route('admin.companies')
            ->with('success', "Le rang de l'entreprise '" . $company->name . "' a bien été mis à jour.");
    }
}
