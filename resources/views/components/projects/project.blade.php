@props(['project'])

<a href="{{ route('projects.show', $project) }}">
    <div class="flex items-center rounded-xl border border-gray-200 hover:border-indigo-400 hover:dark:border-indigo-600 hover:cursor-pointer group">
        <img src="{{ $project->thumbnail ? asset('images/projects/'.$project->thumbnail) : Vite::asset('resources/images/thumb-image.png') }}"
             alt="{{ $project->name }} thumbnail"
             class="h-full aspect-square rounded-l-xl rounded-r-none object-cover"
             style="min-width: 64px; max-width: 100px;" />
        <div class="flex-1 ml-4">
            <h2 class="md:text-lg font-semibold group-hover:text-indigo-400 group-hover:dark:text-indigo-600">{{ $project->name }}</h2>
            <p class="text-sm text-gray-500">{{ $project->created_at->toFormattedDayDateString() }}</p>
        </div>
    </div>
</a>
