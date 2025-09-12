@props([
    'project',
    'report'
])

<div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg hover:border-blue-400 transition">
    <a href="{{ route('projects.reports.show', [$project, $report]) }}" class="flex items-center gap-4 text-blue-500 hover:text-blue-700">
        <!-- Thumbnails -->
        <div class="flex items-center gap-2">
            @foreach($report->images()->take(2)->get() as $image)
                <img src="{{ '/images/reports/'.$report->id.'/'.$image->path }}"
                     alt="Report image"
                     class="h-20 w-20 object-cover rounded border border-gray-200"
                />
            @endforeach
        </div>

        <!-- Main info -->
        <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">Report #{{ $report->id }}</h3>
            <p class="text-gray-700 dark:text-gray-300 truncate">{{ $report->description }}</p>
            <span class="text-sm text-gray-500 block">{{ $report->date_of_work->format('Y-m-d') }}</span>
        </div>

        <!-- View Details -->
        <div class="ml-4 whitespace-nowrap text-right text-blue-500 hover:text-blue-700 font-semibold">
            View Details →
        </div>
    </a>
</div>
