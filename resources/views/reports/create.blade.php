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

                            @php
                                // For create we may not have a persisted report yet
                                $report = $report ?? null;
                            @endphp

                            @include('reports.partials.form', ['mode' => 'create'])

                            <!-- Images upload -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.images') }}</h2>
                                <div>
                                    <x-input-label for="images" :value="__('report.images.upload')" />
                                    <input id="images" type="file" name="images[]" multiple accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                    <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">{{ __('report.actions.cancel') }}</a>
                                <x-primary-button>{{ __('report.actions.create') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
