<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Rapports</h2>
                <p class="mt-1 text-sm text-gray-600">Rapports annuels, mensuels et journaliers des entreprises.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
            @include('admin.sidebar')
            <div class="space-y-6">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <p class="text-sm text-gray-500">Imprimez les rapports selon leur durée, directement depuis cette page.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button" onclick="printReport('annual-section')" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Imprimer annuel</button>
                        <button type="button" onclick="printReport('daily-section')" class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Imprimer journalier</button>
                        <button type="button" onclick="printReport('monthly-section')" class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Imprimer mensuel</button>
                        <button type="button" onclick="printReport('full-page')" class="inline-flex items-center rounded-xl bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Imprimer tout</button>
                    </div>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total d'entreprises</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $totalCompanies }}</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Nouvelles aujourd'hui</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $todayCompanies->count() }}</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Nouvelles ce mois</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $monthCompanies->count() }}</p>
                    </div>
                </div>

                <div id="annual-section" class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm printable-section">
                    <h3 class="text-lg font-semibold text-gray-900">Rapport annuel</h3>
                    <p class="mt-1 text-sm text-gray-500">Évolution des entreprises par année.</p>
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 font-medium text-gray-700">Année</th>
                                    <th class="px-6 py-3 font-medium text-gray-700">Nouveaux comptes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($annualCompanies as $report)
                                    <tr>
                                        <td class="px-6 py-4 text-gray-700">{{ $report->year }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $report->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">Aucun rapport annuel disponible.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <section id="daily-section" class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm printable-section">
                        <h3 class="text-lg font-semibold text-gray-900">Rapport journalier</h3>
                        <p class="mt-1 text-sm text-gray-500">Nouvelles entreprises ajoutées aujourd'hui.</p>
                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 font-medium text-gray-700">Nom</th>
                                        <th class="px-6 py-3 font-medium text-gray-700">Ville</th>
                                        <th class="px-6 py-3 font-medium text-gray-700">Créée le</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($todayCompanies as $company)
                                        <tr>
                                            <td class="px-6 py-4 text-gray-700">{{ $company->name }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $company->city }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune entreprise créée aujourd'hui.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section id="monthly-section" class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm printable-section">
                        <h3 class="text-lg font-semibold text-gray-900">Rapport mensuel</h3>
                        <p class="mt-1 text-sm text-gray-500">Nouvelles entreprises ajoutées ce mois-ci.</p>
                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 font-medium text-gray-700">Nom</th>
                                        <th class="px-6 py-3 font-medium text-gray-700">Ville</th>
                                        <th class="px-6 py-3 font-medium text-gray-700">Créée le</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($monthCompanies as $company)
                                        <tr>
                                            <td class="px-6 py-4 text-gray-700">{{ $company->name }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $company->city }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $company->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune entreprise créée ce mois-ci.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .printable-section, .printable-section * {
                visibility: visible;
            }
            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>
    <script>
        function printReport(sectionId) {
            const sections = document.querySelectorAll('.printable-section');
            sections.forEach(section => {
                section.classList.toggle('no-print', section.id !== sectionId && sectionId !== 'full-page');
            });

            if (sectionId === 'full-page') {
                document.querySelectorAll('.no-print').forEach(el => el.classList.remove('no-print'));
            }

            window.print();

            sections.forEach(section => {
                section.classList.remove('no-print');
            });
        }
    </script>
</x-app-layout>
