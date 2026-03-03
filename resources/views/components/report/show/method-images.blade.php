@props(['images', 'reportId'])

@if($images && $images->count())
    <div x-data="{ showModal: false, modalImg: '', modalCaption: '' }" class="mt-6">
        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Afbeeldingen') }}</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($images as $image)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden flex flex-col items-center">
                    <img src="{{ route('files.report-image', [$reportId, $image->path]) }}"
                        alt="{{ __('report.images.alt_report_image') }}"
                        class="w-full h-32 sm:h-40 object-cover cursor-pointer hover:opacity-90 transition-opacity"
                        @click="$dispatch('open-modal', 'large-image-method', modalImg = '{{ route('files.report-image', [$reportId, $image->path]) }}', modalCaption = '{{ $image->caption ?? '' }}')" />
                    @if($image->caption)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 px-2 text-center">{{ $image->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <x-modal name="large-image-method" focusable>
            <div class="p-6">
                <img :src="modalImg" alt="{{ __('report.images.alt_enlarged') }}"
                    class="w-full h-auto max-h-[70vh] object-contain rounded-lg" />
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800"
                        @click="$dispatch('close')">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </x-modal>
    </div>
@endif
