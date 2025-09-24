
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('status'))
                        <div class="mb-4 rounded-md bg-blue-50 p-4 border border-blue-200 dark:bg-blue-900/30 dark:border-blue-800">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-300 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 102 0v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-sm text-blue-800 dark:text-blue-200">{{ session('status') }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="flex flex-col md:flex-row items-center gap-3 mb-6">
                        <img src="{{ Vite::asset('resources/images/thumb-image.png') }}"
                            alt="{{ __('report.images.alt_report_thumb') }}"
                                 class="h-24 w-24 rounded-lg object-cover mr-6" />

                        <div class="text-center md:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('report.title.show', ['id' => $report->id]) }}</h1>
                            @php
                                $link = '<a href="'. route('projects.show', $report->project).'">'.$report->project->name.'</a>';
                            @endphp
                            <p class="text-gray-500 dark:text-gray-400 hover:text-gray-300 underline">{{ __('report.project.label') }}: {!! $report->project->name ? $link : __('report.status.n_a') !!}</p>
                        </div>
                        <div class="self-center md:self-start md:ml-auto">
                            <p class="text-sm text-center md:text-right text-gray-500 dark:text-gray-400">
                                <span class="font-bold">{{ __('report.fields.work_date') }}</span>: {{ $report->date_of_work->format('l, j F Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.work') }}</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Field Worker -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('report.fields.field_worker') }}</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->fieldWorker->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $report->fieldWorker->email ?? 'N/A' }}</p>

                                <br />

                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('report.fields.work_hours') }}</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->work_hours }}</p>

                                <br />

                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('report.fields.travel_time') }}</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->travel_time }}</p>
                            </div>

                            <!-- Description -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.description') }}</h3>
                                <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $report->description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.cables') }}</h2>

                        <div class="space-y-8">
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('report.title.cables_section') }}</h3>
                                @if($report->cables->count())
                                    <div class="space-y-2">
                                        @foreach($report->cables as $cable)
                                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg flex flex-col md:flex-row md:items-center md:justify-between">
                                                <div>
                                                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $cable->cable_type }}</span>
                                                    <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $cable->material }}</span>
                                                    @if($cable->diameter)
                                                        <span class="text-gray-500 dark:text-gray-400 ml-2">{{ number_format($cable->diameter, 2) }} mm</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('report.cables.none') }}</p>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('report.title.pipes_section') }}</h3>
                                @if($report->pipes && $report->pipes->count())
                                    <div class="space-y-2">
                                        @foreach($report->pipes as $pipe)
                                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg flex flex-col md:flex-row md:items-center md:justify-between">
                                                <div>
                                                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $pipe->pipe_type }}</span>
                                                    <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $pipe->material }}</span>
                                                    @if($pipe->diameter)
                                                        <span class="text-gray-500 dark:text-gray-400 ml-2">{{ number_format($pipe->diameter, 2) }} mm</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('report.pipes.none') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($report->radioDetection || $report->gyroscope || $report->testTrench || $report->groundRadar)
                        <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('Uitgevoerde werkzaamheden') }}</h2>
                            <div class="space-y-4">
                                <x-report.show.test-trench :report="$report" />

                                <x-report.show.radio-detection :report="$report" />

                                <x-report.show.ground-radar :report="$report" />

                                <x-report.show.gyroscope :report="$report" />
                            </div>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.images') }}</h2>
                        @if($report->images && $report->images->count())
                                <div x-data="{ showModal: false, modalImg: '', modalCaption: '' }">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                                        @foreach($report->images as $image)
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden flex flex-col items-center">
                                                <img src="{{ asset('images/reports/'.$report->id.'/'.$image->path) }}"
                                                     alt="{{ __('report.images.alt_report_image') }}"
                                                     class="w-full h-32 sm:h-40 object-cover cursor-pointer"
                                                     @click="$dispatch('open-modal', 'large-image', modalImg = '{{ asset('images/reports/'.$report->id.'/'.$image->path) }}', modalCaption = '{{ $image->caption ?? '' }}')"
                                                 />
                                                @if($image->caption)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 px-2 text-center">{{ $image->caption }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Test Model -->
                                    <x-modal name="large-image" focusable>
                                        <div class="p-6">
                                            <img :src="modalImg" alt="{{ __('report.images.alt_enlarged') }}" class="w-full h-auto max-h-[70vh] object-contain rounded-lg" />
                                            <div class="mt-6 flex justify-end gap-3">
                                                <button type="button" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800"
                                                        @click="$dispatch('close')">
                                                    {{ __('Close') }}
                                                </button>
                                            </div>
                                        </div>
                                    </x-modal>

                                </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('report.images.none') }}</p>
                        @endif

                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('projects.show', $report->project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ __('report.project.back') }}
                        </a>

                        <a href="{{ route('projects.reports.edit', [$report->project, $report]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            {{ __('report.actions.edit') }}
                        </a>

                        @php($report->loadMissing('pdf'))
                        @if($report->pdf && \Storage::disk('public')->exists($report->pdf->file_path))
                            <a href="{{ route('projects.reports.download', [$report]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                {{ __('report.actions.download') }}
                            </a>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8" stroke-width="4" class="opacity-75"/></svg>
                                {{ __('report.actions.preparing_pdf') }}
                            </span>
                            <a href="{{ route('projects.reports.regenerate', [$report]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                {{ __('report.actions.regenerate') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
