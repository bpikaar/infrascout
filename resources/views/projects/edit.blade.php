<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Project</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Change the details for this project.</p>
                    </div>

                    <form method="post" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Project Number -->
                            <div>
                                <x-input-label for="number" :value="__('Project Number')" />
                                <x-text-input id="number"
                                              class="block mt-1 w-full text-gray-600 bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                                              type="text"
                                              name="number"
                                              :value="$project->number"
                                              disabled />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Project number cannot be changed</p>
                            </div>

                            <!-- Project Name -->
                            <div>
                                <x-input-label for="name" :value="__('Project Name')" />
                                <x-text-input id="name"
                                              class="block mt-1 w-full"
                                              type="text"
                                              name="name"
                                              :value="old('name') ?? $project->name ?? ''"
                                              required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Descriptive name for the project</p>
                            </div>

                            <!-- Client -->
                            <div>
                                <x-input-label for="client" :value="__('Client')" />
                                <x-text-input id="client"
                                              class="block mt-1 w-full"
                                              type="text"
                                              name="client"
                                              :value="old('client') ?? $project->client ?? ''"
                                              required />
                                <x-input-error :messages="$errors->get('client')" class="mt-2" />
                            </div>

                            <!-- Project Image Upload -->
                            <div>
                                <x-input-label for="thumbnail" :value="__('Project Image')" />
                                <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Upload a square image for the project thumbnail</p>
                            </div>
                        </div>

                        <!-- Contact Section -->
                        <x-projects.contact :project="$project"/>

                        <!-- Project Preview -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Preview</h2>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center rounded-xl border border-gray-200 dark:border-gray-600">
                                     <img id="preview-image" src="{{ $project->thumbnail ? asset('images/projects/'.$project->thumbnail) : Vite::asset('resources/images/thumb-image.png') }}"
                                         alt="Project thumbnail"
                                         class="h-full aspect-square rounded-l-xl rounded-r-none object-cover"
                                         style="min-width: 64px; max-width: 128px;" />
                                    <div class="flex-1 ml-4">
                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="preview-name">
                                            {{ $project->name ?? old('name') ?: 'Project Name' }}
                                        </h2>
                                        <p class="text-sm text-gray-500">
                                            #<span id="preview-number">{{ $project->number ?? old('number') ?: '000' }}</span> • {{ now()->toFormattedDayDateString() }}
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
                                {{ __('Save Project') }}
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
                const thumbnailInput = document.getElementById('thumbnail');
                const previewImage = document.getElementById('preview-image');

                nameInput.addEventListener('input', function() {
                    previewName.textContent = this.value || 'Project Name';
                });

                numberInput.addEventListener('input', function() {
                    previewNumber.textContent = this.value || '000';
                });

                thumbnailInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            previewImage.src = ev.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewImage.src = "{{ Vite::asset('resources/images/thumb-image.png') }}";
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
