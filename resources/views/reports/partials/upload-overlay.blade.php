<div
    x-show="state !== 'idle'"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
    style="display: none;"
>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">

        {{-- Uploading state --}}
        <div x-show="state === 'uploading'">
            <div class="flex items-center space-x-3 mb-4">
                {{-- Spinner --}}
                <svg class="animate-spin h-6 w-6 text-blue-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Afbeeldingen uploaden…</h3>
            </div>

            {{-- Progress bar --}}
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 mb-2 overflow-hidden">
                <div
                    class="bg-blue-500 h-3 rounded-full transition-all duration-300"
                    :style="'width: ' + progress + '%'"
                ></div>
            </div>
            <p class="text-sm text-right text-gray-500 dark:text-gray-400 mb-4" x-text="progress + '%'"></p>

            {{-- File list --}}
            <ul class="space-y-1 max-h-48 overflow-y-auto" x-show="files.length > 0">
                <template x-for="(file, index) in files" :key="index">
                    <li class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 px-3 py-1.5 rounded-lg">
                        <span class="flex items-center space-x-2 truncate">
                            <svg class="h-4 w-4 text-gray-400 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="truncate" x-text="file.name"></span>
                        </span>
                        <span class="text-gray-400 ml-2 shrink-0" x-text="file.sizeMb + ' MB'"></span>
                    </li>
                </template>
            </ul>
        </div>

        {{-- Processing state --}}
        <div x-show="state === 'processing'">
            <div class="flex flex-col items-center space-y-4 py-4">
                <svg class="animate-spin h-10 w-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <p class="text-gray-700 dark:text-gray-300 font-medium">Rapport opslaan…</p>
            </div>
        </div>

        {{-- Done state --}}
        <div x-show="state === 'done'">
            <div class="flex flex-col items-center space-y-4 py-4">
                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="h-7 w-7 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-gray-700 dark:text-gray-300 font-medium">Opgeslagen! Doorsturen…</p>
            </div>
        </div>

    </div>
</div>
{{-- Upload progress overlay + Alpine component. Parent must have x-data="reportUploadProgress()" --}}
@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('reportUploadProgress', () => ({
                // state: idle | uploading | processing | done
                state: 'idle',
                progress: 0,
                files: [],

                onFileChange(event) {
                    this.files = Array.from(event.target.files || []).map(f => ({
                        name: f.name,
                        sizeMb: (f.size / 1024 / 1024).toFixed(2),
                    }));
                },

                submitForm(event) {
                    const form = event.target;

                    // Check if any file input has files selected
                    let hasFiles = false;
                    form.querySelectorAll('input[type="file"]').forEach(input => {
                        if (input.files && input.files.length > 0) hasFiles = true;
                    });

                    // No files → normal synchronous submit, show processing state
                    if (!hasFiles) {
                        this.state = 'processing';
                        setTimeout(() => form.submit(), 10);
                        return;
                    }

                    this.state = 'uploading';
                    this.progress = 0;

                    const formData = new FormData(form);
                    const xhr = new XMLHttpRequest();

                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            this.progress = Math.round((e.loaded / e.total) * 100);
                        }
                    });

                    xhr.upload.addEventListener('load', () => {
                        this.progress = 100;
                        this.state = 'processing';
                    });

                    xhr.addEventListener('load', () => {
                        if (xhr.status >= 200 && xhr.status < 400) {
                            try {
                                const data = JSON.parse(xhr.responseText);
                                if (data.redirect) {
                                    this.state = 'done';
                                    setTimeout(() => { window.location.href = data.redirect; }, 600);
                                    return;
                                }
                            } catch (_) {}
                            // Fallback: follow final URL after redirect chain
                            this.state = 'done';
                            setTimeout(() => { window.location.href = xhr.responseURL || window.location.href; }, 600);
                        } else {
                            // Validation error – fall back to regular form submit so Laravel shows errors
                            this.state = 'idle';
                            form.submit();
                        }
                    });

                    xhr.addEventListener('error', () => {
                        this.state = 'idle';
                        form.submit();
                    });

                    xhr.open('POST', form.action);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.send(formData);
                },
            }));
        });
    </script>
@endpush
