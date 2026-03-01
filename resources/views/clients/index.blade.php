<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($clients->isEmpty())
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <p>{{ __('client.index_empty') }}</p>
                        </div>
                    @else
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col gap-2">
                            @foreach($clients as $client)

                                <x-clients.client :client="$client" />

                            @endforeach
                        </div>
                    @endif

                    {{-- Pagination--}}
                    @if($clients->hasPages())
                        <div class="p-6">
                            {{ $clients->links() }}
                        </div>
                    @endif

                    {{-- Create new blog post --}}
                    <div>
                        <a href="{{ route('clients.create') }}" class="fixed bottom-4 right-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-full text-3xl">
                                +
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
