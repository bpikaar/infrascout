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
                        <img src="{{ $project->thumbnail ? asset('images/projects/'.$project->thumbnail) : Vite::asset('resources/images/thumb-image.png') }}"
                            alt="{{ $project->name }} thumbnail"
                            class="h-24 w-24 rounded-lg object-cover mr-6 md:mr-6" />

                        <div class="text-center md:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $project->name }}</h1>
                            <p class="text-gray-500 dark:text-gray-400">Project #{{ $project->number }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created: {{ $project->created_at->toFormattedDayDateString() }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Project Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Project Number</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->number }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Project Name</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->name }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Client</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->client }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Contact</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->contact }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Phone</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->phone ?? '—' }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Mail</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->mail ?? '—' }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg md:col-span-2">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Address</h3>
                                <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $project->address ?? '—' }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Created At</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->created_at->format('Y-m-d H:i') }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Last Updated</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $project->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Reports</h2>

                        @if($project->reports && $project->reports->count() > 0)
                            <div class="space-y-3">
                                @foreach($project->reports()->orderBy('updated_at', 'DESC')->get() as $report)
                                    <x-project.report-row :report="$report" :project="$project"/>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No reports available for this project.</p>
                        @endif
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('projects.reports.create', $project) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create New Report
                        </a>

                        <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
