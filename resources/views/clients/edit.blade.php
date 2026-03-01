<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('client.edit_title') }}</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">{{ __('client.edit_intro') }}</p>
                    </div>

                    <form method="post" action="{{ route('clients.update', $client) }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Client Number -->
                            <!-- Voor nu wordt het nummer weggelaten. Het zit nog wel in de database -->
                            {{-- <div>--}}
                                {{-- <x-input-label for="number" :value="__('client.number')" />--}}
                                {{-- <x-text-input id="number" --}} {{--
                                    class="block mt-1 w-full text-gray-600 bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                                    --}} {{-- type="text" --}} {{-- name="number" --}} {{-- :value="$client->number"
                                    --}} {{-- disabled />--}}
                                {{-- <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{
                                    __('client.number_immutable') }}</p>--}}
                                {{-- </div>--}}

                            <!-- Client Name -->
                            <div>
                                <x-input-label for="name" :value="__('client.name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name') ?? $client->name ?? ''" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Client Image Upload -->
                            <div>
                                <x-input-label for="thumbnail" :value="__('client.image')" />
                                <input id="thumbnail" type="file" name="thumbnail" accept="image/*"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('client.image_help') }}</p>
                            </div>
                        </div>

                        <!-- Contact Section -->
                        <x-clients.contact :client="$client" />

                        <!-- Client Preview -->
                        <x-client.preview :client="$client" />

                        <!-- Form Actions -->
                        <div
                            class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('clients.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('client.cancel') }}
                            </a>

                            <x-primary-button class="ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ __('client.save_action') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
