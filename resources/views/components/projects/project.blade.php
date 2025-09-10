@props(['project'])

<a href="{{ route('projects.show', $project) }}">
    <div class="flex items-center rounded-xl border border-gray-200 hover:border-blue-400 hover:cursor-pointer group">
        <img src="{{ $project->thumbnail ? asset('images/projects/'.$project->thumbnail) : Vite::asset('resources/images/thumb-image.png') }}"
             alt="{{ $project->name }} thumbnail"
             class="h-full aspect-square rounded-l-xl rounded-r-none object-cover"
             style="min-width: 64px; max-width: 128px;" />
        <div class="flex-1 ml-4">
            <h2 class="text-lg font-semibold group-hover:text-blue-400">{{ $project->name }}</h2>
            <p class="text-sm text-gray-500">{{ $project->created_at->toFormattedDayDateString() }}</p>
        </div>
    </div>
</a>
