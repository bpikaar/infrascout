@props(['client'])

<div
    class="flex items-stretch rounded-xl border border-gray-200 hover:border-indigo-400 hover:dark:border-indigo-600 group overflow-hidden transition-colors bg-white dark:bg-gray-800">
    <a href="{{ route('clients.show', $client) }}" class="flex-1 flex items-center hover:cursor-pointer">
        <img src="{{ $client->thumbnail ? route('files.client-thumbnail', $client) : Vite::asset('resources/images/thumb-image.png') }}"
            alt="{{ $client->name }} thumbnail" class="h-full aspect-square object-cover"
            style="min-width: 64px; max-width: 80px;" />
        <div class="flex-1 ml-4 py-1.5">
            <h2 class="md:text-lg font-semibold group-hover:text-indigo-400 group-hover:dark:text-indigo-600">
                {{ $client->name }}
            </h2>
            <p class="text-sm text-gray-500">Contactpersoon {{ $client->contact->name }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-200 font-bold">{{ $client->reports_count }}
                {{ __('rapporten') }}
            </p>
        </div>
    </a>

    <a href="{{ route('clients.edit', $client) }}"
        class="relative z-10 flex items-center justify-center px-4 md:px-6 text-gray-600 dark:text-gray-500 bg-gray-50 dark:bg-gray-700/50 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white group-hover:border-indigo-400 group-hover:dark:border-indigo-600 border-l border-gray-200 transition-colors duration-200"
        title="{{ __('client.edit') }}">
        <span class="font-medium text-sm md:text-base pointer-events-none">{{ __('client.edit') }}</span>
    </a>
</div>
