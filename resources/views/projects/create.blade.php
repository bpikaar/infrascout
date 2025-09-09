<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Project</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Fill in the details to create a new project.</p>
                    </div>

                    <form method="post" action="{{ route('projects.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Project Number -->
                            <div>
                                <x-input-label for="number" :value="__('Project Number')" />
                                <x-text-input id="number"
                                              class="block mt-1 w-full"
                                              type="number"
                                              name="number"
                                              :value="old('number')"
                                              required />
                                <x-input-error :messages="$errors->get('number')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Unique project number for identification</p>
                            </div>

                            <!-- Project Name -->
                            <div>
                                <x-input-label for="name" :value="__('Project Name')" />
                                <x-text-input id="name"
                                              class="block mt-1 w-full"
                                              type="text"
                                              name="name"
                                              :value="old('name')"
                                              required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Descriptive name for the project</p>
                            </div>
                        </div>

                        <!-- Project Preview -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Preview</h2>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center rounded-xl border border-gray-200 dark:border-gray-600">
                                    <img src="{{ Vite::asset('resources/images/thumb-image.png') }}"
                                         alt="Project thumbnail"
                                         class="h-full aspect-square rounded-l-xl rounded-r-none object-cover"
                                         style="min-width: 64px; max-width: 128px;" />
                                    <div class="flex-1 ml-4">
                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="preview-name">
                                            {{ old('name') ?: 'Project Name' }}
                                        </h2>
                                        <p class="text-sm text-gray-500">
                                            #<span id="preview-number">{{ old('number') ?: '000' }}</span> • {{ now()->toFormattedDayDateString() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('projects.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Cancel
                            </a>

                            <x-primary-button class="ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Create Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Live preview update
            document.addEventListener('DOMContentLoaded', function() {
                const nameInput = document.getElementById('name');
                const numberInput = document.getElementById('number');
                const previewName = document.getElementById('preview-name');
                const previewNumber = document.getElementById('preview-number');

                nameInput.addEventListener('input', function() {
                    previewName.textContent = this.value || 'Project Name';
                });

                numberInput.addEventListener('input', function() {
                    previewNumber.textContent = this.value || '000';
                });
            });
        </script>
    @endpush
</x-app-layout>
