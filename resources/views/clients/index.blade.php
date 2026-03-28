<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <div class="p-2 sm:p-4 lg:p-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('nav.clients') }}</h1>
{{--                            <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('client.index_title') }}</p>--}}
                        </div>
                        <a href="{{ route('clients.create') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-white shadow-md shadow-indigo-600/30 transition hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            <span class="text-xl leading-none">+</span>
                            <span class="text-sm font-semibold">{{ __('client.index_create_hint') }}</span>
                        </a>
                    </div>

                    @if($clients->isEmpty())
                        <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-gray-100">
                            <p>{{ __('client.index_empty') }}</p>
                        </div>
                    @else
                        <div class="p-2 sm:p-4 lg:p-6 text-gray-900 dark:text-gray-100 flex flex-col gap-2">
                            @foreach($clients as $client)

                                <x-clients.client :client="$client" />

                            @endforeach
                        </div>
                    @endif

                    {{-- Pagination--}}
                    @if($clients->hasPages())
                        <div class="p-2 sm:p-4 lg:p-6">
                            {{ $clients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
