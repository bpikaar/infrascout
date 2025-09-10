
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="mr-6">
                            <img src="{{ Vite::asset('resources/images/thumb-image.png') }}"
                                alt="New report thumbnail"
                                class="h-24 w-24 rounded-lg object-cover" />
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Report</h1>
                            <p class="text-gray-500 dark:text-gray-400">
                                    For project: {{ $project->name }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <form method="POST" action="{{ route('projects.reports.store', old('project_id') ?? request('project')) }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Project Selection -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Project Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="project_id" :value="__('Project')" />
                                        <select id="project_id" name="project_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                            <option value="">Select a project</option>
                                            @foreach($projects as $p)
                                                <option value="{{ $p->id }}" {{ (old('project_id') == $p->id || $project->id == $p->id) ? 'selected' : '' }}>
                                                    #{{ $p->number }} - {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="date_of_work" :value="__('Date of Work')" />
                                        <x-text-input id="date_of_work"
                                            class="block mt-1 w-full"
                                            type="datetime-local"
                                            name="date_of_work"
                                            :value="old('date_of_work', now()->format('Y-m-d\TH:i'))"
                                            required />
                                        <x-input-error :messages="$errors->get('date_of_work')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Personnel -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Personnel</h2>

                                <div>
                                    <x-input-label for="field_worker" :value="__('Field Worker')" />
                                    <select id="field_worker" name="field_worker" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="">Select field worker</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('field_worker') == $user->id || auth()->id() == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('field_worker')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Technical Specifications -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Technical Specifications</h2>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label for="cable_type" :value="__('Cable Type')" />
                                        <x-text-input id="cable_type"
                                            class="block mt-1 w-full"
                                            type="text"
                                            name="cable_type"
                                            :value="old('cable_type')"
                                            required
                                            placeholder="e.g., Cat 6, Fiber optic" />
                                        <x-input-error :messages="$errors->get('cable_type')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="material" :value="__('Material')" />
                                        <x-text-input id="material"
                                            class="block mt-1 w-full"
                                            type="text"
                                            name="material"
                                            :value="old('material')"
                                            required
                                            placeholder="e.g., Copper, Aluminum" />
                                        <x-input-error :messages="$errors->get('material')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="diameter" :value="__('Diameter (mm)')" />
                                        <x-text-input id="diameter"
                                            class="block mt-1 w-full"
                                            type="number"
                                            name="diameter"
                                            :value="old('diameter')"
                                            required
                                            step="0.1"
                                            placeholder="e.g., 12.5" />
                                        <x-input-error :messages="$errors->get('diameter')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Work Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Work Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="work_hours" :value="__('Work Hours')" />
                                        <x-text-input id="work_hours"
                                            class="block mt-1 w-full"
                                            type="text"
                                            name="work_hours"
                                            :value="old('work_hours')"
                                            required
                                            placeholder="e.g., 8 hours, 09:00-17:00" />
                                        <x-input-error :messages="$errors->get('work_hours')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="travel_time" :value="__('Travel Time')" />
                                        <x-text-input id="travel_time"
                                            class="block mt-1 w-full"
                                            type="text"
                                            name="travel_time"
                                            :value="old('travel_time')"
                                            required
                                            placeholder="e.g., 2 hours, 45 minutes" />
                                        <x-input-error :messages="$errors->get('travel_time')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Description</h2>

                                <div>
                                    <x-input-label for="description" :value="__('Work Description')" />
                                    <textarea id="description"
                                        name="description"
                                        rows="6"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        required
                                        placeholder="Describe the work performed, any issues encountered, and results...">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Images -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Images</h2>

                                <div>
                                    <x-input-label for="images" :value="__('Upload Images')" />
                                    <input id="images"
                                        type="file"
                                        name="images[]"
                                        multiple
                                        accept="image/*"
                                        class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        You can select multiple images. Supported formats: JPG, PNG, GIF, WebP (Max 2MB each)
                                    </p>
                                    <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                    <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                                </div>

                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ request()->has('project') ? route('projects.show', request('project')) : '#' }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Cancel
                                </a>

                                <div class="flex space-x-4">
                                    <x-secondary-button type="button" onclick="document.querySelector('form').reset(); clearImagePreview();">
                                        Reset Form
                                    </x-secondary-button>

                                    <x-primary-button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Create Report
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Image preview functionality
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            const files = Array.from(e.target.files);

            preview.innerHTML = '';

            if (files.length > 0) {
                preview.classList.remove('hidden');

                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-300">
                                <p class="text-xs text-gray-500 mt-1 truncate">${file.name}</p>
                            `;
                            preview.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                preview.classList.add('hidden');
            }
        });

        function clearImagePreview() {
            document.getElementById('image-preview').innerHTML = '';
            document.getElementById('image-preview').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
