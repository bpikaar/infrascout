<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="mr-6">
                            <img src="{{ Vite::asset('resources/images/thumb-image.png') }}"
                                alt="{{ __('report.images.alt_new_report_thumb') }}"
                                class="h-24 w-24 rounded-lg object-cover" />
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('report.title.create') }}</h1>
                            <p class="text-gray-500 dark:text-gray-400">
                                    {{ __('report.project.for_project', ['name' => $project->name]) }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <form method="POST" action="{{ route('projects.reports.store', old('project_id') ?? request('project')) }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Project Selection -->
                            <div class="bg-gray-200 dark:bg-gray-500 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.fields.project') }} / {{ __('report.title.details') }}</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="project_id" :value="__('report.fields.project')" />
                                        <select id="project_id" name="project_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                            <option value="">{{ __('report.project.select') }}</option>
                                            @foreach($projects as $p)
                                                <option value="{{ $p->id }}" {{ (old('project_id') == $p->id || $project->id == $p->id) ? 'selected' : '' }}>
                                                    #{{ $p->number }} - {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="date_of_work" :value="__('report.fields.date_of_work')" />
                                        <x-text-input id="date_of_work"
                                            class="block mt-1 w-full"
                                            type="datetime-local"
                                            name="date_of_work"
                                            :value="old('date_of_work', now()->format('Y-m-d\TH:i'))"
                                            required />
                                        <x-input-error :messages="$errors->get('date_of_work')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="field_worker" :value="__('report.fields.field_worker')" />
                                        <select id="field_worker" name="field_worker" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                            <option value="">{{ __('report.fields.field_worker') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('field_worker') == $user->id || auth()->id() == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('field_worker')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Rapport title--}}
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div>
                                    <x-input-label for="title" :value="__('report.fields.title')" />
                                    <x-text-input id="title"
                                                  class="block mt-1 w-full"
                                                  type="text"
                                                  name="title"
                                                  :value="old('title')"
                                                  required
                                                  placeholder="{{ __('report.placeholders.title') }}" />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                            </div>
                            <!-- Work Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.work') }}</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="work_hours" :value="__('report.fields.work_hours')" />
                                        <x-text-input id="work_hours"
                                                      class="block mt-1 w-full"
                                                      type="text"
                                                      name="work_hours"
                                                      :value="old('work_hours')"
                                                      required
                                                      placeholder="{{ __('report.placeholders.work_hours') }}" />
                                        <x-input-error :messages="$errors->get('work_hours')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="travel_time" :value="__('report.fields.travel_time')" />
                                        <x-text-input id="travel_time"
                                                      class="block mt-1 w-full"
                                                      type="text"
                                                      name="travel_time"
                                                      :value="old('travel_time')"
                                                      required
                                                      placeholder="{{ __('report.placeholders.travel_time') }}" />
                                        <x-input-error :messages="$errors->get('travel_time')" class="mt-2" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <x-input-label for="description" :value="__('report.fields.description')" />
                                        <textarea id="description"
                                                  name="description"
                                                  rows="6"
                                                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                  required
                                                  placeholder="{{ __('report.placeholders.description') }}">{{ old('description') }}</textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Specifications (Multiple Cable & Pipe Rows with Autofill) -->
                            <x-report.create.cable-selector />

                            <x-report.create.pipe-selector />

                            <div x-data="{ radioEnabled: @js(old('radio_detection_enabled', false)),
                                           enabledGyroscope: @js(old('gyroscope_enabled', false)),
                                           testTrenchEnabled: @js(old('test_trench_enabled', false)),
                                           groundRadarEnabled: @js(old('ground_radar_enabled', false)),
                                           cableFailureEnabled: @js(old('cable_failure_enabled', false)),
                                           gpsMeasurementEnabled: @js(old('gps_measurement_enabled', false)),
                                           lanceEnabled: @js(old('lance_enabled', false)) }"
                                 class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.work_performed') }}</h2>
                                    <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="radio_detection_enabled" x-model="radioEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">{{ __('Radiodetectie') }}</span>
                                        </label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="gyroscope_enabled" x-model="enabledGyroscope" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">{{ __('Gyroscoopmeting') }}</span>
                                        </label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="test_trench_enabled" x-model="testTrenchEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">{{ __('Proefsleuf') }}</span>
                                        </label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="ground_radar_enabled" x-model="groundRadarEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">{{ __('Grondradar') }}</span>
                                        </label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="cable_failure_enabled" x-model="cableFailureEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">{{ __('Kabelstoring') }}</span>
                                        </label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="gps_measurement_enabled" x-model="gpsMeasurementEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">{{ __('GPS-meting') }}</span>
                                        </label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="lance_enabled" x-model="lanceEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="text-gray-700 dark:text-gray-300">Aanlansen / aanprikken</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Radio Detection (optional) -->
                                <x-report.create.radio-detection />

                                <!-- Gyroscope (optional) -->
                                <x-report.create.gyroscope />

                                <!-- Test Trench (Proefsleuf) (optional) -->
                                <x-report.create.test-trench />

                                <!-- Ground Radar (optional) -->
                                <x-report.create.ground-radar />

                                <!-- Cable Failure (optional) -->
                                <x-report.create.cable-failure />

                                <!-- GPS Measurement (optional) -->
                                <x-report.create.gps-measurement />

                                <!-- Lance (optional) -->
                                <x-report.create.lance />
                            </div>

                            <!-- Results & Follow-up -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Resultaten & vervolg</h2>

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <x-input-label for="results_summary" value="Samenvatting resultaten" />
                                        <textarea id="results_summary"
                                                  name="results_summary"
                                                  rows="4"
                                                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                  placeholder="Korte samenvatting van de bevindingen">{{ old('results_summary') }}</textarea>
                                        <x-input-error :messages="$errors->get('results_summary')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="advice" value="Advies / aanbevelingen" />
                                        <textarea id="advice"
                                                  name="advice"
                                                  rows="4"
                                                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                  placeholder="Eventuele adviezen of aanbevelingen">{{ old('advice') }}</textarea>
                                        <x-input-error :messages="$errors->get('advice')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="follow_up" value="Vervolgacties" />
                                        <textarea id="follow_up"
                                                  name="follow_up"
                                                  rows="4"
                                                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                  placeholder="Welke acties volgen hieruit?">{{ old('follow_up') }}</textarea>
                                        <x-input-error :messages="$errors->get('follow_up')" class="mt-2" />
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="problem_solved" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('problem_solved') ? 'checked' : '' }} />
                                            <span class="text-gray-700 dark:text-gray-300">Probleem opgelost</span>
                                        </label>

                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="question_answered" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('question_answered') ? 'checked' : '' }} />
                                            <span class="text-gray-700 dark:text-gray-300">Vraag opdrachtgever beantwoord</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Images -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.images') }}</h2>

                                <div>
                                    <x-input-label for="images" :value="__('report.images.upload')" />
                                    <input id="images"
                                        type="file"
                                        name="images[]"
                                        multiple
                                        accept="image/*"
                                        class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('report.images.supported') }}
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
                                    {{ __('report.actions.cancel') }}
                                </a>

                                <div class="flex space-x-4">
                                    <x-primary-button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('report.actions.create') }}
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
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('images');
                const preview = document.getElementById('image-preview');

                function renderPreviewFrom(files) {
                    preview.innerHTML = '';
                    if (!files || files.length === 0) {
                        preview.classList.add('hidden');
                        return;
                    }
                    preview.classList.remove('hidden');

                    Array.from(files).forEach(file => {
                        if (!file.type || !file.type.startsWith('image/')) return;
                        const container = document.createElement('div');
                        container.className = 'relative';

                        const img = document.createElement('img');
                        img.className = 'w-full h-24 object-cover rounded-lg border border-gray-300';
                        img.alt = file.name;

                        const caption = document.createElement('p');
                        caption.className = 'text-xs text-gray-500 mt-1 truncate';
                        caption.textContent = file.name;

                        const reader = new FileReader();
                        reader.onload = ev => { img.src = ev.target.result; };
                        reader.readAsDataURL(file);

                        container.appendChild(img);
                        container.appendChild(caption);
                        preview.appendChild(container);
                    });
                }

                input.addEventListener('change', e => {
                    const chosen = e.target.files || [];
                    renderPreviewFrom(chosen);
                    // Do NOT modify input.files or clear input.value; rely on native multiple selection
                });

                // Optional: click preview area to reopen picker
                preview.addEventListener('click', () => input.click());
            });
        </script>
    @endpush

</x-app-layout>
