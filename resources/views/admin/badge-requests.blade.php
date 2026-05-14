<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion des Demandes de Badges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-400 uppercase tracking-wider">Demandes de Badges</h3>
                        <div class="flex-grow ms-4 h-px bg-gray-200 dark:bg-gray-700"></div>
                    </div>

                    @if($badgeRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($badgeRequests as $request)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $request->company->name }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Demandé par: {{ $request->user->name }} ({{ $request->user->email }})</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Badge demandé: <span class="font-medium">{{ $request->requested_badge }}</span></p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Statut: 
                                                @if($request->status === 'pending')
                                                    <span class="text-yellow-600">En attente</span>
                                                @elseif($request->status === 'approved')
                                                    <span class="text-green-600">Approuvé</span>
                                                @else
                                                    <span class="text-red-600">Rejeté</span>
                                                @endif
                                            </p>
                                            @if($request->message)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Message: {{ $request->message }}</p>
                                            @endif
                                            @if($request->admin_response)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Réponse admin: {{ $request->admin_response }}</p>
                                            @endif
                                        </div>
                                        @if($request->status === 'pending')
                                            <div class="flex space-x-2">
                                                <form method="POST" action="{{ route('admin.badge-requests.approve', $request) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                        Approuver
                                                    </button>
                                                </form>
                                                <button onclick="rejectRequest({{ $request->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Rejeter
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Aucune demande de badge pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for rejecting request -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="my-modal">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Rejeter la demande</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="admin_response" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Réponse (optionnel)</label>
                        <textarea id="admin_response" name="admin_response" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRejectModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Annuler
                        </button>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function rejectRequest(id) {
            document.getElementById('rejectForm').action = '{{ url("/admin/badge-requests") }}/' + id + '/reject';
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>