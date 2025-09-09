
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <img src="{{ Vite::asset('resources/images/thumb-image.png') }}"
                             alt="Report thumbnail"
                             class="h-24 w-24 rounded-lg object-cover mr-6" />

                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Report #{{ $report->id }}</h1>
                            <p class="text-gray-500 dark:text-gray-400">Project: {{ $report->project->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Work Date: {{ $report->date_of_work->format('Y-m-d') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Report Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Project Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Project</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->project->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Project #{{ $report->project->number ?? 'N/A' }}</p>
                            </div>

                            <!-- Date of Work -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Date of Work</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->date_of_work->format('l, F j, Y') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $report->date_of_work->format('H:i') }}</p>
                            </div>

                            <!-- Creator -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Created By</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $report->user->email ?? 'N/A' }}</p>
                            </div>

                            <!-- Field Worker -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Field Worker</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->fieldWorker->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $report->fieldWorker->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Technical Specifications</h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Cable Type -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Cable Type</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->cable_type }}</p>
                            </div>

                            <!-- Material -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Material</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->material }}</p>
                            </div>

                            <!-- Diameter -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Diameter</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->diameter }}mm</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Work Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Work Hours -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Work Hours</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->work_hours }}</p>
                            </div>

                            <!-- Travel Time -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Travel Time</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->travel_time }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Description</h2>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $report->description }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Timestamps</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Created At</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->created_at->format('Y-m-d H:i') }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="font-semibold text-gray-700 dark:text-gray-300">Last Updated</h3>
                                <p class="text-gray-900 dark:text-gray-100">{{ $report->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('projects.show', $report->project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Project
                        </a>

                        <a href="{{ route('reports.edit', $report) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
