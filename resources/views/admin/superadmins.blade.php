<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">SuperAdmins</h2>
                <p class="mt-1 text-sm text-gray-600">Liste des super administrateurs et accès à vos identifiants.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
            @include('admin.sidebar')

            <div class="space-y-6">
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">SuperAdmins actifs</h3>
                            <p class="mt-1 text-sm text-gray-600">Vous pouvez consulter les comptes de tous les super administrateurs.</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Modifier mes identifiants
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 font-medium text-gray-700">#</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Nom</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Email</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Role</th>
                                <th class="px-6 py-3 font-medium text-gray-700">Créé le</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($superadmins as $superadmin)
                                <tr>
                                    <td class="px-6 py-4 text-gray-700">{{ $superadmin->id }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $superadmin->name }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $superadmin->email }}</td>
                                    <td class="px-6 py-4 text-gray-700 capitalize">{{ $superadmin->role }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $superadmin->created_at?->format('d/m/Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun super administrateur trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
