<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Gestion des entreprises</h2>
                <p class="mt-1 text-sm text-gray-600">Page réservée au SuperAdmin pour gérer les rangs des entreprises.</p>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Gestion des entreprises</h1>
        <p class="text-sm text-gray-600">Page réservée au SuperAdmin pour gérer les rangs des entreprises.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 font-medium text-gray-700">ID</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Entreprise</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Ville</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Rang</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($companies as $company)
                    <tr>
                        <td class="px-6 py-4 text-gray-700">{{ $company->id }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $company->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $company->city }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $company->rank }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.updateRank', $company) }}" class="flex items-center gap-2">
                                @csrf
                                <label class="sr-only" for="rank-{{ $company->id }}">Rang</label>
                                <select id="rank-{{ $company->id }}" name="rank" class="rounded border-gray-300 px-3 py-2 text-sm">
                                    @for($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" @selected($company->rank === $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Mettre à jour</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune entreprise trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
