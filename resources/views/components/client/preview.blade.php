@props(['client' => null])
<div class="border-t border-gray-200 dark:border-gray-700 pt-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('client.preview') }}</h2>
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <div class="flex items-center rounded-xl border border-gray-200 dark:border-gray-600">
            @php
                $defaultImage = Vite::asset('resources/images/thumb-image.png');
                $imageSource = $client && $client->thumbnail ? route('files.client-thumbnail', $client) : $defaultImage;
            @endphp
            <img id="preview-image" src="{{ $imageSource }}" alt="Client thumbnail"
                class="h-full aspect-square rounded-l-xl rounded-r-none object-cover"
                style="min-width: 64px; max-width: 128px;" />
            <div class="flex-1 ml-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="preview-name">
                    {{ $client->name ?? old('name') ?: __('client.name') }}
                </h2>
                <p class="text-sm text-gray-500">
                    <span id="preview-contact">{{ old('contact') ?: 'Meneer / Mevrouw' }}</span> • {{ now()->toDateString() }}
                </p>
            </div>
        </div>
    </div>
</div>

@once('client-preview-scripts')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const nameInput = document.getElementById('name');
                const previewName = document.getElementById('preview-name');
                const thumbnailInput = document.getElementById('thumbnail');
                const previewImage = document.getElementById('preview-image');
                const contactInput = document.getElementById('contact');
                const previewContact = document.getElementById('preview-contact');

                if (nameInput && previewName) {
                    nameInput.addEventListener('input', function () {
                        previewName.textContent = this.value || @json(__('client.name'));
                    });
                }

                if (contactInput && previewContact) {
                    contactInput.addEventListener('input', function () {
                        previewContact.textContent = this.value || 'Meneer / Mevrouw';
                    });
                }

                if (thumbnailInput && previewImage) {
                    thumbnailInput.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function (ev) {
                                previewImage.src = ev.target.result;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewImage.src = "{{ Vite::asset('resources/images/thumb-image.png') }}";
                        }
                    });
                }
            });
        </script>
    @endpush
@endonce
