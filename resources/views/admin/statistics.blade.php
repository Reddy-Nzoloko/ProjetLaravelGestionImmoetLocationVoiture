<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Statistiques</h2>
                <p class="mt-1 text-sm text-gray-600">Aperçu des entreprises et performances du réseau.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
            @include('admin.sidebar')

            <div class="space-y-6">
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Entreprises actives</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $activeCompanies }}</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Entreprises bloquées</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $blockedCompanies }}</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total d'entreprises</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $totalCompanies }}</p>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Entreprises par rang</h3>
                                <p class="mt-1 text-sm text-gray-500">Distribution des sociétés selon leur rang.</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <canvas id="rankChart" class="h-72 w-full"></canvas>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Nouvelles entreprises</h3>
                                <p class="mt-1 text-sm text-gray-500">Par mois sur l'année en cours.</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <canvas id="monthlyChart" class="h-72 w-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const rankLabels = @json($ranks->pluck('rank'));
        const rankData = @json($ranks->pluck('total'));
        const monthLabels = @json($monthLabels);
        const monthData = @json($companiesPerMonth->pluck('total'));

        new Chart(document.getElementById('rankChart'), {
            type: 'bar',
            data: {
                labels: rankLabels,
                datasets: [{
                    label: 'Entreprises',
                    data: rankData,
                    backgroundColor: '#4F46E5',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Nouvelles entreprises',
                    data: monthData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.15)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>
