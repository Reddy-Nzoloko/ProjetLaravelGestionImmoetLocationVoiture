<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Demander un Badge') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                <form method="POST" action="{{ route('badge-requests.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="requested_badge" value="Badge demandé" />
                        <x-text-input id="requested_badge" name="requested_badge" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('requested_badge')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="message" value="Message (optionnel)" />
                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>
                            {{ __('Soumettre la demande') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>