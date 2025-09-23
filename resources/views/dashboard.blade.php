<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">{{ __('Ga naar de projecten') }}</a>
                    </div>

                    <h3 class="text-lg font-semibold mb-3">{{ request('all') ? __('Alle rapporten') : __('Laatste 5 rapporten') }}</h3>

                    @if(isset($reports) && $reports->count())
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($reports as $report)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <a href="{{ route('projects.reports.show', [$report->project_id, $report->id]) }}" class="text-gray-900 dark:text-gray-100 hover:underline">
                                            #{{ $report->id }} – {{ optional($report->project)->number ? '#'.$report->project->number.' ' : '' }}{{ optional($report->project)->name }}
                                        </a>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $report->date_of_work?->format('d-m-Y H:i') }} • {{ __('Door') }} {{ optional($report->fieldWorker)->name ?? optional($report->user)->name }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if($report->pdf && $report->pdf->file_path)
                                            <a href="{{ route('projects.reports.download', $report) }}" class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                                                {{ __('Download PDF') }}
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('PDF wordt gegenereerd…') }}</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">{{ __('Geen rapporten gevonden.') }}</p>
                    @endif
                    @if(!request('all'))
                        <div class="mt-4">
                            <a href="{{ route('dashboard', ['all' => 1]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                                {{ __('Toon alle rapporten') }}
                            </a>
                        </div>
                    @else
                        <div class="mt-4">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                                {{ __('Toon laatste 5') }}
                            </a>
                        </div>
                    @endif

                    @if(request('all') && $reports->hasPages())
                        <div class="mt-4">
                            {{ $reports->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
