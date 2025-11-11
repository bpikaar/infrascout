<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="mr-6">
                            @php
                                $imageSrc = $report->images->isNotEmpty() ?
                                    asset('/storage/images/reports/'.$report->id.'/'.$report->images()->first()->path)  :
                                    Vite::asset('resources/images/thumb-image.png');
                            @endphp
                            <img src="{{ $imageSrc }}"
                                 alt="{{ __('report.images.alt_edit_report_thumb') }}"
                                 class="h-24 w-24 rounded-lg object-cover" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('report.actions.edit') }}</h1>
                            <p class="text-gray-500 dark:text-gray-400">#{{ $report->project->number }} - {{ $report->project->name }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <form method="POST" action="{{ route('projects.reports.update', [$report->project, $report]) }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- reuse create form blocks but prefill with $report -->
                            @include('reports.partials.form', ['mode' => 'edit'])

                            <!-- Existing images with delete checkboxes -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.images') }}</h2>
                                @if($report->images->count())
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-4">
                                        @foreach($report->images as $image)
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                                <img src="{{ asset('/storage/images/reports/'.$report->id.'/'.$image->path) }}"
                                                     alt=""
                                                     class="w-full h-32 object-cover"/>
                                                <label class="flex items-center space-x-2 p-2">
                                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('report.images.delete') }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div>
                                    <x-input-label for="images" :value="__('report.images.upload')" />
                                    <input id="images" type="file" name="images[]" multiple accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('projects.reports.show', [$report->project, $report]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">{{ __('report.actions.cancel') }}</a>
                                <x-primary-button>{{ __('report.actions.update') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

