@props([
    'client',
    'report'
])

<div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg hover:border-blue-400 transition">
    <a href="{{ route('clients.reports.show', [$client, $report]) }}" class="flex flex-col gap-4 md:flex-row md:items-center text-blue-500 hover:text-blue-700">
        <!-- Thumbnails -->
        <div class="flex items-center gap-2 w-full md:w-auto">
            @foreach($report->images()->take(2)->get() as $image)
                <img src="{{ route('files.report-image', [$report, $image->path]) }}"
                     alt="Report image"
                     class="h-20 w-20 object-cover rounded border border-gray-200"
                />
            @endforeach
        </div>

        <!-- Main info -->
        <div class="flex-1 min-w-0 w-full">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">#{{ $report->report_number }} - {{ $report->title }}</h3>
            <p class="text-gray-700 dark:text-gray-300 truncate">{{ $report->description }}</p>
            <span class="text-sm text-gray-500 block">{{ $report->date_of_work->format('Y-m-d') }}</span>
        </div>

        <!-- View Details -->
        <div class="w-full md:w-auto md:ml-4 whitespace-nowrap text-left md:text-right text-blue-500 hover:text-blue-700 font-semibold">
            Klik voor details →
        </div>
    </a>
</div>
