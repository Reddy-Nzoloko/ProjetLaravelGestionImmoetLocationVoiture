<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the list of companies for the superadmin.
     */
    public function index()
    {
        $companies = Company::orderByDesc('rank')->get();
        $summary = [
            'total' => $companies->count(),
            'active' => $companies->where('is_active', true)->count(),
            'blocked' => $companies->where('is_active', false)->count(),
        ];

        return view('admin.companies', compact('companies', 'summary'));
    }

    /**
     * Delete a company.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.companies')
            ->with('success', "L'entreprise '" . $company->name . "' a bien été supprimée.");
    }

    /**
     * Toggle the active state of a company.
     */
    public function toggleActive(Company $company)
    {
        $company->update(['is_active' => ! $company->is_active]);

        return redirect()->route('admin.companies')
            ->with('success', "Le statut de l'entreprise '" . $company->name . "' a été mis à jour.");
    }

    /**
     * Display the list of superadmins.
     */
    public function superadmins()
    {
        $superadmins = User::where('role', 'superadmin')->orderBy('name')->get();

        return view('admin.superadmins', compact('superadmins'));
    }

    /**
     * Display administration statistics.
     */
    public function statistics()
    {
        $totalCompanies = Company::count();
        $activeCompanies = Company::where('is_active', true)->count();
        $blockedCompanies = Company::where('is_active', false)->count();

        $ranks = Company::select('rank', DB::raw('count(*) as total'))
            ->groupBy('rank')
            ->orderByDesc('rank')
            ->get();

        $companiesPerMonth = Company::selectRaw('MONTH(created_at) as month, count(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthLabels = $companiesPerMonth->pluck('month')->map(function ($month) {
            $names = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            return $names[$month - 1] ?? $month;
        });

        return view('admin.statistics', compact('totalCompanies', 'activeCompanies', 'blockedCompanies', 'ranks', 'companiesPerMonth', 'monthLabels'));
    }

    /**
     * Display reports for the superadmin.
     */
    public function reports()
    {
        $totalCompanies = Company::count();
        $todayCompanies = Company::whereDate('created_at', now())->get();
        $monthCompanies = Company::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();

        $annualCompanies = Company::selectRaw('YEAR(created_at) as year, count(*) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('admin.reports', compact('totalCompanies', 'todayCompanies', 'monthCompanies', 'annualCompanies'));
    }

    /**
     * Update the rank and badge of a company.
     */
    public function updateRank(Request $request, Company $company)
    {
        $validated = $request->validate([
            'rank' => ['required', 'integer', 'min:0', 'max:10'],
            'badge' => ['nullable', 'string', 'max:50'],
        ]);

        $company->update([
            'rank' => $validated['rank'],
            'badge' => $validated['badge'] ?? null,
        ]);

        return redirect()->route('admin.companies')
            ->with('success', "Les informations de l'entreprise '" . $company->name . "' ont bien été mises à jour.");
    }
}
