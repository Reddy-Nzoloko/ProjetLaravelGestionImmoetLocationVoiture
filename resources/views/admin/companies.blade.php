<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Gestion des entreprises</h2>
                <p class="mt-1 text-sm text-gray-600">SuperAdmin : supprimez, bloquez ou modifiez le rang des entreprises.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
            @include('admin.sidebar')

            <div class="space-y-6">
                @if(session('success'))
                    <div class="rounded-3xl border border-green-200 bg-green-50 p-4 text-green-800 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Entreprises actives</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $summary['active'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Entreprises bloquées</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $summary['blocked'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total d'entreprises</p>
                        <p class="mt-4 text-3xl font-bold text-gray-900">{{ $summary['total'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 font-medium text-gray-700">ID</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Entreprise</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Ville</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Badge</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Rang</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Statut</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($companies as $company)
                                <tr>
                                    <td class="px-6 py-4 text-gray-700">{{ $company->id }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $company->name }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $company->city }}</td>
                                    <td class="px-6 py-4">
                                        @if($company->badge)
                                            <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ $company->badge }}</span>
                                        @else
                                            <span class="text-sm text-gray-500">Aucun</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $company->rank }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $company->is_active ? 'Active' : 'Bloquée' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-y-2">
                                        <form method="POST" action="{{ route('admin.updateRank', $company) }}" class="grid gap-2">
                                            @csrf
                                            <div class="grid gap-2 sm:grid-cols-[1fr_auto] sm:items-center">
                                                <label class="sr-only" for="rank-{{ $company->id }}">Rang</label>
                                                <select id="rank-{{ $company->id }}" name="rank" class="rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700">
                                                    @for($i = 0; $i <= 10; $i++)
                                                        <option value="{{ $i }}" @selected($company->rank === $i)>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <button type="submit" class="rounded bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">Mettre à jour</button>
                                            </div>
                                            <div class="grid gap-2 sm:grid-cols-[1fr_auto] sm:items-center">
                                                <label class="sr-only" for="badge-{{ $company->id }}">Badge</label>
                                                <select id="badge-{{ $company->id }}" name="badge" class="rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700">
                                                    <option value="" @selected(empty($company->badge))>Aucun badge</option>
                                                    <option value="Premium" @selected($company->badge === 'Premium')>Premium</option>
                                                    <option value="Vérifié" @selected($company->badge === 'Vérifié')>Vérifié</option>
                                                    <option value="Favori" @selected($company->badge === 'Favori')>Favori</option>
                                                    <option value="Nouveau" @selected($company->badge === 'Nouveau')>Nouveau</option>
                                                </select>
                                            </div>
                                        </form>

                                        <div class="flex flex-wrap gap-2">
                                            <form method="POST" action="{{ route('admin.companies.toggleActive', $company) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                                                    {{ $company->is_active ? 'Bloquer' : 'Activer' }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.companies.destroy', $company) }}" onsubmit="return confirm('Confirmer la suppression de cette entreprise ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucune entreprise trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
